/*
 * Theme build workflow
 *
 * Usage:
 *
 *   gulp init                 // initial / run-once development build
 *   gulp                      // development build with watch task
 *   gulp build                // build for staging/production (export files in compact mode)
 *   gulp deploy --staging     // deploy to staging environment, same as `gulp build sync --staging`
 *   gulp deploy --production  // deploy to live environment, same as `gulp build sync --production`
 *
 */

// Load plugins
const gulp = require('gulp');
const plugins = require('gulp-load-plugins')({ camelize: true, rename: { 'gulp-ruby-sass': 'sass' } });
// const path = require('path');
const argv = require('minimist')(process.argv);
const runSequence = require('run-sequence');
const del = require('del');


// File Location Variables
// let env;
let compact = false;
let sassStyle = 'expanded'; // default to expanded, change in build/deploy tasks to compressed

const outputDir = 'assets/';
const sassSources = ['_source/scss/main.scss'];
const sassWatch = ['_source/scss/**/*.scss'];
const jsSources = [
  // '../core/assets/js/_auto-hide-mobile-header.js',
  // '../core/assets/js/_browser_detection.js',
  // '../core/assets/js/_dynamic-top-bar.js',
  '../core/assets/js/_navigation-menu.js',
  // '_source/js/lib/*.js',
  '_source/js/*.js',
];
const svgSources = ['_source/svg/*.svg'];
const svgSpriteSources = ['_source/svg-sprites/**/*.svg'];
const fontSources = ['_source/fonts/*.{ttf,woff,eot,svg,otf}'];
const imageSources = ['_source/images/**/*'];


// Utility functions
// =================

// Error handling for the deploy task
function throwError(taskName, msg) {
  throw new plugins.util.PluginError({
    plugin: taskName,
    message: msg,
  });
}

// Tasks
// =====

// SCSS
gulp.task('sass', () => (
  plugins.sass(sassSources, { style: sassStyle, sourcemap: true })
    // return plugins.sass(sassSources, { style: sassStyle })
    .pipe(plugins.sourcemaps.init())
    // https://github.com/ai/browserslist#queries
    // http://browserl.ist
    .pipe(plugins.autoprefixer('> 1%', 'last 2 versions', 'Firefox ESR', 'ie >= 10'))
    .pipe(plugins.cleanCss({ keepSpecialComments: 1 }))
    .pipe(plugins.sourcemaps.write('.', { includeContent: true, sourceRoot: '../../core/assets' }))
    .pipe(plugins.if(compact, plugins.rename({ suffix: '.min' })))
    .pipe(gulp.dest(`${outputDir}css`))
    .pipe(plugins.notify({ message: 'SASS task complete' }))
));


// SVG Assets
gulp.task('svg', () => (
  gulp.src(svgSources)
    .pipe(plugins.svgmin())
    .pipe(gulp.dest(`${outputDir}svg`))
    .pipe(plugins.notify({ message: 'SVG task complete' }))
));


// SVG Sprites
gulp.task('svgsprites', () => (
  gulp.src(svgSpriteSources)
    .pipe(plugins.svgmin(/*function (file) {
      var prefix = path.basename(file.relative, path.extname(file.relative));
      return {
        plugins: [{
          cleanupIDs: {
            prefix: prefix + '--',
            minify: true
          }
        }]
      };
    }*/))
    // Rename Symbol IDs by subfolder name, if none (in root) put 'sprite'
    .pipe(plugins.rename((filePath) => {
      const name = filePath.dirname.split(filePath.sep);
      if (name[0] === '.') {
        name[0] = 'sprite';
      }
      name.push(filePath.basename);
      filePath.basename = name.join('-');
    }))
    .pipe(plugins.svgstore())
    .pipe(gulp.dest(`${outputDir}svg`))
    .pipe(plugins.notify({ message: 'SVG Sprites task complete' }))
));


// Fonts to Build
gulp.task('fonts', () => (
  gulp.src(fontSources)
    .pipe(plugins.newer(`${outputDir}fonts`))
    .pipe(gulp.dest(`${outputDir}fonts`))
    .pipe(plugins.notify({ message: 'Fonts task complete' }))
));


// Site Scripts
// Fix Babel < 7 resolving relative to the file as opposed to cwd - https://github.com/babel/babel-preset-env/issues/186#issuecomment-297692922
const nmDir = `${(__dirname.includes(process.cwd()) ? process.cwd() : __dirname)}/node_modules/`;
gulp.task('js', () => (
  gulp.src(jsSources)
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.jshint.reporter('default'))
    .pipe(plugins.babel({
      presets: [
        // Use `${nmDir}babel-preset-env` rather than just 'env' for Babel < 7
        [`${nmDir}babel-preset-env`, {
          targets: {
            browsers: ['> 1%', 'last 2 versions', 'ie >= 10', 'safari >= 7'],
          },
        }],
      ],
    }))
    .pipe(plugins.concat('main.js'))
    .pipe(plugins.if(compact, plugins.rename({ suffix: '.min' })))
    .pipe(plugins.if(compact, plugins.uglify()))
    .pipe(plugins.sourcemaps.write('.'))
    .pipe(gulp.dest(`${outputDir}js`))
    .pipe(plugins.notify({ message: 'Scripts task complete' }))
));


// Images
gulp.task('images', () => (
  gulp.src(imageSources)
    .pipe(plugins.cache(plugins.imagemin({
      optimizationLevel: 7,
      progressive: true,
      interlaced: true,
    })))
    .pipe(gulp.dest(`${outputDir}images`))
    .pipe(plugins.notify({ message: 'Images task complete' }))
));


// Watch
gulp.task('watch', () => {
  // Watch .scss files
  gulp.watch([sassSources, sassWatch], ['sass']);

  // Watch .js files
  gulp.watch(jsSources, ['js']);

  // Watch image files
  gulp.watch(imageSources, ['images']);

  // Watch .svg files
  gulp.watch(svgSources, ['svg']);

  // Watch .svg sprite files
  gulp.watch(svgSpriteSources, ['svgsprites']);
});


// Clean Dist - Empty the output Dir
// runSequence requires all the tasks to 'return' a value,
// hence '()' after arrow instead of '{}'
// https://www.npmjs.com/package/run-sequence
gulp.task('clean-dist', () => (
  del([outputDir])
    .then(paths => plugins.notify({ message: `Cleaned ${paths}` }))
));


// Build
gulp.task('build', () => {
  compact = true;
  sassStyle = 'compressed';
  runSequence('clean-dist', 'init');
  return plugins.notify({ message: 'Build task complete' });
});

// Deploy
// ======
// Examples:
// gulp sync --staging
// gulp sync --production
gulp.task('deploy', () => {
  if (!argv.staging && !argv.production) {
    return console.error('Must specify deploy destination: --staging or --production'); // eslint-disable-line no-console
  }
  compact = true;
  sassStyle = 'compressed';
  runSequence('clean-dist', 'build', 'sync'); // Using 'build' instead of 'init'
  // Init doesn't have a return value!
  // Parallel tasks issue (sync starts before init/build is finished)
  return plugins.notify({ message: 'Deploy task complete' });
});


// Sync
// ====
// Examples:
// gulp sync --staging
// gulp sync --production

gulp.task('sync', () => {
  // Folders to sync
  const rsyncPaths = outputDir; // ['assets']

  // rsync options
  const rsyncConf = {
    progress: true,
    incremental: true,
    relative: true,
    emptyDirectories: true,
    recursive: true,
    clean: true,
    exclude: [],
  };

  // Staging
  if (argv.staging) {
    rsyncConf.hostname = ''; // hostname
    rsyncConf.username = ''; // username
    rsyncConf.destination = ''; // path for file uploads, eg. ~/sg1/content/themes/themename/
  // Production
  } else if (argv.production) {
    rsyncConf.hostname = ''; // hostname
    rsyncConf.username = ''; // username
    rsyncConf.destination = ''; // path for file uploads, eg. ~/www/content/themes/themename/
  } else {
    throwError('deploy', plugins.util.colors.red('Missing or invalid target'));
  }

  // Run gulp-rsync to sync files
  return gulp.src(rsyncPaths)
    .pipe(plugins.if(
      argv.production,
      plugins.prompt.confirm({
        message: 'Deploying to PRODUCTION, continue?',
        default: false,
      }) // eslint-disable-line comma-dangle
    ))
    .pipe(plugins.rsync(rsyncConf))
    .pipe(plugins.notify({ message: 'Deploy task complete' }));
});


// Init Task
gulp.task('init', ['sass', 'svg', 'svgsprites', 'fonts', 'js', 'images']);

// Default task
gulp.task('default', ['sass', 'svg', 'svgsprites', 'fonts', 'js', 'images', 'watch']);

# WordPress IMG Starter Theme

Version: 2.0.0

## Authors:

Dante Chichizola ( [@dchichizola](https://twitter.com/dchichizola) / [incrementalmarketing.com.au](https://www.incrementalmarketing.com.au) / [chichizola.net](http://www.chichizola.net) )

Igor Vidic ( [@igorvidic](https://twitter.com/igorvidic) / [incrementalmarketing.com.au](https://www.incrementalmarketing.com.au) / [igorvidic.com](https://igorvidic.com) )

## Summary

WordPress IMG Starter Theme uses the Core Submodule and it is to be used as a starting template for building custom themes.
Uses SCSS and AutoPrefixr, HTML5 Boilerplate with Modernizr and Normalize.css, and Gulp (from Core) for all processing tasks. Tested with WordPress 4.6.

## Prerequisites

In order to use this framework you need to have Node.js and NPM installed in your system.

Before you can install Node, you will need to install two other applications. Fortunately, once you have got these on your machine, installing Node takes just a few minutes.

* __XCode__. To install it just open Terminal and type `xcode-select --install`. You should see a pop up prompting you to install command line developer tools. Click `Install`. Then `Agree` the License Agreement and click `Done`.
* __Homebrew__. To install it just open Terminal and type `ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`. You will see messages in the Terminal explaining what you need to do to complete the installation process.


### Installation

* Open the Terminal app and type `brew install node`.
* To make sure you have Nope and NPM installed, run the following commands to see what version of each is installed: `node -v` and `npm -v`
* Make sure Homebrew has the lastest version of the Node package by typing in Terminal `brew update` and then Upgrade Node `brew upgrade node`.


If you find any error in NPM after installing Node.js, follow these instructions:

```
rm -rf /usr/local/lib/node_modules
brew uninstall node
brew install node --without-npm
echo prefix=~/.node >> ~/.npmrc
curl -L https://www.npmjs.com/install.sh | sh
```
Node and npm should be correctly installed at this point. The final step is to add `~/.node/bin` to your PATH so commands you install globally are usable. I added this line to my `~/.path` script, which gets run via `~/.bash_profile`.

```
export PATH="$HOME/.node/bin:$PATH"

```
Now you can re-install any global packages with the command below, replacing the npm modules with whatever global packages you need.

```
npm install -g http-server node-inspector forever nodemon
```



## Usage

The theme is setup to use [Gulp](http://gulpjs.com) to compile SCSS (with source maps), run it through [AutoPrefixr](https://github.com/ai/autoprefixer), lint, concatenate and minify JavaScript (with source maps) and optimize images, with flexibility to add any additional tasks via the Gulp.js file.

1. Change the `style.css` intro block to your theme information.

2. Run `npm install` to pull all the Gulp dependencies.

3. Edit the `gulpfile.js` file to include/exclude the **js** files you need from the core `../core/assets/js/`

4. Add your custom **scss** files into `_source/scss` to override default values of variables if needed.

5. Add your custom **js** files into `_source/js`. Remember that all of them will be minified and combined into one and enqueued by `theme-functions.php` core function.

6. Use the hooks (Check the hooks section) to modify the functions in the theme.

7. Run `gulp` to execute tasks.

8. To Run for production environment, run gulp as follow:

```
NODE_ENV=production gulp
```

Code as you will.


### The Hooks

By default we are using the [Theme Hook Alliance](https://github.com/zamoose/themehookalliance) framework to facilitate coding. Consider reading the documentation in the provided link. 

Also, we are including custom hooks as follows:

- `core_load_scripts_hook` located in `lib/theme-functions.php` file at the bottom of the `core_load_scripts` function.


To concatenate and minify your jQuery plugins, add them to the `_source/js/vendor` directory and add the `js` filename and path to the `Gulp.js` file and `uglify` task.



### Image Optimization

To optimize images, run `gulp image`.
This was also included in the default `watch` task.


### Deployment

To deploy you must push your website to the production environment, ensure node.js and npm are running in production mode, install all dependencies with `npm install`, ensure all submodules are included recursively running `git submodule update --init --recursive` and run gulp for production `NODE_ENV=production gulp`.

After that, you can install WordPress and activate this theme, alternatively this theme will be auto-activated by the [IMG WP AutoInstaller](https://bitbucket.org/incrementalmarketing/img-wp-autoinstaller).



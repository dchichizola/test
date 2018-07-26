<?php

define( 'WP_LOCAL_DEV', true );
define( 'DB_NAME', '%%DATABASE%%' );
define( 'DB_USER', '%%USERNAME%%' );
define( 'DB_PASSWORD', '%%PASSWORD%%' );
define( 'DB_HOST', 'localhost' ); // Probably 'localhost'

define('TESTMODE', false);

// Using AUTH_SALT
// Details can be found in theme-functions.php
define( 'HTTP_CREDENTIALS', serialize(array(
	array('imgdits', '5cd66431e6be20da4e30d7cfa535e362'),
	array('imgdev', '5cd66431e6be20da4e30d7cfa535e362'),
	array('searchWP', '08825798A0B8FFFE8BE9C34EC3D7EB13')
)));
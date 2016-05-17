<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'hotrobds');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '123@cms');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define( 'WP_MEMORY_LIMIT', '96M' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ' <v{MnnO$@U}zKgS%>i/hEL<GZ)+y_d`kYTIC&~b54+:5OyRXF`r79A)Z80n=NIR');
define('SECURE_AUTH_KEY',  'xUN)F0AP`(V|_hU+^Wx+!E`iK+~56{paCgtjfcq42`=?4)SA V#9qLVtxe)bE_>(');
define('LOGGED_IN_KEY',    'E$6JOCF3{$+oImN9rbHXEQGQ jpeyU`oj{kr!2iaj7SF;IUEbAfY]{p}j<4=Hy]>');
define('NONCE_KEY',        'p,]N?fsPh}@|q*-Cy^&^KHc_o+-$J?h2(oJ.@K_|n;Wg4Rstd^h7~RqQUH~&K4%f');
define('AUTH_SALT',        'Uug_Jel|vO|y`BlJ2<]7BIV.SfB-h8vM@+QLz3]*{)ji}8]-fYz)I{,Mt|(<K].5');
define('SECURE_AUTH_SALT', '*.Tc+zD#d7%-X-Da3-%WIJW<P.,,,ZC2pm@<-A4qPNffFOm=/RsbZ{ECtTKva#5H');
define('LOGGED_IN_SALT',   'tvl;FGH6Kzikb[i6]4F_&m|6#JXL7Pbni|CsrIu/n|#MLf?NG><1CZ=0Be,DvWUh');
define('NONCE_SALT',       'd2E.^D5sSzQu{vKkWRNs&T}{T^qE]8-W7rZeJ!s4zJ{d+>Ew-NG~1 [7>r(Ot/v-');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'hotrobds_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

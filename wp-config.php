<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'news');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost:8888');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ZFB(XVnD)&b,+d)nqPW-+jV6;RY``o~{@2Xcjp0DG gA0k2R?.Y&TIx-!N?w6|$n');
define('SECURE_AUTH_KEY',  '.=5n1|gG&&O>(kt chIY&R{grk9q Qsy@&}&%.{ /:Qq<)GjW_4xA>IjTM4Onn|F');
define('LOGGED_IN_KEY',    'd,-3:qrgTK8?kT9X-%wu~|_zO*x f^#q}?6<xkCm_7.F(AVmR7?`~[/XfK@jh%T-');
define('NONCE_KEY',        '/Ek9y.q|jD-,Vec|w-;Ma6F)7gCE$RGc!z-FlyA]1j^x#+<9AAj|=-G?u/zow/`1');
define('AUTH_SALT',        'Q>Ti%MLZZbF96qOJWBPwR8e}D{z?rMY;W_WIQ]?]&3lIxwQ3rh-Q~+m$]WJml?|U');
define('SECURE_AUTH_SALT', ' =))t-j+,4{Q`#EJ|;:@$G*X|PMLNnvk8aS]HhU>U}<brtmo/h8FD0dA9;ZPQCAN');
define('LOGGED_IN_SALT',   'cfjpyT<bH$P5`PF:8J5.>|Q>[.m>!&}^XpB$_MN%|&/A[ld7o_|+ZW|>qLcHm3{J');
define('NONCE_SALT',       'WC&DN.Bh]leY MX1D@K$gYJ,uk6Ap)4&Ib60w/e{&&R+RkyM(H,F9|-6~V=a<bpS');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

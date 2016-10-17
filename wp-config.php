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
define('DB_NAME', 'newcommon');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

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
define('AUTH_KEY',         'g96}( ^o<~ _-&;o+}_gnly|b).P_||zi>3qgjA8oa7bxV}W_!-^NMOMG:R)-QOr');
define('SECURE_AUTH_KEY',  '/rVrM8~m+:3+>Mx0-<jn-K)QcJYkTAj@ [Y5f27V+W)Lj8}0[i;PxqP^[7#i90-H');
define('LOGGED_IN_KEY',    'l[d9Hf|:|9fC^WHnlug)KhxaCh91{CKJH.bNB-B6 8{EdM]_wy>w&QD24Q1Fdhe8');
define('NONCE_KEY',        ']2G!GRR8DdR#Q@_)~-#-@I ,t$KvWxq6*u&z$4b UbRlnRbubFo^JUKv7JIXOX|0');
define('AUTH_SALT',        '%K~wZPz|Yi!eGTtp=pg-n$EDT(RC<-X4+GWo@D$0_X[rA6/BjI.qL(q~f0i(YC.F');
define('SECURE_AUTH_SALT', ')S8P:zf{)+$,++5Jv{4p?ch]!oSwK5M|o!u=Uht!pnYHWN%[LnJ`TM-+-z)dCRGK');
define('LOGGED_IN_SALT',   '|++(J}e59SI)5x}9KM[*:NFjhn*(MgF~M*Fx,`4~<Z#i>- {q<=p8I|,|Rq-S-0t');
define('NONCE_SALT',       '|HvTR?bbZ27-IiAfseZaJH}=wb=hXt&?1KZ9rLE6{-|^rGQ+Tr/r:PU$k/WJ0Vt,');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', true);

/* Multisite */
define('MULTISITE', false);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'goldman.dev');

define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
define('WP_MEMORY_LIMIT', '96M');


/** Enable W3 Total Cache */
//define('WP_CACHE', true); 
// Added by W3 Total Cache

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

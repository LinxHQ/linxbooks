<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'lb_usermanual');

/** MySQL database username */
define('DB_USER', 'lb_usermanual');

/** MySQL database password */
define('DB_PASSWORD', 'Lkoe97834#^%!');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'U$hLy:v(:9E!c@bfZ$_C|gr:0P!m+&zI$_+;C+S{_)]}`vFhY;512E=]tM;zrMF_');
define('SECURE_AUTH_KEY',  '|E:%GLLKJN6YE@1h^8 drm9!,?S;k-`|MoE+7V}^}2~!/tGDsqmB&+;kJ8)8zn3v');
define('LOGGED_IN_KEY',    'YNp{VH64o8?wjh!-G=[hzR1 y|f_`d$=wnlhG.$GG`)/)#UqJl{<n- :TMdai-=!');
define('NONCE_KEY',        '3P=q;]s%H*rMlWiin[O<NJog8~^w~Hc~&0WJS$czh6Pohsx/%7/XH5WOnjU|-utJ');
define('AUTH_SALT',        '#PA?tQy_nZ*K2ARS@ZrXD(c7z@n3znko{xZ<[lz~mDY3RQgHxWzy[+ph0l((x8Q`');
define('SECURE_AUTH_SALT', '3d|&W6aU+F=YxHpVrbU-D@>I>BNKCSBUYu<9VSrQ!0Oy(%0?-708z:q;z}W[-j6M');
define('LOGGED_IN_SALT',   'MWHA:%3+0+x)=7nWb]LP 8CpQ[!:.rqRNh^wp]-}24{;-wpkKnz&Ku_;-N)|;]Z=');
define('NONCE_SALT',       'ip)|-3&zk1pbH4P+1>VUly=1$aM&fd:@07E,x>o;z|T0xQ>@IquM{OjLeC-ug|sU');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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

<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
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
define('DB_NAME', 'lb_website');

/** MySQL database username */
define('DB_USER', 'lb_website');

/** MySQL database password */
define('DB_PASSWORD', 'nhwqoe97834#^%!2');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '+> ax_d[4&cgAUt(+K_3hqo-q6mj+j{_HrC *{!jSK|Q9)(rI;xkCVHy[Stcr%r?');
define('SECURE_AUTH_KEY',  '4=sqylyrpJcl]t+5[;,9E?L_f76_t<wPkRJ]bcn}[F :^2^;Syx<Vi).g[|IL>:q');
define('LOGGED_IN_KEY',    'p:Iit$`NeRMZw3Mv-{:!}j,s>[fJ|o2|QvdWaj>Y!yXLOBb|Sb$}Um,^e`o:-[sn');
define('NONCE_KEY',        'zYy.}%2`fdraRCAjK?_7@6|8sXPy$O1#A?4q3{%~QS>r (O.dn~FE^72pli.I_Fb');
define('AUTH_SALT',        'U7$<~+d4la[+6r<7h@S.Q9r<iqQ^=)Oq`7u^$&+-f<OetF1r4qnsOR!L~|(O|EqI');
define('SECURE_AUTH_SALT', '%>`Vxjj-1r+jxo,.ls3ePmi-v.A=4/0OmB56Yc)/IH[4nvWqdtv<lh$x~r,niRs5');
define('LOGGED_IN_SALT',   '#]I@H[rot2+:!E8Q{Sqxda^B|F2]ZCF(aWD(UQ>>DN07fgTj@zK2Ic`$e.zM=RW{');
define('NONCE_SALT',       '-FZ~$iP>[9~bg/(iP%}}QAt[,.(5]qcxHxL&DoXrb|CS6~U p:ud*9H(03bf;;~g');

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

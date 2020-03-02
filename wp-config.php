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
define( 'DB_NAME', 'offerus_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'QW5,B7.jCQ{Sg(QD=:=,P(U!;q2%+rO33[x84.V=)7%hGAu+Uym>&y96w&M({70(' );
define( 'SECURE_AUTH_KEY',  ',np.Qq#4jiBf6u}%fT_8ka(^Sci=}e997i*]mP8I)]xJ/|BGMZ5|2 B8`8nW,FM~' );
define( 'LOGGED_IN_KEY',    'pok<iXW@IfdY.f3vz6sOG}[x?;`fy@~!l%yCYB1Kf(QVr5D^j&YJ~&J;H,O%/beu' );
define( 'NONCE_KEY',        '0vI]4i|o8bHp)L14uj7*S(df)E 1Y%[*vQOv=1Lb]YKR73EW%A11  EhJ^/Kc>@f' );
define( 'AUTH_SALT',        'D`>r)r7=fa9QB~j&o.n]}boRfRMs9GF@yC5g*X1L%NlGgl5nfWUb@.Ew},.*;1br' );
define( 'SECURE_AUTH_SALT', '-o#]/JUm$XA 2y-wlhy_]esd}@9_-U{*Co6>h:9 .}MKM5x1a(.2be7w]43fk]b4' );
define( 'LOGGED_IN_SALT',   'L%Hu[n=$=f;X;p{qpo]4vF,F|ZX`-dP)52j<hr8};oEP)Kd$%[.ar0wvTX@TeQca' );
define( 'NONCE_SALT',       'rPD8S(Is<Guu9t/xflhHbp<2gXc_/i4wUDS`/nz%p/#BqKGE?/[:HRNvHvVbn<bd' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

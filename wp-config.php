<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'db' );

/** Database username */
define( 'DB_USER', 'wpuser' );

/** Database password */
define( 'DB_PASSWORD', 'wpuser' );

/** Database hostname */
define( 'DB_HOST', 'db' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define( 'WP_DEBUG', false );
/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'sCLv;_.U/ok5A7UotUG,~MXF_;uus_,?;$:9zYl}])s>b!K0Tgsbj]e(I#%ee]Np' );
define( 'SECURE_AUTH_KEY',  'dH=U[HUyFhm,<ViTa< vz*bx_m?e$D059 8sCcHJju.W}Mf#Ld*DO;wsP~6?bw[;' );
define( 'LOGGED_IN_KEY',    ')B3YiiY4MtAD6h$c9_}=_+(f><8U$M&)b!O^X`P/G[%>Qf!T<bEj(Of;UX)v%S>&' );
define( 'NONCE_KEY',        'E1DlVn?v2]WH$,-S]NOXf@rR2!(=!@ocGUNLHLAuyJe]n^A[CM)3/usX-c&-L2[S' );
define( 'AUTH_SALT',        'lM(V[p^ruAXPyW,8HxTK8!m.E~^P=fb^3kR=|E_g!j)?OC,,siQ~mSgQ*:n6P!xZ' );
define( 'SECURE_AUTH_SALT', '0O*YJ+3n2o7[j+TqLc[O~5lu#JhR }G5]UwlR4($|-bhJM~Zu{Bp7TKd$YoJx>bY' );
define( 'LOGGED_IN_SALT',   'CNsJe~hudbV/ld.}f;3TOl)$#e=KO~|A`<rf<NVmPgBr|c>/GZq}Bl-mUwo,z655' );
define( 'NONCE_SALT',       '$vR>lCy>%hP%uY[=!c1eS=w?L8v3tBC(9?GEk|B[V=?aO~P5D)W{ -aS.XDwr&zk' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

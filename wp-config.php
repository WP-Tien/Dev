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
define( 'DB_NAME', 'dev-plugin' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'sp,B~mKK3) =U)mUa^j[T<(mlzONfQPSRm>LNb&FIgUt%`cqt.Ian1psPP!tio*z' );
define( 'SECURE_AUTH_KEY',  '*rJc,;Z8{m zD45_h7W58A!.CT>2e&,q|ZSo)us:lu[~?2(g{<@OA6j!3.,o)S,L' );
define( 'LOGGED_IN_KEY',    '8XgM0Za;S=I28/D>=3`0|1s( Tw; 8=wvS6dQ=PY9b}<6DG0M682n=|LQ!y%&!j1' );
define( 'NONCE_KEY',        'X8yq=q.>LS>nIzp&igg2b-I=*MTW yo2N]JN2tLaRNA9Ge+V9##+X)tcpLN b.Do' );
define( 'AUTH_SALT',        '9K8bo(GvOU2s aaPeoqG9H@(#tSaq,bS-Gm>k8.w#%f4[EHx#aZ0AX/q&K$=o9ZO' );
define( 'SECURE_AUTH_SALT', '+_~tpBRv~QoxXW+IM)6$}KavFYIw<$PeND[8!6GR;+RKROJ{s_l-(DQz/jD9])/4' );
define( 'LOGGED_IN_SALT',   '=?[cv9R{_hFS^lTcn_z6e@bp9r3@LDiA7^sep;FYx7?<FDy@%Z)?6YF7_,8/AO8Q' );
define( 'NONCE_SALT',       '#~o5}Sn4TM*>0WTMw.4D)N&ikFNE:FMPT ,9X+NRlsVuJantU-8ApK}2LqqurDh.' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'dev_';

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

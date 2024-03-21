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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wp_admin' );

/** Database password */
define( 'DB_PASSWORD', 'admin' );

/** Database hostname */
define( 'DB_HOST', '10.34.2.38' );

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
define( 'AUTH_KEY',         'Qv=]%p^_wUyXu^L~XUF? X[0hh.jh*B+(Uk@St`^xRr6d mC{d6Z)#=&R4!uClO ' );
define( 'SECURE_AUTH_KEY',  '~Vz^QE:RZTw~f6NK2ffWRX^>8%5OiwTZ_f,,Uw27|3ry]dQv|&/P1O*TA`,Ij#M=' );
define( 'LOGGED_IN_KEY',    'F@UI>}+:,|had0+xkW;-#N1PX<[V$&}b^KLYVS=,ou+27ZgtBaz1/F/.&0Cb- q!' );
define( 'NONCE_KEY',        'o>_e]zHm>?bIPzyx|_0FgA*QmBb5(~>3GfXZ3)Q-JUUd(/;~b+Ca.%T1O+)PV+7M' );
define( 'AUTH_SALT',        '@82 lk^bqt;8KrhQ~![.1p6ehZzMmkboGf@|:4[}d> :@k~lEZD8d`c7#6fP[+:L' );
define( 'SECURE_AUTH_SALT', '{~b]6~`dkhtyqP00NB96w4GdYK/Ekz#}oG<^~~Ih={NmTE?8Se[nzkB-($%GSJ>r' );
define( 'LOGGED_IN_SALT',   '@4J|&?5KK<;o*PsI2o[hS}}%0Z>x3!uw$&hY)YkZ>-%v^Qv@XZ EJ+slWbr(JgF-' );
define( 'NONCE_SALT',       'edt1bd{f(Vgm#ul=`WE|*:5=+lug:nG- @Ui8mn.8h%y!Z9od1VEJtpyS93zc@Hq' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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

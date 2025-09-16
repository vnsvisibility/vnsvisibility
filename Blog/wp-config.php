<?php
define( 'WP_CACHE', true );

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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u686799601_blogvns' );

/** Database username */
define( 'DB_USER', 'u686799601_vishalkumar298' );

/** Database password */
define( 'DB_PASSWORD', 'Galdonda@#$2987Vi$hal' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'v%^.5zL~v .MwZT 5%=>#r*ZGf.(~F:+b2p2hD(IqL&?QyWmBD;S2~8%EKqG:`Eh' );
define( 'SECURE_AUTH_KEY',   'K4+N~`tA7l}}EWl/yOn@(P]l#hF4UO?N[UD09{M~n[yPOW}e=1Zjo41c|zaV!>(z' );
define( 'LOGGED_IN_KEY',     'kUKq1Wz+Ij?u,C`&%0FNAT.EB.U3j<<T1vZ, wrpPehW!f$4ir$jI4RG*np&tiU^' );
define( 'NONCE_KEY',         '6}~X}Ohq (sI >#jm:q)L3z^l=Bx?|l/P8#m&ecC,Vl,2}ZJO7I)BT`n<xcvec0;' );
define( 'AUTH_SALT',         'EFS@saH$I`h]^_T*m8R{BT{HrU}p/FL%648Eu)=i4d-T@_}vfOKjDKY%3%XwhCZz' );
define( 'SECURE_AUTH_SALT',  '_bJFhw$eZSQ/,++ct_G,7sD%+Ihdq`0J!r$|&~gcLW_4|j#XN]:{>bH6gHsl{nXy' );
define( 'LOGGED_IN_SALT',    'xCM>ZBW:)U(J-~ctKCnb59[9Niubp?&KLgzz[,dj3RJeqU+8A(VD@t=~_Xj{5Z,W' );
define( 'NONCE_SALT',        '}8`(VU$s{imo|z6XxAl^J_E^[LeYyh8 z:%SvHZ}+.Qo5F?.K?RUmCk{]6wM|TW*' );
define( 'WP_CACHE_KEY_SALT', '1OzCiN@1jk<jbefGutj_a5!a`Lmjomt8DA A-Mm7[IU~}2t&Edq1=7R`_7ATuJ4;' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', '37404b063572cecb68e90bdc93ad5439' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

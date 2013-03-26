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
define('DB_NAME', 'maqsoods_zpeng');

/** MySQL database username */
define('DB_USER', 'maqsoods_zpeng');

/** MySQL database password */
define('DB_PASSWORD', '19840617');

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
define('AUTH_KEY',         'V/9x$prQh%L]wO]d-];>?5u2)8BdA=XzI.[m{jefdc;9Cb6-mp6=}XB:RU`1/^DA');
define('SECURE_AUTH_KEY',  '%VV;cZ.avb?2ik%hxy]@,GJ9)35NIhkG9{Ht~=0vOdX:,6k(CB`SXGl->t0NMW(b');
define('LOGGED_IN_KEY',    'fB[WTG>$7nK,.lV~Y%l(QzWwVOobE<|+7v2pG6CUZ%N}IP`ootXd7pvs/K0~/th$');
define('NONCE_KEY',        'BR>rT_SK*B9Chj<h*XZTR,<#C#ExEo@VyzPGeOhzhWsbE]$=r@&ujqh}UfD|!K;*');
define('AUTH_SALT',        ',}6kd{{;mW04kHIQq|+&e}j9IUg-FsUn>MdJ9Pf,hQ+T=2v QE:#.4x9`g~km^}H');
define('SECURE_AUTH_SALT', '5DC>{T=%Ia0a)(%kZ) 6HKpkSD7J@1U!c:eW!0FdQqD(B0ALTipq5gZgjZ]0Cq>z');
define('LOGGED_IN_SALT',   '2D3.~FMV3AOE:zW$kckdrX;0>eX]Y:49e wZ~w7EB=w3@Ne,X&6iM)%pzK:rDmx;');
define('NONCE_SALT',       ')2r{#,0d05^mri2SsbxX4[gWbHC+!e>JnCDm[T5LEMNrSM6sS1v@eDQ0gpg KhOo');

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

/* That's alswirl_rightl, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

ini_set('display_errors', '0');
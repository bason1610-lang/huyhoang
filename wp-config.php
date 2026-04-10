<?php
/**
 * The base configuration for iNET/1Panel Deployment
 * 
 * Modified from WordPress wp-config.php
 * Used for iNET hosting with Laravel application
 * 
 * @package Akauto Shop
 */

// ** Database settings for iNET/1Panel ** //
define('DB_NAME', 'nzdrpuqdhosting_csxhuyhoang');
define('DB_USER', 'nzdrpuqdhosting_csxhuyhoang');
define('DB_PASSWORD', 'Admin@123');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

/**
 * Laravel Path Definitions
 * Used for reference in deployment scripts and utilities
 */
if (!defined('LARAVEL_ROOT')) {
    define('LARAVEL_ROOT', dirname(__FILE__));
}

if (!defined('LARAVEL_APP')) {
    define('LARAVEL_APP', LARAVEL_ROOT . '/app');
}

if (!defined('LARAVEL_PUBLIC')) {
    define('LARAVEL_PUBLIC', LARAVEL_ROOT . '/public');
}

if (!defined('LARAVEL_STORAGE')) {
    define('LARAVEL_STORAGE', LARAVEL_ROOT . '/storage');
}

if (!defined('LARAVEL_BOOTSTRAP')) {
    define('LARAVEL_BOOTSTRAP', LARAVEL_ROOT . '/bootstrap');
}

if (!defined('LARAVEL_CONFIG')) {
    define('LARAVEL_CONFIG', LARAVEL_ROOT . '/config');
}

/**
 * Environment Settings for Production
 * Used by iNET/1Panel servers
 */
define('WP_ENV', 'production');  // Development: 'development', Production: 'production'
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

/**
 * Server Information
 * Useful for tracking deployment location
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

// For future use: WordPress compatibility if needed
if (!defined('WPINC')) {
    define('WPINC', 'wp-load.php');
}

/**
 * Database Connection Test (optional)
 * Uncomment to verify database connection on deployment
 */
// $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// if ($conn->connect_error) {
//     die("Database connection failed: " . $conn->connect_error);
// }
// $conn->close();

?>

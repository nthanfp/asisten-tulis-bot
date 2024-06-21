<?php
date_default_timezone_set('Asia/Jakarta');

// Set error reporting to display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log errors to a file
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

// Debugging function to print and log messages
function debug_message($message) {
    echo $message . "<br>";
    error_log($message);
}

try {
    // Check PHP version
    debug_message("PHP Version: " . phpversion());

    // Check if required extensions are loaded
    $required_extensions = ['gd', 'imagick'];
    foreach ($required_extensions as $ext) {
        if (extension_loaded($ext)) {
            debug_message("Extension $ext is loaded.");
        } else {
            debug_message("Extension $ext is not loaded.");
        }
    }

    // Test writing a file to the output directory
    $output_dir = realpath(__DIR__ . '/output');
    if ($output_dir === false) {
        throw new Exception("Output directory does not exist or cannot be resolved: " . __DIR__ . '/../output');
    }
    $test_file_path = $output_dir . '/test.txt';
    debug_message("Testing write permissions in directory: $output_dir");

    if (file_put_contents($test_file_path, 'Test write')) {
        debug_message("File write successful: $test_file_path");
    } else {
        debug_message("File write failed: $test_file_path");
    }

    // Check if directory is writable
    if (is_writable($output_dir)) {
        debug_message("Directory is writable: $output_dir");
    } else {
        debug_message("Directory is not writable: $output_dir");
    }

    // Check if directory exists
    if (file_exists($output_dir)) {
        debug_message("Directory exists: $output_dir");
    } else {
        debug_message("Directory does not exist: $output_dir");
    }

    // Output PHP info
    debug_message("PHP Info:");
    phpinfo();

} catch (Exception $e) {
    debug_message("An error occurred: " . $e->getMessage());
}
?>

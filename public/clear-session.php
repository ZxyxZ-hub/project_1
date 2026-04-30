<?php
/**
 * DEVELOPMENT UTILITY: Clear Session
 * 
 * Use this file to clear the session during development/testing
 * Simply visit: localhost/project_1/public/clear-session.php
 * 
 * ⚠️ REMOVE THIS FILE IN PRODUCTION
 */

// Get writable directory path
$writablePath = __DIR__ . '/../writable/session';

// Clear all session files
if (is_dir($writablePath)) {
    $files = glob($writablePath . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    $count = count($files);
    echo "<h2 style='color: green; font-family: Arial;'>✓ Session Cleared</h2>";
    echo "<p style='font-family: Arial;'>Deleted $count session file(s).</p>";
    echo "<p style='font-family: Arial;'><a href='http://localhost/project_1/public/auth/login'>Go to Login</a></p>";
} else {
    echo "<h2 style='color: red; font-family: Arial;'>✗ Error</h2>";
    echo "<p style='font-family: Arial;'>Session directory not found at: $writablePath</p>";
}
?>

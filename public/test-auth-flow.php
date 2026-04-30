<?php
/**
 * AUTHENTICATION FLOW TEST
 * 
 * Test the complete login → dashboard → logout → login flow
 * This file helps verify authentication is working correctly
 * 
 * Access at: localhost/project_1/public/test-auth-flow.php
 */

$session = session();

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Auth Flow Test</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }";
echo ".test-section { border: 2px solid #333; padding: 15px; margin: 15px 0; border-radius: 8px; }";
echo ".pass { background: #d4edda; border-color: #28a745; color: #155724; }";
echo ".fail { background: #f8d7da; border-color: #f5c6cb; color: #721c24; }";
echo ".warn { background: #fff3cd; border-color: #ffc107; color: #856404; }";
echo ".info { background: #d1ecf1; border-color: #bee5eb; color: #0c5460; }";
echo "h1 { color: #333; }";
echo ".test-result { margin: 10px 0; padding: 10px; border-radius: 4px; background: #f9f9f9; }";
echo ".session-var { font-family: monospace; background: #f0f0f0; padding: 2px 6px; border-radius: 3px; }";
echo "a { color: #0066cc; text-decoration: none; margin: 5px 10px 5px 0; display: inline-block; padding: 8px 12px; background: #e8f4f8; border-radius: 4px; border: 1px solid #0066cc; }";
echo "a:hover { background: #0066cc; color: white; }";
echo "</style>";
echo "</head>";
echo "<body>";

echo "<h1>🔐 Authentication Flow Test</h1>";

// Test 1: Session Status
echo "<div class='test-section " . ($session->get('logged_in') ? 'pass' : 'fail') . "'>";
echo "<h3>Test 1: Session Status</h3>";
if ($session->get('logged_in')) {
    echo "<p class='test-result'>✓ LOGGED IN</p>";
    echo "<p>User ID: <span class='session-var'>" . htmlspecialchars($session->get('user_id')) . "</span></p>";
    echo "<p>Username: <span class='session-var'>" . htmlspecialchars($session->get('username')) . "</span></p>";
    echo "<p>Role: <span class='session-var'>" . htmlspecialchars($session->get('role')) . "</span></p>";
} else {
    echo "<p class='test-result'>✗ NOT LOGGED IN</p>";
    echo "<p>This is expected on fresh start or after logout.</p>";
}
echo "</div>";

// Test 2: Session Variables
echo "<div class='test-section info'>";
echo "<h3>Test 2: All Session Variables</h3>";
$sessionData = $session->get();
if (!empty($sessionData)) {
    echo "<table style='width:100%; border-collapse: collapse;'>";
    foreach ($sessionData as $key => $value) {
        echo "<tr style='border-bottom: 1px solid #ddd;'>";
        echo "<td style='padding: 8px;'><span class='session-var'>" . htmlspecialchars($key) . "</span></td>";
        echo "<td style='padding: 8px;'>" . htmlspecialchars($value) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No session variables set (fresh session)</p>";
}
echo "</div>";

// Test 3: Routes Check
echo "<div class='test-section info'>";
echo "<h3>Test 3: Quick Navigation</h3>";
echo "<p>Test each route:</p>";
$routes = [
    'Home (Root)' => '/',
    'Login Page' => '/auth/login',
    'Signup Page' => '/auth/signup',
    'Form Page' => '/form',
    'Admin Dashboard' => '/admin',
    'Clear Session' => '/clear-session.php'
];
foreach ($routes as $label => $route) {
    $url = base_url(ltrim($route, '/'));
    echo "<a href='" . htmlspecialchars($url) . "'>→ " . htmlspecialchars($label) . "</a>";
}
echo "</div>";

// Test 4: Expected Flow
echo "<div class='test-section warn'>";
echo "<h3>Test 4: Expected Authentication Flow</h3>";
echo "<ol>";
echo "<li><strong>Fresh Start:</strong> Visit <a href='" . base_url('/') . "' style='display: inline;'>/ (root)</a> → Should show <span class='session-var'>Login Page</span></li>";
echo "<li><strong>Login:</strong> Email: <span class='session-var'>admin</span>, Password: <span class='session-var'>admin123</span></li>";
echo "<li><strong>After Login:</strong> Should redirect to <span class='session-var'>/form</span> or <span class='session-var'>/admin</span></li>";
echo "<li><strong>Session Active:</strong> All session variables should be set</li>";
echo "<li><strong>Logout:</strong> Click <span class='session-var'>Close & Logout</span> button on any page</li>";
echo "<li><strong>After Logout:</strong> Session destroyed, redirect to <span class='session-var'>/auth/login</span></li>";
echo "<li><strong>Protected Routes:</strong> Try accessing <span class='session-var'>/form</span> without login → Should redirect to <span class='session-var'>/auth/login</span></li>";
echo "</ol>";
echo "</div>";

// Test 5: Database Check
echo "<div class='test-section'>";
echo "<h3>Test 5: Database Status</h3>";
try {
    $db = db_connect();
    
    // Check tables
    $tables = ['users', 'forms', 'migrations'];
    $allTablesExist = true;
    foreach ($tables as $table) {
        $exists = $db->tableExists($table);
        $status = $exists ? '✓' : '✗';
        $class = $exists ? 'pass' : 'fail';
        echo "<div class='test-result " . $class . "'>" . $status . " Table: <span class='session-var'>" . htmlspecialchars($table) . "</span></div>";
        if (!$exists) $allTablesExist = false;
    }
    
    // Check admin user
    $userCount = $db->table('users')->countAllResults();
    echo "<div class='test-result pass'>✓ Users in database: <span class='session-var'>" . $userCount . "</span></div>";
    
    echo "<div class='test-section " . ($allTablesExist && $userCount > 0 ? 'pass' : 'fail') . "'>";
    if ($allTablesExist && $userCount > 0) {
        echo "<p>✓ Database is properly configured</p>";
    } else {
        echo "<p>✗ Database needs setup: Run <span class='session-var'>php spark migrate</span></p>";
    }
    echo "</div>";
} catch (Exception $e) {
    echo "<div class='test-result fail'>✗ Database Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}
echo "</div>";

// Test 6: Important Notes
echo "<div class='test-section info'>";
echo "<h3>Test 6: Important Notes</h3>";
echo "<ul>";
echo "<li><strong>Fresh Start Rule:</strong> Visiting <a href='" . base_url('/') . "' style='display: inline;'>root (/)</a> will ALWAYS check session first</li>";
echo "<li><strong>If Logged In:</strong> Root redirects to <span class='session-var'>/form</span> (user) or <span class='session-var'>/admin</span> (admin)</li>";
echo "<li><strong>If NOT Logged In:</strong> Root redirects to <span class='session-var'>/auth/login</span></li>";
echo "<li><strong>Logout Button:</strong> Now labeled <span class='session-var'>Close & Logout</span> - logs out AND closes the page</li>";
echo "<li><strong>Protected Routes:</strong> All <span class='session-var'>/form</span> and <span class='session-var'>/admin</span> routes require authentication</li>";
echo "<li><strong>Session Files:</strong> Located at <span class='session-var'>writable/session/</span></li>";
echo "<li><strong>Clear Session:</strong> Visit <a href='" . base_url('clear-session.php') . "' style='display: inline;'>clear-session.php</a> to manually clear (dev only)</li>";
echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<p style='text-align: center; color: #666; font-size: 0.9rem;'>";
echo "⚠️ <strong>Development Tool:</strong> Delete this file (<span class='session-var'>test-auth-flow.php</span>) before production!<br>";
echo "Last Updated: 2026-04-30";
echo "</p>";
echo "</body>";
echo "</html>";
?>

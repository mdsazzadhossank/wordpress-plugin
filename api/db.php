
<?php
// Try to load WordPress environment to use its DB credentials
// Look for wp-load.php in standard locations relative to plugins folder
$wp_load_path = '';
if (file_exists(__DIR__ . '/../../../wp-load.php')) {
    $wp_load_path = __DIR__ . '/../../../wp-load.php';
} elseif (file_exists(__DIR__ . '/../../../../wp-load.php')) {
    $wp_load_path = __DIR__ . '/../../../../wp-load.php';
}

if ($wp_load_path) {
    // We are in a WP environment
    // Define SHORTINIT to load minimal WP resources (faster)
    define('SHORTINIT', true);
    require_once($wp_load_path);
    
    // Use WP constants
    $servername = DB_HOST;
    $username = DB_USER;
    $password = DB_PASSWORD;
    $dbname = DB_NAME;
} else {
    // Fallback for standalone local testing (Keep your local creds here if needed)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecommerce_db";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Return JSON error so frontend handles it gracefully
    die(json_encode(["error" => "Database Connection failed: " . $conn->connect_error]));
}

// Set charset
$conn->set_charset("utf8mb4");
?>

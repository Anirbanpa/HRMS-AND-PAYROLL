<?php

$host = '127.0.0.1';
$port = 3306;
$db   = 'enterprise_hrms';
$user = 'root';
$pass = '12345678';

echo "Connecting to MySQL...\n";

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    echo "Connected successfully to {$db}!\n";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage() . "\n");
}

$sqlFile = __DIR__ . '/database/enterprise_hrms_missing_modules.sql';
if (!file_exists($sqlFile)) {
    die("SQL file not found at: {$sqlFile}\n");
}

$sql = file_get_contents($sqlFile);

// Disable foreign key checks during migration
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");

// Split statements by semicolon at the end of line, or standard SQL parser
// Better yet: use multi_query via mysqli or execute statement by statement
// Let's use mysqli for multi_query or clean parser
$mysqli = new mysqli($host, $user, $pass, $db, $port);
if ($mysqli->connect_error) {
    die("MySQLi connect error: " . $mysqli->connect_error . "\n");
}

echo "Executing SQL statements via multi_query...\n";
if ($mysqli->multi_query($sql)) {
    $count = 0;
    do {
        $count++;
        // flush multi_queries
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());
    
    if ($mysqli->errno) {
        echo "Warning/Error on batch {$count}: " . $mysqli->error . " (Code: " . $mysqli->errno . ")\n";
    } else {
        echo "All statements in multi_query executed successfully! (Batches: {$count})\n";
    }
} else {
    echo "Initial multi_query error: " . $mysqli->error . "\n";
}

// Re-enable FK checks
$mysqli->query("SET FOREIGN_KEY_CHECKS = 1;");
$mysqli->close();

echo "Verifying tables in database...\n";
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
echo "Total tables now: " . count($tables) . "\n";
echo "Tables:\n" . implode(", ", $tables) . "\n";


<?php
$db_path = 'chess_class.db';

// Check if the database file exists, and create it if it doesn't
if (!file_exists($db_path)) {
    touch($db_path); // Create an empty file
}

// Open the database (this will create the file if it doesn't exist)
$db = new SQLite3($db_path);

if (!$db) {
    die("Failed to connect to the database.");
}

// Enable exceptions for better error handling
$db->enableExceptions(true);

try {
    // Create sessions table if it doesn't exist
    $db->exec("
        CREATE TABLE IF NOT EXISTS sessions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            session_number INTEGER NOT NULL,
            session_date TEXT NOT NULL,
            attendance TEXT NOT NULL,
            topics TEXT NOT NULL,
            homework TEXT NOT NULL,
            game_analysis TEXT NOT NULL
        )
    ");
} catch (Exception $e) {
    die("Failed to create the sessions table: " . $e->getMessage());
}
?>
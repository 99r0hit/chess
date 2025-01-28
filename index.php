<?php
include 'db.php';

// Fetch all sessions in reverse chronological order
$sessions = $db->query("SELECT * FROM sessions ORDER BY session_date DESC");

if (!$sessions) {
    die("Failed to fetch session data.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chess Class Sessions</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="public-container">
        <h1>Chess Class Sessions</h1>
        <a href="login.php" class="login-link">Coach Login</a> <!-- Add this line -->
        <?php while ($row = $sessions->fetchArray(SQLITE3_ASSOC)): ?>
            <div class="session">
                <h2>Session <?= $row['session_number'] ?> - <?= $row['session_date'] ?></h2>
                <p><strong>Attendance:</strong> <?= $row['attendance'] ?></p>
                <p><strong>Topics Covered:</strong> <?= $row['topics'] ?></p>
                <p><strong>Homework Assigned:</strong> <?= $row['homework'] ?></p>
                <p><strong>Game Analysis:</strong> <?= $row['game_analysis'] ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
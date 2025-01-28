<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session_number = $_POST['session_number'];
    $session_date = $_POST['session_date'];
    $attendance = $_POST['attendance'];
    $topics = $_POST['topics'];
    $homework = $_POST['homework'];
    $game_analysis = $_POST['game_analysis'];

    $stmt = $db->prepare("
        INSERT INTO sessions (session_number, session_date, attendance, topics, homework, game_analysis)
        VALUES (:session_number, :session_date, :attendance, :topics, :homework, :game_analysis)
    ");
    $stmt->bindValue(':session_number', $session_number, SQLITE3_INTEGER);
    $stmt->bindValue(':session_date', $session_date, SQLITE3_TEXT);
    $stmt->bindValue(':attendance', $attendance, SQLITE3_TEXT);
    $stmt->bindValue(':topics', $topics, SQLITE3_TEXT);
    $stmt->bindValue(':homework', $homework, SQLITE3_TEXT);
    $stmt->bindValue(':game_analysis', $game_analysis, SQLITE3_TEXT);
    $stmt->execute();
}

// Fetch all sessions
$sessions = $db->query("SELECT * FROM sessions ORDER BY session_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Coach Dashboard</h1>
        <a href="logout.php" class="logout">Logout</a>

        <!-- Add Session Form -->
        <form method="POST">
            <h2>Add New Session</h2>
            <label for="session_number">Session Number:</label>
            <input type="number" id="session_number" name="session_number" required>
            <label for="session_date">Session Date:</label>
            <input type="date" id="session_date" name="session_date" required>
            <label for="attendance">Attendance (comma-separated):</label>
            <input type="text" id="attendance" name="attendance" required>
            <label for="topics">Topics Covered:</label>
            <textarea id="topics" name="topics" required></textarea>
            <label for="homework">Homework Assigned:</label>
            <textarea id="homework" name="homework" required></textarea>
            <label for="game_analysis">Game Analysis:</label>
            <textarea id="game_analysis" name="game_analysis" required></textarea>
            <button type="submit">Add Session</button>
        </form>

        <!-- Session List -->
        <h2>Session Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Session Number</th>
                    <th>Date</th>
                    <th>Attendance</th>
                    <th>Topics</th>
                    <th>Homework</th>
                    <th>Game Analysis</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $sessions->fetchArray(SQLITE3_ASSOC)): ?>
                    <tr>
                        <td><?= $row['session_number'] ?></td>
                        <td><?= $row['session_date'] ?></td>
                        <td><?= $row['attendance'] ?></td>
                        <td><?= $row['topics'] ?></td>
                        <td><?= $row['homework'] ?></td>
                        <td><?= $row['game_analysis'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
session_start();

// 1. Restriction: Only logged-in users can see this (Requirement: Authorization)
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Team Tracker</title>
</head>
<body class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Team Tracker</h1>
        <a href="logout.php" class="btn btn-outline-danger">Logout</a>
    </div>

    <a href="add_team.php" class="btn btn-primary mb-3">Add Team</a>
    
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Team Name</th>
                <th>Position</th>
                <th>Player Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM teams");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>";
                if (!empty($row['team_image'])) {
                    echo "<img src='uploads/" . htmlspecialchars($row['team_image']) . "' width='50' class='rounded'>";
                } else {
                    echo "<span class='text-muted'>No Image</span>";
                }
                echo "</td>";
                echo "<td>" . htmlspecialchars($row['team_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                echo "<td>" . htmlspecialchars($row['player_name']) . "</td>";
                echo "<td>
                        <a href='edit_team.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning'>Edit</a>
                        <a href='delete_team.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                      </td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>





<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title> Team Tracker </title>
</head>
    <body class ='container py-5">
    <h1 class="mb-4"> Team Tracker </h1>
    <a href="add_team.php" class="btn btn-primary mb-3"> Add Team </a>
    <table class="table table-bordered">
        <thread>
            <tr>
                <th> Team Name </th>
                <th> Position </th>
                <th> Player Name </th>
                <th> Actions </th>
            </tr>
        </thread>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM teams");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['team_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                echo "<td>" . htmlspecialchars($row['player_name']) . "</td>";
                echo "<td>
                        <a href='edit_team.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning'> Edit </a>
                        <a href='delete_team.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'> Delete </a>
                      </td>";





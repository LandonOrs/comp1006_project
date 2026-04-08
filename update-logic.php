<?php
require 'db.php';
// gets id from player from url query string
$id = $_GET['id'];
$team_name = $_POST['team_name'];
$position = $_POST['position'];

// server side validation
if (empty($team_name) || empty($position)) {
    die("Team name and position are required.");
}

// update the team in the database
$stmt = $pdo->prepare("UPDATE teams SET team_name = :team_name, position = :position WHERE id = :id");
$stmt->bindParam(':team_name', $team_name);
$stmt->bindParam(':position', $position);
$stmt->bindParam(':id', $id);
if ($stmt->execute()) {
    header("Location: index.php");
    exit();
} else {
    die("Error updating team.");
}
?>
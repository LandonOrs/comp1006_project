<?php
session_start();

// Only allow POST requests for update logic to prevent direct URL access
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require 'db.php';

// Grab data from post array
$id = $_POST['id'] ?? null;
$team_name = trim($_POST['team_name'] ?? '');
$position = trim($_POST['position'] ?? '');
$player_name = trim($_POST['player_name'] ?? '');

if (!$id || $team_name === '' || $position === '' || $player_name === '') {
    die('Missing required form data.');
}
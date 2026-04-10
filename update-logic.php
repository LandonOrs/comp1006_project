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

// Grab and validate data from POST
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$team_name = trim($_POST['team_name'] ?? '');
$position = trim($_POST['position'] ?? '');
$player_name = trim($_POST['player_name'] ?? '');

if (!$id || $team_name === '' || $position === '' || $player_name === '') {
    die('Missing required form data.');
}

if (strlen($team_name) > 255 || strlen($position) > 255 || strlen($player_name) > 255) {
    die('Input values exceed allowed length.');
}

$image_name = null;
$upload_dir = __DIR__ . '/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if (isset($_FILES['team_image']) && $_FILES['team_image']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['team_image']['error'] !== UPLOAD_ERR_OK) {
        die('Image upload error.');
    }

    $image_tmp_path = $_FILES['team_image']['tmp_name'];
    $image_info = @getimagesize($image_tmp_path);
    $allowed_types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_GIF => 'gif'];

    if (!$image_info || !isset($allowed_types[$image_info[2]])) {
        die('Invalid image type.');
    }

    if ($_FILES['team_image']['size'] > 2 * 1024 * 1024) {
        die('Image file too large. Maximum size is 2MB.');
    }

    $image_base = pathinfo($_FILES['team_image']['name'], PATHINFO_FILENAME);
    $image_base = preg_replace('/[^A-Za-z0-9_-]/', '', $image_base);
    $image_ext = $allowed_types[$image_info[2]];
    $image_name = sprintf('%s_%s.%s', $image_base ?: 'team', time(), $image_ext);
    $destination = $upload_dir . $image_name;

    if (!move_uploaded_file($image_tmp_path, $destination)) {
        die('Failed to move uploaded image.');
    }

    $oldImageStmt = $pdo->prepare('SELECT team_image FROM teams WHERE id = :id');
    $oldImageStmt->execute([':id' => $id]);
    $oldImage = $oldImageStmt->fetchColumn();

    if ($oldImage && file_exists($upload_dir . $oldImage)) {
        @unlink($upload_dir . $oldImage);
    }
}

if ($image_name) {
    $sql = 'UPDATE teams SET team_name = :team_name, position = :position, player_name = :player_name, team_image = :team_image WHERE id = :id';
} else {
    $sql = 'UPDATE teams SET team_name = :team_name, position = :position, player_name = :player_name WHERE id = :id';
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':team_name', $team_name, PDO::PARAM_STR);
$stmt->bindValue(':position', $position, PDO::PARAM_STR);
$stmt->bindValue(':player_name', $player_name, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

if ($image_name) {
    $stmt->bindValue(':team_image', $image_name, PDO::PARAM_STR);
}

if ($stmt->execute()) {
    header('Location: index.php?msg=success');
    exit();
}

die('Failed to update team.');


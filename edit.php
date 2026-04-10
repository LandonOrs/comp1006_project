<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require 'db.php';

// Get the id from the url

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$id = $_GET['id'];

// Fetch the team data from the database
$stmt = $pdo->prepare("SELECT * FROM teams WHERE id = ?");
$stmt->execute([$id]);
$team = $stmt->fetch();

if (!$team) {
    die("Team not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <title> Edit Team </title>
    </head>
    <body class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 shadow p-4 border rounded">
            <h1 class="mb-4">Edit Team</h1>
            <form action="update-logic.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="mb-3">
                    <label for="team_name" class="form-label">Team Name</label>
                    <input type="text" class="form-control" id="team_name" name="team_name" value="<?php echo htmlspecialchars($team['team_name']); ?>" required>         
                </div>
                
                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($team['position']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="player_name" class="form-label">Player Name</label>
                    <input type="text" class="form-control" id="player_name" name="player_name" value="<?php echo htmlspecialchars($team['player_name']); ?>" required>   
                </div>

                <div class="mb-3">
                    <label for="team_image" class="form-label">Update Team Image</label>
                    <input type="file" class="form-control" id="team_image" name="team_image">
                    <small class="text-muted">Leave blank to keep current image.</small>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update Team</button>
                    <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
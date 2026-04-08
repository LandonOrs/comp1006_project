<?php
// connecting to database
require 'db.php';

//get the team id from the query string
$id = $_GET['id'];

if (isset($id)) {
    // prepare and execute the delete statement
    $stmt = $pdo->prepare("DELETE FROM teams WHERE id = :id");
    $stmt = $pdo->prepare("DELETE FROM teams WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// redirect back to the index page
<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password'] ?? '');

    if (!$email || strlen($password) < 8) {
        die('Please provide a valid email and a password of at least 8 characters.');
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    if ($stmt->execute(['email' => $email, 'password' => $passwordHash])) {
        header("Location: login.php");
        exit();
    } else {
        die("Error registering user.");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <title> Register </title>
    </head>
    <body class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 shadow p-4 border rounded">
            <h1 class="mb-4">Register</h1>
            <form action="register.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>         
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
    </body>
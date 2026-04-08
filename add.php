<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title> Add Team </title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" async defer></script>
</head>

<body class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4"> Add Team </h1>
            <form action="add.php" method="post">

        <div class="mb-3">
            <label for="team_name" class="form-label"> Team Name </label>
            <input type="text" class="form-control" id="team_name" name="team_name" required>        
    </div>
        <div class="mb-3">
            <label for="position" class="form-label"> Position </label>
            <input type="text" class="form-control" id="position" name="position" required>
        </div>

        <div class="mb-3">
            <label for="player_name" class="form-label"> Player Name </label>
            <input type="text" class="form-control" id="player_name" name="player_name" required>   
        </div>
        <button type="submit" class="btn btn-primary"> Add Team </button>
    </form>
</div>
</div>
</body>
</html>
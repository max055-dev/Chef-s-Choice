<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<form method="POST" action="verwerk_inlog.php">
    <div class="form-group">
    <label for="email">E-mail</label>
    <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
    <label for="wachtwoord">Wachtwoord</label>
    <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
    </div>
    <button type='submit' class='btn btn-primary'>Inloggen</button>
    <a href='index.php'> registreren</a>
</form>
</body>
</html>
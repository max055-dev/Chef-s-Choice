
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>webshopwinkel</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div class='container'>
            <h2 class='mt-5'>Registreren</h2>
            <form action="verwerk_registratie.php" method='post' class='mt-3'> 
                <div> 
                    <div class="form-group">
                        <label for="voornaam">Voornaam</label>
                        <input type="text" class="form-control" id="voornaam" name="voornaam" required>
                    </div>
                    <div class="form-group">
                        <label for="achternaam">Achternaam</label>
                        <input type="text" class="form-control" id="achternaam" name="achternaam" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="wachtwoord">Wachtwoord</label>
                        <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
                    </div>
                    <div class='form-group'>
                        <label for='wachtwoord_bevestiging'>Bevestiging Wachtwoord</label>
                        <input type='password' class='form-control' id='wachtwoord_bevesteging' name='wachtwoord_bevestiging' required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registreren</button>

                    <a href='inlog.php'>inloggen</a>
                </div>
            </form>
        </div>
    </body>
    </html>

 
<!DOCTYPE html>
<html lang="nl" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chef's Choice – Registreren</title>

  <!-- Bootstrap 5 + Google Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --donkerbruin: #3E2723;
      --champagne-goud: #D4AF37;
      --crème: #FAF3E0;
      --diep-roodbruin: #7B3F00;
    }
    body {
      font-family: 'Lora', serif;
      background-color: var(--crème);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }
    .reg-card {
      background-color: var(--donkerbruin);
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 480px;
    }
    .reg-card h2 {
      font-family: 'Playfair Display', serif;
      color: var(--champagne-goud);
      margin-bottom: 1.5rem;
      text-align: center;
    }
    .form-control {
      background-color: #4e3a36;
      border: 1px solid var(--champagne-goud);
      color: var(--crème);
    }
    .form-control:focus {
      background-color: #5e4b47;
      border-color: var(--diep-roodbruin);
      box-shadow: 0 0 0 0.2rem rgba(212,175,55,0.25);
      color: #fff;
    }
    .btn-primary {
      background-color: var(--champagne-goud);
      border-color: var(--champagne-goud);
      color: var(--donkerbruin);
      font-weight: bold;
      width: 100%;
      text-transform: uppercase;
    }
    .btn-primary:hover {
      background-color: #b89130;
      border-color: #b89130;
    }
    .login-link {
      text-align: center;
      margin-top: 1rem;
    }
    .login-link a {
      color: var(--champagne-goud);
      text-decoration: none;
      font-weight: bold;
    }
    .login-link a:hover {
      color: var(--diep-roodbruin);
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="reg-card">
    <h2>Registreren</h2>
    <form action="verwerk_registratie.php" method="post">
      <div class="mb-3">
        <label for="voornaam" class="form-label text-light">Voornaam</label>
        <input type="text" class="form-control" id="voornaam" name="voornaam" required>
      </div>
      <div class="mb-3">
        <label for="achternaam" class="form-label text-light">Achternaam</label>
        <input type="text" class="form-control" id="achternaam" name="achternaam" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label text-light">E‑mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="wachtwoord" class="form-label text-light">Wachtwoord</label>
        <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
      </div>
      <div class="mb-3">
        <label for="wachtwoord_bevestiging" class="form-label text-light">Bevestig wachtwoord</label>
        <input type="password" class="form-control" id="wachtwoord_bevestiging" name="wachtwoord_bevestiging" required>
      </div>
      <button type="submit" class="btn btn-primary">Registreren</button>
    </form>
    <div class="login-link">
      <a href="inlog.php">Al een account? Inloggen</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

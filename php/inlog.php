<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chef's Choice – Inloggen</title>

  <!-- Bootstrap & Google Fonts -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
      color: var(--donkerbruin);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-card {
      background-color: var(--donkerbruin);
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 400px;
    }
    .login-card h2 {
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
    .register-link {
      display: block;
      text-align: center;
      margin-top: 1rem;
    }
    .register-link a {
      color: var(--champagne-goud);
      text-decoration: none;
      font-weight: bold;
    }
    .register-link a:hover {
      color: var(--diep-roodbruin);
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h2>Inloggen</h2>
    <form method="POST" action="verwerk_inlog.php">
      <div class="form-group">
        <label for="email" class="text-light">E‑mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="wachtwoord" class="text-light">Wachtwoord</label>
        <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
      </div>
      <button type="submit" class="btn btn-primary">Inloggen</button>
    </form>
    <div class="register-link">
      <a href="index.php">Registreren</a>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

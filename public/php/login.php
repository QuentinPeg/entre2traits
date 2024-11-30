<!DOCTYPE HTML>
<lang lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion - L'Entre-2-Traits</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" href="../img/logo.png">
        <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&display=swap" rel="stylesheet">
    </head>

    <body>

        <header>
            <img src="../img/logo.webp" alt="Logo L'Entre 2 Traits">
        </header>

        <main style="min-height: 100vh;">
            <h1>Connexion</h1>
            <form id="login-form">
                <label for="email">Email</label>
                <input type="email" id="email" required placeholder="Email">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" required placeholder="Mot de passe">
                <button type="submit">Se connecter</button>
            </form>
            <div id="error-message" style="color: red; display: none;"></div>
        </main>

        <!-- Footer -->
        <?php include "./footer.php"; ?>

        <script src="../js/login.js"></script>
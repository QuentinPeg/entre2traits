<!DOCTYPE HTML>
<lang lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>L'Entre-2-Traits</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" href="../img/logo.png">
        <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/interventions.css">
    </head>

    <body>
        <header>
            <img src="../img/logo.webp" alt="Logo L'Entre 2 Traits">
        </header>
        <nav>
            <a href="./index.php">Accueil</a>
            <a href="../php/atelier.php">Atelier</a>
            <a href="../php/travaux.php">Travaux d'élèves</a>
            <a href="../php/interventions.php"><span class="page">Les interventions</span></a>
            <a href="../php/parcours.php">Parcours</a>
            <a href="../php/contact.php">Contact</a>
            <a href="../php/actus.php">Actus</a>
            <a href="../php/boutique.php">Boutique</a>
            <span class="panier-link"></span>
            <img src="../img/panier.png" alt="panier" class="panier">
            <span class="nombre-articles-panier" id="panier-bulle">0</span>
        </nav>
        <main>
            <!-- Les divs des articles seront insérées ici via JavaScript -->
        </main>
        <?php include "./footer.php"; ?>

        <script src="../js/interventions.js"></script>
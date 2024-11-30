<!DOCTYPE HTML>
<lang lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>L'Entre-2-Traits</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" href="../img/logo.png">
        <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/carrousel.css">
        <link rel="stylesheet" href="../css/travaux.css">
    </head>

    <body>

        <!-- Header -->
        <header>
            <img src="../img/logo.webp" alt="Logo L'Entre 2 Traits">
        </header>

        <!-- Navigation -->
        <nav>
            <a href="./index.php">Accueil</a>
            <a href="../php/atelier.php">Atelier</a>
            <a href="../php/travaux.php"><span class="page">Travaux d'élèves</span></a>
            <a href="../php/interventions.php">Les interventions</a>
            <a href="../php/parcours.php">Parcours</a>
            <a href="../php/contact.php">Contact</a>
            <a href="../php/actus.php">Actus</a>
            <a href="../php/boutique.php">Boutique</a>
            <span class="panier-link"></span>
            <img src="../img/panier.png" alt="panier" class="panier">
            <span class="nombre-articles-panier" id="panier-bulle">0</span>
        </nav>

        <main>
            <section class="student-work">
                <h2>Travaux d'élèves</h2>

                <article class="carr">
                    <div id="carrousel1" class="carrousel index-page">
                        <img src="../img/2-euros-E2T-2016 copie.webp" alt="Image 1">
                        <img src="../img/Atelier.gif" alt="Image 2">
                        <img src="../img/boutique.gif" alt="Image 3">
                        <img src="../img/Actualite.gif" alt="Image 3">

                    </div>
                    <button class="prev">&#10094;</button>
                    <button class="next">&#10095;</button>
                </article>
            </section>

        </main>

        <!-- Footer -->
        <?php include "./footer.php"; ?>
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
</head>

<body>

    <!-- Header -->
    <header>
        <img src="../img/logo.webp" alt="Logo L'Entre 2 Traits">
    </header>

    <!-- Navigation -->
    <nav>
        <a href="./index.php"><span class="page">Accueil</span></a>
        <a href="../php/atelier.php">Atelier</a>
        <a href="../php/travaux.php">Travaux d'élèves</a>
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

        <!-- Section principale -->
        <section class="main-section">
            <h1>L'Entre-2-Traits</h1>

            <div class="icons">
                <a href="../php/atelier.php"><img src="../img/Atelier.gif" alt="Icone Atelier">
                    <p>L'atelier</p>
                </a>
                <a href="../php/atelier.php"><img src="../img/Actualite.gif" alt="Icone Actualités">
                    <p>Actualités</p>
                </a>
                <a href="../php/travaux.php"><img src="../img/travaux.gif" alt="Icone Travaux d'élèves">
                    <p>Travaux d'élèves</p>
                </a>
                <a href="../php/interventions.php"> <img src="../img/Contact.gif" alt="Icone Contact">
                    <p>Contact</p>
                </a>
                <a href="../php/boutique.php"><img src="../img/boutique.gif" alt="Icone Boutique">
                    <p>La boutique de MAVIF</p>
                </a>
            </div>

            <div class="content">
                <p>Bienvenue sur le site internet de l'Entre 2 Traits. Ambiance conviviale, échange de plaisir lors des ateliers, en toutes circonstances !</p>
                <p>Vous trouverez ici toutes les informations nécessaires et des dessins d'élèves !</p>

                <hr>

                <h2>Les infos du moment :</h2>
                <p>Cette année, l’atelier est partenaire du Pass culture et de la carte Tatoo !</p>
                <p>
                    Si vous voulez profitez de ces avantages, je vous invite à venir lors de la semaine d’inscription du 4 au 7 septembre aux horaires d’ouverture de l’atelier. Il faut pour cela que votre adhésion à ces deux organismes soit valable !
                </p>
            </div>

            <div id="ndpart">
                <img src="../img/message.webp" alt="message aux utilisateurs" id="img_accueil">
                <div>
                    <section>
                        <h5>Inscription et Règlement en ligne</h5>
                        <a href="https://www.payasso.fr/entre2traits/inscription" class="lien_s">
                            <img src="../img/carte-bleue-webp.webp" alt="">
                            <img src="../img/picto inscription.webp" alt="">
                        </a>
                    </section>

                    <!-- Carrousel de Travaux d'Élèves -->
                    <article class="carr">
                        <div id="carrousel1" class="carrousel index-page">
                            <img src="../img/2-euros-E2T-2016 copie.webp" alt="Image 1">
                            <img src="../img/Atelier.gif" alt="Image 2">
                            <img src="../img/boutique.gif" alt="Image 3">
                        </div>
                        <button class="prev">&#10094;</button>
                        <button class="next">&#10095;</button>
                    </article>

                    <article class="carr">
                        <div id="carrousel2" class="carrousel index-page">
                            <img src="../img/Actualite.gif" alt="Image 1">
                            <img src="../img/Atelier.gif" alt="Image 2">
                            <img src="../img/boutique.gif" alt="Image 3">
                        </div>
                        <button class="prev">&#10094;</button>
                        <button class="next">&#10095;</button>
                    </article>

                </div>
            </div>

        </section>
    </main>

    <!-- Footer -->

    <?php include "./footer.php"; ?>
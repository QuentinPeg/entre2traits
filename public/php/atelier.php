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
    <link rel="stylesheet" href="../css/atelier.css">


</head>

<body>

    <!-- Header -->
    <header>
        <img src="../img/logo.webp" alt="Logo L'Entre 2 Traits">
    </header>
    <!-- Navigation -->
    <nav>
        <a href="./index.php">Accueil</a>
        <a href="../php/atelier.php"><span class="page">Atelier</span></a>
        <a href="../php/travaux.php">Travaux d'élèves</a>
        <a href="../php/interventions.php">Les interventions</a>
        <a href="../php/parcours.php">Parcours</a>
        <a href="../php/contact.php">Contact</a>
        <a href="../php/actus.php">Actus</a>
        <a href="../php/boutique.php">Boutique</a>
        <span class="panier-link"></span>
        <img src="../img/panier.png" alt="panier" class="panier">
        <span class="nombre-articles-panier" id="panier-bulle">0</span>
        </span>
    </nav>
    <main>
        <section class="atelier-info">
            <h4>DESSIN / MANGA / PEINTURE / BANDE DESSINEE ET AUTRES EXPERIENCES</h4>

            <div class="atelier-left">
                <article class="carr">
                    <div id="carrousel3" class="carrousel">
                        <img src="../img/Actualite.gif" alt="Image 1">
                        <img src="../img/Atelier.gif" alt="Image 2">
                        <img src="../img/boutique.gif" alt="Image 3">
                    </div>
                    <button class="prev">&#10094;</button>
                    <button class="next">&#10095;</button>
                </article>


                <h2>L'atelier :</h2>
                <p>J'ai une approche <strong>ludique</strong> dans mes ateliers.</p>
                <p>C'est-à-dire que je pars de ce que vous voulez faire et apprendre...</p>
                <p>C'est donc également des cours <strong>personnalisés</strong> en fonction de vos attentes :
                </p>
                <ul>
                    <li>Dessin réaliste, croquis, manga, BD franco-belge...</li>
                    <li>Les ateliers sont en petits groupes de 12 participants maximum.</li>
                    <li>Ils sont organisés par <strong>tranche d'âge</strong>.</li>
                </ul>
                <p><strong>Tout le matériel nécessaire est fourni</strong> pour l'atelier, venez comme vous êtes
                    !</p>
                <p>L'entrée 2 Traits, 18 bis rue Ponsard, 38100 Grenoble, 06 13 21 20 27</p>
            </div>

            <div class="atelier-right">
                <div class="horaires">
                    <h2>Les horaires :</h2>
                    <ul>
                        <li>Mercredi : 14h30-16h, 16h30-18h, 18h30-20h</li>
                        <li>Vendredi : 18h30-20h</li>
                        <li>Jeudi : 18h30-20h</li>
                        <li>Samedi : 10h30-12h, 14h30-16h</li>
                    </ul>
                </div>
                <div class="tarifs">
                    <h2>Tarifs septembre 2024 :</h2>
                    <img src="../img/2-euros-E2T-2016 copie.webp" alt="Médaille tarif">
                    <ul>
                        <li>À l'année : 429 € au lieu de 442 €</li>
                        <li>Au trimestre : 182 €</li>
                        <li>À la carte : 17 € (1 séance)</li>
                        <li>Le stage : 65 €</li>
                    </ul>
                    <p>Les séances se font à l'année ou au trimestre...</p>
                </div>
            </div>
        </section>


    </main>
    <!-- Footer -->
    <?php include "./footer.php"; ?>

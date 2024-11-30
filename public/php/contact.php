<!DOCTYPE HTML>
<lang lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Entre-2-Traits</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/contact.css">

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
        <a href="../php/travaux.php">Travaux d'élèves</a>
        <a href="../php/interventions.php">Les interventions</a>
        <a href="../php/parcours.php">Parcours</a>
        <a href="../php/contact.php"><span class="page">Contact</span></a>
        <a href="../php/actus.php">Actus</a>
        <a href="../php/boutique.php">Boutique</a>
        <span class="panier-link"></span>
        <img src="../img/panier.png" alt="panier" class="panier">
        <span class="nombre-articles-panier" id="panier-bulle">0</span>
        </span>
    </nav>
    <main>

        <section id="main-contact">
            <h1>Contact</h1>
            <section>
                <p>L'Entre 2 Traits <br>
                    Frédéric Masson-villot</p>
                <p>18 bis rue Ponsard <br>
                    38100 Grenoble <br>
                    06 13 21 20 27
                </p>
            </section>
            <section class="contact-form">
                <form action="#" method="post">
                    <div class="form-group">
                        <label for="name">Nom *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Sujet</label>
                        <input type="text" id="subject" name="subject">
                    </div>
                    <div class="form-group">
                        <label for="phone">Téléphone*</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="participant">Prénom du participant *</label>
                        <input type="text" id="participant" name="participant" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Votre message</label>
                        <textarea id="message" name="message"></textarea>
                    </div>
                    <button type="submit">Envoyer</button>
                </form>
            </section>

            <section class="map-section">
                <div id="map"></div>
            </section>
        </section>



    </main>
    <!-- Footer -->
    <?php include "./footer.php"; ?>

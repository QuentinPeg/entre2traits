<!DOCTYPE HTML>
<lang lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>L'Entre-2-Traits - MANAGER</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" href="../img/logo.png">
        <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/manager.css">
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
            <a href="../php/contact.php">Contact</a>
            <a href="../php/actus.php">Actus</a>
            <a href="../php/boutique.php">Boutique</a>
            <span class="panier-link"></span>
            <img src="../img/panier.png" alt="panier" class="panier">
            <span class="nombre-articles-panier" id="panier-bulle">0</span>
        </nav>

        <main>
            <h1>Manger les interventions</h1>
            <a href="./manager.php"><button>Retour</button></a>
            <!-- Formulaire pour ajouter un article -->
            <form id="article-form">
                <h2>Ajouter un Article dans interventions</h2>
                <input type="text" id="article-title" placeholder="Titre" required>
                <input type="date" id="article-date" placeholder="Date de l'article" required>

                <!-- Sélection d'image existante -->
                <label for="article-image">Sélectionner une image</label>
                <select id="article-image" required>
                </select>
                <!-- Image sélectionnée en petit -->
                <img id="selectedImage" src="" alt="Image sélectionnée" style="display:none; max-width: 100px;" />
                <img id="selectedImage" src="" alt="Image sélectionnée" style="display:none;" />

                <textarea id="article-description" placeholder="Description" required></textarea>
                <input type="text" id="article-link" placeholder="Lien" required>
                <button type="submit">Ajouter l'Article</button>
                <p id="article-status"></p>
            </form>

            <!-- Formulaire pour gérer les images -->
            <section>
                <h2>Gestion des Images</h2>

                <!-- Formulaire pour ajouter une nouvelle image -->
                <form id="image-form">
                    <input type="file" id="image-upload" accept="image/*">
                    <button type="button" id="upload-image-button">Ajouter Image</button>
                    <p id="upload-status"></p>
                </form>

                <!-- Liste des images existantes avec options de suppression -->
                <ul id="images-container">
                    <!-- Les images disponibles seront chargées ici -->
                </ul>
            </section>

            <!-- Liste des articles existants -->
            <section id="article-list">
                <h2>Articles existants</h2>
                <ul id="articles-container">
                    <!-- Les articles seront chargés ici -->
                </ul>
            </section>
        </main>

        <!-- Footer -->
        <?php include "./footer.php"; ?>


        <script src="../js/connection.js"></script>
        <script src="../js/manager_interventions.js"></script>
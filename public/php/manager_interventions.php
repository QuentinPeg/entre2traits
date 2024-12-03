<!-- Header -->

<?php include "./header.php"; ?>
<link rel="stylesheet" href="../css/manager_interventions.css">

<main>
    <h1>Gestion des interventions</h1>
    <a href="./manager.php"><button>Retour</button></a>
    <!-- Formulaire pour ajouter un article -->
    <form id="article-form">
        <h2>Ajouter un Article dans interventions</h2>
        <input type="text" id="article-title" placeholder="Titre" required>

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
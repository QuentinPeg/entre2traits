<!-- Header -->

<?php include "./header_manager.php"; ?>
<link rel="stylesheet" href="../../css/manager_interventions.css">

<main>
    <h1 id="page_title">Gestion de la page d'actus</h1>
    <a href="../manager/manager.php"><button>Retour</button></a>

    <form id="actus-form" method="POST">
        <h2>Ajouter un actus dans actus</h2>
        <input type="text" id="actus-title" placeholder="Titre" required>
        <input type="date" id="actus-date" placeholder="Date" required> <!-- Nouveau champ de date -->

        <!-- Sélection d'image existante -->
        <label for="actus-image">Sélectionner une image</label>
        <select id="actus-image" required>
        </select>
        <!-- Image sélectionnée en petit -->
        <img id="selectedImage" src="" alt="Image sélectionnée" style="display:none; max-width: 100px;" />
        <img id="selectedImage" src="" alt="Image sélectionnée" style="display:none;" />

        <textarea id="actus-description" placeholder="Description" required></textarea>
        <button type="submit">Ajouter l'actus</button>
        <p id="actus-status"></p>
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

    <!-- Liste des actus existants -->
    <section id="actus-list">
        <h2>actus existants</h2>
        <ul id="actus-container">
            <!-- Les actus seront chargés ici -->
        </ul>
    </section>
</main>

<!-- Footer -->
<?php include "./footer_manager.php"; ?>


<script src="../../js/manager_actus.js"></script>
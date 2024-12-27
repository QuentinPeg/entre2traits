<div id="toast"></div>
<form id="form_Accueil" method="POST" enctype="multipart/form-data">
    <!-- Autres sections de formulaire ici... -->

    <div class="image-upload-section">
        <h2>Ajouter une Image</h2>
        <label for="image_upload">Sélectionnez une image :</label>
        <input type="file" id="image_upload" name="image_upload" accept="image/*"><br>
        <button type="submit" id="upload_button">Envoyer l'image</button>
    </div>
</form>

<!-- Aperçu des images dans le dossier ../../img/ -->
<div class="image-preview">
    <h3>Aperçu des Images</h3>
    <div class="image-gallery">
        <?php
        // Dossier contenant les images
        $imageDirectory = "../img/manager/";
        $images = array();

        // Lire le contenu du dossier
        if ($handle = opendir('../' . $imageDirectory)) {
            while (($file = readdir($handle)) !== false) {
                // Vérifier que le fichier est une image valide
                if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'ico', 'webp', 'avif'])) {
                    $images[] = $imageDirectory . $file; // Ajouter le chemin complet de l'image dans le tableau
                }
            }
            closedir($handle);
        }

        // Afficher les images
        foreach ($images as $image) {
            $imageName = basename($image);
            echo "<div class='image-item'>";
            echo "<span class='copy-link' data-clipboard='" . $image . "'>";
            echo "<img src='../" . $image . "' alt='Image' class='img-preview'>";
            echo "<p><strong>Lien:</strong> " . $image . "</p></span>";
            echo "</div>";
        }
        ?>

    </div>
</div>
<script src="../../js/copie.lien.img.js"></script>
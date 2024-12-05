<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image_upload'])) {
    $target_dir = "../img/"; // Dossier de destination des images
    $target_file = $target_dir . basename($_FILES["image_upload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $message = ''; // Variable pour stocker le message à afficher

    // Vérifier si l'image est une véritable image
    if (getimagesize($_FILES["image_upload"]["tmp_name"]) === false) {
        $message = "Erreur : Ce fichier n'est pas une image.";
    }
    // Vérifier la taille de l'image (maximum 5MB)
    elseif ($_FILES["image_upload"]["size"] > 5000000) {
        $message = "Erreur : L'image est trop grande.";
    }
    // Vérifier l'extension de l'image
    elseif ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "ico" && $imageFileType != "webp" && $imageFileType != "avif") {
        $message = "Erreur : Seules les images JPG, JPEG, PNG, ico, webp,avif et GIF sont autorisées.";
    }
    // Vérifier s'il y a un espace dans le nom du fichier
    elseif (strpos($_FILES["image_upload"]["name"], ' ') !== false) {
        $message = "Erreur : Les espaces ne sont pas autorisés dans les noms de fichiers.";
    }
    // Si toutes les vérifications passent, on déplace l'image
    else {
        if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_file)) {
            $message = "L'image " . basename($_FILES["image_upload"]["name"]) . " a été téléchargée avec succès.";
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    }

}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager - Atelier</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/manager_atelier.css">
    <script type="module" src="../js/supabase.js"></script>
</head>

<body>

    <?php include "./header.php"; ?>

    <main>
        <section class="main-section">
            <h1 id="page_title">Gestion de l'Atelier</h1>
            <a href="./manager.php"><button>Retour</button></a>

            <form id="form_Atelier" method="POST" enctype="multipart/form-data">
                <div class="atelier-form">
                    <label for="titre">Titre de l'atelier :</label>
                    <input type="text" id="titre" name="titre"><br>

                    <label for="description">Description :</label>
                    <textarea id="description" name="description" rows="4"></textarea><br>

                    <label for="horaires">Horaires :</label>
                    <textarea id="horaires" name="horaires" rows="4"></textarea><br>

                    <label for="tarifs">Tarifs :</label>
                    <textarea id="tarifs" name="tarifs" rows="4"></textarea><br>

                    <label for="adresse">Adresse :</label>
                    <input type="text" id="adresse" name="adresse"><br>

                    <label for="contact">Contact :</label>
                    <input type="text" id="contact" name="contact"><br>
                    <div class="carrousel-container">

                        <h2>Carrousels</h2>
                        <p style="color:red">Séparé les liens d'images par des "<span style="font:bold;">,</span>" dans
                            le carrousel</p>
                        <div id="contient_carrousel">
                            <div class="carrousel" style="display :none;">
                                <!--EST LA POUR EMPECHER UN BUG, N'APPARAIT PAS-->
                                <label for="carrousel_images">Est juste la pour empêche de bug</label>
                                <textarea id="carrousel_images" name="carrousel_images" rows="3"></textarea>
                            </div>
                            <div class="carrousel">
                                <label for="carrousel3_images">Images Carrousel (séparées par des virgules) :</label>
                                <textarea id="carrousel3_images" name="carrousel3_images" rows="3"></textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <button id="save_button" type="submit">Enregistrer les Modifications</button>
            </form>
            <!-- Aperçu des images dans le dossier ../img/ -->
            <div class="image-preview">
                <h3>Aperçu des Images</h3>
                <div class="image-gallery">
                    <?php
                    // Dossier contenant les images
                    $imageDirectory = "../img/";
                    $images = array();

                    // Lire le contenu du dossier
                    if ($handle = opendir($imageDirectory)) {
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
                        echo "<img src='" . $image . "' alt='Image' class='img-preview'>";
                        echo "<p><strong>Lien:</strong> " . $image . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
            </div>
        </section>
    </main>

    <?php include "./footer.php"; ?>

    <script>
        let currentRecordId = null;

        async function loadAtelierContent() {
            console.log("Chargement du contenu de l'atelier...");
            try {
                const { data, error } = await supabaseClient
                    .from('atelier_content')
                    .select('*')
                    .order('id', { ascending: true })
                    .limit(1)
                    .single();

                if (error) {
                    console.error("Erreur lors du chargement des données depuis Supabase :", error);
                    return;
                }

                console.log("Données chargées avec succès :", data);

                currentRecordId = data.id;

                // Correspondance des champs de formulaire avec les données
                const fields = {
                    'titre': 'titre',
                    'description': 'description',
                    'horaires': 'horaires',
                    'tarifs': 'tarifs',
                    'adresse': 'adresse',
                    'contact': 'contact',
                    'carrousel3_images': 'carrousel3_images'
                };

                Object.keys(fields).forEach(field => {
                    const input = document.getElementById(field);
                    if (input) {
                        let value = data[fields[field]] || '';

                        // Traiter les champs des carrousels pour enlever les crochets et guillemets
                        if (field.includes('carrousel')) {
                            // Si c'est un tableau JSON, le convertir en chaîne propre
                            if (Array.isArray(value)) {
                                value = value.join(','); // Convertir tableau en chaîne séparée par des virgules
                            } else if (typeof value === 'string' && value.startsWith('[') && value.endsWith(']')) {
                                // Si c'est une chaîne formatée JSON, nettoyer les crochets et les guillemets
                                value = value.slice(1, -1).replace(/"/g, '').replace(/,/g, ', ');
                            }
                        }


                        // Remplir les champs avec les données récupérées
                        input.value = value;
                        console.log(`Valeur du champ ${field}: ${value}`);
                    }
                });

            } catch (error) {
                console.error("Erreur de chargement des données :", error);
            }
        }

        // Mettre à jour les données dans Supabase
        async function updateAtelierContent(event) {
            event.preventDefault(); // Empêcher la soumission par défaut du formulaire

            console.log("Début de la mise à jour des données...");
            const formData = new FormData(document.getElementById('form_Atelier'));
            // Supprimer le champ "carrousel_images" du formulaire
            formData.delete('carrousel_images');
            console.log("Champ 'carrousel_images' supprimé.");

            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
                console.log(`Champ: ${key}, Valeur: ${value}`);
            });

            // Traiter le champ des images du carrousel
            if (data.carrousel3_images) {
                // Supprimer les espaces et séparer les URLs par des virgules
                data.carrousel3_images = data.carrousel3_images.split(',').map(url => url.trim()).join(',');
                console.log("URLs carrousel formatées :", data.carrousel3_images);
            }

            // Ajouter l'ID du record si existe
            if (currentRecordId) {
                data.id = currentRecordId;
                console.log("ID du record à mettre à jour:", currentRecordId);
            }

            try {
                const { error } = await supabaseClient.from('atelier_content').upsert(data, {
                    returning: 'minimal'
                });

                if (error) {
                    console.error("Erreur de mise à jour :", error);
                    alert("Erreur lors de la mise à jour des données.");
                    return;
                }

                console.log("Données mises à jour avec succès !");
                alert("Données mises à jour avec succès !");
            } catch (error) {
                console.error("Erreur lors de la mise à jour des données :", error);
                alert("Erreur lors de la mise à jour des données.");
            }
        }
        window.onload = () => {
            loadAtelierContent(); // Charger le contenu initial
        };

        document.getElementById('form_Atelier').addEventListener('submit', updateAtelierContent);
    </script>
</body>

</html>
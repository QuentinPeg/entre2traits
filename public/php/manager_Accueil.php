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
            echo"Erreur lors du téléchargement de l'image.";
        }
    }

}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager - Accueil</title>
    <link rel="stylesheet" href="../css/style.css">
    <script type="module" src="../js/supabase.js"></script>
</head>

<body>

    <?php include "./header.php"; ?>

    <main>
        <section class="main-section">
            <h1 id="page_title">Gestion de l'Accueil</h1>

            <form id="form_Accueil" method="POST">
                <div class="manager-icons">
                    <div class="icon-form">
                        <h3>Icône 1</h3>
                        <label for="icon1_link">Lien :</label>
                        <input type="string" id="icon1_link" name="icon1_link"><br>
                        <label for="icon1_img">Image :</label>
                        <input type="string" id="icon1_img" name="icon1_img"><br>
                        <label for="icon1_text">Texte :</label>
                        <textarea id="icon1_text" name="icon1_text" rows="2"></textarea>
                    </div>
                    <div class="icon-form">
                        <h3>Icône 2</h3>
                        <label for="icon2_link">Lien :</label>
                        <input type="string" id="icon2_link" name="icon2_link"><br>
                        <label for="icon2_img">Image :</label>
                        <input type="string" id="icon2_img" name="icon2_img"><br>
                        <label for="icon2_text">Texte :</label>
                        <textarea id="icon2_text" name="icon2_text" rows="2"></textarea>
                    </div>
                    <div class="icon-form">
                        <h3>Icône 3</h3>
                        <label for="icon3_link">Lien :</label>
                        <input type="string" id="icon3_link" name="icon3_link"><br>
                        <label for="icon3_img">Image :</label>
                        <input type="string" id="icon3_img" name="icon3_img"><br>
                        <label for="icon3_text">Texte :</label>
                        <textarea id="icon3_text" name="icon3_text" rows="2"></textarea>
                    </div>
                    <div class="icon-form">
                        <h3>Icône 4</h3>
                        <label for="icon4_link">Lien :</label>
                        <input type="string" id="icon4_link" name="icon4_link"><br>
                        <label for="icon4_img">Image :</label>
                        <input type="string" id="icon4_img" name="icon4_img"><br>
                        <label for="icon4_text">Texte :</label>
                        <textarea id="icon4_text" name="icon4_text" rows="2"></textarea>
                    </div>
                    <div class="icon-form">
                        <h3>Icône 5</h3>
                        <label for="icon5_link">Lien :</label>
                        <input type="string" id="icon5_link" name="icon5_link"><br>
                        <label for="icon5_img">Image :</label>
                        <input type="string" id="icon5_img" name="icon5_img"><br>
                        <label for="icon5_text">Texte :</label>
                        <textarea id="icon5_text" name="icon5_text" rows="2"></textarea>
                    </div>
                </div>

                <div class="content">
                    <h2>Contenu Principal</h2>
                    <label for="welcome_title">Titre :</label>
                    <textarea id="welcome_title" name="welcome_title" rows="2"></textarea><br>
                    <label for="welcome_message">Message de Bienvenue :</label>
                    <textarea id="welcome_message" name="welcome_message" rows="4"></textarea><br>
                    <label for="current_info">Informations Actuelles :</label>
                    <textarea id="current_info" name="current_info" rows="4"></textarea><br>
                    <label for="welcome_img">Image d'Accueil :</label>
                    <input type="string" id="welcome_img" name="welcome_img"><br>
                </div>
                <div class="inscription-section">
                    <h2>Inscription et Règlement en ligne</h2>
                    <label for="inscription_link">Lien :</label>
                    <input type="string" id="inscription_link" name="inscription_link"><br>
                </div>

                <div class="carrousel-container">
                    <h2>Carrousels</h2>
                    <p>Séparé les liens d'images par des , </p>
                    <div class="carrousel" style="display :none;"><!--EST LA POUR EMPECHER UN BUG, N'APPARAIT PAS-->
                        <label for="carrousel_images">Est juste la pour empêche de bug</label>
                        <textarea id="carrousel_images" name="carrousel_images" rows="3"></textarea>
                    </div>
                    <div class="carrousel">
                        <label for="carrousel1_images">Images Carrousel 1 (séparées par des virgules) :</label>
                        <textarea id="carrousel1_images" name="carrousel1_images" rows="3"></textarea>
                    </div>
                    <div class="carrousel">
                        <label for="carrousel2_images">Images Carrousel 2 (séparées par des virgules) :</label>
                        <textarea id="carrousel2_images" name="carrousel2_images" rows="3"></textarea>
                    </div>
                </div>

                <button id="save_button" type="submit">Enregistrer les Modifications</button>
            </form>

            <form id="form_Accueil" method="POST" enctype="multipart/form-data">
                <!-- Autres sections de formulaire ici... -->

                <div class="image-upload-section">
                    <h2>Ajouter une Image</h2>
                    <label for="image_upload">Sélectionnez une image :</label>
                    <input type="file" id="image_upload" name="image_upload" accept="image/*"><br>
                    <button type="submit" id="upload_button">Envoyer l'image</button>
                </div>
            </form>
            <?php
            // Récupération des images dans le dossier ../img/
            $dir = "../img/";
            $images = glob($dir . "*.{jpg,jpeg,png,gif,ico,webp,avif}", GLOB_BRACE); // Liste des images dans le dossier
            ?>

            <!-- Aperçu des images dans le dossier ../img/ -->
            <div class="image-preview">
                <h3>Aperçu des Images</h3>
                <div class="image-gallery">
                    <?php
                    // Affichage des images et des liens
                    foreach ($images as $image) {
                        $imageName = basename($image);
                        echo "<div class='image-item'>";
                        echo "<img src='" . $image . "' alt='Image' width='100' height='100'>";
                        echo "<p><strong>Lien:</strong> ../img/" . $imageName . "</p>";
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

        // Fonction pour charger les données depuis Supabase
        async function loadManagerContent() {
            console.log("Chargement du contenu...");

            try {
                const { data, error } = await supabaseClient
                    .from('accueil_content')
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

                const fields = [
                    'welcome_title', 'welcome_message', 'current_info', 'welcome_img',
                    'icon1_link', 'icon1_img', 'icon1_text',
                    'icon2_link', 'icon2_img', 'icon2_text',
                    'icon3_link', 'icon3_img', 'icon3_text',
                    'icon4_link', 'icon4_img', 'icon4_text',
                    'icon5_link', 'icon5_img', 'icon5_text',
                    'carrousel1_images', 'carrousel2_images',
                    'inscription_link', // Nouveaux champs
                ];

                // Remplissage des champs du formulaire
                fields.forEach(field => {
                    const input = document.getElementById(field);
                    if (input) {
                        let value = data[field] || '';

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

                        input.value = value;
                        console.log(`Valeur du champ ${field}: ${value}`);
                    }
                });
            } catch (error) {
                console.error("Erreur de chargement des données :", error);
            }
        }

        // Fonction pour mettre à jour les données dans Supabase
        async function updateManagerContent(event) {
            event.preventDefault(); // Empêcher le comportement par défaut de soumission du formulaire.

            console.log("Début de la mise à jour des données...");
            const formData = new FormData(document.getElementById('form_Accueil'));

            // Supprimer le champ "carrousel_images" du formulaire
            formData.delete('carrousel_images');
            console.log("Champ 'carrousel_images' supprimé.");

            const data = {};

            // Traitement des données du formulaire restantes
            formData.forEach((value, key) => {
                if (key.includes('carrousel')) {
                    data[key] = value.split(',').map(img => img.trim());
                    console.log(`Carrousel - Champ: ${key}, Valeur: ${data[key]}`);
                } else {
                    data[key] = value;
                    console.log(`Champ: ${key}, Valeur: ${value}`);
                }
            });

            // Ajout de l'ID si disponible
            if (currentRecordId) {
                data.id = currentRecordId;
                console.log("ID du record à mettre à jour:", currentRecordId);
            }

            try {
                // Mise à jour dans Supabase
                const { error } = await supabaseClient.from('accueil_content').upsert(data, {
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
            loadManagerContent(); // Charger le contenu
        };

        // Écouteur d'événement pour la soumission du formulaire
        document.getElementById('form_Accueil').addEventListener('submit', updateManagerContent);
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .main-section {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .manager-icons {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .icon-form,
        .content,
        .carrousel {
            background: #fff;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .icon-form {
            flex: 1;
            margin: 10px;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .manager-icons {
                flex-direction: column;
            }

            .icon-form {
                margin: 10px 0;
            }
        }

        .inscription-section {
            background: #fff;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</body>

</html>
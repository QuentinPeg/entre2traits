<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image_upload'])) {
    $target_dir = "../../img/"; // Dossier de destination des images
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

<?php include "./header_manager.php"; ?>

<main>
    <section class="main-section">
        <h1 id="page_title">Gestion de la page de parcours</h1>
        <a href="../manager/manager.php"><button>Retour</button></a>

        <form id="form_parcours" method="POST">
            <label for="image_url">URL de l'image :</label>
            <input type="text" id="image_url" name="image_url"><br>

            <label for="destination_url">URL de destination :</label>
            <input type="text" id="destination_url" name="destination_url"><br>

            <label for="parcours-titre">Titre :</label>
            <input id="parcours-titre" name="parcours-titre" rows="4"></input><br>

            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="4"></textarea><br>

            <button id="save_button" type="submit">Enregistrer les Modifications</button>
        </form>

        <!-- Aperçu des images dans le dossier ../../img/ -->
        <?php include "./view.img.directory.php"; ?>

    </section>
</main>

<?php include "./footer_manager.php"; ?>
<script>

    async function loadParcoursContent() {
        console.log("Chargement du contenu du parcours...");
        try {
            const { data, error } = await supabaseClient
                .from('parcours')
                .select('*')
                .order('id', { ascending: true })
                .single();

            if (error) {
                console.error("Erreur lors du chargement des données depuis Supabase :", error);
                return;
            }

            console.log("Données chargées avec succès :", data);

            currentRecordId = data.id;

            // Correspondance des champs de formulaire avec les données
            const fields = {
                'parcours-titre': 'titre',
                'description': 'description',
                'image_url': 'image_url',
                'destination_url': 'destination_url',
            };

            Object.keys(fields).forEach(field => {
                const input = document.getElementById(field);
                if (input) {
                    let value = data[fields[field]] || '';


                    // Remplir les champs avec les données récupérées
                    input.value = value;
                    console.log(`Valeur du champ ${field}: ${value}`);
                }
            });

        } catch (error) {
            console.error("Erreur de chargement des données :", error);
        }
    }

    window.onload = () => {
        loadParcoursContent(); // Charger le contenu initial
    };
</script>
// Fonction pour charger les images et peupler le dropdown
async function loadImages() {
    const bucket = 'images_interventions';

    try {
        // Récupérer les fichiers dans le bucket
        const { data: files, error } = await supabaseClient
            .storage
            .from(bucket)
            .list();

        if (error) throw error;

        if (!files || files.length === 0) {
            console.warn('Aucune image trouvée dans le bucket.');
            return;
        }

        const select = document.getElementById('actus-image');
        select.innerHTML = '<option value="">Sélectionner une image</option>'; // Option par défaut

        files.forEach(file => {
            // Vérifier si le fichier est un "emptyFolderPlaceholder" et ignorer
            if (file.name.includes('.emptyFolderPlaceholder')) {
                return;
            }

            // Générer l'URL publique
            const { data: publicUrlResponse, error: publicUrlError } = supabaseClient
                .storage
                .from(bucket)
                .getPublicUrl(file.name);

            if (publicUrlError) {
                console.error(`Erreur lors de la génération de l'URL pour ${file.name}:`, publicUrlError.message);
                return;
            }

            const publicUrl = publicUrlResponse.publicUrl;
            if (!publicUrl) {
                console.warn(`Pas d'URL publique disponible pour ${file.name}`);
                return;
            }

            // Créer l'option dans le select
            const option = document.createElement('option');
            option.value = publicUrl; // L'URL publique comme valeur
            option.textContent = file.name; // Le nom de fichier comme texte visible
            select.appendChild(option);
        });

    } catch (err) {
        console.error('Erreur lors du chargement des images:', err.message);
    }
}

document.getElementById('actus-image').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const selectedImageUrl = selectedOption.value;

    if (selectedImageUrl) {
        const selectedImage = document.getElementById('selectedImage');
        selectedImage.src = selectedImageUrl;
        selectedImage.style.display = 'block'; // Afficher l'image sélectionnée
    } else {
        document.getElementById('selectedImage').style.display = 'none'; // Cacher l'image si aucune sélection
    }
});

// Fonction pour ajouter un nouvel actus
async function addactus(title, description, link, imageUrl) {
    try {
        const { data, error } = await supabaseClient
            .from('actus')
            .insert([{ image_url: imageUrl, titre: title, description: description, lien: link }]);

        if (error) throw error;

        document.getElementById('actus-status').textContent = 'actus ajouté avec succès.';
        document.getElementById('actus-form').reset(); // Réinitialiser le formulaire
        loadactus(); // Recharger les actus après ajout
    } catch (err) {
        console.error('Erreur lors de l\'ajout de l\'actus:', err.message);
        document.getElementById('actus-status').textContent = 'Erreur lors de l\'ajout de l\'actus.';
    }
}

// Fonction pour charger les actus existants
async function loadactus() {
    try {
        const { data, error } = await supabaseClient
            .from('actus')
            .select('*');

        if (error) throw error;

        const container = document.getElementById('actus-container');
        container.innerHTML = '';

        data.forEach(actus => {
            const listItem = document.createElement('li');
            listItem.innerHTML = `
                <hr>
                <h3>${actus.titre}</h3>
                <img src="${actus.image_url}" alt="${actus.titre}" width="100">
                <p>${actus.description}</p>
                <a href="${actus.lien}" target="_blank">Lien de l'actus</a>
                <button onclick="deleteactus(${actus.id})">Supprimer</button>
                `;
            container.appendChild(listItem);
        });

    } catch (err) {
        console.error('Erreur lors du chargement des actus:', err.message);
    }
}

// Gestion de l'événement de soumission du formulaire
document.getElementById('actus-form').addEventListener('submit', async (event) => {
    event.preventDefault();

    const title = document.getElementById('actus-title').value;
    const description = document.getElementById('actus-description').value;
    const link = document.getElementById('actus-link').value;
    const imageSelect = document.getElementById('actus-image');
    Array.from(imageSelect.options).forEach((option, index) => {
    });

    const imageUrl = imageSelect.value; // Récupère directement la valeur sélectionnée

    if (title && description && link && imageUrl) {
        await addactus(title, description, link, imageUrl);
    } else {
        document.getElementById('actus-status').textContent = 'Veuillez remplir tous les champs.';
        console.warn('Tous les champs ne sont pas remplis.');
    }
});
// Fonction pour uploader une image
async function uploadImage(file) {
    const fileName = `${Date.now()}_${file.name}`;  // Générer un nom de fichier unique

    // Upload dans la racine du bucket
    const { data, error } = await supabaseClient
        .storage
        .from('images_interventions')
        .upload(fileName, file);  // Pas de sous-dossier ici, c'est directement à la racine

    if (error) {
        console.error('Erreur lors de l\'upload:', error.message);
        document.getElementById('upload-status').textContent = 'Erreur lors de l\'upload.';
        return;
    }

    await loadImages(); // Recharger les images après l'ajout
    document.getElementById('upload-status').textContent = 'Image ajoutée avec succès.';
}
// Fonction pour supprimer un actus
async function deleteactus(actusId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cet actus ?')) {
        return; // Annule la suppression si l'utilisateur clique sur "Annuler"
    }

    try {
        const { data, error } = await supabaseClient
            .from('actus')
            .delete()
            .eq('id', actusId); // Filtrer par l'ID de l'actus

        if (error) throw error;

        document.getElementById('actus-status').textContent = 'actus supprimé avec succès.';
        loadactus(); // Recharger la liste des actus après suppression
    } catch (err) {
        console.error('Erreur lors de la suppression de l\'actus:', err.message);
        document.getElementById('actus-status').textContent = 'Erreur lors de la suppression de l\'actus.';
    }
}
// Ajouter une nouvelle image
document.getElementById('upload-image-button').addEventListener('click', async () => {
    const fileInput = document.getElementById('image-upload');
    const file = fileInput.files[0];
    if (file) {
        await uploadImage(file);
    }
});

// Charger les images et actus au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    loadImages();
    loadactus();
});
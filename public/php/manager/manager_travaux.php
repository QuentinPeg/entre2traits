<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager - Travaux</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/manager_travaux.css">
    <script type="module" src="../../js/supabase.js"></script>
</head>

<?php include "./header_manager.php"; ?>

<main>
    <section class="main-section">
        <h1 id="page_title">Gestion de la page de travaux</h1>
        <a href="../manager/manager.php"><button>Retour</button></a>

        <label for="content_type">Choisir le type de contenu:</label>
        <select id="content_type" name="content_type">
            <option value="images">Images</option>
            <option value="videos">Vidéos</option>
        </select>

        <form id="form_travaux" method="POST">
            <h2>Ajouter un carousel</h2>
            <label for="carousel_title">Titre du carousel:</label>
            <input type="text" id="carousel_title" name="carousel_title" required>

            <label for="section_name">Nom de la section:</label>
            <input type="text" id="section_name" name="section_name" required>

            <p style="color:red">Séparé les liens d'images/vidéos par des "<span style="font:bold;">,</span>" dans le carrousel</p>
            <label for="carousel_content">Liens des images/vidéos du carousel :</label>
            <textarea id="carousel_content" name="carousel_content" rows="4" required></textarea>

            <button type="submit">Ajouter le carousel</button>
        </form>

        <h2>carousels existants</h2>
        <div id="carousels_list"></div>

        <!-- Aperçu des images dans le dossier ../../img/ -->
        <?php include "./view.img.directory.php"; ?>

    </section>

    <!-- Modal pour la modification du carousel -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-content-content">
                <h2>Modifier le carousel</h2>
                <label for="edit_carousel_title">Titre du carousel:</label>
                <input type="text" id="edit_carousel_title" name="edit_carousel_title" required>

                <label for="edit_section_name">Nom de la section:</label>
                <input type="text" id="edit_section_name" name="edit_section_name" required>

                <label for="edit_carousel_content">Liens des images/vidéos du carousel (séparés par des virgules):</label>
                <textarea id="edit_carousel_content" name="edit_carousel_content" rows="4" required></textarea>

                <button id="saveChanges">Enregistrer les modifications</button>
            </div>
        </div>
    </div>
</main>

<!-- Modal pour la confirmation de suppression -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-content-content">
            <h2>Confirmer la suppression</h2>
            <p>Êtes-vous sûr de vouloir supprimer ce carousel ?</p>
            <div>
                <button id="confirmDelete">Oui</button>
                <button id="cancelDelete">Non</button>
            </div>
        </div>
    </div>
</div>

<?php include "./footer_manager.php"; ?>

<script>
    document.getElementById('form_travaux').addEventListener('submit', async (event) => {
        event.preventDefault();

        const title = document.getElementById('carousel_title').value;
        const contentType = document.getElementById('content_type').value;
        const sectionName = document.getElementById('section_name').value;
        const content = document.getElementById('carousel_content').value.split(',').map(item => item.trim());

        const { error } = await supabaseClient
            .from('travaux')
            .insert([{ title: title, type: contentType, section: sectionName, content: content }]);

        if (error) {
            console.error('Erreur lors de l\'ajout du carousel:', error);
            alert('Erreur lors de l\'ajout du carousel.');
        } else {
            document.getElementById('form_travaux').reset();
            loadCarousels();
        }
    });

    async function loadCarousels() {
        const { data, error } = await supabaseClient
            .from('travaux')
            .select('*');

        if (error) {
            console.error('Erreur lors du chargement des carousels:', error);
            return;
        }

        const carouselsList = document.getElementById('carousels_list');
        carouselsList.innerHTML = '';

        data.forEach(carousel => {
            const carouselDiv = document.createElement('div');
            carouselDiv.className = 'carousel-item';
            carouselDiv.innerHTML = `
                    <h3>${carousel.title}</h3>
                    <div class="carousel-content">
                        ${carousel.content.map(item => carousel.type === 'images' ? `<img src="../${item}" alt="Image du carousel">` : `<iframe src="${item}"></iframe>`).join('')}
                    </div>
                    <button onclick="editCarousel(${carousel.id})">Modifier</button>
                    <button onclick="deleteCarousel(${carousel.id})">Supprimer</button>
                `;
            carouselsList.appendChild(carouselDiv);
        });
    }

    async function editCarousel(id) {
        const { data, error } = await supabaseClient
            .from('travaux')
            .select('*')
            .eq('id', id)
            .single();

        if (error) {
            console.error('Erreur lors de la récupération du carousel:', error);
            alert('Erreur lors de la récupération du carousel.');
            return;
        }

        // Préremplir les champs du modal
        document.getElementById('edit_carousel_title').value = data.title;
        document.getElementById('edit_section_name').value = data.section;
        document.getElementById('edit_carousel_content').value = data.content.join(',');

        // Afficher le modal
        const modal = document.getElementById('editModal');
        modal.style.display = 'block';

        // Enregistrer les modifications
        document.getElementById('saveChanges').onclick = async () => {
            const newTitle = document.getElementById('edit_carousel_title').value;
            const newSection = document.getElementById('edit_section_name').value;
            const newContent = document.getElementById('edit_carousel_content').value.split(',').map(item => item.trim());

            const { error } = await supabaseClient
                .from('travaux')
                .update({ title: newTitle, section: newSection, content: newContent })
                .eq('id', id);

            if (error) {
                console.error('Erreur lors de la modification du carousel:', error);
                alert('Erreur lors de la modification du carousel.');
            } else {
                modal.style.display = 'none';
                loadCarousels();
            }
        };
    }

    let carouselToDelete = null;

    async function deleteCarousel(id) {
        carouselToDelete = id;
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'block';
    }

    // Confirmer la suppression
    document.getElementById('confirmDelete').onclick = async () => {
        if (carouselToDelete !== null) {
            const { error } = await supabaseClient
                .from('travaux')
                .delete()
                .eq('id', carouselToDelete);

            if (error) {
                console.error('Erreur lors de la suppression du carousel:', error);
                alert('Erreur lors de la suppression du carousel.');
            } else {
                loadCarousels();
            }
            carouselToDelete = null;
            document.getElementById('deleteModal').style.display = 'none';
        }
    };

    // Annuler la suppression
    document.getElementById('cancelDelete').onclick = () => {
        carouselToDelete = null;
        document.getElementById('deleteModal').style.display = 'none';
    };

    // Fermer le modal
    document.querySelectorAll('.close').forEach(closeButton => {
        closeButton.onclick = () => {
            document.getElementById('deleteModal').style.display = 'none';
            document.getElementById('editModal').style.display = 'none';
        };
    });

    // Fermer le modal en cliquant en dehors
    window.onclick = (event) => {
        const deleteModal = document.getElementById('deleteModal');
        const editModal = document.getElementById('editModal');
        if (event.target == deleteModal) {
            deleteModal.style.display = 'none';
        }
        if (event.target == editModal) {
            editModal.style.display = 'none';
        }
    };

    loadCarousels();
</script>
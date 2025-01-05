<?php include "./upload.php"; ?>


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
        <select id="content_type" name="content_type" onchange="toggleForm()">
            <option value="images">Images</option>
            <option value="videos">Vidéos</option>
            <option value="buttons">Document (boutons)</option>
        </select>

        <form id="form_travaux" method="POST" style="display: none;">
            <h2>Ajouter un carousel</h2>
            <label for="carousel_title">Titre du carousel:</label>
            <input type="text" id="carousel_title" name="carousel_title" required>

            <label for="section_name">Nom de la section:</label>
            <input type="text" id="section_name" name="section_name" required>

            <p style="color:red">Séparé les liens d'images/vidéos par des "<span style="font:bold;">,</span>" dans le
                carrousel</p>
            <label id="carousel_content_label" for="carousel_content">Liens des images du carousel :</label>
            <textarea id="carousel_content" name="carousel_content" rows="4" required></textarea>

            <button type="submit">Ajouter le carousel</button>
        </form>

        <form id="form_buttons" method="POST" style="display: none;">
            <h2>Ajouter des boutons</h2>
            <label for="section_name_buttons">Nom de la section:</label>
            <input type="text" id="section_name_buttons" name="section_name_buttons" required>

            <label for="button_count">Nombre de boutons:</label>
            <input type="number" id="button_count" name="button_count" min="1" required>
            <button type="button" onclick="generateButtonFields()">Générer les champs de boutons</button>

            <div id="buttons_container"></div>

            <button type="submit">Ajouter les boutons</button>
        </form>

        <h2>Travaux existants</h2>
        <div id="travaux_list"></div>

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

                <label for="edit_carousel_content">Liens des images/vidéos du carousel (séparés par des
                    virgules):</label>
                <textarea id="edit_carousel_content" name="edit_carousel_content" rows="4" required></textarea>

                <div id="edit_buttons_container"></div>
                <button id="addButtonField">Ajouter un bouton</button>
                <button id="saveChanges">Enregistrer les modifications</button>
                <button id="deleteAllButtons">Supprimer tous les boutons</button>
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
    function toggleForm() {
        const contentType = document.getElementById('content_type').value;
        document.getElementById('form_travaux').style.display = contentType === 'images' || contentType === 'videos' ? 'flex' : 'none';
        document.getElementById('form_buttons').style.display = contentType === 'buttons' ? 'flex' : 'none';

        const formTravauxTitle = document.querySelector('#form_travaux h2');
        const carouselContentLabel = document.getElementById('carousel_content_label');
        if (contentType === 'images') {
            formTravauxTitle.textContent = 'Ajouter un carousel d\'images';
            carouselContentLabel.textContent = 'Liens des images du carousel :';
        } else if (contentType === 'videos') {
            formTravauxTitle.textContent = 'Ajouter un carousel de vidéos';
            carouselContentLabel.textContent = 'Liens des vidéos du carousel :';
        }
    }

    function generateButtonFields() {
        const buttonCount = document.getElementById('button_count').value;
        const buttonsContainer = document.getElementById('buttons_container');
        buttonsContainer.innerHTML = '';

        for (let i = 0; i < buttonCount; i++) {
            const buttonDiv = document.createElement('div');
            buttonDiv.className = 'button-field';

            const label = document.createElement('label');
            label.textContent = `Bouton ${i + 1}:`;

            const inputText = document.createElement('input');
            inputText.type = 'text';
            inputText.name = `button_text_${i}`;
            inputText.placeholder = 'Titre du bouton';
            inputText.required = true;

            const inputFile = document.createElement('input');
            inputFile.type = 'file';
            inputFile.name = `button_file_${i}`;
            inputFile.accept = '.pdf';
            inputFile.required = true;

            const inputImage = document.createElement('input');
            inputImage.type = 'text';
            inputImage.name = `button_image_${i}`;
            inputImage.placeholder = 'Lien de l\'image (optionnel)';

            buttonDiv.appendChild(label);
            buttonDiv.appendChild(inputText);
            buttonDiv.appendChild(inputFile);
            buttonDiv.appendChild(inputImage);
            buttonsContainer.appendChild(buttonDiv);
        }
    }

    document.getElementById('form_buttons').addEventListener('submit', async (event) => {
        event.preventDefault();

        const sectionName = document.getElementById('section_name_buttons').value;
        const buttonCount = document.getElementById('button_count').value;
        const buttons = [];

        for (let i = 0; i < buttonCount; i++) {
            const buttonText = document.querySelector(`input[name="button_text_${i}"]`).value;
            const buttonFile = document.querySelector(`input[name="button_file_${i}"]`).files[0];
            const buttonImage = document.querySelector(`input[name="button_image_${i}"]`).value;

            // Upload the file to the server
            const formData = new FormData();
            formData.append('file', buttonFile);
            const response = await fetch(window.location.href, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                console.error('Erreur lors du téléchargement du fichier:', response.statusText);
                alert('Erreur lors du téléchargement du fichier.');
                return;
            }

            const filePath = await response.text(); // Assuming the server returns the relative file path

            buttons.push({ text: buttonText, file: filePath, image: buttonImage });
        }

        const { error } = await supabaseClient
            .from('travaux')
            .insert([{ title: 'Boutons', type: 'buttons', section: sectionName, content: buttons }]);

        if (error) {
            console.error('Erreur lors de l\'ajout des boutons:', error);
            alert('Erreur lors de l\'ajout des boutons.');
        } else {
            document.getElementById('form_buttons').reset();
            loadCarousels();
        }
    });

    async function loadCarousels() {
        const { data, error } = await supabaseClient
            .from('travaux')
            .select('*');

        if (error) {
            console.error('Erreur lors du chargement des carrousels:', error);
            return;
        }

        const carouselsList = document.getElementById('travaux_list');
        carouselsList.innerHTML = '';

        data.forEach(carousel => {
            const carouselDiv = document.createElement('div');
            carouselDiv.className = 'carousel-item';
            carouselDiv.innerHTML = `
                    <h3>${carousel.title}</h3>
                    <div class="carousel-content">
                        ${carousel.content.map(item => carousel.type === 'images' ? `<img src="../${item}" alt="Image du carousel">` : carousel.type === 'videos' ? `<iframe src="${item}"></iframe>` : `<div><h4>${item.text}</h4><button onclick="window.open('../${item.file}', '_blank')">Lire</button></div>`).join('')}
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

        const editButtonsContainer = document.getElementById('edit_buttons_container');
        const editCarouselContent = document.getElementById('edit_carousel_content');
        const carouselContentLabel = document.querySelector('label[for="edit_carousel_content"]');
        const addButtonField = document.getElementById('addButtonField');

        editButtonsContainer.innerHTML = '';
        editCarouselContent.value = '';

        if (data.type === 'buttons') {
            editCarouselContent.style.display = 'none';
            carouselContentLabel.style.display = 'none';
            editButtonsContainer.style.display = 'block';
            addButtonField.style.display = 'inline-block';

            data.content.forEach((item, index) => {
                const buttonDiv = document.createElement('div');
                buttonDiv.className = 'button-field';

                const label = document.createElement('label');
                label.textContent = `Bouton ${index + 1}:`;

                const inputText = document.createElement('input');
                inputText.type = 'text';
                inputText.name = `edit_button_text_${index}`;
                inputText.value = item.text;
                inputText.required = true;

                const inputFile = document.createElement('input');
                inputFile.type = 'text';
                inputFile.name = `edit_button_file_${index}`;
                inputFile.value = item.file;
                inputFile.required = true;

                const inputImage = document.createElement('input');
                inputImage.type = 'text';
                inputImage.name = `edit_button_image_${index}`;
                inputImage.value = item.image || '';
                inputImage.placeholder = 'Lien de l\'image (optionnel)';

                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Supprimer';
                deleteButton.onclick = () => {
                    buttonDiv.remove();
                };

                buttonDiv.appendChild(label);
                buttonDiv.appendChild(inputText);
                buttonDiv.appendChild(inputFile);
                buttonDiv.appendChild(inputImage);
                buttonDiv.appendChild(deleteButton);
                editButtonsContainer.appendChild(buttonDiv);
            });
        } else {
            editCarouselContent.style.display = 'block';
            carouselContentLabel.style.display = 'block';
            editButtonsContainer.style.display = 'none';
            addButtonField.style.display = 'none';

            editCarouselContent.value = data.content.join(',');
            carouselContentLabel.textContent = data.type === 'images' ? 'Liens des images du carousel :' : 'Liens des vidéos du carousel :';
        }

        // Afficher le modal
        const modal = document.getElementById('editModal');
        modal.style.display = 'block';

        // Ajouter un nouveau champ de bouton
        addButtonField.onclick = () => {
            const index = editButtonsContainer.children.length;
            const buttonDiv = document.createElement('div');
            buttonDiv.className = 'button-field';

            const label = document.createElement('label');
            label.textContent = `Bouton ${index + 1}:`;

            const inputText = document.createElement('input');
            inputText.type = 'text';
            inputText.name = `edit_button_text_${index}`;
            inputText.placeholder = 'Titre du bouton';
            inputText.required = true;

            const inputFile = document.createElement('input');
            inputFile.type = 'text';
            inputFile.name = `edit_button_file_${index}`;
            inputFile.placeholder = 'Lien du fichier';
            inputFile.required = true;

            const inputImage = document.createElement('input');
            inputImage.type = 'text';
            inputImage.name = `edit_button_image_${index}`;
            inputImage.placeholder = 'Lien de l\'image (optionnel)';

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Supprimer';
            deleteButton.onclick = () => {
                buttonDiv.remove();
            };

            buttonDiv.appendChild(label);
            buttonDiv.appendChild(inputText);
            buttonDiv.appendChild(inputFile);
            buttonDiv.appendChild(inputImage);
            buttonDiv.appendChild(deleteButton);
            editButtonsContainer.appendChild(buttonDiv);
        };

        // Enregistrer les modifications
        document.getElementById('saveChanges').onclick = async () => {
            const newTitle = document.getElementById('edit_carousel_title').value;
            const newSection = document.getElementById('edit_section_name').value;
            const newContent = data.type === 'buttons' ? Array.from(editButtonsContainer.children).map((buttonDiv, index) => {
                const text = buttonDiv.querySelector(`input[name="edit_button_text_${index}"]`).value;
                const file = buttonDiv.querySelector(`input[name="edit_button_file_${index}"]`).value;
                const image = buttonDiv.querySelector(`input[name="edit_button_image_${index}"]`).value;
                return { text, file, image };
            }) : document.getElementById('edit_carousel_content').value.split(',');

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

        // Supprimer tous les boutons
        document.getElementById('deleteAllButtons').onclick = () => {
            editButtonsContainer.innerHTML = '';
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

    // Appeler toggleForm() pour afficher le formulaire des images par défaut
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('content_type').value = 'images';
        toggleForm();
    });

    loadCarousels();
</script>
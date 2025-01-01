
    <?php include "./header_manager.php"; ?>

    <main>
        <section class="main-section">
            <h1 id="page_title">Gestion de la page de contact</h1>
            <a href="../manager/manager.php"><button>Retour</button></a>

            <form id="form_contact" method="POST">
                <label for="adresse">Adresse :</label>
                <input type="text" id="adresse" name="adresse"><br>

                <label for="contact">Contact :</label>
                <input type="text" id="contact" name="contact" maxlength="14" pattern="\d{2} \d{2} \d{2} \d{2} \d{2}" title="Le contact doit contenir 10 chiffres séparés par des espaces"><br>

                <button id="save_button" type="submit">Enregistrer les Modifications</button>

            </form>

        </section>
    </main>

    <?php include "./footer_manager.php"; ?>

    <script>

        let currentRecordId = null;

        async function loadContactContent() {
            console.log("Chargement du contenu de contact...");
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
                    'adresse': 'adresse',
                    'contact': 'contact'
                };

                Object.keys(fields).forEach(field => {
                    const input = document.getElementById(field);
                    if (input) {
                        let value = data[fields[field]] || '';
                        if (field === 'contact') {
                            value = formatContact(value);
                        }
                        input.value = value;
                        console.log(`Valeur du champ ${field}: ${value}`);
                    }
                });

            } catch (error) {
                console.error("Erreur de chargement des données :", error);
            }
        }

        function formatContact(contact) {
            // Supprimer tous les caractères non numériques
            contact = contact.replace(/\D/g, '');

            // Limiter à 10 chiffres
            contact = contact.substring(0, 10);

            // Ajouter un espace après chaque paquet de 2 chiffres
            return contact.replace(/(\d{2})(?=\d)/g, '$1 ');
        }

        // Mettre à jour les données dans Supabase
        async function updateContactContent(event) {
            event.preventDefault(); // Empêcher la soumission par défaut du formulaire

            console.log("Début de la mise à jour des données...");
            const formData = new FormData(document.getElementById('form_contact'));

            const data = {};
            formData.forEach((value, key) => {
                if (key === 'contact') {
                    value = value.replace(/\s/g, ''); // Supprimer les espaces pour stocker uniquement les chiffres
                }
                data[key] = value;
                console.log(`Champ: ${key}, Valeur: ${value}`);
            });

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
            loadContactContent(); // Charger le contenu initial
        };

        document.getElementById('form_contact').addEventListener('submit', updateContactContent);

        // Ajouter un écouteur d'événement pour formater le champ de contact en temps réel
        document.getElementById('contact').addEventListener('input', function (e) {
            e.target.value = formatContact(e.target.value);
        });
    </script>

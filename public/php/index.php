<?php include "./header.php"; ?>

<main>
    <section class="main-section">
        <h1 id="title">Chargement...</h1>

        <div class="icons" id="icons">
            <!-- Les icônes seront injectées ici -->
        </div>

        <div class="content">
            <p id="welcome_message">Chargement...</p>
            <hr>
            <h2>Les infos du moment :</h2>
            <p id="current_info">Chargement...</p>
        </div>

        <div id="ndpart">
            <img src="" alt="Message aux utilisateurs" id="img_accueil">
            <div>
                <section>
                    <h5>Inscription et Règlement en ligne</h5>
                    <a id="inscription_link" href="#" class="lien_s">
                        <img src="../img/carte-bleue-webp.webp" alt="Carte de paiement">
                        <img src="../img/picto_inscription.webp" alt="Picto inscription">
                    </a>
                </section>

                <!-- Carrousel de Travaux d'Élèves -->
                <article class="carr">
                    <div id="carrousel1" class="carrousel index-page">
                        <!-- Images du carrousel 1 -->
                    </div>
                    <button class="prev">&#10094;</button>
                    <button class="next">&#10095;</button>

                </article>

                <article class="carr">
                    <div id="carrousel2" class="carrousel index-page">
                        <!-- Images du carrousel 2 -->
                    </div>
                    <button class="prev">&#10094;</button>
                    <button class="next">&#10095;</button>

                </article>
            </div>
        </div>
    </section>
</main>

<?php include "./footer.php"; ?>


<script>
    async function loadAccueilContent() {
        try {
            const { data, error } = await supabaseClient
                .from('accueil_content')
                .select('*')
                .single();

            if (error) {
                console.error("Erreur lors du chargement des données :", error);
                return;
            }

            // Injecter les données dynamiques dans la page
            document.getElementById('title').textContent = data.welcome_title;
            document.getElementById('welcome_message').textContent = data.welcome_message;
            document.getElementById('current_info').textContent = data.current_info;
            document.getElementById('img_accueil').src = data.welcome_img;

            // Icônes dynamiques
            const iconsHtml = `
                    <a href="${data.icon1_link}">
                        <img src="${data.icon1_img}" alt="Icone Atelier">
                        <p>${data.icon1_text}</p>
                    </a>
                    <a href="${data.icon2_link}">
                        <img src="${data.icon2_img}" alt="Icone Actualités">
                        <p>${data.icon2_text}</p>
                    </a>
                    <a href="${data.icon3_link}">
                        <img src="${data.icon3_img}" alt="Icone Travaux d'élèves">
                        <p>${data.icon3_text}</p>
                    </a>
                    <a href="${data.icon4_link}">
                        <img src="${data.icon4_img}" alt="Icone Contact">
                        <p>${data.icon4_text}</p>
                    </a>
                    <a href="${data.icon5_link}">
                        <img src="${data.icon5_img}" alt="Icone Boutique">
                        <p>${data.icon5_text}</p>
                    </a>
                `;
            document.getElementById('icons').innerHTML = iconsHtml;

            // Carrousels dynamiques
            let carrousel1Images = [];
            try {
                // Tenter de parser comme JSON
                carrousel1Images = JSON.parse(data.carrousel1_images);
            } catch (error) {
                // Si erreur, tenter de traiter comme texte séparé par des virgules
                carrousel1Images = data.carrousel1_images.split(',');
            }

            // Générer le HTML
            const carrousel1Html = carrousel1Images
                .map(img => `<img src="${img.trim()}" alt="Carrousel 1">`)
                .join('');
            document.getElementById('carrousel1').innerHTML = carrousel1Html;

            let carrousel2Images = [];
            try {
                carrousel2Images = JSON.parse(data.carrousel2_images);
            } catch (error) {
                carrousel2Images = data.carrousel2_images.split(',');
            }

            const carrousel2Html = carrousel2Images
                .map(img => `<img src="${img.trim()}" alt="Carrousel 2">`)
                .join('');
            document.getElementById('carrousel2').innerHTML = carrousel2Html;

        } catch (error) {
            console.error("Une erreur s'est produite :", error);
        }
    }

    // Charger les données lors du chargement de la page
    loadAccueilContent();

    function loadScriptDynamically(src, callback) {
        const script = document.createElement('script'); // Crée une balise <script>
        script.src = src; // Spécifie le chemin du script
        script.type = 'text/javascript'; // Définit le type
        script.async = true; // Permet un chargement asynchrone

        // Exécute une fonction lorsque le script est chargé
        script.onload = () => {
            console.log(`Script ${src} chargé avec succès.`);
            if (callback) callback();
        };

        // Gère les erreurs de chargement
        script.onerror = () => {
            console.error(`Erreur lors du chargement du script ${src}`);
        };

        // Ajoute le script dans le DOM
        document.head.appendChild(script); // ou document.body.appendChild(script);
    }

    setTimeout(() => {
        loadScriptDynamically('../js/carrousel.js', () => {
            console.log('Le script carrousel.js est prêt après 10 secondes.');
            // Vous pouvez appeler des fonctions ou initialiser des éléments ici
        });
    }, 5000); // 5 000 ms = 5 secondes

</script>
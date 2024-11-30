<!DOCTYPE HTML>
<lang lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>L'Entre-2-Traits</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" href="../img/logo.png">
        <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&display=swap" rel="stylesheet">


    </head>

    <body>

        <!-- Header -->
        <header>
            <img src="../img/logo.webp" alt="Logo L'Entre 2 Traits">
        </header>
        <!-- Navigation -->
        <nav>
            <a href="./index.php">Accueil</a>
            <a href="../php/atelier.php">Atelier</a>
            <a href="../php/travaux.php">Travaux d'élèves</a>
            <a href="../php/interventions.php">Les interventions</a>
            <a href="../php/parcours.php">Parcours</a>
            <a href="../php/contact.php">Contact</a>
            <a href="../php/actus.php">Actus</a>
            <a href="../php/boutique.php"><span class="page">Boutique</span></a>
            <span class="panier-link"></span>
            <img src="../img/panier.png" alt="panier" class="panier">
            <span class="nombre-articles-panier" id="panier-bulle">0</span>
            </span>
        </nav>
        <main>

            <div class="container">
                <div id="produit-detail"></div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js"></script>
            <script>
                const SUPABASE_URL = 'https://dquhqpoitxwaahkdrkfy.supabase.co';
                const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImRxdWhxcG9pdHh3YWFoa2Rya2Z5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjYzMTc3NTcsImV4cCI6MjA0MTg5Mzc1N30.ayeOG1udDkkBM0yPNI1v9F8Eox_0s7ja-6UVtSgj1KE';
                const supabaseClient = supabase.createClient(SUPABASE_URL, SUPABASE_KEY);

                async function fetchProduit() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const id = urlParams.get('id');

                    const { data, error } = await supabase
                        .from('boutique')
                        .select('*')
                        .eq('id', id)
                        .single();

                    if (error) {
                        console.error("Erreur lors du chargement du produit :", error);
                        return;
                    }

                    const produitDiv = document.getElementById('produit-detail');
                    produitDiv.innerHTML = `
        <img src="${data.image_url}" alt="${data.nom}">
        <h2>${data.nom}</h2>
        <p>${data.prix} €</p>
        <p>${data.description}</p>
    `;
                }

                // Charger le produit à l'ouverture de la page
                fetchProduit();


            </script>


        </main>
        <!-- Footer -->
        <?php include "./footer.php"; ?>
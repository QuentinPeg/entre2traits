<!-- Header -->

<?php include "./header.php"; ?>

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
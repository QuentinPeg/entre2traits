<!-- Header -->

<?php include "./header.php"; ?>
<main>

    <div class="container">
        <h1>Tous les articles</h1>
        <div id="articles" class="articles-grid"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js"></script>
    <script>
        const SUPABASE_URL = 'https://dquhqpoitxwaahkdrkfy.supabase.co';
        const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImRxdWhxcG9pdHh3YWFoa2Rya2Z5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjYzMTc3NTcsImV4cCI6MjA0MTg5Mzc1N30.ayeOG1udDkkBM0yPNI1v9F8Eox_0s7ja-6UVtSgj1KE';
        const supabaseClient = supabase.createClient(SUPABASE_URL, SUPABASE_KEY);

        async function fetchArticles() {
            const { data, error } = await supabase
                .from('boutique')
                .select('*');

            if (error) {
                console.error("Erreur lors du chargement des articles :", error);
                return;
            }

            const articlesGrid = document.getElementById('articles');

            data.forEach(article => {
                const articleDiv = document.createElement('div');
                articleDiv.classList.add('article');
                articleDiv.innerHTML = `
            <img src="${article.image_url}" alt="${article.nom}">
            <h2>${article.nom}</h2>
            <p>${article.prix} €</p>
            <a href="produit.php?id=${article.id}">Voir le produit</a>
        `;
                articlesGrid.appendChild(articleDiv);
            });
        }

        // Charger les articles à l'ouverture de la page
        fetchArticles();

    </script>


</main>
<!-- Footer -->
<?php include "./footer.php"; ?>
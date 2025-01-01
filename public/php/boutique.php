<!-- Header -->

<?php include "./header.php"; ?>

<head>
    <link rel="stylesheet" href="../css/boutique.css">
</head>

<main>

    <div class="container">
        <h1>Tous les articles</h1>
        <div id="articles"></div>
    </div>

</main>
<!-- Footer -->
<?php include "./footer.php"; ?>

<script>

    async function fetchArticles() {
        const { data, error } = await supabaseClient
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
            <h2>${article.nom}</h2>
            <a href="produit.php?id=${article.id}">
                <img src="${article.image_url}" alt="${article.nom}">
            </a>
            <p>${article.prix} €</p>
            <div>
                <a href="produit.php?id=${article.id}"><button>Voir le produit</button></a>
                <a><button>Ajouter au panier</button></a>
            </div>
        `;
            articlesGrid.appendChild(articleDiv);
        });
    }

    // Charger les articles à l'ouverture de la page
    fetchArticles();

</script>
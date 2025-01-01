<!-- Header -->

<?php include "./header.php"; ?>

<head>
    <link rel="stylesheet" href="../css/boutique.css">
</head>

<main>
    <div id="main-produit">
        <a href="./boutique.php"><button id="bouton-retour"><img src="../img/Retour.png"
                    alt="Bouton retour"></button></a>
        <div class="container">
            <div id="produit-detail"></div>
        </div>
    </div>
</main>

<!-- Footer -->
<?php include "./footer.php"; ?>

<script>

    async function fetchProduit() {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');

        const { data, error } = await supabaseClient
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
        <h2>${data.nom}</h2>
        <img src="${data.image_url}" alt="${data.nom}">
        <p>${data.prix} €</p>
        <p>${data.description}</p>
        <div>
            <a href="./boutique.php"><button> Retour à la boutique </button></a>
            <a><button>Ajouter au panier</button></a>
        </div>

    `;
    }

    // Charger le produit à l'ouverture de la page
    fetchProduit();


</script>
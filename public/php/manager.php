<!-- Header -->

<?php include "./header.php"; ?>
<link rel="stylesheet" href="../css/manager.css">

<main>
    <h1>Page du manager</h1>
    <div class="deux_boutons">
        <a href="./manager_Accueil.php"><button>Modifier la page d'accueil</button></a>
        <a href="./manager_interventions.php"><button>Modifier la page d'interventions</button></a>
    </div>
    <div class="deux_boutons">
        <a href="./manager_atelier.php"><button>Modifier la page atelier</button></a>
    </div>


    <!-- Bouton de déconnexion -->
    <button id="logout-button">Se déconnecter</button>
</main>
<!-- Footer -->
<?php include "./footer.php"; ?>

<script src="../js/connection.js"></script>
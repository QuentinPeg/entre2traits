<!-- Header -->

<?php include "./header_manager.php"; ?>
<link rel="stylesheet" href="../../css/manager.css">

<main>
    <h1>Page du manager</h1>
    <div class="boutons">
        <a href="../manager/manager_Accueil.php"><button>Modifier la page d'accueil</button></a>
        <a href="../manager/manager_atelier.php"><button>Modifier la page atelier</button></a>
        <a href="../manager/manager_travaux.php"><button>Modifier la page de travaux d'élèves</button></a>
        <a href="../manager/manager_interventions.php"><button>Modifier la page d'interventions</button></a>
        <a href="../manager/manager_parcours.php"><button>Modifier la page de parcours</button></a>
        <a href="../manager/manager_contact.php"><button>Modifier la page de contact</button></a>
        <a href="../manager/manager_actus.php"><button>Modifier la page d'actus</button></a>
        <a href="../manager/manager_boutique.php"><button>Modifier la boutique</button></a>
    </div>

    <!-- Bouton de déconnexion -->
    <button id="logout-button">Se déconnecter</button>
</main>
<!-- Footer -->
<?php include "./footer_manager.php"; ?>

<script src="../../js/connexion.js"></script>
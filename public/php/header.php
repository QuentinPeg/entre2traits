<?php

// Récupérer le chemin actuel
$currentPage = basename($_SERVER['REQUEST_URI'], ".php");

// Générer les titres dynamiques
$menuItems = [
    "index" => "Accueil",
    "atelier" => "Atelier",
    "travaux" => "Travaux d'élèves",
    "interventions" => "Les interventions",
    "parcours" => "Parcours",
    "contact" => "Contact",
    "actus" => "Actus",
    "boutique" => "Boutique"
];

// Définir le titre en fonction de la page actuelle
$pageTitle = isset($menuItems[$currentPage]) ? "L'Entre-2-Traits | " . $menuItems[$currentPage] : "L'Entre-2-Traits";
?>
<!DOCTYPE HTML>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/carrousel.css">
</head>

<body>

    <!-- Header -->
    <header>
        <img src="../img/logo.webp" alt="Logo L'Entre 2 Traits">
    </header>

    <!-- Navigation -->

    <!-- Navigation -->
    <nav>
        <button id="menu-toggle" aria-label="Toggle navigation">
            ☰
        </button>
        <div id="menu-items">
            <button id="menu-close">✖</button>

            <?php
            foreach ($menuItems as $page => $label) {
                if ($currentPage === $page) {
                    echo "<a href='./$page.php'><span class='page'>$label</span></a>";
                } else {
                    echo "<a href='./$page.php'>$label</a>";
                }
            }
            ?>
            <a href="./manager.php" id="manager-link" style="display : none; background-color: #656d76">
                <span class='page'>Manager</span>
            </a>
            <div class="panier-container">
                <img src="../img/panier.png" alt="panier" class="panier">
                <span class="nombre-articles-panier" id="panier-bulle">0</span>
            </div>
        </div>
    </nav>
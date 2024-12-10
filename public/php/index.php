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
                        <!-- Grande image -->
                        <div class="carrousel-large">
                            <img id="large-image-1" src="../img/picto_inscription.webp" alt="Grande Image Carrousel 1">
                        </div>
                        <!-- Miniatures -->
                        <div class="carrousel-small">
                            <!-- Les miniatures seront injectées ici -->
                        </div>
                    </div>
                </article>

                <article class="carr">
                    <div id="carrousel2" class="carrousel index-page">
                        <!-- Grande image -->
                        <div class="carrousel-large">
                            <img id="large-image-2" src="../img/picto_inscription.webp" alt="Grande Image Carrousel 2">
                        </div>
                        <!-- Miniatures -->
                        <div class="carrousel-small">
                            <!-- Les miniatures seront injectées ici -->
                        </div>
                    </div>

                </article>
            </div>
        </div>
    </section>
</main>

<?php include "./footer.php"; ?>

<script src="../js/accueil.js"></script>
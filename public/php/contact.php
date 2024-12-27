<!-- Header -->

<?php include "./header.php"; ?>
<link rel="stylesheet" href="../css/contact.css">

<main>

    <section id="main-contact">
        <h1>Contact</h1>
        <section>
            <p>L'Entre 2 Traits <br>
                Frédéric Masson-villot</p>
            <p>18 bis rue Ponsard <br>
                38100 Grenoble <br>
                06 13 21 20 27
            </p>
        </section>
        <section class="contact-form">
            <form action="#" method="post">
                <div class="form-group">
                    <label for="name">Nom *</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="subject">Sujet</label>
                    <input type="text" id="subject" name="subject">
                </div>
                <div class="form-group">
                    <label for="phone">Téléphone*</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="participant">Prénom du participant *</label>
                    <input type="text" id="participant" name="participant" required>
                </div>
                <div class="form-group">
                    <label for="message">Votre message</label>
                    <textarea id="message" name="message"></textarea>
                </div>
                <button type="submit">Envoyer</button>
            </form>
        </section>

        <!--<section class="map-section">
            <div id="map"></div>
        </section>-->
    </section>



</main>
<!-- Footer -->
<?php include "./footer.php"; ?>
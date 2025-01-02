<!-- Header -->

<?php include "./header_manager.php"; ?>

<link rel="stylesheet" href="../../css/login.css">

<main>
    <h1>Connexion</h1>
    <form id="login-form">
        <div>
            <div class="col">
                <label for="email">Email</label>
                <input type="email" id="email" required placeholder="Email">
            </div>
            <div class="col">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" required placeholder="Mot de passe">
            </div>
        </div>
        <button type="submit">Se connecter</button>
    </form>
    <div id="error-message" style="color: red; display: none;"></div>
</main>

<!-- Footer -->
<?php include "./footer_manager.php"; ?>

<script src="../../js/login.js"></script>
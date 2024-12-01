<!-- Header -->

<?php include "./header.php"; ?>
<main style="min-height: 100vh;">
    <h1>Connexion</h1>
    <form id="login-form">
        <label for="email">Email</label>
        <input type="email" id="email" required placeholder="Email">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" required placeholder="Mot de passe">
        <button type="submit">Se connecter</button>
    </form>
    <div id="error-message" style="color: red; display: none;"></div>
</main>

<!-- Footer -->
<?php include "./footer.php"; ?>

<script src="../js/login.js"></script>
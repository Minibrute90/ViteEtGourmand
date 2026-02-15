<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Vite & Gourmand - Réinitialiser votre mot de passe</title>
</head>

<body>
    <header>
       <img class="logo-header" src="img/logoblanc_cercle_transparent_150.png">
       <div class="nav-header">
            <ul class="nav-classic">
                <li><a href="index.php">ACCUEIL</a></li>
                <li class="active"><a href="nos-menus.php">NOS MENUS</a></li>
                <li><a href="#info">INFOS</a></li>
                <li><a href="connexion.php">CONNEXION</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
        </div>
        <button id="boutonHamburger"><img class="picto-hamburger" src="img/picto_hamburger.png" ></button>
            <ul id="navHamburger" class="hidden">
                <li><a href="index.php">ACCUEIL</a></li>
                <li class="active"><a href="nos-menus">NOS MENUS</a></li>
                <li><a href="#info">INFOS</a></li>
                <li><a href="connexion.php">CONNEXION</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
       <img class="logo-header-2" src="img/logoblanc_cercle_transparent_150.png">
    </header>
    <main>
            <?php
            require_once __DIR__ . '/db.php';

$message = '';
$ok = false;

$email = trim($_GET['email'] ?? '');
$token = trim($_GET['token'] ?? '');

$row = null;

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($token) < 10) {
    $message = "Lien invalide.";
} else {
    $stmt = $connexionBdd->prepare("
        SELECT id, token_hash, expires_at, used_at
        FROM password_resets
        WHERE email = :email
          AND used_at IS NULL
          AND expires_at > NOW()
        ORDER BY id DESC
        LIMIT 1
    ");
    $stmt->execute(['email' => $email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $message = "Lien expiré ou déjà utilisé.";
    } elseif (!password_verify($token, $row['token_hash'])) {
        $message = "Lien invalide.";
    } else {
        $ok = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mdp = $_POST['mdp'] ?? '';
    $mdp2 = $_POST['mdp2'] ?? '';

    if (!$ok) {
        $message = "Lien invalide ou expiré.";
    } elseif (strlen($mdp) < 8) {
        $message = "Le mot de passe doit faire au moins 8 caractères.";
    } elseif ($mdp !== $mdp2) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        $hash = password_hash($mdp, PASSWORD_DEFAULT);


        $up = $connexionBdd->prepare("UPDATE utilisateur SET mdp = :mdp WHERE email = :email");
        $up->execute(['mdp' => $hash, 'email' => $email]);

        $uu = $connexionBdd->prepare("UPDATE password_resets SET used_at = NOW() WHERE id = :id");
        $uu->execute(['id' => $row['id']]);

        $message = "Mot de passe modifié, vous pouvez vous connecter.";

    }
}
?>

<?php if ($message !== ''): ?>
        <p class="message-erreur" style="font-weight:bold; color:<?= (str_contains($message, '✅') ? 'green' : 'red') ?>;">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>


<main>
<section class="form-connexion">

    <h1 class="formulaire">Nouveau mot de passe</h1>


    <?php if ($ok): ?>
        <form class="inscription" method="post">
            <input class="saisie-info-account" type="password" name="mdp" placeholder="Nouveau mot de passe" required>
            <input class="saisie-info-account" type="password" name="mdp2" placeholder="Confirmer le mot de passe" required>
            <button type="submit" class="inscription">Valider</button>
        </form>
    <?php endif; ?>

</section>
</main>


    <footer id="info">
        <div class="info-entreprise">
            <div class="colonne-info">
                <img class="picto-info" src="img/picto_adresse.svg">
                <div class="titre-info">Adresse</div>
                <div class="info-info">27 Rue des Faures, 33000 Bordeaux</div>
            </div>
            <div class="colonne-info">
                <img class="picto-info" src="img/picto_tel.svg">
                <div class="titre-info">Téléphone</div>
                <div class="info-info">05 56 87 42 13</div>
            </div>
            <div class="colonne-info">
                <img class="picto-info" src="img/picto_email.svg">
                <div class="titre-info">Email</div>
                <div class="info-info">contact@vite&gourmand.com</div>
            </div>
            <div class="colonne-info">
                <img class="picto-info" src="img/picto_clock.svg">
                <div class="titre-info">Horaire d'ouverture</div>
                <table class="info-info">
                    <tr>
                        <th>Lundi</th>
                        <th class="h">9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>mardi</th>
                        <th class="h">9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Mercredi</th>
                        <th class="h">9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Jeudi</th>
                        <th class="h">9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Vendredi</th>
                        <th class="h">9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Samedi</th>
                        <th class="h">10h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Dimanche</th>
                        <th class="h">10h00-13h00</th>
                    </tr>
                </table>
            </div>
        </div>
        <img class="logo-footer" src="img/logoblanc_cercle_transparent_150.png">
        <div class="mentions">
           @Minibrute - 2026 - Tous droits réservés - <a href="">Mentions Légales</a> - <a href="">conditions générales de ventes</a> - <a href="">Gestion des cookies</a>
        </div> 
    </footer>
    
</body>
    <script>
        const boutonHamburger = document.getElementById("boutonHamburger");
        const navHamburger = document.getElementById("navHamburger");

        boutonHamburger.addEventListener('click', () => {
        navHamburger .classList.toggle("hidden");
        });
    </script>

</html>
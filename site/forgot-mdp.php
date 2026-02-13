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
    <title>Vite & Gourmand - Nos menus</title>

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
                <li class="active"><a href="nos-menus.php">NOS MENUS</a></li>
                <li><a href="#info">INFOS</a></li>
                <li><a href="connexion.php">CONNEXION</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
       <img class="logo-header-2" src="img/logoblanc_cercle_transparent_150.png">
    </header>
    <main>
        <?php

            require_once __DIR__ . '/db.php';
            require_once __DIR__ . '/mail.php';

            $message = "";

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $email = trim($_POST["email"] ?? "");

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $message = "Email invalide.";
                } else {

                    $message = "Si un compte existe, un email de réinitialisation a été envoyé.";

                    $stmt = $connexionBdd->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = :email");
                    $stmt->execute(['email' => $email]);
                    $existe = (int)$stmt->fetchColumn();

                    if ($existe > 0) {
                        $token = bin2hex(random_bytes(32));
                        $tokenHash = password_hash($token, PASSWORD_DEFAULT);
                        $expiresAt = (new DateTime('+30 minutes'))->format('Y-m-d H:i:s');

                        $ins = $connexionBdd->prepare("
                            INSERT INTO password_resets (email, token_hash, expires_at)
                            VALUES (:email, :token_hash, :expires_at)
                        ");
                        $ins->execute([
                            'email' => $email,
                            'token_hash' => $tokenHash,
                            'expires_at' => $expiresAt
                        ]);

                        $baseUrl = "https://viteetgourmand.arsediaa.com";
                        $lien = $baseUrl . "/reset-mdp.php?email=" . urlencode($email) . "&token=" . urlencode($token);

                        envoyerMailResetMdp($email, $lien);
                    }
                }
            }
        ?>
                        <?php if (!empty($message)): ?>
                            <div class="message-erreur"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>
        
        <section class="form_connexion">
            <form class="inscription" method="post" action="">
                <h1 class="formulaire">Mot de passe oublié</h1>
                <input class="saisie-info-account" type="email" id="mdp" name="email" placeholder="Veillez saisir votre Email" required>
                <button type='submit' class='connexion' id="">Envoyer le lien</button>
                <div class ="redirection-inscription"><a href="connexion.php">Retour à la page de connexion</a></div>
                </form>
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
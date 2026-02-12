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

<?php require __DIR__ . '/db.php'; ?>

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
            $success = false;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $nom    = trim($_POST['nom'] ?? '');
                $prenom = trim($_POST['prenom'] ?? '');
                $gsm    = trim($_POST['gsm'] ?? '');
                $email  = trim($_POST['email'] ?? '');
                $adress = trim($_POST['adress'] ?? '');
                $mdp    = trim((string)($_POST['mdp'] ?? ''));

                if ($nom === '' || $prenom === '' || $gsm === '' || $email === '' || $adress === '' || $mdp === '') {
                    $message = "Tous les champs doivent être remplis.";
                }
                elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $message = "Adresse email invalide.";
                }
                elseif (strlen($mdp) < 10) {
                    $message = "Mot de passe non conforme : 10 caractères minimum.";
                }
                elseif (!preg_match('/[A-Z]/', $mdp)) {
                    $message = "Mot de passe non conforme : au moins 1 majuscule.";
                }
                elseif (!preg_match('/\d/', $mdp)) {
                    $message = "Mot de passe non conforme : au moins 1 chiffre.";
                }
                elseif (!preg_match('/[!?\_\-\@\&]/', $mdp)) {
                    $message = "Mot de passe non conforme : au moins 1 caractère spécial (!?_-@&).";
                }
                else {
                    $verifUtilisateur = $connexionBdd->prepare(
                        "SELECT COUNT(*) FROM utilisateur WHERE email = :email"
                    );
                    $verifUtilisateur->bindValue(':email', $email, PDO::PARAM_STR);
                    $verifUtilisateur->execute();

                    $emailExiste = (int)$verifUtilisateur->fetchColumn();

                    if ($emailExiste !== 0) {
                        $message = "Cet email est déjà utilisé.";
                    } else {
                        // 4) Insert
                        $pdoStat = $connexionBdd->prepare(
                            "INSERT INTO utilisateur (nom, prenom, gsm, email, adress, mdp)
                            VALUES (:nom, :prenom, :gsm, :email, :adress, :mdp)"
                        );

                        $hash = password_hash($mdp, PASSWORD_DEFAULT);

                        $pdoStat->bindValue(':nom', $nom);
                        $pdoStat->bindValue(':prenom', $prenom);
                        $pdoStat->bindValue(':gsm', $gsm);
                        $pdoStat->bindValue(':email', $email);
                        $pdoStat->bindValue(':adress', $adress);
                        $pdoStat->bindValue(':mdp', $hash);

                        $pdoStat->execute();

                        $success = true;
                        $message = "Inscription réussie 🎉";
                    }
                }
            }
        ?>

        <?php if ($message !== '') : ?>
            <p class="message-erreur" style="font-weight:bold; color:<?= $success ? 'green' : 'red' ?>;">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <section class="form_connexion">
            <form class="inscription" method="post">
                        <h1 class="formulaire">Inscription</h1>
                        <input class="saisie-info-account" type="text" id="nom" name="nom" placeholder="Veuillez saisir votre Nom" required>
                        <input class="saisie-info-account" type="text" id="prenom" name="prenom" placeholder="Veuillez saisir votre Prenom" required>
                        <input class="saisie-info-account" type="tel" id="gsm" name="gsm" placeholder="Veuillez saisir votre numéro de téléphone" required>
                        <input class="saisie-info-account" type="email" id="email" name="email" placeholder="Veuillez saisir votre adresse email" required>
                        <input class="saisie-info-account" type="text" id="adress" name="adress" placeholder="Veuillez saisir votre adresse postale complète" required>
                        <input class="saisie-info-account" type="password" id="mdp" name="mdp" placeholder="Veuillez saisir un mot de passe" required>
                        <div class="condition">
                            <p>10 caractères minimum</p>
                            <p>1 chiffre minimum</p>
                            <p>1 majuscule minimum</p>
                            <p>1 caractères spécial minimum (!?_-@&)</p></br>
                        </div>
                        <button type="submit" class="inscription">inscription</button>
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
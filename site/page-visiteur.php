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
    <title>Vite & Gourmand - Ma page utilisateur</title>

</head>

<?php require __DIR__ . '/db.php'; ?>

<body>
    <header>
       <img class="logo-header" src="img/logoblanc_cercle_transparent_150.png">
       <div class="nav-header">
            <ul class="nav-classic">
                <li><a href="index.php">ACCUEIL</a></li>
                <li ><a href="nos-menus.php">NOS MENUS</a></li>
                <li><a href="#info">INFOS</a></li>
                <li class="active"><a href="connexion.php">CONNEXION</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
        </div>
        <button id="boutonHamburger"><img class="picto-hamburger" src="img/picto_hamburger.png" ></button>
            <ul id="navHamburger" class="hidden">
                <li><a href="index.php">ACCUEIL</a></li>
                <li class="active"><a href="nos-menus">NOS MENUS</a></li>
                <li><a href="#info">INFOS</a></li>
                <li class="active"><a href="connexion.php">CONNEXION</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
       <img class="logo-header-2" src="img/logoblanc_cercle_transparent_150.png">
    </header>
    <main>
        <section class="page-utilisateur">
            <?php
            session_start();

            if (!isset($_SESSION['id_utilisateur'])) {
                header("Location: connexion.php");
                exit();
            }

            $stmt = $connexionBdd->prepare("
                SELECT nom, prenom, email, gsm, adress
                FROM utilisateur
                WHERE id_utilisateur = :id
            ");
            $stmt->bindValue(':id', $_SESSION['id_utilisateur'], PDO::PARAM_INT);
            $stmt->execute();

            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

            // Sécurité : utilisateur introuvable
            if (!$utilisateur) {
                session_destroy();
                header('Location: connexion.php');
                exit;
            }
            ?>

            <h1 class="page-utilisateur">Bienvenue <?= htmlspecialchars($utilisateur['prenom']) ?></h1>
            <div class="column-infos">
                <div class="bloc-info">
                    <ul class="info-utilisateur">
                        <li class="info-utilisateur"><strong>Nom :</strong> <?= htmlspecialchars($utilisateur['nom']) ?></li>
                        <li class="info-utilisateur"><strong>Prenom :</strong> <?= htmlspecialchars($utilisateur['prenom']) ?></li>
                        <li class="info-utilisateur"><strong>Email :</strong> <?= htmlspecialchars($utilisateur['email']) ?></li>
                        <li class="info-utilisateur"><strong>Téléphone :</strong> <?= htmlspecialchars($utilisateur['gsm']) ?></li>
                        <li class="info-utilisateur"><strong>Adresse :</strong> <?= htmlspecialchars($utilisateur['adress']) ?></li>
                    </ul>
                    <a href="modifier-utilisateur.php" class="modifier">Modifier</a>
                </div>
                <div class="historique">
                    <h2>Historique</h2>
                </div>
            </div>
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
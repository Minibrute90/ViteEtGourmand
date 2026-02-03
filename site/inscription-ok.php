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

<?php
    // Connexion à la base de données
    $connexionBdd = new PDO('mysql:host=localhost;dbname=viteetgourmand;charset=utf8', 'root', '');
?>

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
        <section>
            <?php
                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\Exception;

                require __DIR__ . '/vendor/autoload.php';

                $message = null;

                try {
                    $bdd = new PDO('mysql:host=localhost;dbname=viteetgourmand;charset=utf8', 'root', '');
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (Exception $e) {
                    die('Erreur : ' . $e->getMessage());
                }

                $verifUtilisateur = $bdd->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = :email");
                $verifUtilisateur->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $verifUtilisateur->execute();

                $emailExiste = (int)$verifUtilisateur->fetchColumn();

                if ($emailExiste === 0) {

                    $pdoStat = $bdd->prepare(
                        "INSERT INTO utilisateur (nom, prenom, gsm, email, adress, mdp)
                        VALUES (:nom, :prenom, :gsm, :email, :adress, :mdp)"
                    );

                    $pdoStat->bindValue(':nom', $_POST['nom']);
                    $pdoStat->bindValue(':prenom', $_POST['prenom']);
                    $pdoStat->bindValue(':gsm', $_POST['gsm']);
                    $pdoStat->bindValue(':email', $_POST['email']);
                    $pdoStat->bindValue(':adress', $_POST['adress']);

                    // ✅ Hash mot de passe
                    $hash = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
                    $pdoStat->bindValue(':mdp', $hash);

                    $pdoStat->execute();

                    // ✅ Message inscription
                    $message = "Inscription réussie ✅ Un email de confirmation va être envoyé.";

                    // ✅ Envoi email
                    $mail = new PHPMailer(true);

                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.laposte.net';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'tonadresse@laposte.net';
                        $mail->Password   = 'TON_MOT_DE_PASSE_LAPOSTE'; // ou mot de passe d'application si dispo
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ou ENCRYPTION_SMTPS si 465
                        $mail->Port       = 587;

                        $mail->setFrom('tonadresse@laposte.net', 'Vite & Gourmand');

                        $mail->setFrom('tonmail@laposte.com', 'Vite & Gourmand');
                        $mail->addAddress($_POST['email'], $_POST['prenom']);

                        $mail->isHTML(true);
                        $mail->Subject = "Confirmation d'inscription — Vite & Gourmand";
                        $mail->Body = "
                            <p>Bonjour <strong>{$_POST['prenom']}</strong>,</p>
                            <p>Votre inscription est bien prise en compte ✅</p>
                            <p>Bienvenue chez <strong>Vite & Gourmand</strong>.</p>
                            <p>À très vite 🍽️</p>
                        ";
                        $mail->AltBody = "Bonjour {$_POST['prenom']},\n\nVotre inscription est bien prise en compte.\n\nVite & Gourmand";

                        $mail->send();

                        // Option : affiner message si tu veux
                        $message = "Inscription réussie  Email de confirmation envoyé.";

                    } catch (Exception $e) {
                        // ✅ L'inscription est OK, mais le mail a échoué
                        $message = "Inscription réussie (mais l'email n'a pas pu être envoyé)";
                        // debug utile :
                        // $message .= " | Erreur mail: " . $mail->ErrorInfo;
                    }

                } else {
                    $message = "Cet email est déjà utilisé";
                }
                ?>

            <form class="inscription" method="post" action="connexion.php">
                <?php if (!empty($message)) : ?>
                    <h1 class="formulaire"><?= htmlspecialchars($message) ?></h1>
                <?php endif; ?>
                <button type="submit" class="connexion">Connexion</button>
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
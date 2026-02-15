<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/db.php';
session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: connexion.php");
    exit;
}

$idUtilisateur = (int)$_SESSION['id_utilisateur'];

$menuId = filter_input(INPUT_GET, 'menu_id', FILTER_VALIDATE_INT);
if (!$menuId) {
    die("Menu invalide.");
}

$stmtMenu = $connexionBdd->prepare("
    SELECT menu_id, titre, prix, Nombre_minimum_de_personnes, stock
    FROM menus
    WHERE menu_id = :id
");
$stmtMenu->execute([':id' => $menuId]);
$menu = $stmtMenu->fetch(PDO::FETCH_ASSOC);

if (!$menu) {
    die("Menu introuvable.");
}

$message = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nbPersonnes = filter_input(INPUT_POST, 'nb_personnes', FILTER_VALIDATE_INT);
    $dateEvenement = trim($_POST['date_evenement'] ?? '');
    $commentaire = trim($_POST['commentaire'] ?? '');
    $livraison = isset($_POST['livraison']) ? 1 : 0;
    $adresseLivraison = trim($_POST['adresse_livraison'] ?? '');

    if ((int)$menu['stock'] <= 0) {
        $message = "Ce menu n'est plus disponible (stock épuisé).";
    } elseif (!$nbPersonnes || $nbPersonnes <= 0) {
        $message = "Nombre de personnes invalide.";
    } elseif ($nbPersonnes < (int)$menu['Nombre_minimum_de_personnes']) {
        $message = "Le minimum pour ce menu est de " . (int)$menu['Nombre_minimum_de_personnes'] . " personnes.";
    } elseif ($livraison === 1 && $adresseLivraison === '') {
        $message = "Merci de renseigner une adresse de livraison.";
    } else {

        try {
            $connexionBdd->beginTransaction();

            // 1) Décrément stock (uniquement si stock > 0)
            $updateStock = $connexionBdd->prepare("
                UPDATE menus
                SET stock = stock - 1
                WHERE menu_id = :menu_id AND stock > 0
            ");
            $updateStock->execute([':menu_id' => $menuId]);

            if ($updateStock->rowCount() !== 1) {
                $connexionBdd->rollBack();
                $message = "Désolé, ce menu n'est plus disponible (stock épuisé).";
            } else {

                // 2) Insert commande
                $stmt = $connexionBdd->prepare("
                    INSERT INTO commandes
                        (id_utilisateur, menu_id, nb_personnes, date_evenement, livraison, adresse_livraison, commentaire)
                    VALUES
                        (:id_utilisateur, :menu_id, :nb_personnes, :date_evenement, :livraison, :adresse_livraison, :commentaire)
                ");

                $stmt->execute([
                    ':id_utilisateur' => $idUtilisateur,
                    ':menu_id' => $menuId,
                    ':nb_personnes' => $nbPersonnes,
                    ':date_evenement' => ($dateEvenement !== '' ? $dateEvenement : null),
                    ':livraison' => $livraison,
                    ':adresse_livraison' => ($livraison === 1 ? $adresseLivraison : null),
                    ':commentaire' => ($commentaire !== '' ? $commentaire : null),
                ]);

                $idCommande = (int)$connexionBdd->lastInsertId();

                $connexionBdd->commit();

                // ✅ 3) Envoi mail (SEULEMENT après commande OK)
                require __DIR__ . '/mail.php';

                $stmtU = $connexionBdd->prepare("SELECT email, prenom FROM utilisateur WHERE id_utilisateur = :id");
                $stmtU->execute([':id' => $idUtilisateur]);
                $client = $stmtU->fetch(PDO::FETCH_ASSOC);

                $stmtM = $connexionBdd->prepare("SELECT titre, prix FROM menus WHERE menu_id = :id");
                $stmtM->execute([':id' => $menuId]);
                $menuMail = $stmtM->fetch(PDO::FETCH_ASSOC);

                $mailOk = false;
                if ($client && $menuMail) {
                    $mailOk = envoyerMailCommandeClient($client, $menuMail, [
                        'id_commande' => $idCommande,
                        'nb_personnes' => $nbPersonnes,
                        'date_evenement' => ($dateEvenement !== '' ? $dateEvenement : null),
                        'livraison' => $livraison,
                        'adresse_livraison' => ($livraison === 1 ? $adresseLivraison : null),
                    ]);
                }

                // ✅ message sur la page
                $success = true;
                if ($mailOk) {
                    $message = "Votre commande a bien été enregistrée. Un mail récapitulatif vous a été envoyé.";
                } else {
                    $message = "Votre commande a bien été enregistrée. Le mail récapitulatif n'a pas pu être envoyé.";
                }

                // (optionnel) vider les champs après succès
                $_POST = [];
            }

        } catch (Exception $e) {
            if ($connexionBdd->inTransaction()) {
                $connexionBdd->rollBack();
            }
            $message = "Erreur lors de la validation de la commande.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Vite & Gourmand - Passer une commande</title>
</head>

<body>

<header>
    <img class="logo-header" src="img/logoblanc_cercle_transparent_150.png" alt="Logo Vite & Gourmand">
    <div class="nav-header">
        <ul class="nav-classic">
            <li><a href="index.php">ACCUEIL</a></li>
            <li class="active"><a href="nos-menus.php">NOS MENUS</a></li>
            <li><a href="#info">INFOS</a></li>
            <li><a href="connexion.php">CONNEXION</a></li>
            <li><a href="contact.php">CONTACT</a></li>
        </ul>
    </div>

    <button id="boutonHamburger" type="button">
        <img class="picto-hamburger" src="img/picto_hamburger.png" alt="Menu">
    </button>
    <ul id="navHamburger" class="hidden">
        <li><a href="index.php">ACCUEIL</a></li>
        <li class="active"><a href="nos-menus.php">NOS MENUS</a></li>
        <li><a href="#info">INFOS</a></li>
        <li><a href="connexion.php">CONNEXION</a></li>
        <li><a href="contact.php">CONTACT</a></li>
    </ul>

    <img class="logo-header-2" src="img/logoblanc_cercle_transparent_150.png" alt="Logo Vite & Gourmand">
</header>

<main>

    <div class="header-page-menu">
        <div class="titre-page-menu">
            <h1 class="titre-page">PASSER UNE COMMANDE</h1>
            <div class="trait-titre-page"></div>
            <p class="titre-page">Finalisez votre commande en quelques secondes.</p>
        </div>
    </div>

    <section class="liste-menu" style="max-width: 900px; margin: 0 auto;">

        <!-- ✅ Récap menu -->
        <div class="bloc-menu" style="display:block;">
            <div class="ensemble-titre-menu">
                <div class="titre-menu"><?= htmlspecialchars($menu['titre']) ?></div>
            </div>

            <div class="info-menu">
                <div><strong>Prix :</strong> <?= htmlspecialchars($menu['prix']) ?> €</div>
                <div><strong>Minimum :</strong> <?= (int)$menu['Nombre_minimum_de_personnes'] ?> personnes</div>
                <div><strong>Stock restant :</strong> <?= (int)$menu['stock'] ?></div>
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div style="
                margin:20px 0;
                padding:15px;
                border-radius:10px;
                text-align:center;
                font-weight:600;
                background: <?= $success ? '#d4edda' : '#ffe6e6' ?>;
                color: <?= $success ? '#155724' : '#721c24' ?>;
            ">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- ✅ Formulaire commande -->
        <form method="POST" action="" style="margin-top: 20px;">
            <div class="bloc-menu" style="display:block;">
                <div class="ensemble-titre-menu">
                    <div class="titre-menu">Informations de commande</div>
                </div>

                <div style="display:flex; flex-direction:column; gap:14px; padding: 10px 0;">
                    <label>
                        Nombre de personnes (min <?= (int)$menu['Nombre_minimum_de_personnes'] ?>) :
                        <input
                            type="number"
                            name="nb_personnes"
                            min="<?= (int)$menu['Nombre_minimum_de_personnes'] ?>"
                            value="<?= (int)($menu['Nombre_minimum_de_personnes']) ?>"
                            required
                            style="width: 100%; padding: 10px; border-radius: 8px; border:none; margin:10px;"
                        >
                    </label>

                    <label>
                        Date de l'évènement (optionnel) :
                        <input
                            type="date"
                            name="date_evenement"
                            value="<?= htmlspecialchars($_POST['date_evenement'] ?? '') ?>"
                            style="width: 100%; padding: 10px; border-radius: 8px; border:none; margin:10px;"
                        >
                    </label>

                    <label style="display:flex; align-items:center; gap:10px;">
                        <input type="checkbox" name="livraison" id="livraison"
                               <?= isset($_POST['livraison']) ? 'checked' : '' ?>>
                        <span>Je souhaite une livraison</span>
                    </label>

                    <label id="blocAdresse" style="display:none;">
                        Adresse de livraison :
                        <input
                            type="text"
                            name="adresse_livraison"
                            placeholder="Ex: 27 Rue des Faures, 33000 Bordeaux"
                            value="<?= htmlspecialchars($_POST['adresse_livraison'] ?? '') ?>"
                            style="width: 100%; padding: 10px; border-radius: 8px; margin:10px;"
                        >
                    </label>

                    <label>
                        Commentaire (optionnel) :
                        <textarea
                            name="commentaire"
                            rows="4"
                            placeholder="Allergies particulières, précisions, horaires..."
                            style="width: 100%; padding: 10px; border-radius: 8px; margin:10px;"
                        ><?= htmlspecialchars($_POST['commentaire'] ?? '') ?></textarea>
                    </label>

                        <button type="submit" class="connexion" style="border:none; cursor:pointer;">
                            Valider la commande
                        </button>
                        <a class="redirection-inscription" href="nos-menus.php" style="text-decoration:underline;">Retour aux menus</a>
                </div>
            </div>
        </form>

    </section>

</main>

<footer id="info">
    <div class="info-entreprise">
        <div class="colonne-info">
            <img class="picto-info" src="img/picto_adresse.svg" alt="">
            <div class="titre-info">Adresse</div>
            <div class="info-info">27 Rue des Faures, 33000 Bordeaux</div>
        </div>
        <div class="colonne-info">
            <img class="picto-info" src="img/picto_tel.svg" alt="">
            <div class="titre-info">Téléphone</div>
            <div class="info-info">05 56 87 42 13</div>
        </div>
        <div class="colonne-info">
            <img class="picto-info" src="img/picto_email.svg" alt="">
            <div class="titre-info">Email</div>
            <div class="info-info">contact@vite&gourmand.com</div>
        </div>
        <div class="colonne-info">
            <img class="picto-info" src="img/picto_clock.svg" alt="">
            <div class="titre-info">Horaire d'ouverture</div>
            <table class="info-info">
                <tr><th>Lundi</th><th class="h">9h00-18h00</th></tr>
                <tr><th>Mardi</th><th class="h">9h00-18h00</th></tr>
                <tr><th>Mercredi</th><th class="h">9h00-18h00</th></tr>
                <tr><th>Jeudi</th><th class="h">9h00-18h00</th></tr>
                <tr><th>Vendredi</th><th class="h">9h00-18h00</th></tr>
                <tr><th>Samedi</th><th class="h">10h00-18h00</th></tr>
                <tr><th>Dimanche</th><th class="h">10h00-13h00</th></tr>
            </table>
        </div>
    </div>
    <img class="logo-footer" src="img/logoblanc_cercle_transparent_150.png" alt="Logo">
    <div class="mentions">
        @Minibrute - 2026 - Tous droits réservés - <a href="">Mentions Légales</a> - <a href="">conditions générales de ventes</a> - <a href="">Gestion des cookies</a>
    </div>
</footer>

<script>
    // hamburger
    const boutonHamburger = document.getElementById("boutonHamburger");
    const navHamburger = document.getElementById("navHamburger");
    boutonHamburger?.addEventListener('click', () => navHamburger.classList.toggle("hidden"));

    // afficher/cacher adresse livraison
    const cbLivraison = document.getElementById('livraison');
    const blocAdresse = document.getElementById('blocAdresse');

    function toggleAdresse() {
        if (!cbLivraison || !blocAdresse) return;
        blocAdresse.style.display = cbLivraison.checked ? 'block' : 'none';
    }

    cbLivraison?.addEventListener('change', toggleAdresse);
    toggleAdresse(); // init
</script>

</body>
</html>

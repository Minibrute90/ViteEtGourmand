<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require __DIR__ . '/vendor/autoload.php';

function makeMailer(): PHPMailer
{
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    $mail->isSMTP();
    $mail->Host       = 'ssl0.ovh.net';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'contact.viteetgourmand@arsediaa.com';
    $mail->Password   = 'OlyElisa2312**';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('contact.viteetgourmand@arsediaa.com', 'Vite & Gourmand');

    return $mail;
}

function envoyerMailBienvenue(string $toEmail, string $toName): bool
{
    $mail = new PHPMailer(true);

    try {
        $mail->CharSet = 'UTF-8';

        $mail->isSMTP();
        $mail->Host       = 'ssl0.ovh.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contact.viteetgourmand@arsediaa.com'; 
        $mail->Password   = 'OlyElisa2312**';   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('contact.viteetgourmand@arsediaa.com', 'Vite & Gourmand');
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);
        $mail->Subject = 'Bienvenue chez Vite & Gourmand';
        $mail->Body    = "
            <h2>Bienvenue {$toName}</h2>
            <p>Ton compte est bien créé.</p>
            <p>À très vite,<br>Vite & Gourmand</p>
        ";
        $mail->AltBody = "Bienvenue {$toName}. Ton compte est bien créé. — Vite & Gourmand";

        return $mail->send();
    } catch (Exception $e) {
        error_log("Erreur PHPMailer: " . $mail->ErrorInfo);
        return false;
    }
}

function envoyerMailResetMdp(string $toEmail, string $lien): bool
{
    $mail = new PHPMailer(true);

    try {
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host       = 'ssl0.ovh.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contact.viteetgourmand@arsediaa.com'; 
        $mail->Password   = 'OlyElisa2312**';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('contact.viteetgourmand@arsediaa.com', 'Vite & Gourmand');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Réinitialisation de votre mot de passe';
        $mail->Body = "
            <p>Vous avez demandé à réinitialiser votre mot de passe.</p>
            <p>Cliquez sur ce lien (valide 30 minutes) :</p>
            <p><a href='{$lien}'>Réinitialiser mon mot de passe</a></p>
            <p>Si vous n’êtes pas à l’origine de la demande, ignorez cet email.</p>
        ";
        $mail->AltBody = "Lien de réinitialisation (30 min) : $lien";

        return $mail->send();
    } catch (Exception $e) {
        error_log("Erreur reset mail: " . $mail->ErrorInfo);
        return false;
    }
}

function envoyerMailContact(string $fromEmail, string $sujet, string $contenu): array
{
    $fromEmail = trim($fromEmail);
    $sujet     = trim($sujet);
    $contenu   = trim($contenu);

    if (!filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => "Adresse email invalide."];
    }
    if ($sujet === '' || mb_strlen($sujet) < 2) {
        return ['success' => false, 'message' => "Le titre est trop court."];
    }
    if ($contenu === '' || mb_strlen($contenu) < 5) {
        return ['success' => false, 'message' => "Le message est trop court."];
    }

    $smtpHost = 'ssl0.ovh.net';
    $smtpUser = 'contact.viteetgourmand@arsediaa.com';
    $smtpPass = 'OlyElisa2312**'; 
    $smtpPort = 587;

    $toEmail = 'contact.viteetgourmand@arsediaa.com';
    $toName  = 'Vite & Gourmand';

    $mail = new PHPMailer(true);

    try {

        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host       = $smtpHost;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtpUser;
        $mail->Password   = $smtpPass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtpPort;

        $mail->setFrom($smtpUser, 'Formulaire Vite & Gourmand');

        $mail->addReplyTo($fromEmail);


        $mail->addAddress($toEmail, $toName);

        $mail->Subject = "[CONTACT] " . $sujet;

        $mail->isHTML(true);

        $html = "
            <h2>Nouveau message via le formulaire de contact</h2>
            <p><strong>Email :</strong> " . htmlspecialchars($fromEmail) . "</p>
            <p><strong>Sujet :</strong> " . htmlspecialchars($sujet) . "</p>
            <p><strong>Message :</strong><br>" . nl2br(htmlspecialchars($contenu)) . "</p>
        ";

        $text = "Nouveau message via le formulaire de contact\n"
              . "Email: {$fromEmail}\n"
              . "Sujet: {$sujet}\n\n"
              . "Message:\n{$contenu}\n";

        $mail->Body    = $html;
        $mail->AltBody = $text;

        $mail->send();

        return ['success' => true, 'message' => "Message envoyé. Merci, on vous répond vite !"];
    } catch (Exception $e) {
        return ['success' => false, 'message' => "Erreur d'envoi. Réessayez plus tard."];
    }
}


function envoyerMailCommandeClient(array $client, array $menu, array $commande): bool
{
    $config = require __DIR__ . '/config/mail_config.php';

    try {
        $mail = makeMailer();

        $toEmail = $client['email'] ?? '';
        $toName  = $client['prenom'] ?? '';

        if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $mail->addAddress($toEmail, $toName);

        // copie pour moi
        if (!empty($config['admin_email'])) {
            $mail->addBCC($config['admin_email']);
        }

        $livraisonTxt = ((int)($commande['livraison'] ?? 0) === 1) ? "Oui" : "Non";
        $adresseTxt   = ((int)($commande['livraison'] ?? 0) === 1) ? ($commande['adresse_livraison'] ?? '—') : "—";
        $dateTxt      = !empty($commande['date_evenement']) ? $commande['date_evenement'] : "—";
        $idCommandeTxt = !empty($commande['id_commande']) ? ("#" . (int)$commande['id_commande']) : "";

        $mail->isHTML(true);
        $mail->Subject = "Confirmation de commande {$idCommandeTxt} - Vite & Gourmand";

        $mail->Body = "
            <h2>Commande validée</h2>
            <p>Bonjour <strong>" . htmlspecialchars($toName) . "</strong>,</p>
            <p>Merci pour votre commande. Voici votre récapitulatif :</p>
            <ul>
              <li><strong>Menu :</strong> " . htmlspecialchars($menu['titre'] ?? '') . "</li>
              <li><strong>Prix :</strong> " . htmlspecialchars((string)($menu['prix'] ?? '')) . " €</li>
              <li><strong>Nombre de personnes :</strong> " . (int)($commande['nb_personnes'] ?? 0) . "</li>
              <li><strong>Date évènement :</strong> " . htmlspecialchars($dateTxt) . "</li>
              <li><strong>Livraison :</strong> " . htmlspecialchars($livraisonTxt) . "</li>
              <li><strong>Adresse :</strong> " . htmlspecialchars($adresseTxt) . "</li>
            </ul>
            <p>À très vite,<br><strong>Vite & Gourmand</strong></p>
        ";

        $mail->AltBody =
            "Commande validée.\n" .
            "Menu: " . ($menu['titre'] ?? '') . "\n" .
            "Prix: " . ($menu['prix'] ?? '') . " €\n" .
            "Personnes: " . (int)($commande['nb_personnes'] ?? 0) . "\n" .
            "Date: {$dateTxt}\n" .
            "Livraison: {$livraisonTxt}\n" .
            "Adresse: {$adresseTxt}\n";

        return $mail->send();
    } catch (Exception $e) {
        error_log("Erreur PHPMailer (Commande): " . $e->getMessage());
        return false;
    }
}

?>


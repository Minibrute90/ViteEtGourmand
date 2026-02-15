<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config/mail_config.php';

function envoyerMailBienvenue(string $toEmail, string $toName): bool
{
    $mail = new PHPMailer(true);

    try {
        $mail->CharSet = 'UTF-8';

        $mail->isSMTP();
        $mail->Host       = $config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['username'];
        $mail->Password   = $config['password'];
        $mail->Port       = $config['port'];
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;

        $mail->setFrom($config['username'], 'Formulaire Vite & Gourmand');
        $mail->addAddress($config['to_email'], $config['to_name']);

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
        $mail->Host       = $config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['username'];
        $mail->Password   = $config['password'];
        $mail->Port       = $config['port'];
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;

        $mail->setFrom($config['username'], 'Formulaire Vite & Gourmand');
        $mail->addAddress($config['to_email'], $config['to_name']);

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
    $smtpPass =  'Dkwier2312**'; 
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

        return ['success' => true, 'message' => "Message envoyé. Merci, on te répond vite !"];
    } catch (Exception $e) {
        return ['success' => false, 'message' => "Erreur d'envoi. Réessaie plus tard."];
    }
}


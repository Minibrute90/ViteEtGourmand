<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require __DIR__ . '/vendor/autoload.php';

function envoyerMailBienvenue(string $toEmail, string $toName): bool
{
    $mail = new PHPMailer(true);

    try {
        $mail->CharSet = 'UTF-8';

        $mail->isSMTP();
        $mail->Host       = 'ssl0.ovh.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contact.viteetgourmand@arsediaa.com'; 
        $mail->Password   = 'Dkwier2312**';   
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
        $mail->Password   = 'Dkwier2312**';
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
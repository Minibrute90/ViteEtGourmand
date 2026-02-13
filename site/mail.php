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
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// require '../vendor/autoload.php';

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

class ControllerMailer
{

public function sendUserCredentials($email, $user,$tel, $password)
{
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    try {
        $mail->isSMTP();
        $mail->Host = 'mail.jetrouvtout.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'test@jetrouvtout.com';
        $mail->Password = 'test@jetrouvtout';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom($mail->Username, 'Notre Boutique');
        $mail->addAddress($email);
        $mail->addReplyTo($mail->Username, 'Notre Boutique');

        $mail->isHTML(true);
        $mail->Subject = 'Vos identifiants Boutique';

        // Logos en ligne
        $logoCI = 'https://biblio.dndcorporations.com/assets/img/armoirie_ci.png';

        $mail->Body = "
            
                    <img src='$logoCI' alt='boutique' width='50' style='margin: 5px 0;'><br>
                

            <hr>

            <h2 style='text-align: center;'>Bienvenue $user !</h2>
            <p>Votre inscription à notre boutique a été prise en compte.</p>
            <p><strong>Voici vos informations de connexion :</strong></p>
            <ul>
                <li><strong>Téléphone :</strong> $tel</li>
                <li><strong>Mot de passe :</strong> $password</li>
            </ul>
            <p>Vous pouvez maintenant accéder à nos services en ligne.</p>

            <br>
            <p>Cordialement,<br>Notre Boutique</p>
        ";

        $mail->AltBody = "Bienvenue $user !\n\n"
            . "Votre inscription à notre boutique a été prise en compte.\n\n"
            . "Téléphone : $tel\n"
            . "Mot de passe : $password\n\n"
            . "Cordialement,\nNotre Boutique.";

        $mail->send();

        return true;
    } catch (Exception $e) {
        return "Erreur lors de l'envoi : " . $mail->ErrorInfo;
    }
}
}

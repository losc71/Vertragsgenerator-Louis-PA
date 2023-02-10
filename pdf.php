<?php
namespace Dompdf;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/SMTP.php';
require 'vendor/autoload.php';
require_once 'vendor/dompdf/autoload.inc.php';

date_default_timezone_set("Europe/Zurich");

session_start();

$fileName = $_SESSION['enterprise'] . "-Vertrag-animatedlogo.pdf";

//Insert Userdetails into DB
require_once 'include/config.php';
$stmt = $db->prepare("INSERT INTO customers (firstName, lastName, email, enterprise, address, location, phoneNumber, price, contract, hasCreated) 
VALUES (:firstName, :lastName, :email, :enterprise, :address, :location, :phoneNumber, :price, :contract, :hasCreated)");
$stmt->bindParam(':firstName', $_SESSION['name']);
$stmt->bindParam(':lastName', $_SESSION['prename']);
$stmt->bindParam(':email', $_SESSION['email']);
$stmt->bindParam(':enterprise', $_SESSION['enterprise']);
$stmt->bindParam(':address', $_SESSION['address']);
$stmt->bindParam(':location', $_SESSION['location']);
$stmt->bindParam(':phoneNumber', $_SESSION['telefon']);
$stmt->bindParam(':price', $_SESSION['total']);
$stmt->bindParam(':contract', $fileName);
$stmt->bindParam(':hasCreated', $_SESSION['username']);
$stmt->execute();

//Get the name of the user
$query = "SELECT firstNameUser, lastNameUser FROM users WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $_SESSION['username']);
$stmt->execute();
$result = $stmt->fetchAll();

foreach ($result as $row) {
    $_SESSION['firstNameUser'] = $row['firstNameUser'];
    $_SESSION['lastNameUser'] = $row['lastNameUser'];
    break;
}

//Dompdf for creating the PDF
use Dompdf\Dompdf;

if (isset($_POST['submit_val'])) {
    $dompdf = new Dompdf();
    $dompdf->set_option('enable_html5_parser', TRUE);
    $dompdf->set_option('isRemoteEnabled', TRUE);
    $pdf_html = file_get_contents('pdf.html');
    $pdf_html = mb_convert_encoding($pdf_html, 'HTML-ENTITIES', 'UTF-8');

    $domDocument = new \DOMDocument();
    $domDocument->loadHTML($pdf_html);


    //Delete nodes which arent selected
    if (!$_SESSION['vektor']) {
        $xpath = new \DOMXPath($domDocument);
        foreach ($xpath->query('//tr[contains(attribute::class, "vektor")]') as $e) {
            // Delete this node
            $e->parentNode->removeChild($e);
        }
    }
    ;

    if (!$_SESSION['modern']) {
        $xpath = new \DOMXPath($domDocument);
        foreach ($xpath->query('//tr[contains(attribute::class, "modern")]') as $e) {
            // Delete this node
            $e->parentNode->removeChild($e);
        }
    }
    ;

    if (!$_SESSION['standart']) {
        $xpath = new \DOMXPath($domDocument);
        foreach ($xpath->query('//tr[contains(attribute::class, "standart")]') as $e) {
            // Delete this node
            $e->parentNode->removeChild($e);
        }
    }
    ;

    if (!$_SESSION['pers']) {
        $xpath = new \DOMXPath($domDocument);
        foreach ($xpath->query('//tr[contains(attribute::class, "pers")]') as $e) {
            // Delete this node
            $e->parentNode->removeChild($e);
        }
    }
    ;

    if (!$_SESSION['instant']) {
        $xpath = new \DOMXPath($domDocument);
        foreach ($xpath->query('//tr[contains(attribute::class, "instant")]') as $e) {
            // Delete this node
            $e->parentNode->removeChild($e);
        }
    }
    ;

    if (!$_SESSION['special']) {
        $xpath = new \DOMXPath($domDocument);
        foreach ($xpath->query('//tr[contains(attribute::class, "special")]') as $e) {
            // Delete this node
            $e->parentNode->removeChild($e);
        }
    }
    ;

    if ($_SESSION['instant']) {
        $xpath = new \DOMXPath($domDocument);
        foreach ($xpath->query('//tr[contains(attribute::class, "bill")]') as $e) {
            // Delete this node
            $e->parentNode->removeChild($e);
        }
    }
    ;

    $pdf_html = $domDocument->saveHTML();


    //Replace string to place Values in the PDF
    $pdf_html = str_replace("{{date}}", date('d.m.Y'), $pdf_html);
    $pdf_html = str_replace("{{enterprise}}", $_SESSION['enterprise'], $pdf_html);
    $pdf_html = str_replace("{{name}}", $_SESSION['name'], $pdf_html);
    $pdf_html = str_replace("{{prename}}", $_SESSION['prename'], $pdf_html);
    $pdf_html = str_replace("{{address}}", $_SESSION['address'], $pdf_html);
    $pdf_html = str_replace("{{telefon}}", $_SESSION['telefon'], $pdf_html);
    $pdf_html = str_replace("{{email}}", $_SESSION['email'], $pdf_html);
    $pdf_html = str_replace("{{user}}", $_SESSION['firstNameUser'] . ' ' . $_SESSION['lastNameUser'], $pdf_html);
    $pdf_html = str_replace("{{total}}", number_format($_SESSION['total'], 2), $pdf_html);
    $pdf_html = str_replace("{{rabatt}}", number_format($_SESSION['rabatt'], 2), $pdf_html);
    $pdf_html = str_replace("{{instantPay}}", number_format($_SESSION['instantPay'], 2), $pdf_html);
    $pdf_html = str_replace("{{specialinput}}", number_format($_SESSION['specialinput'], 2), $pdf_html);
    $pdf_html = str_replace("{{mwstRabatt}}", number_format($_SESSION['mwstRabatt'], 2), $pdf_html);
    $pdf_html = str_replace("{{mwst}}", number_format($_SESSION['mwst'], 2), $pdf_html);
    $pdf_html = str_replace("{{totalMwstRabatt}}", number_format($_SESSION['totalMwstRabatt'], 2), $pdf_html);
    $pdf_html = str_replace("{{totalMwst}}", number_format($_SESSION['totalMwst'], 2), $pdf_html);
    $pdf_html = str_replace("{{location}}", $_SESSION['location'], $pdf_html);


    $dompdf->loadHtml($pdf_html);


    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    ob_end_clean();
    $dompdf->stream($_SESSION['enterprise'] . "-Vertrag-animatedlogo", array("Attachment" => false));
    

    $output = $dompdf->output();


    file_put_contents('/home/carlos4/www/vertrag.door42.cloud/pdf/'.$fileName, $output);
/*
    //Mailing the PDF
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'asmtp.mail.hostpoint.ch';
        $mail->SMTPAuth = TRUE;
        $mail->Username = 'noreplay@vertrag.door42.cloud';
        $mail->Password = '***';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('noreplay@vertrag.door42.cloud', 'Door42');
        $mail->addAddress($_SESSION['email'], $_SESSION['name'] . ' ' . $_SESSION['prename']);
        $mail->addCC('produktion@door42.ch');
        $mail->addCC('buchhaltung@door42.ch');

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Animated Logo Vertrag';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->addAttachment('/home/carlos4/www/vertrag.door42.cloud/pdf/' . $fileName);
        $mail->AddEmbeddedImage('/home/carlos4/www/vertrag.door42.cloud/img/Logo_small.gif', 'logo_gif');
        $emailBody = file_get_contents('include/email_template.php');
        $mail->Body = $emailBody;

        error_log(print_r($mail, true));
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        file_put_contents('phpmailer.log', $mail->ErrorInfo, FILE_APPEND);
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

*/

}
?>
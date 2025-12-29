<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer include (তোমার ইনস্টল করা path অনুযায়ী)
require 'C:/PHP/php-8.5.1-nts-Win32-vs17-x64/PHPMailer-master/src/Exception.php';
require 'C:/PHP/php-8.5.1-nts-Win32-vs17-x64/PHPMailer-master/src/PHPMailer.php';
require 'C:/PHP/php-8.5.1-nts-Win32-vs17-x64/PHPMailer-master/src/SMTP.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "PHP reached\n";
echo "FILES:\n";
print_r($_FILES);
echo "\nPOST:\n";
print_r($_POST);
echo "\n";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['cv'])) {

    if ($_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
        die("File upload error: " . $_FILES['cv']['error']);
    }

    $to   = "contradox.tech@gmail.com";
    $from = "contradox.tech@gmail.com";

    $message = "New application received.\n\n"
        . "Name: " . ($_POST['fullName'] ?? 'N/A') . "\n"
        . "Email: " . ($_POST['email'] ?? 'N/A') . "\n"
        . "Phone: " . ($_POST['phone'] ?? 'N/A') . "\n"
        . "Position: " . ($_POST['jobTitle'] ?? 'N/A') . "\n"
        . "Experience: " . ($_POST['experience'] ?? 'N/A') . "\n"
        . "GitHub: " . ($_POST['github'] ?? 'N/A') . "\n"
        . "LinkedIn: " . ($_POST['linkedin'] ?? 'N/A') . "\n"
        . "Website: " . ($_POST['website'] ?? 'N/A') . "\n"
        . "Cover Letter: " . ($_POST['coverLetter'] ?? 'N/A') . "\n";

    try {
        $mail = new PHPMailer(true);

        // Gmail SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = "contradox.tech@gmail.com" ;    // তোমার Gmail
        $mail->Password   = 'mjpw fsst gzwn wipl';       // ১৬ digit App Password (কোনো space ছাড়া)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Optional debug (problem হলে uncomment করে দেখবে)
        $mail->SMTPDebug  = 2;
        $mail->Debugoutput = 'html';

        // Sender & Receiver
        $mail->setFrom($from, 'Career Form');
        $mail->addAddress($to);

        // Email content
        $mail->Subject = 'New career application from website';
        $mail->Body    = $message;

        // CV attachment
        $mail->addAttachment($_FILES['cv']['tmp_name'], $_FILES['cv']['name']);

        if ($mail->send()) {
            echo "MAIL_OK";
        } else {
            echo "MAIL_FAILED: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "MAIL_EXCEPTION: " . $e->getMessage();
    }

} else {
    echo "Invalid request in PHP";
}

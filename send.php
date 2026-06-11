<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Form Data
    $fullName = htmlspecialchars($_POST['fullName']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);

    // Readonly Division Field
    $division = htmlspecialchars($_POST['division']);

    $country = htmlspecialchars($_POST['country']);
    $location = htmlspecialchars($_POST['location']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {

        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;

        /*
        ======================================
        MAIL TO TEAM
        ======================================
        */

        // Sender
        $mail->setFrom(SMTP_USER, SMTP_FROM_NAME);

        // Receiver
        $mail->addAddress(SMTP_RECEIVER);

        $mail->SMTPKeepAlive = true;
        $mail->Timeout = 10;

        // Email Content
        $mail->isHTML(true);

        $mail->Subject = "New Enquiry Received from Aria Website - {$division} Page";

        $mail->Body = "
            <p>Dear Team, </p>

            <p>A new inquiry has been submitted through the Aria website. Below are the details of the submission:</p>

            <p><b>Full Name:</b> {$fullName} <br>
            <b>Phone Number:</b> {$phone}<br>
            <b>Email Address:</b> {$email}<br>
            <b>Page:</b> {$division}<br>
            <b>Country:</b> {$country}<br>
            <b>State / City:</b> {$location}<br>
            <b>Message:</b> {$message}</p>

            <p>Please review the enquiry and take the necessary steps to respond promptly.</p>

            <p><b>Best Regards, </b> <br>
            Website Notification System <br>
            Aria Compressor</p>
        ";

        $mail->send();

        /*
        ======================================
        AUTO REPLY TO CUSTOMER
        ======================================
        */

        $mail->clearAddresses();

        $mail->addAddress($email);

        $mail->Subject = "Your Enquiry Request for Electric Screw Compressor from Aria";

        $mail->Body = "
        <p>Dear {$fullName},</p>

        <p>
        Thank you for your interest in Electric Screw Compressor.
        </p>

        <p> 
        We have successfully received your enquiry request.
        Our team will review your request and connect with you shortly.
        </p>

        <p>
        For any questions or immediate assistance, please feel free to contact:
        </p>

        <p>
        <strong>Email:</strong> ariasales@kirloskar.com <br>
        <strong>Phone:</strong> 020 26727372
        </p>

        <p>
        We look forward to the opportunity of serving you.
        </p>

        <p>
        Warm Regards,<br>
        <b>Aria Compressor</b><br>
        www.ariacompressor.com
        </p>
        ";

        // Optional Debug
        // $mail->SMTPDebug = 2;
        // $mail->Debugoutput = 'html';

        $mail->send();
        echo json_encode([
            "status" => "success",
            "message" => "Email Sent Successfully"
        ]);

    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Mailer Error: {$mail->ErrorInfo}"
        ]);
    }
}
?>
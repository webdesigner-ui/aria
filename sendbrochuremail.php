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

    $full_name     = htmlspecialchars($_POST['fullName']);
    $phone         = htmlspecialchars($_POST['phone']);
    $company_name  = htmlspecialchars($_POST['companyName']);
    $location      = htmlspecialchars($_POST['location']);
    $email         = htmlspecialchars($_POST['email']);
    $message       = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {

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

        $mail->setFrom(SMTP_USER, SMTP_FROM_NAME);

        // TEAM EMAIL
        $mail->addAddress(SMTP_RECEIVER);
        $mail->SMTPKeepAlive = true;
        $mail->Timeout = 10;
        $mail->isHTML(true);

        // $mail->Subject = "New Quote Request Received from Website - {$division} Page Connect with Us";
        $mail->Subject = "New Brochure Download Request - Follow-Up Required | Aria Compressor";
        $mail->Body = "
            <p>Dear Team, </p>

            <p>A visitor has shown interest to download the brochure from the website.
            Below are the details of the request:</p>


            <p><strong>Full Name:</strong> {$full_name}<br>
            <strong>Phone:</strong> {$phone}<br>
            <strong>Company Name:</strong> {$company_name}<br>
            <strong>Location:</strong> {$location}<br>
            <strong>Email:</strong> {$email}<br>
            <strong>Message:</strong> {$message}</p>

            <p>The brochure has been successfully sent to the visitor's email address. Please take the necessary action to follow up with the visitor regarding their interest and any further queries they may have.</p>

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

        $mail->Subject = "Your Brochure for Electric Screw Compressor from Aria";
        // $mail->isHTML(true);

        // ATTACH BROCHURE
        $mail->addAttachment('brochure/Aria-brochure.pdf');

        $mail->Body = "
        <p>Dear {$full_name},</p>

        <p>
        Thank you for your interest in Electric Screw Compressor. We’re excited to share more details about our offerings with you.
        </p>

        <p>
        Please find the brochure attached to this email. It contains detailed information about our products and solutions to help you better understand how we can cater to your needs.
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

        $mail->send();

        echo json_encode([
            "status" => "success",
            "message" => "Email sent successfully!"
        ]);

    } catch (Exception $e) {

        echo json_encode([
            "status" => "error",
            "message" => $mail->ErrorInfo
        ]);
    }
}
?>
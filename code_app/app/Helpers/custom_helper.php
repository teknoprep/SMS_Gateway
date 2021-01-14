<?php

require CONS_VENDOR;

use Plivo\RestClient;
use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function display_success_message()
{
    if (isset($_SESSION['msg_success'])) {
        $errors    =    array();
        $numarray    =    array();
        $strarray    =    array();
        $string = "";
        $string2 = "";
        if (is_array($_SESSION['msg_success'])) {
            foreach ($_SESSION['msg_success'] as $msgvalue) {
                $strarray[]    =    $msgvalue;
            }
            $string    .=    implode("<br>", $strarray);
        } else {
            $string    .=    $_SESSION['msg_success'];
        }

        unset($_SESSION['msg_success']);
        return "$string";
    } else {
        return "";
    }
}

function display_error()
{

    if (isset($_SESSION['msg_error'])) {
        $errors    =    array();
        $numarray    =    array();
        $strarray    =    array();
        $string = "";
        $string2 = "";
        if (is_array($_SESSION['msg_error'])) {
            foreach ($_SESSION['msg_error'] as $msgvalue) {
                $strarray[]    =    $msgvalue;
            }
            $string    .=    implode("<br>", $strarray);
        } else {
            $string    .=    $_SESSION['msg_error'];
        }

        unset($_SESSION['msg_error']);

        return "$string";
    } else {
        return "";
    }
}

function json_response($code, $message, $data = "")
{
    $return_arr[] = array(
        "response" => $code,
        "message" => $message,
        "data" => $data,
    );

    echo json_encode($return_arr);
}

function convertDate($unixTimeStamp)
{
    $unix_timestamp = $unixTimeStamp;
    $datetime = new DateTime("@$unix_timestamp");
    // Display GMT datetime
    return $datetime->format('Y-m-d H:i:s');
}

function generateRandomString()
{
    $length = 10;
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}

function plivo_send_sms($mobile, $message, $from_number)
{

    try {

        $client = new RestClient(CONS_PLIVO_AUTH_ID, CONS_PLIVO_AUTH_TOKEN);

        $params = array(
            'src' => str_replace('+', '', $from_number),
            'dst' => str_replace('+', '', $mobile),
            'text' => $message,
            'method' => 'POST'
        );

        $response = $client->messages->create($from_number, [$mobile], $message);

        if ($response) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return $e->getMessage();
        // $_SESSION['msg_error'][] = "Something went wrong " . $e->getMessage();
    }
}

function twilio_send_sms($mobile, $message, $from_number)
{

    try {
        $account_sid = CONS_TWILIO_SID;
        $auth_token = CONS_TWILIO_AUTH_TOKEN;

        $mobile =  $mobile;
        $from_number =  $from_number;
        $client = new Client($account_sid, $auth_token);
        $response = $client->messages->create(
            $mobile,
            array(
                'from' => $from_number,
                'body' => $message,
            )
        );

        if ($response) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return $e->getMessage();
        //  $_SESSION['msg_error'][] = "Something went wrong " . $e->getMessage();
    }
}

function send_email($to, $subject, $message)
{
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = CONS_EMAIL_SMTP;
        $mail->SMTPAuth   = true;
        $mail->Username   = CONS_EMAIL_SMTP_USER;
        $mail->Password   = CONS_EMAIL_SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = CONS_EMAIL_SMTP_PORT;
        $mail->SMTPDebug = 2;


        $mail->setFrom(CONS_EMAIL_SMTP_USER, CONS_EMAIL_SMTP_FROM_NAME);
        $mail->addAddress($to);


        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        echo "<pre>";
        print_r($mail);
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

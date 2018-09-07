<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use PHPMailer\PHPMailer\PHPMailer;

class ContactFormController extends BaseController {
    public function contact() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        $name = $decoded['name'];
        $email = $decoded['email'];
        $message = $decoded['message'];

        if($name !== '' && $email !== '' && $message != '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $body = 'E-Mail: ' . $email . '<br><br>Message: ' . $message; 
            $mail = new PHPMailer(true);
    
            $mail->isHTML(true); 
            $mail->setFrom('noreply@email.com', $name);
            $mail->addAddress('email@email.com');
            $mail->FromName = 'New Request from ' . $name;
    
            $mail->Subject = 'Subject';
            $mail->Body = $body;
            $mail->send();
    
            $data['message'] = "Thanks! We’ll get back to you soon!";
    
            header('Content-type: application/json');
            echo json_encode($data);
        }
    }
}
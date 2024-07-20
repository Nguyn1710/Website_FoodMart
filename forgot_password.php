<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
function send_email($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'your-email@gmail.com';                 //SMTP username
        $mail->Password   = 'your-email-password';                  //SMTP password
        $mail->SMTPSecure = 'tls';                                  //Enable TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to

        $mail->setFrom('your-email@gmail.com', 'Food Mart');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

require 'class/Database.php';

function forgot_password($email) {
    $conn = Database::getConnect();

    // Tạo token và thời gian hết hạn
    $token = bin2hex(random_bytes(16));
    $expiry = date("Y-m-d H:i:s", strtotime("+30 minutes"));

    // Cập nhật token vào cơ sở dữ liệu
    $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
    $stmt->execute([$token, $expiry, $email]);

    // Kiểm tra xem cập nhật có thành công không
    if ($stmt->rowCount() > 0) {
        // Gửi email xác nhận
        $subject = "Password Reset";
        $body = "Click <a href='http://example.com/reset_password.php?token=$token'>here</a> to reset your password.";
        if (send_email($email, $subject, $body)) {
            return true;
        }
    }
    return false;
}

// Sử dụng hàm forgot_password
$email = "phomaivien123@gmail.com";
if (forgot_password($email)) {
    echo "Password reset email sent successfully!";
} else {
    echo "Failed to send password reset email.";
}
?>

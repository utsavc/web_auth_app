<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../config/database.php';



require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function registerUser($username,$email,$address,$password,$balance) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username,email,address ,password,balance) VALUES (?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $username,$email,$address,$hashedPassword,$balance);
        $stmt->execute();
        $stmt->close();
    }

    private function saveToken($username,$token){
        $query = "INSERT INTO authtoken (username, token) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $username, $token);
        $stmt->execute();
        $stmt->close();

    }

    private function updateTokenStatus($username,$token){
        $query = "UPDATE authtoken SET expired = 1 WHERE username = ? AND token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $username, $token);
        $stmt->execute();
        $stmt->close();

    }


    public function verifyToken($username,$token){

        // if (!isset($_SESSION['username'])) {
        //     return false;
        // }

        $query = "SELECT expired FROM authtoken WHERE username = ? AND token = ? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $username, $token);
        $stmt->execute();
        $stmt->bind_result($expired);

        if ($stmt->fetch()) {

            $stmt->close();

            if ($expired==0) {
                $query1 = "UPDATE authtoken SET expired = 1 WHERE username = ? AND token = ?";
                $stmt1 = $this->conn->prepare($query1);
                $stmt1->bind_param("ss", $username, $token);
                $stmt1->execute();
                $stmt1->close();
                return true;
            }

            return false;
        }

    }



    public function getData($username){
        $query = "SELECT username,email,address,balance FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($usernameResult, $emailResult, $addressResult,$balance);

        $usersData = [];

        while ($stmt->fetch()) {
            $user = [
                'username' => $usernameResult,
                'email' => $emailResult,
                'address' => $addressResult,
                'balance'=>$balance
            ];
            $usersData[] = $user;
        }

        $stmt->close();

        $_SESSION['usersData']=$usersData;

        return $usersData;


    }




    public function authenticateUser($email, $password) {
        $query = "SELECT username,password FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($username,$hashedPassword);

    // Check if the query executed successfully
        if ($stmt->fetch()) {
            $stmt->close();

        // Verify the password
            if (password_verify($password, $hashedPassword)) {

            // User is authenticated
                $token =$this->generateToken();

                $_SESSION['username']=$username;
                $this->saveToken($username,$token);
                // Send email
                $this->sendAuthenticationEmail($email,$username,$token); 

                return true; 
            // Password is correct
            } else {
                return false; 
            // Password is incorrect
            }
        } else {
            $stmt->close();
            return false; 
        // User not found
        }
    }


    private function generateToken() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';

        for ($i = 0; $i < 7; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $token .= $characters[$randomIndex];
        }
        return $token;
    }


    private function sendAuthenticationEmail($email,$username,$token) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF; // Enable verbose debug output
            $mail->isSMTP(); // Send using SMTP
            $mail->Host       = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth   = true; // Enable SMTP authentication
            $mail->Username   = 'rabinmandal4090@gmail.com'; // SMTP username
            $mail->Password   = 'yalhldkdfjaoccfm'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port       = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom('rabinmandal4090@gmail.com', 'Rabin');
            $mail->addAddress($email); // Recipient email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Verification Link';

            // Create the link// Replace with your actual link
            $verificationLink = "http://localhost/webauth/public/display.php?page=authenticate&username=$username&token=$token"; 
            $message = "Dear $username, <br> Please use this link to login to the website: <br> 
            $verificationLink <br> Admin Team.";
            $mail->Body    = $message;

            $mail->send();
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


}
?>

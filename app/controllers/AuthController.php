<?php
session_start();
require '../app/models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function showRegisterForm() {
        require '../app/views/register.php';
    }

    public function showLoginForm() {
        require '../app/views/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location:/webauth/app/views/logout.php");
        exit();
    }

    public function register() {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address=$_POST['address'];
        $balance=$_POST['balance'];

        $this->userModel->registerUser($username,$email,$address,$password,$balance);
        header("Location:/webauth/app/views/registration-success.php");
        exit();
    }

    public function login() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($this->userModel->authenticateUser($email, $password)) {
            header("Location:/webauth/app/views/re-authenticate.php");
            exit();
        } else {
            echo "Login failed. Check your credentials.";
        }
    }   


    public function reAuthenticate() {
        $username = $_GET['username'];
        $token = $_GET['token'];

        if (!(isset($_SESSION['username']) && $_SESSION['username'] === $username)) {
            header("Location:/webauth/app/views/unauthorized-access.php");
            exit();
        }

        if ($this->userModel->verifyToken($username, $token)) {
            $users=$this->userModel->getData($username);
            require '../app/views/dashboard.php';
            exit();
        } else if (isset($_SESSION['usersData'])) { 
            $users=$this->userModel->getData($username); 
            require '../app/views/dashboard.php';
            exit();
        } else {
            header("Location:/webauth/app/views/expired.php");
            exit();
        }
    }
}
?>

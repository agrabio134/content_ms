<?php
class ViewController
{

    public $database;
    public $pdo;

    public function __construct()
    {
        $this->database = new Connection();
        $this->pdo = $this->database->connect();
    }


    public function login()
    {
        // Check if the user is already logged in
        session_start();
        if (isset($_SESSION['id'])) {
            header('Content-Type: text/html; charset=utf-8');
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            header('Location: /cms/content');
            exit;
        }


        require_once 'view/login.php';
    }
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /cms/login');
        exit;
    }

    //create content
    public function content()
    {
        header('Content-Type: text/html; charset=utf-8');
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        session_start();
        // if not logged in, redirect to login page
        if (!isset($_SESSION['id'])) {
            header('Location: /cms/login');
            exit;
        }

        $sql = "SELECT * FROM cms_contents";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $contents = $stmt->fetchAll();


        require_once 'view/content/create_content.php';
    }
}
$app = new ViewController();
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

    public function index()
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
        $ann_results = "SELECT COUNT(*) as total FROM cms_contents WHERE is_archived = 0 && category = 'announcements'";
        $stmt = $this->pdo->prepare($ann_results);
        $stmt->execute();

        // $contents = $stmt->fetchAll();
        $count_announcements = $stmt->fetchColumn();

        $events_results = "SELECT COUNT(*) as total FROM cms_contents WHERE is_archived = 0 && category = 'events'";
        $stmt = $this->pdo->prepare($events_results);
        $stmt->execute();

        // $contents = $stmt->fetchAll();
        $count_events = $stmt->fetchColumn();


        $total_results = "SELECT COUNT(*) as total FROM cms_contents WHERE is_archived = 0 ";
        $stmt = $this->pdo->prepare($total_results);
        $stmt->execute();

        // $contents = $stmt->fetchAll();
        $count_total = $stmt->fetchColumn();


        $total_imgs = "SELECT COUNT(*) as total FROM cms_gallery";
        $stmt = $this->pdo->prepare($total_imgs);
        $stmt->execute();

        // $contents = $stmt->fetchAll();
        $count_imgs = $stmt->fetchColumn();





        // echo $count;

    

        require_once './../view/dashboard/index.php';

    }


    public function rooms()
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
        // $ann_results = "SELECT COUNT(*) as total FROM cms_contents WHERE is_archived = 0 && category = 'announcements'";
        // $stmt = $this->pdo->prepare($ann_results);
        // $stmt->execute();

        // // $contents = $stmt->fetchAll();
        // $count_announcements = $stmt->fetchColumn();

    

        require_once './../view/dashboard/facilities/room.php';

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
            // header('Location: /cms/index');
            exit;
        }


        require_once './../view/login.php';
    }
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /cms/login');
        exit;
    }

    //create content
    public function postevents()
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

        //get the users id from the session
        $user_id = $_SESSION['id'];

        //if no inputs, set null

        



   

        require_once './../view/content/create_events.php';
    }

    public function postannouncements()
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

        //get the users id from the session
        $user_id = $_SESSION['id'];

        //if no inputs, set null

        



   

        require_once './../view/content/create_announcements.php';
    }

    
    public function postimages()
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

        //get the users id from the session
        $user_id = $_SESSION['id'];

        //if no inputs, set null

        



   

        require_once './../view/content/gallery.php';
    }
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


        $sql = "SELECT * FROM cms_contents WHERE is_archived = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $contents = $stmt->fetchAll();

      


        require_once './../view/dashboard/content.php';
    }

    public function editcontent()
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

        $id =  $_GET['id'];

        $sql = "SELECT * FROM cms_contents WHERE is_archived = 0 && id = $id ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $contents = $stmt->fetchAll();

        foreach($contents as $content)


      if ($content['category'] == "Announcements"){
        require_once './../view/content/edit_Announcement.php';

      }else{
        require_once './../view/content/edit_event.php';

      }


    }
    
}
$app = new ViewController();

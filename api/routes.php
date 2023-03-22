<?php
require_once "./config/Connection.php";
require_once "./mainmodule/Get.php";
require_once "./mainmodule/Post.php";
require_once "./mainmodule/Auth.php";
require_once "./mainmodule/Global.php";
require_once "./mainmodule/Index.php";


$db = new Connection();
$pdo = $db->connect();
$global = new GlobalMethods($pdo);
$get = new Get($pdo);
$auth = new Auth($pdo);
$content = new Post($pdo);
$index = new ViewController($pdo);

if (isset($_REQUEST['request'])) {
    $req = explode('/', rtrim($_REQUEST['request'], '/'));
} else {
    $req = array("errorcatcher");
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        switch ($req[0]) {
            case 'authenticate':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $data = (object) [
                        'username' => $_POST['username'],
                        'password' => $_POST['password'],
                    ];
                    echo json_encode($auth->login($data));
                }

                $sql = "SELECT * FROM ems_credentials WHERE username = ? ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$data->username]);
                $user = $stmt->fetch();

                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                echo 'Success: You are now logged in';
                echo "session id: " . $_SESSION['id'];

                header('Location: /cms/index');

                break;
             
            case 'upload_image':
                echo json_encode($content->upload_image($data));
                break;

            case 'create_post':
                echo json_encode($content->create_post($data));
                break;
            case 'edit':
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    echo "hello";
                    $index->editcontent($id);

                    // include
                }
                break;
            case 'archive':
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $content->archive_post($id);
                }
                break;


            case 'delete_post':
                echo json_encode($content->delete_post($data));
                break;

            default:
                echo json_encode(array('error' => 'request not found'));
                break;
        }
        break;


    default:
        echo json_encode(array('error' => 'failed request'));
        break;
}

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
                        'email' => $_POST['email'],
                        'password' => $_POST['password'],
                    ];
                    echo json_encode($auth->login($data));
                }

                $sql = "SELECT * FROM cms_users WHERE email = ? ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$data->email]);
                $user = $stmt->fetch();

                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                echo 'Success: You are now logged in';
                echo "session id: " . $_SESSION['id'];

                header('Location: /cms/content');

                break;
            case 'register':
                echo json_encode($auth->create_user($data));
                break;
            case 'createpost':
                echo json_encode($content->create_post($data));
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
?>
<?php
class Auth
{
    protected $pdo;
    protected $gm;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->gm = new GlobalMethods($pdo);
    }

    private function check_password($password, $existing_hash)
    {
        $hash = crypt($password, $existing_hash);
        if ($hash === $existing_hash) {
            return true;
        }
        return false;
    }

    private function encrypt_password($password_string)
    {
        $hash_format = "$2y$10$";
        $salt_length = 22;
        $salt = $this->generate_salt($salt_length);
        return crypt($password_string, $hash_format . $salt);
    }

    private function generate_salt($length)
    {
        $urs = md5(uniqid(mt_rand(), true));
        $b64_string = base64_encode($urs);
        $mb64_string = str_replace('+', '.', $b64_string);
        return substr($mb64_string, 0, $length);
    }

    private function generate_token($id)
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode(['user_id' => $id]);
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        return $jwt;
    }
    // create user
    public function create_user($received_data)
    {
        $fname = $received_data->fname;
        $lname = $received_data->lname;
        $email = $received_data->email;
        $contact_number = $received_data->contact_number;
        $username = $received_data->username;
        $password = $this->encrypt_password($received_data->password);
        $role = $received_data->role;
        $sql = "INSERT INTO cms_users (firstname, lastname, username, password, email, contact_number, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute([$fname, $lname, $username, $password, $email, $contact_number, $role]);
            if ($stmt->rowCount() > 0) {
                $code = 200;
                $remarks = "success";
                $message = "User created successfully.";
                $payload = null;
            } else {
                $code = 500;
                $remarks = "failed";
                $message = "Failed to create user.";
                $payload = null;
            }
        } catch (\PDOException $e) {
            $code = 500;
            $remarks = "failed";
            $message = "Failed to create user.";
            $payload = null;
        }
        return $this->gm->returnPayload($payload, $remarks, $message, $code);
    }

    public function login($received_data)
    {
        if (!isset($received_data->email) || !isset($received_data->password)) {
            $code = 400;
            $remarks = "failed";
            $message = "Email or password is missing.";
            $payload = null;

            return $this->gm->returnPayload($payload, $remarks, $message, $code);
        }

        $email = $received_data->email;
        $pword = $received_data->password;

        $sql = "SELECT * FROM cms_users WHERE email = ? ";
        $stmt = $this->pdo->prepare($sql);
        

        $user = $stmt->fetch();


        // if ($user) {
  
            // header('Location: /cms/index');
        //     return true;
        //   } else {
        //     echo 'Error: Invalid email address or password';
        //     return false;
        //   }


        //check if the session is set



        try {
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $res = $stmt->fetchAll()[0];
                if ($this->check_password($pword, $res['password'])) {
                    $id = $res['id'];
                    $fname = $res['firstname'];
                    $lname = $res['lastname'];
                    $token = $this->generate_token($res['id']);
                    $role = $res['role'];

                    $code = 200;
                    $remarks = "success";
                    $message = "Logged in successfully.";
                    $payload = array("id" => $id, "fname" => $fname, "lname" => $lname, "token" => $token, "role" => $role);

                    return $this->gm->returnPayload($payload, $remarks, $message, $code);
                } else {
                    $code = 401;
                    $remarks = "failed";
                    $message = "Invalid username or password.";
                    $payload = null;
                }
            } else {
                $code = 401;
                $remarks = "failed";
                $message = "Invalid username or password.";
                $payload = null;
            }
        } catch (\PDOException $e) {
            $code = 500;
            $remarks = "failed";
            $message = "Failed to login.";
            $payload = null;
        }
        return $this->gm->returnPayload($payload, $remarks, $message, $code);
    }
}

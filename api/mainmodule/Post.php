<?php
    class Post{
        protected $pdo;
        protected $gm;

        public function __construct(\PDO $pdo)
        {
            $this->pdo = $pdo;
            $this->gm = new GlobalMethods($pdo);
        }



        public function create_post($received_data)
        {
          //get the users id from the session

        session_start();
        $user_id = $_SESSION['id'];

        
          $title = $_POST['title'];
          $category = $_POST['category'];
          $description = $_POST['description'];
          $date = $_POST['date'];
          $time = $_POST['time'];
      
          $media = $_FILES['media']['name'];
          $file_extension = pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION);
          $filename = "$media";
          $target = "media/content/" . $filename;

          //add folder if it doesn't exist
            if (!file_exists('media/content')) {
                mkdir('media/content', 0777, true);
            }

            // if no date and time is set, set it to null
            if ($date == "" && $time == "") {
                $date = null;
                $time = null;
            }
           
      
      
          if (move_uploaded_file($_FILES['media']['tmp_name'], $target)) {
            // Insert the event data into the database
            $query = "SELECT * FROM cms_contents WHERE media = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$filename]);
            $result = $stmt->fetch();
      
            if ($result) {
              //delete the uploaded file once if it already exists in the database
              
              unlink($target);
              http_response_code(400);
              echo "File already uploaded";
              header('Location: /cms/content');

              return false;
            } else {
              $query = "INSERT INTO cms_contents (title, category, description, date, time, media, user_id) VALUES (?,?,?,?,?,?,?)";
              $stmt = $this->pdo->prepare($query);
              $stmt->execute([$title, $category, $description, $date, $time, $media, $user_id]);
              http_response_code(200);
            //   echo "File uploaded successfully";
            }
          } else {
            http_response_code(500);
            echo "There was an error uploading the file.";
          }
          echo "File uploaded successfully";
          header('Location: /cms/content');
        }

        // archive content change to 1 or 0
        public function archive_post($id)
        {



            $sql = "SELECT * FROM cms_contents WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch();
            $archive = $result['is_archive'];

            if ($archive == 0) {
                $sql = "UPDATE cms_contents SET is_archive = 1 WHERE id = ?";
            } else {
                $sql = "UPDATE cms_contents SET is_archive = 0 WHERE id = ?";
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            header('Location: /cms/content');
            exit;
        }


       
        // delete content


        public function delete_post($id)
        {
            $sql = "DELETE FROM cms_contents WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            header('Location: /cms/content');
            exit;
        }


       


    }

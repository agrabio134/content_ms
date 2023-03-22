<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
            font-family: Arial, sans-serif;
        }

        label {
            margin-bottom: 10px;
            font-size: 18px;
        }

        input[type="text"],
        textarea,
        input[type="date"],
        input[type="time"],
        select,
        input[type="file"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            font-family: Arial, sans-serif;
            width: 400px;
            max-width: 100%;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>

<body>
    <?php include_once "./../view/dashboard/navigation/nav.php"; ?>

    <?php include_once "content_nav.php"; ?>


    <h1>Update Events</h1>
    <form action="../routes.php?request=update_post" method="post" enctype="multipart/form-data">

        <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">

        <input type="text" name="id" value="<?php echo $_GET['id']; ?>">

        <label for="title">Title</label>

        <input type="text" name="title" id="title"  default="<?php echo $content['title']; ?>"
         placeholder="<?php echo $content['title']; ?>" required>

        <input type="text" id="category" name="category" value="Events" hidden>


        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10"  default="<?php echo $content['description']; ?>"
        placeholder="<?php echo $content['description']; ?>"></textarea>

        <input type="date" name="date" id="date" default="<?php echo $content['date']; ?>">

        <input type="time" name="time" id="time" default="<?php echo $content['time']; ?>">

        <label for="media">Media</label>
        <input type="file" name="media" id="media" required>

        <input type="submit" value="Submit">
    </form>

</body>

</html>
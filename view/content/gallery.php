<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
</head>
<body>

<?php include_once "./../view/dashboard/navigation/nav.php"; ?>

<?php include_once "content_nav.php"; ?>

<form action="../routes.php?request=upload_image" method="post"  enctype="multipart/form-data">
    <input type="file" name="images[]" multiple>
    <input type="submit" name ="submit" value="Upload">
</form>
    
</body>
</html>
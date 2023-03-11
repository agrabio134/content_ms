<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contents</title>
</head>

<body>
    <!-- get all contents and foreach -->
    <?php foreach ($contents as $content) : ?>
        <div>
            <h1><?php echo $content['title']; ?></h1>
            <p><?php echo $content['content']; ?></p>
            <p><?php echo $content['date']; ?></p>
            <p><?php echo $content['time']; ?></p>
            <p><?php echo $content['category']; ?></p>
            <p>
                <img src="../../media/Announcements/<?php echo $content['image']; ?>" alt="<?php echo $content['image']; ?> " />
            </p>
            <a href="/cms/edit_content?id=<?php echo $content['id']; ?>">Edit</a>
            <a href="/cms/delete_content?id=<?php echo $content['id']; ?>">Delete</a>
        </div>
    <?php endforeach; ?>



</body>

</html>
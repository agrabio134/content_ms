<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contents</title>
</head>

<body>
<a href="/cms/logout">Logout</a>

    <!-- get all contents and foreach -->
    <?php foreach ($contents as $content) : ?>
        <div>
            <h1><?php echo $content['title']; ?></h1>
            <p><?php echo $content['description']; ?></p>
            <p><?php echo $content['date']; ?></p>
            <p><?php echo $content['time']; ?></p>
            <p><?php echo $content['category']; ?></p>
            <p>
                <img src="../../media/content/<?php echo $content['media']; ?>" alt="<?php echo $content['media']; ?> " />
            </p>
            <a href="../routes.php?request=edit?id=<?php echo $content['id'];?>">Edit</a>
            <!-- archive -->
            <a href="../routes.php?request=archive&id=<?php echo $content['id'];?>">Archive</a>
        </div>
    <?php endforeach; ?>



</body>

</html>
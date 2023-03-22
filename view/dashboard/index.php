<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <?php include_once "navigation/nav.php"; ?>

    <div>
    <h4>Total Announcements</h4>
    <?php echo $count_announcements; ?>
    </div>

    <div>
    <h4>Total Events</h4>
    <?php echo $count_events; ?>
    </div>

    <div>
    <h4>Total Post</h4>
    <?php echo $count_total; ?>
    </div>
    
</body>

</html>
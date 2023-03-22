<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contents</title>
</head>

<body>

<?php include_once "navigation/nav.php"; ?>
<br>
<?php include_once "./../view/content/content_nav.php"; ?>



   

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
            <a href="javascript:void(0)" onclick="edit(<?php echo $content['id']; ?>)">Edit</a>
            <!-- archive -->
            <a href="javascript:void(0)" onclick="confirmArchive(<?php echo $content['id']; ?>)">Archive</a>
        </div>
    <?php endforeach; ?>



</body>

</html>

<script>

function edit(id) {

            // Create a new form element
            var form = document.createElement("form");

            // Set the form attributes
            form.method = "POST";
            form.action = "../routes.php?request=edit&id=" + id;

            // Create a new input element for the ID
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "id";
            input.value = id;

            // Append the input element to the form
            form.appendChild(input);

            // Append the form to the body and submit it
            document.body.appendChild(form);
            form.submit();
      
    }
    function confirmArchive(id) {
        if (confirm("Are you sure you want to archive this content?")) {
            // Create a new form element
            var form = document.createElement("form");

            // Set the form attributes
            form.method = "POST";
            form.action = "../routes.php?request=archive&id=" + id;

            // Create a new input element for the ID
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "id";
            input.value = id;

            // Append the input element to the form
            form.appendChild(input);

            // Append the form to the body and submit it
            document.body.appendChild(form);
            form.submit();
        } else {
            // If the user cancels, do nothing
            return;
        }
    }
</script>
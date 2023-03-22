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


<h1>Create Events</h1>
<form action="../routes.php?request=create_post" method="post" enctype="multipart/form-data">
    <!-- user id  -->
    <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'];?>">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" placeholder="Title" required>

    <!-- <label for="category">Category</label> -->
    <input type="text" id="category" name="category" value="Events" hidden>


    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10" placeholder="Description"></textarea>

    <input type="date" name="date" id="date">

    <input type="time" name="time" id="time">

    <label for="media">Media</label>
    <input type="file" name="media" id="media" required>

    <input type="submit" value="Submit">
</form>

<!-- <script>
    // add event listener to category dropdown
    document.getElementById("category").addEventListener("change", function() {
        var selectedCategory = this.value;
        var dateInput = document.getElementById("date");
        var timeInput = document.getElementById("time");

        // if selected category is Events, show date and time inputs
        if(selectedCategory === "Events") {
            dateInput.style.display = "block";
            timeInput.style.display = "block";
        } else {
            dateInput.style.display = "none";
            timeInput.style.display = "none";
        }
    });
</script> -->

</body>
</html>
<!-- Include Database Details -->
<?php
    include 'app/init.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Things to do.</title>
    
    <!-- Link to stylesheets and fonts. -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/main.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="list">
            <h1 contenteditable="true" class="header">Things to do.</h1>
                <!-- Import database in a variable.-->
                <?php
                    $todos = $conn->query("SELECT * FROM todo ORDER BY id DESC");
                ?>
            <ul class="items">
                <!-- If theres no rows in database print placeholder. -->
                <?php if($todos->rowCount() === 0) { ?>
                    <li><span class="item">Add a task</span></li>
                <?php } ?>
                
                <!-- Display all items in the todo list. -->
                <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) {?>
                    <!-- If the item is done have it crossed out. -->
                    <?php 
                        // Human time, time!!
                        $seconds_ago = (time() - strtotime($todo['created']));

                        if($seconds_ago >= 31536000) {
                            $timeAgo = intval($seconds_ago / 31536000)." years ago";
                        } elseif($seconds_ago >= 2419200) {
                            $timeAgo = intval($seconds_ago / 2419200)." months ago";
                        } elseif($seconds_ago >= 86400) {
                            $timeAgo = intval($seconds_ago / 86400)." days ago";
                        } elseif($seconds_ago >= 3600) {
                            $timeAgo = intval($seconds_ago / 3600)." hours ago";
                        } elseif($seconds_ago >= 60) {
                            $timeAgo = intval($seconds_ago / 60)." minutes ago";
                        } elseif($seconds_ago >= 30) { 
                            $timeAgo = "few seconds ago";
                        } else {
                            $timeAgo = "now";
                        }

                        if($todo['done']) { ?>
                        <li>
                            <!-- Echo name with item crossed out using stylesheets, unmark button. -->
                            <a href="app/done.php?id=<?php echo $todo['id'] ?>" class="done-button"><i class="far fa-check-circle"></i></a>
                            <span class="item checked">
                                <?php echo $todo['name'] ?>
                            </span>
                            <!-- Remove button that on click forwards you to remove.php file. -->
                            <span id="<?php echo $todo['id'] ?>" class="remove-to-do">
                                <a href="app/remove.php?id=<?php echo $todo['id'] ?>" class="delete-button"><i class="far fa-trash-alt"></i><a>
                            </span>
                            <!-- Echo date when was item created. -->
                            <span class="date"><?php echo $timeAgo ?></span>
                        </li>
                    <!-- If the item is not done -->
                    <?php } else { ?>
                        <li>
                            <!-- Echo name with, mark as done button. -->
                            <span class="item">
                                <a href="app/done.php?id=<?php echo $todo['id'] ?>" class="done-button"><i class="far fa-circle"></i></a>
                                <?php echo $todo['name'] ?>
                            </span>
                            <!-- Remove button that on click forwards you to remove.php file. -->
                            <span id="<?php echo $todo['id'] ?>" class="remove-to-do">
                                <a href="app/remove.php?id=<?php echo $todo['id'] ?>" class="delete-button"><i class="far fa-trash-alt"></i><a>
                            </span>
                            <!-- Echo date when was item created. -->
                            <span class="date"><?php echo $timeAgo ?></span>
                        </li>
                    <?php } ?>
                <?php } ?>
                <!-- Input section to push item to database.. -->
                <form class="item-add" action="app/add.php" method="POST">
                    <input type="text" name="item" placeholder="Type a new task here." class="input" autocomplete="off" required>
                    <button class="submit" type="submit" value="add"><i class="fas fa-plus"></i></button>
                </form>
            </ul>
        </div>
    </div>
</body>
</html>
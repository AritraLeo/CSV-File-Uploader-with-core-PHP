<?php
include('../../Includes/AuthHeader.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $sqlProg = "SELECT * FROM cinema_programmer WHERE ";
    ?>

    <?php
    echo $_GET['circuit'];
    echo '<br>';
    echo $_GET['state'];
    echo '<br>';
    echo $_GET['operator'];
    ?>
</body>

</html>
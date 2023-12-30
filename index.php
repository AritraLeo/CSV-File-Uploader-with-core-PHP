<?php

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: ./Auth/signup.php");
}

$email = $_SESSION['email'];
?>

<?php
require('./Database/db.php');
?>
<?php

$sql1 = "SELECT * FROM users WHERE email = '$email'";
$res1 = mysqli_query($conn, $sql1) or die('Query has error');

while ($row = mysqli_fetch_assoc($res1)) {
    $Faname = $row['fname'];
    $Lname  = $row['lname'];
    $cat = $row['category'];
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
        <h1>Welcome
            <?php
            echo $Faname;
            echo '  ';
            echo $Lname;
            ?>
        </h1>
        <h2>You're logged in as a <?php echo $cat;  ?></h2>

        <a href="./Auth/logout.php">LOGOUT</a>

        <?php
        $prog = "SELECT category FROM users WHERE email = '$email' LIMIT 1";
        $isProg = mysqli_query($conn, $prog);
        while ($categoryArray = mysqli_fetch_assoc($isProg)) {
            $category = $categoryArray['category'];
        }
        if ($category == 'programmer') {
            $urlCsv = './Functions/ProgrammerCsv.php';
        } else {
            $urlCsv = '';
        }
        ?>
        <a href="<?php echo $urlCsv;  ?>">Add CSV File</a>
        <br>
        <br>
        <a href="./Modules/RoCalculator/">RO Calculator</a>
    </body>
<?php
}

?>

    </html>
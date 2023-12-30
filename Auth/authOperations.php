
<?php

include('../Database/db.php');

if (isset($_POST['signup'])) {
    $err = '';
    $Fname = htmlspecialchars(trim($_POST['fname']));
    $Lname = htmlspecialchars(trim($_POST['lname']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $category = htmlspecialchars($_POST['category']);

    echo $Fname . '' . $Lname . '' . $phone . '';

    // checks - 
    $sql2 = "SELECT id FROM users WHERE email = '$email' LIMIT 1";
    $res2 = mysqli_query($conn, $sql2);
    $sql3 = "SELECT id FROM users WHERE phone = '$phone' LIMIT 1";
    $res3 = mysqli_query($conn, $sql3);


    if (mysqli_num_rows($res2) == 1) {
        echo "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'>This email is already taken!</span></div>";
        $err = 'Error';
    }
    if (mysqli_num_rows($res3) == 1) {
        echo "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'>This phone is already taken!</span></div>";
        $err = 'Error';
    }
    if (empty($err)) {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $insertQ = "INSERT INTO users (fname, lname,  phone, email, password, category, dt) VALUES ('$Fname', '$Lname', '$phone', '$email', '$hashPassword', '$category', current_timestamp())";
        $insert = mysqli_query($conn, $insertQ);

        if ($insert) {
            // echo '<script>window.location.href="../MailSending/RegisterMail.php?GetData=' . $username . '";</script>';
            session_start();
            $_SESSION['loggenin'] = true;
            $_SESSION['email'] = $email;
            echo 'Inserted';
            // echo '<script>window.location.href="./index.php";</script>';
        } else {
            echo "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'>Something went wrong....!</span></div>";
        }
    }
}

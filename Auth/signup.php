<?php
include('../Database/db.php');
?>

<?php

if (isset($_POST['signup'])) {

    $err = '';
    $Fname = htmlspecialchars(trim($_POST['fname']));
    $Lname = htmlspecialchars(trim($_POST['lname']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $category = htmlspecialchars($_POST['category']);

    if ($category == 'programmer') {
        $circuit = htmlspecialchars($_POST['circuit']);
    } else {
        $circuit = '';
    }


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
        $insertQ = "INSERT INTO users (fname, lname, email, phone, password, category, circuit, dt) VALUES ('$Fname', '$Lname', '$email', '$phone', '$hashPassword', '$category', '$circuit', current_timestamp())";
        $insert = mysqli_query($conn, $insertQ);

        if ($insert) {
            // echo 'Registered!';

            session_start();
            $_SESSION["email"] = $email;
            $_SESSION["id"] = $id;
            $_SESSION["loggedin"] = true;
            echo '<script>window.location.href="../index.php";</script>';
        } else {
            echo "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'>Something went wrong....!" . $error . "</span></div>";
        }
    }
}


?>

<?php

if (isset($_POST['signin'])) {

    $Lerr = '';
    $Lemail = htmlspecialchars(trim($_POST['lemail']));
    $Lpassword = htmlspecialchars(trim($_POST['lpassword']));
    $CheckPassword = '';

    $sql1 = "SELECT * FROM users WHERE email = '$Lemail' LIMIT 1";
    $res1 = mysqli_query($conn, $sql1);

    if (empty($Lpassword)) {
        echo "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'>Password Cannot be empty...!</span></div>";
    } else {


        while ($row = mysqli_fetch_assoc($res1)) {
            $CheckPassword = $row['password'];
        }
        if (password_verify($Lpassword, $CheckPassword)) {
            // this means the password is corrct. Allow user to login
            session_start();
            $_SESSION["email"] = $Lemail;
            $_SESSION["id"] = $id;
            $_SESSION["loggedin"] = true;
            echo '<script>window.location.href="../index.php";</script>';
        } else {
            echo "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'>Wrong Password....!</span></div>";
        }
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/signup.css">
    <title>Authentification</title>
</head>

<body>
    <div class="container right-panel-active">


        <!-- Sign Up -->
        <div class="container__form container--signup">
            <form action="signup.php" method="POST" class="form" id="form1">
                <h2 class="form__title">Sign Up</h2>
                <input type="text" placeholder="First Name" name="fname" class="input" />
                <input type="text" placeholder="Last Name" name="lname" class="input" />
                <input type="number" placeholder="Phone" name="phone" class="input" />
                <input type="email" placeholder="Email" name="email" class="input" />
                <input type="password" minlength="5" placeholder="Password" name="password" id="txtPassword" class="input" />
                <button type="button" id="btnToggle" class="toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                <select name="category" id="cat" class="input">
                    <option value="general">Choose your category</option>
                    <option value="producer">Producer</option>
                    <option value="programmer">Programmer</option>
                    <option value="distributor">Distributor</option>
                </select>

                <select name="circuit" class="input" style="display: none;" id="circuit">
                    <?php
                    $sqlCircuit = "SELECT circuit FROM theaters";
                    $resCircuit = mysqli_query($conn, $sqlCircuit);
                    while ($circuit = mysqli_fetch_assoc($resCircuit)) {
                    ?>
                        <option value="<?php echo $circuit['circuit'];  ?>"><?php echo $circuit['circuit'];  ?></option>
                    <?php
                    }
                    ?>
                </select>
                <input type="submit" value="SIGNUP" name="signup" class="btn">
                <!-- <button class="btn">Sign Up</button> -->
            </form>
        </div>



        <!-- Sign In -->
        <div class="container__form container--signin">
            <form action="" method="POST" class="form" id="form2">
                <h2 class="form__title">Sign In</h2>
                <input type="email" placeholder="Email" name="lemail" class="input" />
                <input type="password" minlength="5" placeholder="Password" name="lpassword" id="txtPasswordL" class="input" />
                <button type="button" id="btnToggleL" class="toggle"><i id="eyeIconL" class="fa fa-eye"></i></button>
                <a href="#" class="link">Forgot your password?</a>
                <input type="submit" value="SIGNIN" name="signin" class="btn">
            </form>
        </div>




        <!-- Overlay -->
        <div class="container__overlay">
            <div class="overlay">
                <div class="overlay__panel overlay--left">
                    <button class="btn" id="signIn">Sign In</button>
                </div>
                <div class="overlay__panel overlay--right">
                    <button class="btn" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../Js/signup.js"></script>

    <!-- Jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- Hide and show password signup -->
    <script>
        let passwordInput = document.getElementById('txtPassword'),
            toggle = document.getElementById('btnToggle'),
            icon = document.getElementById('eyeIcon');

        function togglePassword() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.add("fa-eye-slash");
                //toggle.innerHTML = 'hide';
            } else {
                passwordInput.type = 'password';
                icon.classList.remove("fa-eye-slash");
                //toggle.innerHTML = 'show';
            }
        }

        toggle.addEventListener('click', togglePassword, false);
        // passwordInput.addEventListener('keyup', checkInput, false);
    </script>


    <!-- Hide show password signin -->
    <script>
        let passwordInputL = document.getElementById('txtPasswordL'),
            toggleL = document.getElementById('btnToggleL'),
            iconL = document.getElementById('eyeIconL');

        function togglePasswordL() {
            if (passwordInputL.type === 'password') {
                passwordInputL.type = 'text';
                iconL.classList.add("fa-eye-slash");
                //toggle.innerHTML = 'hide';
            } else {
                passwordInputL.type = 'password';
                iconL.classList.remove("fa-eye-slash");
                //toggle.innerHTML = 'show';
            }
        }

        toggleL.addEventListener('click', togglePasswordL, false);
    </script>



    <script>
        $('#cat').change(function() {
            let category = $('#cat').val();
            if (category === 'programmer') {
                $('#circuit').css('display', 'block');
            } else {
                $('#circuit').css('display', 'none');
            }
        })
    </script>
</body>

</html>
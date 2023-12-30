<?php
// cinema_programmer
include('../Includes/AuthHeader.php');

$users = "SELECT * FROM users WHERE email = '$email'";
$res1 = mysqli_query($conn, $users);
while ($user = mysqli_fetch_assoc($res1)) {
    $circuit = $user['circuit'];
}


?>
<?php

$cinemaName = $_POST['cinema'];
// echo $cinemaName;

if (!empty($_FILES['prog_file']['name'])) {

    $output = '';
    $file = $_FILES['prog_file']['tmp_name'];
    $file_data = fopen($file, 'r');
    $fileName = current(explode('.', $_FILES['prog_file']['name']));
    // echo $fileName;
    $uniqueIdentifier = $fileName . '*' . $email;
    $checkUnique = "SELECT id FROM programmer_csvs WHERE unique_identifier = '$uniqueIdentifier' LIMIT 1";
    $checkUniqueRes = mysqli_query($conn, $checkUnique);
    $checkUniqueNo = mysqli_num_rows($checkUniqueRes);
    if ($checkUniqueNo == 1) {
        echo "<div class='alert alert-danger'>The file already exists if this is a different file plz change the name or delete the previous one from dashboard!</div>";
    } else {
        while ($row = fgetcsv($file_data)) {

            // Variables -
            $session = $row[0];
            // Skip zero kept to avoid confusion
            $s = array();
            $t = array();

            // For Screens - 
            for ($i = 1; $i <= 15; $i += 2) {
                $sOfi = ceil($i / 2);
                if (empty($row[$i])) {
                    $s[$sOfi] = ' ';
                } else {
                    $s[$sOfi] = $row[$i];
                }
            }

            // For Time - 
            for ($j = 2; $j <= 14; $j += 2) {
                $tOfj = $j / 2;
                if (empty($row[$j])) {
                    $t[$tOfj] = ' ';
                } else {
                    $t[$tOfj] = $row[$j];
                }
            }

            // Start uploading from 6th one - particularly now - 
            $insert = "INSERT INTO cinema_programmer (session, unique_identity, email, s1, t1, s2, t2, s3, t3, s4, t4, s5, t5, s6, t6, s7, t7) VALUES 
            ('$session', '$uniqueIdentifier', '$email',
            '$s[1]', '$t[1]',
            '$s[2]', '$t[2]',
            '$s[3]', '$t[3]',
            '$s[4]', '$t[4]',
            '$s[5]', '$t[5]',
            '$s[6]', '$t[6]',
            '$s[7]', '$t[7]'
            )";
            $Inserted = mysqli_query($conn, $insert) or die(mysqli_error($conn));


            // OUTPUT - 

            /*$output .= "
            <tr>
                <th>" . $session . "</th>
                    <td>" . $s[1] . "</td>
                        <td>" . $s[2] . "</td>
                        <td>" . $s[3] . "</td>
                        <td>" . $s[4] . "</td>
                        <td>" . $s[5] . "</td>
                        <td>" . $s[6] . "</td>
                        <td>" . $s[7] . "</td>
            </tr>
        ";*/


            // END OF WHILE
        }


        // Getting id where it was inserted - 
        $IdInserted = "SELECT id FROM cinema_programmer WHERE unique_identity = '$uniqueIdentifier' LIMIT 1";
        $Idres = mysqli_query($conn, $IdInserted);
        while ($Id = mysqli_fetch_assoc($Idres)) {
            $idCinemaProg = $Id['id'];
        }
        // echo $idCinemaProg;


        // Inserting into  for displaying in dashboard later and else where -
        $insertProgCsv = "INSERT INTO programmer_csvs (email, unique_identifier, circuit, id_cinema_prog) VALUES ('$email', '$uniqueIdentifier', '$circuit', '$idCinemaProg')";
        $idCinemaProgRes = mysqli_query($conn, $insertProgCsv);



        echo "<div class='alert alert-success'>CSV file contents inserted succesfully!</div>";
        // echo $output;

        fclose($file_data);
    }
} else {
    echo "<div class='alert alert-danger'>You haven't specified the name of the file!</div>";
}



/*
$output .= "
        
        " . $row[1] . "
        <br/>

        " . $row[2] . "
        <br/>

        " . $row[3] . "
        <br/>

        " . $row[4] . "
        <br/>

        " . $row[5] . "
        <br/>

        " . $row[7] . "
        <br/>

        ";

*/
<?php
include('../../Includes/AuthHeader.php');
?>

<?php

$state = trim($_POST['state']);
$operator = trim($_POST['operator']);

if (!empty($state)) {

    $output = "<option value=''>Choose your circuit</option>";
    $CircuitSql = "SELECT circuit FROM theaters WHERE TRIM(state) = '$state'";
    $res = mysqli_query($conn, $CircuitSql);

    while ($circuit = mysqli_fetch_assoc($res)) {
        $output .= "
        <option value='" . $circuit['circuit'] . "'>" . $circuit['circuit'] . "</option>
        ";
    }

    echo $output;
}




?>
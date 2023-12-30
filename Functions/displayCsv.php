<?php
include('../Database/db.php');

$email = $_POST['email'];
$UniqueIdentity = $_POST['unique_identifier'];
$EndId = $_POST['endId'];

$sql = "SELECT * FROM cinema_programmer WHERE unique_identity = '$UniqueIdentity'";
$res = mysqli_query($conn, $sql);

$IdQuery = "SELECT id FROM cinema_programmer WHERE unique_identity = '$UniqueIdentity' LIMIT 1";
$IdRes = mysqli_query($conn, $IdQuery) or die('Error');

while ($Id = mysqli_fetch_assoc($IdRes)) {
    $IdStart = $Id['id'];
}

// echo $IdStart;

$out = '';
$output = '';
$thead = '';
$header = '';

// for ($id = $IdStart; $id < $EndId; $id++) {

$counter = 0;
while ($row = mysqli_fetch_assoc($res)) {
    $session = $row['session'];
    if ($counter == 0 || $counter == 1) {
        // for ($i = 1; $i <= 7; $i++) {
        // $thead .= "<tr>
        //         <th scope='col' class='text-center col-md-full'>" . $session . "</th>
        //     </tr>";
        $header .= "
        <h2 class='text-center my-2 mb-2 p-2'>" . $session . "</h2>
        ";
        // }
    } else if ($counter == 3) {
        $thead .= "<tr>
            <td scope='col'>" . $session . "</td>
            <th scope='col'>" . $row['s1'] . "</th>
            <th scope='col'>" . $row['t1'] . "</th>
            <th scope='col'>" . $row['s2'] . "</th>
            <th scope='col'>" . $row['t2'] . "</th>
            <th scope='col'>" . $row['s3'] . "</th>
            <th scope='col'>" . $row['t3'] . "</th>
            <th scope='col'>" . $row['s4'] . "</th>
            <th scope='col'>" . $row['t4'] . "</th>
            <th scope='col'>" . $row['s5'] . "</th>
            <th scope='col'>" . $row['t5'] . "</th>
            <th scope='col'>" . $row['s6'] . "</th>
            <th scope='col'>" . $row['t6'] . "</th>
            <th scope='col'>" . $row['s7'] . "</th>
            <th scope='col'>" . $row['t7'] . "</th>
        </tr>
        ";
        // <td class='col-md-3'><h5>" . $session . "</h5></td>
    } else if ($counter == 2) {
        $thead .= "
        ";
    } else {
        $output .= "<tr>
            <td>" . $session . "</td>
            <td>" . $row['s1'] . "</td>
            <td>" . $row['t1'] . "</td>
            <td>" . $row['s2'] . "</td>
            <td>" . $row['t2'] . "</td>
            <td>" . $row['s3'] . "</td>
            <td>" . $row['t3'] . "</td>
            <td>" . $row['s4'] . "</td>
            <td>" . $row['t4'] . "</td>
            <td>" . $row['s5'] . "</td>
            <td>" . $row['t5'] . "</td>
            <td>" . $row['s6'] . "</td>
            <td>" . $row['t6'] . "</td>
            <td>" . $row['s7'] . "</td>
            <td>" . $row['t7'] . "</td>
            </tr>
            ";
    }

    $counter++;
}


$test = '<table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                        </tbody>
                    </table>';


$out .= "
" . $header . "
<table class='table table-responsive'>
<thead class='thead-dark'>
" . $thead . "
</thead>
<tbody>
" . $output . "
</tbody>
</table>
";

echo $out;

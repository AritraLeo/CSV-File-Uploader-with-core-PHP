<?php
// cinema_programmer
include('../Database/db.php');
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: ../Auth/signup.php");
}
$email = $_SESSION['email'];

?>
<?php
// Collecting all cinema halls - name
$sql = "SELECT * FROM cinema_halls";
$res = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>

<!-- <style>
    .right-side {
        margin-left: 3em;
        justify-content: center;
        align-items: center;
        min-height: 440px;
    }

    .side-bar {
        overflow: hidden;
        height: 414px;
        width: auto;
    }
</style> -->

<body>
    <h1 class="container my-4 p-1 text-center">User Actions</h1>


    <!-- Dashboard sidebar -->
    <?php
    $fetchAll = "SELECT * FROM programmer_csvs WHERE email = '$email'";
    $res1 = mysqli_query($conn, $fetchAll);
    while ($csvRow = mysqli_fetch_assoc($res1)) {
        $UniqueIdentifierCsv = $csvRow['unique_identifier'];
        $EndId = $csvRow['id_cinema_prog'];
        $CsvfileName = explode('*', $UniqueIdentifierCsv)[0];
    }


    ?>
    <div class="side-bar d-flex justify-content-left">
        <input type="text" value="<?php echo $email; ?>" id="email" style="display: none;">
        <ul class="side-bar p-2 my-2">
            <li class="p-2">
                <input class="btn btn-primary fileBtn" type="submit" data-endId="<?php echo $EndId; ?>" id="<?php echo $UniqueIdentifierCsv; ?>" value="<?php echo $CsvfileName;  ?>">
            </li>
            <!-- <li>
                    <input type="text" name="" id="">
                </li>
                <li>
                    <input type="text" name="" id="">
                </li>
                <li>
                    <input type="text" name="" id="">
                </li> -->
        </ul>
    </div>


    <div class="right-side col-md-12 m-0">
        <!-- ALERT -->
        <div class="alerts" id="alerts"></div>


        <!-- File upload Form -->
        <div class="form container my-3 d-flex justify-content-center">
            <form action="importCsv.php" id="upload" method="post" enctype="multipart/form-data">
                <select name="cinema" id="cinema" class="form-control col-md-4">
                    <?php
                    while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                        <option value="<?php echo $row['cinema_hall'];   ?>"><?php echo $row['cinema_hall'];   ?></option>
                    <?php  }
                    ?>
                </select>
                <div class="form-group" enctype="multipart/form-data">
                    <label for="exampleFormControlFile1">Upload the CSV file</label>
                    <input type="file" name="prog_file" class="form-control-file" accept=".csv" id="exampleFormControlFile1">
                    <input type="submit" class="btn btn-primary my-2" name="upload_csv" value="Upload">
                </div>
            </form>
        </div>


        <!-- Display the data -->
        <div class="container my-3">
            <div class="display">
                <div class="table">
                    <table class="table">
                        <!-- <thead>
                            <tr>
                                <th scope="col">Your Result</th>
                            </tr>
                        </thead> -->
                        <tbody class="tbody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- END -->
    </div>
    </div>




    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- For Form submit -->
    <script>
        $('#upload').on('submit', function(e) {
            e.preventDefault();
            const cinemahall = $('#cinema').val();
            const fl = new FormData(this);
            $.ajax({
                url: 'importCsv.php',
                method: 'post',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    // console.log(data);
                    // $('.tbody').append(data);
                    $('#alerts').append(data);
                }
            });
        });
    </script>


    <!-- For File button click -->
    <script>
        $('.fileBtn').click(function() {

            const email = $('#email').val();
            const unique_identifier = $(this).attr('id');
            const endId = $(this).attr('data-endId');
            // console.log(email);
            console.log(endId);
            // console.log(unique_identifier);
            $.ajax({
                url: 'displayCsv.php',
                method: 'post',
                data: {
                    email: email,
                    unique_identifier: unique_identifier,
                    endId: endId
                },
                success: function(data) {
                    // console.log(data);
                    $('.tbody').append(data);
                    // $('#alerts').append(data);
                }
            });
        });
    </script>
</body>

</html>
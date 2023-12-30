<?php
include('../../Includes/AuthHeader.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Css/RoCalcIndex.css">
    <!-- Bootstrap CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>
<?php include('../Navbar/index.php') ?>

<body class="background">

    <div class="meessage text-center my-3 p-2">
        <h1 class="text-bold my-2 p-1">Please choose the state and circuit</h1>
        <span class="my-2 p-2 text-bold">
            The Ro Form will be generated according to your choice
        </span>
    </div>

    <div class="container parent my-4 p-3" style="
    display: flex;
  /* grid-template-columns: 1fr 1fr; */
    justify-content: space-between;
    ">

        <div class="inline-block">
            <label for="">Operator</label>
            <select name="operator" id="operator" class="dropdown input my-3 p-2">
                <option value="">Choose your operator</option>
                <option value="ufo">UFO</option>
            </select>
        </div>

        <div class="inline-block">
            <label for="">State</label>
            <select name="state" id="state" class="dropdown input my-3 p-2">
                <option value="">Choose your state</option>
                <option value="Andhra Pradesh">Andhra Pradesh</option>
                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                <option value="Daman and Diu">Daman and Diu</option>
                <option value="Delhi">Delhi</option>
                <option value="Lakshadweep">Lakshadweep</option>
                <option value="Puducherry">Puducherry</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madhya Pradesh">Madhya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Odisha">Odisha</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="Uttarakhand">Uttarakhand</option>
                <option value="West Bengal">West Bengal</option>
            </select>
        </div>

        <div class="inline-block">
            <label for="">Circuit</label>
            <select name="circuit" id="circuit" class="dropdown input my-3 p-2">
                <option value="">Choose your circuit</option>
            </select>
        </div>

        <div class="inline-block">
            <label for=""></label>
            <button class="btn btn-success input my-3 p-2" id="ro">Generate RO FORM</button>
        </div>
    </div>

    <div class="alerts" style="display: none; width: 50%; margin-left: 20rem;">

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <script>
        $('#state').change(function() {
            var operator = $('#operator').val();
            var state = $('#state').val();
            if (state != ' ' || operator != '') {
                // console.log(state);
                $.ajax({
                    url: "circuits.php",
                    method: 'POST',
                    data: {
                        state: state,
                        operator: operator,
                    },
                    success: function(res) {
                        $('#circuit').html(res);
                    }
                });
            }
        });


        $('#ro').click(function() {
            $('.alerts').css('display', 'none');
            var err = '';
            var operator = $('#operator').val();
            var state = $('#state').val();
            var circuit = $('#circuit').val();
            console.log(operator);
            console.log(circuit);
            console.log(state);
            console.log(err);
            if (circuit == null || circuit == undefined || circuit == '') {
                err = 'Circuit is not chosen';
            } else if (state == null || state == undefined || state == '') {
                err = 'State is not chosen';
            } else if (operator == null || operator == undefined || operator == '') {
                err = 'Operator is not chosen';
            }
            if (err != '') {
                // Display alert
                $Err = '<div class="alert alert-danger text-center">' + err + '</div>';
                $('.alerts').append($Err);
                $('.alerts').css('display', 'block');
            } else {
                // AJAX :
                console.log('AJAX');
                console.log(operator);
                console.log(circuit);
                console.log(state);
                console.log(err);

                location.href = "calculator.php?operator=" + operator + "&circuit=" + circuit + "&state=" + state + "";
            }


        });
    </script>
</body>

</html>
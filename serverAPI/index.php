<?php

//read Data and build arrays
$conn = new mysqli('hostName','userName','Password','databaseName');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$query = "SELECT time, tValue, hValue FROM home ORDER by num DESC LIMIT 24";
if ($stmt = $conn->prepare($query)) {
          
            $stmt->execute();
        
            $stmt->bind_result($time, $tValue, $hValue);
       
            $timeArray = array();
            $tArray = array();
            $hArray = array();

            while ($stmt->fetch()) {
                array_push($timeArray, $time);
                array_push($tArray, $tValue);
                array_push($hArray, $hValue);
            }
            $stmt->close();
        }
         
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Our flat data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style media="all">
        div {background: #e7e7e7; display: table; max-width: 330px; padding: 10px; margin: 0 auto 20px;}
    </style>
</head>
<body>
    <div>
    <canvas id="temperature" width="330px" height="400px"></canvas>
    </div>
    <div>
    <canvas id="Humidity" width="330px" height="400px"></canvas>
    </div>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
 <script>
 Chart.scaleService.updateScaleDefaults('linear', {
    ticks: {
        min: 0
    }
});
</script>
<script>
 var ctx = document.getElementById('temperature').getContext('2d');
 var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {        
        labels: [<?php echo "'".implode("','",$timeArray)."'"; ?>],
        datasets: [{
            label: "Temperature",
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [<?php echo implode(",",$tArray); ?>],
        }]
    },

    // Configuration options go here
    options: {}
});
</script>

<script>
 var ctx = document.getElementById('Humidity').getContext('2d');
 var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {        
        labels: [<?php echo "'".implode("','",$timeArray)."'"; ?>],
        datasets: [{
            label: "Humidity",
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [<?php echo implode(",",$hArray); ?>],
        }]
    },

    // Configuration options go here
    options: {}
});
</script>


</body>
</html>

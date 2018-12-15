<!DOCTYPE html>
<html>
  <head>
</head>
<body>
<!-- <script type="text/javascript">
document.getElementById("myButton").onclick = function () {
window.location.href = "new.php";

};
</script> -->
<!-- <button onclick="location.href = 'new.php';" id="myButton" class="float-left submit-button" >Home</button>
 <br> -->
<b>Info Source</b><br><br>
<?php

$servername = "localhost";
$username = "someuser";
$password = "Tesco@2015";
$dbname = "weather";


$source= $_GET["w1"];
$destination=$_GET["w2"];
$maxtemp_src=$_GET["w3"];
$mintemp_src=$_GET["w4"];
$humidity_src=$_GET["w5"];
$maxtemp1=$_GET["w6"];
$mintemp1=$_GET["w7"];
$humidity1=$_GET["w8"];
$maxtemp2=$_GET["w9"];
$mintemp2=$_GET["w10"];
$humidity2=$_GET["w11"];
$maxtemp3=$_GET["w12"];
$mintemp3=$_GET["w13"];
$humidity3=$_GET["w14"];
$maxtemp4=$_GET["w15"];
$mintemp4=$_GET["w16"];
$humidity4=$_GET["w17"];
$maxtemp5=$_GET["w18"];
$mintemp5=$_GET["w19"];
$humidity5=$_GET["w20"];
$maxtemp_dest=$_GET["w21"];
$mintemp_dest=$_GET["w22"];
$humidity_dest=$_GET["w23"];


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql1 = "SELECT source, destination FROM weather_api WHERE source='$source' and destination='$destination'";
$result = $conn->query($sql1);
if ($result->num_rows == 0) {

$sql = "INSERT INTO weather_api (source,destination,source_max,source_min,source_hum,way1_max,way1_min,way1_hum,way2_max,way2_min,way2_hum,way3_max,way3_min,way3_hum,way4_max,way4_min,way4_hum,way5_max,way5_min,way5_hum,destination_max,destination_min,destination_hum)
VALUES ('$source','$destination',$maxtemp_src,$mintemp_src,$humidity_src,$maxtemp1,$mintemp1,$humidity1,$maxtemp2,$mintemp2,$humidity2,$maxtemp3,$mintemp3,$humidity3,$maxtemp4,$mintemp4,$humidity4,$maxtemp5,$mintemp5,$humidity5,$maxtemp_dest,$mintemp_dest,$humidity_dest)";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully in the Database. Hence result shown from API. ";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

else {
$sql2 = "SELECT source,destination,source_max,source_min,source_hum,way1_max,way1_min,way1_hum,way2_max,way2_min,way2_hum,way3_max,way3_min,way3_hum,way4_max,way4_min,way4_hum,way5_max,way5_min,way5_hum,destination_max,destination_min,destination_hum FROM weather_api";
$result_new = $conn->query($sql2);

    echo "From Database.";
}
$conn->close();
?>
<br>
<br>
Showing info:<br>
City : <?php echo $source ?> ,Max Temp : <?php echo $maxtemp_src ?>       ,Min Temp : <?php echo $mintemp_src ?> ,Humidity : <?php echo $humidity_src ?>
<br>
Location : Waypoint1 ,Max Temp : <?php echo $maxtemp1 ?>       ,Min Temp : <?php echo $mintemp1 ?> ,Humidity : <?php echo $humidity1 ?>
<br>
Location : Waypoint2 ,Max Temp : <?php echo $maxtemp2 ?>       ,Min Temp : <?php echo $mintemp2 ?> ,Humidity : <?php echo $humidity2 ?>
<br>
Location : Waypoint3 ,Max Temp : <?php echo $maxtemp3 ?>       ,Min Temp : <?php echo $mintemp3 ?> ,Humidity : <?php echo $humidity3 ?>
<br>
Location : Waypoint4 ,Max Temp : <?php echo $maxtemp4 ?>       ,Min Temp : <?php echo $mintemp4 ?> ,Humidity : <?php echo $humidity4 ?>
<br>
Location : Waypoint5 ,Max Temp : <?php echo $maxtemp5 ?>       ,Min Temp : <?php echo $mintemp5 ?> ,Humidity : <?php echo $humidity5 ?>

<br>
Destination : <?php echo $destination ?> ,Max Temp : <?php echo $maxtemp_dest ?>       ,Min Temp : <?php echo $mintemp_dest ?> ,Humidity : <?php echo $humidity_dest ?>

</body>
</html>
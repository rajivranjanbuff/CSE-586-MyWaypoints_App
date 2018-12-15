<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions Service</title>
    <script src="https://code.jquery.com/jquery-3.0.0.js"></script>
    <style>
    
      #map {
        height: 50%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
    </style>
  </head>
  <body>
    <div id="floating-panel">
    <b>Start: </b>
    <?php 
    echo $_GET["w1"]; 
    ?>
    <b>End: </b>
    <?php 
    $destination = $_GET["w2"]; 
    echo $destination ?>
    </div>
    <div id="map"></div>
    <script>
          var latitude1_des;
          var longitude1_des;
      function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var source ="<?php echo $_GET["w1"]; ?>";
        
  
        var destination ="<?php echo $_GET["w2"]; ?>";
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 7,
          center: {lat: 43.65 , lng: 79.38}

        });
           directionsDisplay.setMap(map);
          calculateAndDisplayRoute(directionsService, directionsDisplay, source, destination);
      }
      function calculateAndDisplayRoute(directionsService, directionsDisplay,source,destination
      ) {
        var waypoints = [];
        var lat1=<?php echo $_GET["w3"]; ?>;
        var lng1=<?php echo $_GET["w8"]; ?>;
        var lat2=<?php echo $_GET["w4"]; ?>;
        var lng2=<?php echo $_GET["w9"]; ?>;
        var lat3=<?php echo $_GET["w5"]; ?>;
        var lng3=<?php echo $_GET["w10"]; ?>;
        var lat4=<?php echo $_GET["w6"]; ?>;
        var lng4=<?php echo $_GET["w11"]; ?>;
        var lat5=<?php echo $_GET["w7"]; ?>;
        var lng5=<?php echo $_GET["w12"]; ?>;
        console.log(lat1);
        console.log(lng1);
        waypoints.push({location: {lat:lat1,lng:lng1},stopover: true});
        waypoints.push({location: {lat:lat2,lng:lng2},stopover: true});
        waypoints.push({location: {lat:lat3,lng:lng3},stopover: true});
        waypoints.push({location: {lat:lat4,lng:lng4},stopover: true});
        waypoints.push({location: {lat:lat5,lng:lng5},stopover: true});

        
        directionsService.route({
          origin: source,
          destination: destination,
          waypoints: waypoints,
          travelMode: 'DRIVING'

        }, function(response, status) {

          var route =response.routes[0];
          
          console.log(route);
          var over_path = route.overview_polyline;
          // var legs= route.legs;
          // console.log(legs);
          // var steps = legs[0];
          // console.log(steps);
          // var loc = steps.steps;
          // console.log(loc);
          // var end_loc = loc[5];
          // console.log(end_loc);
          // var end_point = end_loc.overview_polyline;
          // console.log(end_point);
          console.log(over_path);
          
          var points=[ ]
          var index = 0, len = over_path.length;
          var lat = 0, lng = 0;
          while (index < len) {
              var b, shift = 0, result = 0;
              do {

              b = over_path.charAt(index++).charCodeAt(0) - 63;//finds ascii                                                                                    //and substract it by 63
              result |= (b & 0x1f) << shift;
              shift += 5;
             } while (b >= 0x20);


       var dlat = ((result & 1) != 0 ? ~(result >> 1) : (result >> 1));
       lat += dlat;
      shift = 0;
      result = 0;
     do {
        b = over_path.charAt(index++).charCodeAt(0) - 63;
        result |= (b & 0x1f) << shift;
       shift += 5;
         } while (b >= 0x20);
     var dlng = ((result & 1) != 0 ? ~(result >> 1) : (result >> 1));
     lng += dlng;
 
   points.push({latitude:( lat / 1E5),longitude:( lng / 1E5)})  
 
  }
  console.log (points);
  console.log(points.length);
  var i;
  var new_points=[ ];
  
 
  for(i=0;i<5;i++){
    var randomnumber = Math.floor(Math.random() * (points.length - 0 + 1)) + 0;
    new_points.push({lat:points[randomnumber].latitude, lng :points[randomnumber].longitude});
    console.log(new_points[i]);
  }
 
 var maxtemp_src;
  var mintemp_src;
  var humidity_src;
 
var apiCall="https://api.openweathermap.org/data/2.5/weather?q="+source+"&appid=e2f2617b5dbd372045c9014d513ea889";

$.getJSON(apiCall,weatherCallback);

function weatherCallback(weatherData){
  maxtemp_src=weatherData.main.temp_max;
   mintemp_src=weatherData.main.temp_min;
   humidity_src=weatherData.main.humidity;
  $('.weatherResponse').append("For the Source city A :"+source+"  "+"    The max temp is "+maxtemp_src+"     and the min temp is "+mintemp_src+"     and the humidity is "+humidity_src);
}
  
var apiCall2="https://api.openweathermap.org/data/2.5/weather?lat="+new_points[0].lat+"&lon="+new_points[0].lng+"&appid=e2f2617b5dbd372045c9014d513ea889";

$.getJSON(apiCall2,weatherCallback2);
var maxtemp1;
  var mintemp1;
  var humidity1;
function weatherCallback2(weatherData2){
  maxtemp1=weatherData2.main.temp_max;
  mintemp1=weatherData2.main.temp_min;
   humidity1=weatherData2.main.humidity;
 
  $('.weatherResponse0').append("For the intermediate waypoint B with latitude:"+new_points[0].lat+"  and the longitude "+new_points[0].lng+"  The max temp is "+maxtemp1+"     and the min temp is "+mintemp1+"     and the humidity is "+humidity1+"<br>"+"<br>");
}



var apiCall3="https://api.openweathermap.org/data/2.5/weather?lat="+new_points[1].lat+"&lon="+new_points[1].lng+"&appid=e2f2617b5dbd372045c9014d513ea889";

$.getJSON(apiCall3,weatherCallback3);
var maxtemp2;
  var mintemp2;
 var humidity2;

function weatherCallback3(weatherData3){
  maxtemp2=weatherData3.main.temp_max;
   mintemp2=weatherData3.main.temp_min;
 humidity2=weatherData3.main.humidity;
  $('.weatherResponse1').append("For the intermediate waypoint  C with latitude:"+new_points[1].lat+"  and the longitude "+new_points[1].lng+"  The max temp is "+maxtemp2+"     and the min temp is "+mintemp2+"     and the humidity is "+humidity2+"<br>"+"<br>");
}


var maxtemp3;
  var mintemp3;
  var humidity3;

var apiCall4="https://api.openweathermap.org/data/2.5/weather?lat="+new_points[2].lat+"&lon="+new_points[2].lng+"&appid=e2f2617b5dbd372045c9014d513ea889";

$.getJSON(apiCall4,weatherCallback4);

function weatherCallback4(weatherData4){
  maxtemp3=weatherData4.main.temp_max;
   mintemp3=weatherData4.main.temp_min;
  humidity3=weatherData4.main.humidity;
 
  $('.weatherResponse2').append("For the intermediate waypoint D with latitude:"+new_points[2].lat+"  and the longitude "+new_points[2].lng+"  The max temp is "+maxtemp3+"     and the min temp is "+mintemp3+"     and the humidity is "+humidity3+"<br>"+"<br>");
}



var apiCall5="https://api.openweathermap.org/data/2.5/weather?lat="+new_points[3].lat+"&lon="+new_points[3].lng+"&appid=e2f2617b5dbd372045c9014d513ea889";

$.getJSON(apiCall5,weatherCallback5);

var maxtemp4;
  var mintemp4;
  var humidity4;

function weatherCallback5(weatherData5){
   maxtemp4=weatherData5.main.temp_max;
   mintemp4=weatherData5.main.temp_min;
  humidity4=weatherData5.main.humidity;
 
  $('.weatherResponse3').append("For the intermediate waypoint E with latitude:"+new_points[3].lat+"  and the longitude "+new_points[3].lng+"  The max temp is "+maxtemp4+"     and the min temp is "+mintemp4+"     and the humidity is "+humidity4+"<br>"+"<br>");
}


var apiCall6="https://api.openweathermap.org/data/2.5/weather?lat="+new_points[4].lat+"&lon="+new_points[4].lng+"&appid=e2f2617b5dbd372045c9014d513ea889";

$.getJSON(apiCall6,weatherCallback6);

var maxtemp5;
  var mintemp5;
  var humidity5;

function weatherCallback6(weatherData6){
 maxtemp5=weatherData6.main.temp_max;
   mintemp5=weatherData6.main.temp_min;
  humidity5=weatherData6.main.humidity;
 
  $('.weatherResponse4').append("For the intermediate waypoint F with latitude:"+new_points[4].lat+"  and the longitude "+new_points[4].lng+"  The max temp is "+maxtemp5+"     and the min temp is "+mintemp5+"     and the humidity is "+humidity5+"<br>"+"<br>");
}



var apiCall1="https://api.openweathermap.org/data/2.5/weather?q="+destination+"&appid=e2f2617b5dbd372045c9014d513ea889";


$.getJSON(apiCall1,weatherCallback1);

var maxtemp_dest;
  var mintemp_dest;
  var humidity_dest;

function weatherCallback1(weatherData1){
   maxtemp_dest=weatherData1.main.temp_max;
  mintemp_dest=weatherData1.main.temp_min;
  humidity_dest=weatherData1.main.humidity;
  $('.weatherResponse5').append("For the destination city G :"+destination+"  "+"    The max temp is "+maxtemp_dest+"     and the min temp is "+mintemp_dest+"     and the humidity is "+humidity_dest);
}
document.getElementById("myButton").onclick = function () {
  
            window.location.href = "final.php?w1=" + source + "&w2=" + destination + "&w3=" + maxtemp_src + "&w4=" + mintemp_src
             + "&w5=" + humidity_src + "&w6=" + maxtemp1 + "&w7=" + mintemp1 + "&w8=" + humidity1 + "&w9=" + maxtemp2 + "&w10=" + mintemp2
              + "&w11=" + humidity2 + "&w12=" + maxtemp3+ "&w13=" + mintemp2+ "&w14=" + humidity3+ "&w15=" + maxtemp4+ "&w16=" + mintemp4+ "&w17=" + humidity4+ "&w18=" + maxtemp5+ "&w19=" + mintemp5+ "&w20=" + humidity5+ "&w21=" + maxtemp_dest+ "&w22=" + mintemp_dest+ "&w23=" + humidity_dest;
              //alert("Hello! I am an alert box!!");

            
};


          if (status === 'OK') {
            console.log(response)
            directionsDisplay.setDirections(response);
            
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });  


}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwJ2Vepe9L2Miuh7QH87SR_RItIXHlX6Q&callback=initMap">
    </script>
<div class="weatherResponse"></div> 
<br>
 <div><div class="weatherResponse0"></div> </div>
 </div>
 <br>
 <div class="weatherResponse1"></div> 
 <br>
 <div class="weatherResponse2"></div> 
 <br>
 <div class="weatherResponse3"></div> 
 <br>
 <div class="weatherResponse4"></div> 
 <br>
 <div class="weatherResponse5">
 </div> 

<button id="myButton" class="float-left submit-button" >Get Source Info</button>
  </body>
</html>
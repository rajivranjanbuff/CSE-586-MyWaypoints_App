<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions Service</title>
    <script src="https://code.jquery.com/jquery-3.0.0.js"></script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
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
    echo $_POST['source']; 
    ?>
    <b>End: </b>
    <?php 
    $destination = $_POST['destination']; 
    echo $destination ?>
    </div>
    <div id="map"></div>
    <script>
          
      function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var source ="<?php echo $_POST['source']; ?>";
        var source1 ="oklahoma city, ok";
        var destination1="amarillo, tx";
        var destination ="<?php echo $_POST['destination']; ?>";
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 7,
          center: {lat: 43.65 , lng: 79.38}

        });
       
          
             directionsDisplay.setMap(map);
          calculateAndDisplayRoute(directionsService, directionsDisplay, source, destination);
  
    
      }

      function calculateAndDisplayRoute(directionsService, directionsDisplay,source,destination) {

        
        directionsService.route({
          origin: source,
          destination: destination,
          travelMode: 'DRIVING'
        }, function(response, status) {

          var route =response.routes[0];
          
          console.log(route);
          var over_path = route.overview_polyline;
          
          console.log(over_path);
          
          var points=[ ]
          var index = 0, len = over_path.length;
          var lat = 0, lng = 0;
          while (index < len) {
              var b, shift = 0, result = 0;
              do {

              b = over_path.charAt(index++).charCodeAt(0) - 63;//finds ascii                                                                                   
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
  var lat1=new_points[0].lat;
  var lat2=new_points[1].lat;
  var lat3=new_points[2].lat;
  var lat4=new_points[3].lat;
  var lat5=new_points[4].lat;
  var lng1 = new_points[0].lng;
  var lng2 = new_points[1].lng;
  var lng3 = new_points[2].lng;
  var lng4 = new_points[3].lng;
  var lng5 = new_points[4].lng;
  console.log(new_points);
 
// document.getElementById("myButton").onclick = function () {
//   // window.setTimeout('window.location="http://www.pa.msu.edu/services/"; ',2000);
//             window.location.href = "new.php?w1=" + source + "&w2=" + destination + "&w3=" + lat1 + "&w4=" + lat2+ "&w5=" + lat3 + "&w6=" +lat4 + "&w7=" + lat5 + "&w8=" + lng1 + "&w9=" + lng2 + "&w10=" + lng3 + "&w11=" + lng4 + "&w12=" + lng5;
            
// };


document.getElementById("newImage").onmouseout = function () {
  // window.setTimeout('window.location="http://www.pa.msu.edu/services/"; ',2000);
            window.location.href = "new.php?w1=" + source + "&w2=" + destination + "&w3=" + lat1 + "&w4=" + lat2+ "&w5=" + lat3 + "&w6=" +lat4 + "&w7=" + lat5 + "&w8=" + lng1 + "&w9=" + lng2 + "&w10=" + lng3 + "&w11=" + lng4 + "&w12=" + lng5;
            
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


<!-- <button id="myButton" class="float-left submit-button" >get waypoints</button> -->
<img id ="newImage" src="data/2000px-Solid_white_svg.png"  width="300" height="300"/>


  </body>
</html>
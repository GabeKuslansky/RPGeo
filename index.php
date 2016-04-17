
 <?php session_start(); ?>
<!DOCTYPE html>
    <html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      img {
          height: 150px;
          width: 150px;
      }
      #info {
          border: 1px #ccc solid;
          height: 150px;
          width: 400px;
          position: absolute;
          bottom: 0px;
          left: 0px;
      }
      #location {
          text-align: center;
          color: black;
          font-size: 12px;
      }
      #map {
          z-index: 1;
        height: 100%;
      }
      #hotspot {
          border-radius: 100px;
          border: 25px #ccc solid;
      }
      #sidekick {
          margin-left: auto;
          margin-right: auto;
          display: block;
          z-index: 0;
      }
    </style>
  </head><?php echo "<div id='name'>" . $_SESSION['name'] . '</div>'; echo "<div id='gender'>" . $_SESSION['gender'] . '</div>';?>

  <body>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.js"></script>
      <!--<div class="container">-->
      <!--    <img id="sidekick" src="images/sidekick.png"></img>-->
      <!--    <h1 id='typed-container'></h1>-->
      <!--  </div>-->
 
   <div id="map">
       <p id="location"></p>
   </div>    
    <script>
    
    //Scrollbar Functions
    function reloadScrollBars() {
    document.documentElement.style.overflow = 'auto';  // firefox, chrome
    document.body.scroll = "yes"; // ie only
}

function unloadScrollBars() {
    document.documentElement.style.overflow = 'hidden';  // firefox, chrome
    document.body.scroll = "no"; // ie only
}

 unloadScrollBars();
 var charName =  '<?php echo $_SESSION["name"]; ?>';
 var charGender ='<?php echo $_SESSION["gender"]; ?>';
 var charHp =    '<?php echo $_SESSION["hp"]; ?>';
 var battleLat = '<?php echo $_SESSION["lat"]; ?>';
 var battleLng = '<?php echo $_SESSION["lng"]; ?>';
 var beginning = '<?php echo $_SESSION["beginning"]; ?>';
 var monstersKilled = '<?php echo $_SESSION["monstersKilled"]; ?>';

$('#name').css('opacity','0%');
$('#gender').css('opacity','0%');

if (monstersKilled === NaN) {
   monstersKilled = 0;
}

var character = {
  hp: charHp,
  maxHp: 20,
  int: 5,
  strength: 9,
  lvl: 1,
  name: charName,
  gender: charGender,
  monstersKilled: monstersKilled
};

if (!beginning) {
 character.lat = battleLat;
 character.lng = battleLng;
}


    $('#hp').html('HP: ' + character.hp + '/'+character.maxHp);
    $('#kills').html('Monsters Killed: ' + character.monstersKilled);
    var info = $('#info');


$('#name').hide();
$('#gender').hide();
    
    
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.

      function initMap() {
          
  //Define Global Hotspot Vars
  
  const latIncrement = 0.00007;
  const lngIncrement = 0.00004;
  
  var hotspots = {
              'Boss Battle': {lat: 40.744758899999105, lng: -73.98530479999968, color: 'yellow'},
              'Weak Enchanted Forest': {lat: 40.7450647000002, lng: -73.98495649999991, color: 'red'},
              whatever: {lat: 40.7453651000002, lng: -73.98303738888882, color: 'yellow', custom: true, increment: 0.0001},
              'Funky Town': {lat: 40.74425220000043, lng: -73.98549699999934, color: 'yellow'},
              'Healing Station': {lat: 40.744890599998755, lng: -73.98571754999872, color: 'green'},
              'Weak Cave': {lat: 40.74466219999939, lng: -73.98509720000031
              }
          };
  var keys = [];
          
        addEventListener('keydown',function(e){
            keys[e.keyCode] = true;
        }, false);
        
        addEventListener('keyup', function(e) {
            keys[e.keyCode] = false;
        }, false);
        
  var polygons = [];
  
  var coordinates = [];
  
  for (var i in hotspots) {
      
  }
 
 //Define hotspot length
 var hotspotLength = 0; 
for (var i in hotspots) {
 hotspotLength++;
}

var hotspotNames = [];

for (var i in hotspots) {
    hotspotNames[hotspotNames.length] = i;
}

  //
  for (var i = 0; i < hotspotLength; i++) {
      var latitude = hotspots[hotspotNames[i]].lat, longitude = hotspots[hotspotNames[i]].lng;
      if (hotspots[hotspotNames[i]].custom) {
          if (i == 2) {
              var increment = hotspots[hotspotNames[i]].increment; //use var increment if you want a square and don't want to type a number each time
              polygons[i] = [{lat: latitude-increment, lng: longitude-increment+0.000279}, {lat: latitude-increment+0.00006, lng: longitude+increment+0.00009}, {lat: latitude+increment+0.00007, lng: longitude+increment-0.0004}, {lat: latitude+increment, lng: longitude+increment-0.0004}, {lat: latitude - increment + 0.0001, lng: longitude+increment-0.00016}];
          }
      } else {
            polygons[i] = [{lat: latitude-latIncrement, lng: longitude-lngIncrement}, {lat: latitude+latIncrement, lng: longitude-lngIncrement}, {lat: latitude+latIncrement, lng: longitude+lngIncrement}, {lat: latitude-latIncrement, lng: longitude+lngIncrement}];
  
      }
      }

         var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: character.lat, lng: character.lng},
            zoom: 20
          });
          
          map.controls[google.maps.ControlPosition.TOP_CENTER].push(info);
        
    //       $("#map").hide();
        
          var infoWindow = new google.maps.InfoWindow({map: map}); 
          var realtimeLng = 0;
          var realtimeLat = 0;
          var direction = 0;
                setInterval(function() {
                    var gender = (character.gender).toLowerCase();
                    if (keys[83] || keys[83] && keys[65] || keys[83] && keys[65]) { direction = 0; } //s - down
                    if (keys[65]) { direction = 1; } //a - left
                    if (keys[87]) { direction = 2; } //w - forward
                    if (keys[68]) { direction = 3; } //d - right
                    
                    
                    var positions = {0: gender+'front', 1: gender+'left', 2: gender+'back', 3: gender+'right'};
                    $('#map > div > div:nth-child(1) > div:nth-child(4) > div:nth-child(4) > div:nth-child(1)').html('<img style="height: 100px; width: 100px;" src="images/'+positions[direction]+'.png"/>');
                }, 10);
 
            
                
                // Try HTML5 geolocation.
                //Prior to doomsday
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
              
              //Fake coordinates for debugging
              if (!beginning) {
              var latitude = character.lat;
              var longitude = character.lng;
              } else {
                  var latitude = position.coords.latitude;
                  var longitude = position.coords.longitude;
              }
                
                function updateMap() {
                  var pos = {
                    lat: latitude,
                    lng: longitude
                  };
                    
                  infoWindow.setPosition(pos);
                  map.setCenter(pos);
                }
                
                //Actual realtime coordinates based on where you are
                
                    realtimeLng = position.coords.latitude;
                    realtimeLat = position.coords.longitude;
                   
                    
                  infoWindow.setPosition(pos);
                  map.setCenter(pos);
                
               function inRadius(hotspot) {
                   var lat = hotspots[hotspot].lat,
                   lng = hotspots[hotspot].lng;
                 
                   if (!hotspot.custom) { 
                      // var customIncrement = hotspot.increment;
                   if (((Math.abs(/*realtimeLat*/latitude-lat) <= latIncrement) && (Math.abs(/*realtimeLng*/longitude-lng) <= lngIncrement))) {
                       return true;
                   } else {
                       //Noncustom hotspot
                       return false;
               
                   }
                   } else {
                   
               }
               }
        
        setInterval(function(){
             
                if (keys[87] /*make w key*/) {
                    latitude+= 0.00000075;
                    updateMap();
                } 
                if(keys[83] /*Make s key*/) {
                    latitude-= 0.00000075;
                    updateMap();
                } 
                if(keys[68] /*Make d key*/) {
                    longitude+= 0.00000075;
                    updateMap();
                } 
                if(keys[65] /*Make a key*/) {
                    longitude-= 0.00000075;
                    updateMap();
                } 
                if(keys[32] /*Make spacebar key*/) {
                    console.log(latitude,longitude);
                }
        }, 10);
            addEventListener('keydown',function(){
                
                
               
            var hotspotYouAreIn = false;     
            for (var i in hotspots) {
                    if (inRadius(i)) {
                        hotspotYouAreIn = i;
                        
                        $('#location').html(hotspotYouAreIn);
                        infoWindow.setContent(i);
                        var num = Math.floor(Math.random() * 15);
                       console.log(num);
                       var otherNum = Math.floor(Math.random() * 15);
                       console.log(otherNum);
                      if (num == otherNum /*&& !4*/) {
                           window.location.href = ('https://mapproject-gabekuslansky.c9users.io/battle.php?hp='+character.hp+'&lat='+latitude+'&lng='+longitude+'&name='+character.name+'&gender='+(character.gender).toLowerCase());
                           keys = [];
                       } 
                    } else {
                        if (!hotspotYouAreIn) {
                            hotspotYouAreIn = false;
                        //    infoWindow.setContent('<img src="images/femalefront.png"/>');
                        }    
                    }
                }
            
                
            }, false);
    
              var pos = {
                lat: latitude,
                lng: longitude
              };
                
            infoWindow.setPosition(pos);
            infoWindow.setContent('No Hotspot');
            map.setCenter(pos);
       
       
       for (var i = 0; i < hotspotNames.length; i++) {
            var hotspot_indicator = new google.maps.Polygon({
             paths: polygons[i],
             strokeColor: '#FF0000',
             strokeOpacity: 0.8,
             strokeWeight: 2,
             fillColor: '#FF0000',
             fillOpacity: 0.35
           });
           hotspot_indicator.setMap(map);
            
          }

          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
        
        
          function getLiveData() {
          navigator.geolocation.getCurrentPosition(function(position) {
              
              //Fake coordinates for debugging
              realtimeLat = position.coords.latitude;
              realtimeLng = position.coords.longitude;
              var pos = {
                  lat: realtimeLat+0.00025,
                  lng: realtimeLng+0.0004
              }
                 infoWindow.setPosition(pos);
                  map.setCenter(pos);
                  console.debug(pos);
      });
        $("#sidekick").click(function(){
            $('#map').show();
         });
      }
      
       $("#sidekick").click(function(){
            $('#map').show();
        });
      
//setInterval(getLiveData, 2500);
      }
      

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }
      
  

      
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjt82xiXlgpD79LPuV_4EBbutfzPJeSsI&callback=initMap">
    </script>
    
  </body>
</html>
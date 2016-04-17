<? session_start(); $_SESSION['hp'] = 15; ?>
<!DOCTYPE html>
    <html>
    <head>
        <title>Geolocation</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" />
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.js"></script>
        <script type="text/javascript" src="typed.min.js"></script>
        
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style type="text/css">
        #sidekick {
            margin-left: auto;
            margin-right: auto;
            display: block;
            height: 600px;
            margin-bottom: -100px;
            margin-top: -100px;
            padding-bottom: 50px;
        }
        
        input {
            text-align: center;
            width: 400px;
            height: 30px;
            font-size: 20px;
        }
        
    </style>
    </head>
    <body>
        <center>
        <div class="container">
            <img id="sidekick" src="images/sidekick.png"/>
            <div id="crab_dialogue"></div>
            <div id="crab_dialogue2"></div>
            <div id="crab_dialogue3"></div>
            <input type="text" id='name'/>
            <div id="mf_select">
                <button id="male">MALE</button>
                <button id="female">FEMALE</button>
            </div>
            <button id="start">START</button>
        </div>
        </center>
        <script>
        function unloadScrollBars() {
    document.documentElement.style.overflow = 'hidden';  // firefox, chrome
    document.body.scroll = "no"; // ie only
}
    
 unloadScrollBars();  
        $('#name').hide();
        $('#crab_dialogue2').hide();
        $('#start').hide();
        $('#mf_select').hide();
            // $(function(){
              $("#crab_dialogue").typed({
                strings: ["<h1>I am crabdad, your sidekick. Welcome to RPGeo. What is your name?</h1>"],
                callback: function()  { $('#name').fadeIn(1000); $('#name').focus(); },
                typeSpeed: 0,
                showCursor: false
              });
              
              $('#name').keyup(function(e) {
              console.log(e.keyCode);
                  if (e.keyCode == 13) {
                     var name = $(this).val();
                      $(this).val('');
                      $(this).fadeOut(1000);
                      $('#crab_dialogue').fadeOut(1000, function() {
                          
                      $(this).fadeOut(1000);
                      $('#crab_dialogue2').fadeIn(1000);
                     
                      $('#crab_dialogue2').typed({
                          strings: ["<h1>Welcome " + name + ", are you a male or female?</h1>"],
                          callback: function() { $('#mf_select').fadeIn(1000); },
                          typeSpeed: 0,
                          showCursor: false,
                      });
                     $('div > button').click(function() {
                          var gender = $(this).html();
                          $(this).fadeOut(1000);
                          $('button').fadeOut(1000);
                          $('#crab_dialogue2').fadeOut(1000, function() {
                             $(this).fadeOut(1000);
                              $('#crab_dialogue3').fadeIn(1000);
                             $('#crab_dialogue3').typed({
                                 strings:["<h1>Every player starts at level one, and gains experience by battling monsters. You battle these monsters by entering the geolocational fields that have been located throughout the world. The team that gains the most amount of points by killing more monsters each day will control each geolocation</h1>"],
                                 callback: function() { $('#start').fadeIn(1000); },
                                 typeSpeed: -10,
                                 showCursor: false
                             });
                             
                             $('#start').click(function() {
                                 window.location.href='https://mapproject-gabekuslansky.c9users.io/variables.php?name='+name+'&gender='+gender+'&beginning=true';
                          });
                           });
                        });
                     });
                 }
              });
        </script>
    </body>
</html>
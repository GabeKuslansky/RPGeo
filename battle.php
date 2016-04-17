<?php session_start(); ?>
<head>
    
<style type="text/css">
    img {
        height: 450px;
        width: 450px;
    }
    #monster {
        height: 300px;
        width: 300px;
    }
    .enemy {
        position: fixed;
        right: 1%;
        top: 0px;
    }
    #player {
          position: fixed;
        left: 10%;
        bottom: 0px;
    }
    
    #crabdad {
        height: 200px;
        width: 200px;
        position: fixed;
        left: -2.5%;
        bottom: 10%;
    }
    #playerHpContainer {
        position: fixed;
        left: 2%;
        bottom: 30%;
    }
    #monsterHpContainer {
        position: fixed;
        right: 0.5%;
        top: -1%;
    }
</style>
 <link rel="stylesheet" href="https ://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" />
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.js"></script>
</head>
<body>
    <audio autoplay>
        <source src="music/complete_trash_-_Hackathon_Game_Music.mp3" autoloop hidden type="audio/mpeg"></source>
    </audio>
    <h2>You encountered a <span id='monster'></span></h2>
<div class="enemy"></div>
<div class="char"><img id='crabdad'src="images/sidekick.png" alt="crabdad"><img id='player' src="<?php  echo 'images/' . strtolower($_SESSION['gender']) . 'back.png'; ?>"/></div>

<button id='inspect'>Inspect</button>
<button id='attack'>Attack</button>
<button id='flee'>Flee</button>
<p id='playerHpContainer'>HP: <span id="playerHp"></span></p>
<p id='monsterHpContainer'>HP: <span id='monsterHp'></span></p>
<?php $_SESSION['beginning'] = false; ?>
<script>


function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)", "i"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

var character = {
  hp: getParameterByName('hp'),
  maxHp: 20,
  int: 5,
  strength: 9,
  lvl: 1,
  name: getParameterByName('name'),
  gender: getParameterByName('gender'),
  lat: getParameterByName('lat'),
  lng: getParameterByName('lng'),
  monstersKilled: getParameterByName('monstersKilled')
};
$('#playerHp').html(character.hp+'/'+character.maxHp);
$('h2').hide();
    var monsters = ['crawlhand','cygopher','eyetapus'];
    var num = Math.floor(Math.random() * monsters.length);
    var monsterHP =  getRandomInt(15,25);
    var monster = {hp: monsterHP, maxhp: monsterHP, strength: 5}
    $("<img id='monster' src='images/"+monsters[num]+".png'/>").appendTo('.enemy');
    $('#monster').html(monsters[num]);
    $('h2').fadeIn(1000);
    if (!character.hp) { character.hp = character.maxHp; }
    $("#playerHp").html(character.hp+'/'+character.maxHp);
    $("#monsterHp").html(monster.hp+'/'+monster.maxhp);
    
    $('#attack').click(function() {
        $('h2').html('');
            var damage = (getRandomInt(character.strength-2, character.strength+2));
            $('h2').html('You did ' + damage + ' damage to the ' + monsters[num]);
            monster.hp-=damage;
            if (monster.hp <= 0) {
                monster.hp = 0;
            }
            $("#monsterHp").html(monster.hp+'/'+monster.maxhp);
           if (monster.hp <= 0) {
               //monster killed
                   $('h2').html(character.name + ' has killed the ' + monsters[num]+'!');
               setTimeout(function() {
                   character.monstersKilled++;
                   window.location.href = 'https://mapproject-gabekuslansky.c9users.io/variables.php?hp='+character.hp+'&lng='+character.lng+'&lat='+character.lat+'&monstersKilled='+character.monstersKilled+'&gender='+character.gender+'&name='+character.name+'&close=true&beginning=false';
               }, 2500);
           } else { 
               var damage = (getRandomInt(monster.strength-2,monster.strength+2));
               character.hp-=damage;
               if (character.hp <= 0) {
                   character.hp = 0;
               }
                 $('#playerHp').html(character.hp + '/' + character.maxHp);
                 if (character.hp <= 0) {
                     //you died
                     $('h2').html('You have died to the ' + monsters[num] +'. Game Over!');
                     setTimeout(function() {
                   window.location.href = 'https://mapproject-gabekuslansky.c9users.io/dialogue.php';
               }, 2500);
                 } else {
            
                $('h2').html($('h2').html()+',<br>'+monsters[num] + ' has done ' + damage + ' damage to ' + character.name);
           } }
  });
</script>
</body>
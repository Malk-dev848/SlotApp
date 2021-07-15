<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title><h1>Slot Machine</h1></title>
<style>
@import url('https://fonts.googleapis.com/css?family=Roboto');
@import url('https://fonts.googleapis.com/css?family=Roboto+Mono');
a{
	color: #283593;
	text-decoration: none;
}
h3{
	margin-top: 12px;
}
*{
	margin:0px;
}
body{
	background-color: #424242;
	font-family: 'Roboto', sans-serif;
}
main{
	border-radius: 5px;
	background-color: #EF5350;
	margin-top: 30px;
	padding-top: 20px;
	padding-bottom: 20px;
	padding-left: 15px;
	padding-right: 15px;
	margin-left: calc((100% - 580px) / 2);
	width: 550px;
}
section#status{
	margin-bottom: 25px;
	padding-top: 25px;
	padding-bottom: 25px;
	border-radius: 5px;
	text-align: center;
	background-color: #37474F;
	color: #FFFFFF;
	font-size: 25px;
	font-family: 'Roboto Mono', monospace;
}
section#Slots{
	border-radius: 15px;
	background-color: #FAFAFA;
}
section#Gira{
	margin-top: 25px;
	padding-top: 25px;
	padding-bottom: 25px;
	border-radius: 5px;
	text-align: center;
	background-color: #AB47BC;
	color: #FFFFFF;
	font-size: 25px;
}
section#Gira:hover{
	background-color: #BA68C8;
}
section#options{
	margin-top: 20px;
	padding-top: 5px;
	border-radius: 5px;
	background-color: #C62828;
	color: #FFFFFF;
}
.option{
	padding-left: 5px;
}
section#info{
	background-color: #616161;
	padding-left: 12px;
	padding-bottom: 12px;
	border-radius: 5px;
	overflow: hidden;
	animation-duration: 1s;
	color: #BDBDBD;
	margin-top: 50px;
	margin-left: 30%;
	margin-right: 30%;
	display: none;
}
#slot1, #slot2, #slot3{
	display: inline-block;
	margin-top: 5px;
	margin-left: 15px;
	margin-right: 15px;
	background-size: 150px;
	width: 150px;
	height: 150px;
}
.a1{
	background-image: url("res/tiles/seven.png");
}
.a2{
	background-image: url("res/tiles/cherries.png");
}
.a3{
	background-image: url("res/tiles/club.png");
}
.a4{
	background-image: url("res/tiles/diamond.png");
}
.a5{
	background-image: url("res/tiles/heart.png");
}
.a6{
	background-image: url("res/tiles/spade.png");
}
.a7{
	background-image: url("res/tiles/joker.png");
}
</style>
</head>
<body>

<div class="header">
	<h2>Home Page</h2>
</div>
	Welcome to my project page	
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>
<body onload="toggleAudio()">
<main>
	<section id="status">WELCOME!</section>
	<section id="Slots">
		<div id="slot1" class="a1"></div>
		<div id="slot2" class="a1"></div>
		<div id="slot3" class="a1"></div>
	</section>
	<section onclick="doSlot()" id="Gira">TAKE A SPIN!</section>
	<section id="options">
		<img src="res/icons/audioOn.png" id="audio" class="option" onclick="toggleAudio()" />
	</section>
</main>
<section id="info">
	<h3>Come si Gioca?</h3>
	<p>Tenta la tua fortuna premendo il bottone! Il Jolly vale l'elemento mancante per vincere. Tre elementi uguali e vinici! Ma attenzione, non prendere tre Jolly o perderai!</p>
	<h3>Licenza</h3>
	<p><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licenza Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" /></a><br />Quest'opera è distribuita con Licenza <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Attribuzione - Non commerciale - Condividi allo stesso modo 4.0 Internazionale</a>.</p>
</section>

<script>
var doing = false;
var spin = [new Audio("res/sounds/spin.mp3"),new Audio("res/sounds/spin.mp3"),new Audio("res/sounds/spin.mp3"),new Audio("res/sounds/spin.mp3"),new Audio("res/sounds/spin.mp3"),new Audio("res/sounds/spin.mp3"),new Audio("res/sounds/spin.mp3")];
var coin = [new Audio("res/sounds/coin.mp3"),new Audio("res/sounds/coin.mp3"),new Audio("res/sounds/coin.mp3")]
var win = new Audio("res/sounds/win.mp3");
var lose = new Audio("res/sounds/lose.mp3");
var audio = false;
let status = document.getElementById("status")
var info = true;

function doSlot(){
	if (doing){return null;}
	doing = true;
	var numChanges = randomInt(1,4)*7
	var numeberSlot1 = numChanges+randomInt(1,7)
	var numeberSlot2 = numChanges+2*7+randomInt(1,7)
	var numeberSlot3 = numChanges+4*7+randomInt(1,7)

	var i1 = 0;
	var i2 = 0;
	var i3 = 0;
	var sound = 0
	status.innerHTML = "SPINNING"
	slot1 = setInterval(spin1, 50);
	slot2 = setInterval(spin2, 50);
	slot3 = setInterval(spin3, 50);
	function spin1(){
		i1++;
		if (i1>=numeberSlot1){
			coin[0].play()
			clearInterval(slot1);
			return null;
		}
		slotTile = document.getElementById("slot1");
		if (slotTile.className=="a7"){
			slotTile.className = "a0";
		}
		slotTile.className = "a"+(parseInt(slotTile.className.substring(1))+1)
	}
	function spin2(){
		i2++;
		if (i2>=numeberSlot2){
			coin[1].play()
			clearInterval(slot2);
			return null;
		}
		slotTile = document.getElementById("slot2");
		if (slotTile.className=="a7"){
			slotTile.className = "a0";
		}
		slotTile.className = "a"+(parseInt(slotTile.className.substring(1))+1)
	}
	function spin3(){
		i3++;
		if (i3>=numeberSlot3){
			coin[2].play()
			clearInterval(slot3);
			testWin();
			return null;
		}
		slotTile = document.getElementById("slot3");
		if (slotTile.className=="a7"){
			slotTile.className = "a0";
		}
		sound++;
		if (sound==spin.length){
			sound=0;
		}
		spin[sound].play();
		slotTile.className = "a"+(parseInt(slotTile.className.substring(1))+1)
	}
}

function testWin(){
	var slot1 = document.getElementById("slot1").className
	var slot2 = document.getElementById("slot2").className
	var slot3 = document.getElementById("slot3").className

	if (((slot1 == slot2 && slot2 == slot3) ||
		(slot1 == slot2 && slot3 == "a7") ||
		(slot1 == slot3 && slot2 == "a7") ||
		(slot2 == slot3 && slot1 == "a7") ||
		(slot1 == slot2 && slot1 == "a7") ||
		(slot1 == slot3 && slot1 == "a7") ||
		(slot2 == slot3 && slot2 == "a7") ) && !(slot1 == slot2 && slot2 == slot3 && slot1=="a7")){
		status.innerHTML = "YOU WIN!";
		win.play();
	}else{
		status.innerHTML = "YOU LOSE!"
		lose.play();
	}
	doing = false;
}

function toggleAudio(){
	if (!audio){
		audio = !audio;
		for (var x of spin){
			x.volume = 0.5;
		}
		for (var x of coin){
			x.volume = 0.5;
		}
		win.volume = 1.0;
		lose.volume = 1.0;
	}else{
		audio = !audio;
		for (var x of spin){
			x.volume = 0;
		}
		for (var x of coin){
			x.volume = 0;
		}
		win.volume = 0;
		lose.volume = 0;
	}
	document.getElementById("audio").src = "res/icons/audio"+(audio?"On":"Off")+".png";
}

function randomInt(min, max){
	return Math.floor((Math.random() * (max-min+1)) + min);
}
</script>

<button></button>
</body>
</body>
</html>
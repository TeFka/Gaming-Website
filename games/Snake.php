<!DOCTYPE html>
<html>
    <head>
	<link rel = 'stylesheet' href = '../siteCSS.css' />
   <link rel = 'stylesheet' href = './Snake.css' />
	<title>Snakec</title>
</head>
    <body>
	<?php include('../parts/header.php'); ?>
	<div class="gameArea">
    <div id="menu">
    <h1>Snakec</h1>
	<svg width="345" height="270">
        <circle cx="50%" cy="50%" r="120"
        fill="green"></circle> 
         <circle cx="45%" cy="40%" r="15"
         fill="blue"></circle> 
         <circle cx="55%" cy="40%" r="15"
         fill="blue"></circle>
        </svg>
       <button onClick="pAgain(menu, modr)">Play</button>
        <button onClick="gMode()">Mode</button>
        <button>***</button>
    </div>
    <div id="modr">
   <div class="close" onClick="closeP(modr)">
        
    </div>
       <h1>Modes</h1>
       <button id="normM"
       onClick="chMode(normM)">
       Normal</button> 
       <button id="crazM"
       onClick="chMode(crazM)">
       Crazy</button>
       <button id="endM"
       onClick="chMode(endM)">
       Endless</button>
    </div>
    <div id="losr">
        <h1>You lose</h1>
        <button onClick="pAgain(losr, 0)">
        Play again</button>
        <button onClick="showM('losr')">
        Menu</button>
    </div>
    <div id="winr">
        <h1>You win</h1>
        <button onClick="pAgain(winr, 0)">
        Play again</button>
        <button onClick="showM('winr')">
        Menu</button>
    </div>
    <canvas id="canv" width="1000px" height="600px"></canvas>
		</div>
		<?php include('../parts/bottomFotter.php');?>
        <script>
    var canv = document.getElementById("canv");
var scor = document.getElementById("scor");
var liv = document.getElementById("liv");
var inf = document.getElementById("inf");
var inf1 = document.getElementById("inf1");
var inf2 = document.getElementById("inf2");
var losr = document.getElementById("losr");
var winr = document.getElementById("winr");
var modr = document.getElementById("modr");
var menu = document.getElementById("menu");

var ctx = canv.getContext("2d");

var gridWMax = 50;
var gridHMax = 40;
var gridInfo = new Array(gridWMax);

var snakeX = Math.floor(gridWMax/2);
var snakeY = Math.floor(gridHMax/2);
var partW = canv.width / gridWMax;
var partH = canv.height / gridHMax;
var snakeLength = 1;
var trail = [];
var lives = 5;
var dx = 0;
var dy = 0;
var defaultSp = 10;
var sp = defaultSp;
var fruitX = 0;
var fruitY = 0;
var fruitS = partW/2;
var fruitG = 1;
var exit = false;
var exitX = 0;
var exitY = 0;
var exitDefined = false;
var lvl = 1;
var lvlUp = 7;
var play = false;
var endlessM = false;
var crazyM = false;

for (var i = 0; i < gridWMax; i++) {
  gridInfo[i] = new Array(gridHMax);
}

function sleep(ms) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > ms) {
            break;
        }
    }
}

function closeP(page) {
    page.style.display = "none";
}

function showM(word) {
    document.getElementById(word).style.display = "none";
    menu.style.display = "block";
    canv.style.display = "none";
}

function gMode() {
    modr.style.display = "block";
}

function chMode(mod) {
    var norm = document.getElementById("normM");
    var end = document.getElementById("endM");
    var craz = document.getElementById("crazM");
    switch (mod) {
        case normM:
            norm.style.color = "#FF0000";
            norm.style.borderColor = "#FF0000";
            end.style.color = "#0000FF";
            end.style.borderColor = "#0000FF";
            craz.style.color = "#0000FF";
            craz.style.borderColor = "#0000FF";
            lvlUp = 1;
            crazyM = false;
            sp = 5;
            fruitG = 1;
            endlessM = false
            break;
        case endM:
            end.style.color = "#FF0000";
            end.style.borderColor = "#FF0000";
            norm.style.color = "#0000FF";
            norm.style.borderColor = "#0000FF";
            craz.style.color = "#0000FF";
            craz.style.borderColor = "#0000FF";
            fruitG = 5;
            endlessM = true;
            crazyM = false;
            lvlUp = 1;
            sp = 5;
            break;
        case crazM:
            craz.style.color = "#FF0000";
            craz.style.borderColor = "#FF0000";
            norm.style.color = "#0000FF";
            norm.style.borderColor = "#0000FF";
            end.style.colo = "#0000FF";
            end.style.borderColor = "#0000FF";
            sp = 9;
            lvlUp = 2;
            crazyM = true;
            endlessM = false
            fruitG = 1;
            break;
    }
}

function setupLevel(levelNr){
	
	switch(levelNr){
		case 1:
			for(var x=0;x<gridWMax;x++){
				for(var y=0;y<gridHMax;y++){
					gridInfo[x][y] = 0;
				}
			}
		break;
		
		case 2:
		
			for(var x=0;x<gridWMax;x++){
				for(var y=0;y<gridHMax;y++){
					if(x==0 || y==0 || x == gridWMax-1 || y == gridHMax-1){
						gridInfo[x][y] = 1;
					}
					else{
						gridInfo[x][y] = 0;
					}
				}
			}		
			
		break;
		
		case 3:
		
			for(var x=0;x<gridWMax;x++){
				for(var y=0;y<gridHMax;y++){
					if((x==Math.floor(gridWMax/3)&& y<Math.floor(gridHMax/3*2))||(x==Math.floor(gridWMax/3*2)&& y>Math.floor(gridHMax/3))){
						gridInfo[x][y] = 1;
					}
					else{
						gridInfo[x][y] = 0;
					}
				}
			}		
			
		break;
		
		case 4:
		
			for(var x=0;x<gridWMax;x++){
				for(var y=0;y<gridHMax;y++){
					if(x==Math.floor(gridWMax/2) || y==Math.floor(gridHMax/2)){
						gridInfo[x][y] = 1;
					}
					else{
						gridInfo[x][y] = 0;
					}
				}
			}		
			
		break;
		
		case 5:
		
			for(var x=0;x<gridWMax;x++){
				for(var y=0;y<gridHMax;y++){
					if(Math.random()<0.3){
						gridInfo[x][y] = 1;
					}
					else{
						gridInfo[x][y] = 0;
					}
				}
			}		
			
		break;
	}
}

function drawGrid(){
	
	for(var x=0;x<gridWMax;x++){
				for(var y=0;y<gridWMax;y++){
					ctx.beginPath();
					ctx.rect(x*partW, y*partH, partW, partH);
					ctx.strokeStyle = "#DDDDDD";
					ctx.stroke();
					ctx.closePath();
				}
	}
}
function drawSnake() {

    trail.push({
         x: snakeX,
         y: snakeY
    });

    for (i = 0; i < trail.length; i++) {
        ctx.beginPath();
        ctx.rect(trail[i].x*partW, trail[i].y*partH, partW, partH);
			if (snakeX == trail[i].x &&
            snakeY == trail[i].y) {
				switch (lvl) {
					case 1:
						ctx.fillStyle = "#00AAFF";
						ctx.strokeStyle = "#0000FF";
						break;
					case 2:
						ctx.fillStyle = "#000000";
						ctx.strokeStyle = "#77FF00";
						break;
					case 3:
						ctx.fillStyle = "#00FF00";
						ctx.strokeStyle = "#00FFFF";
						break;
					case 4:
						ctx.fillStyle = "#FF4400";
						ctx.strokeStyle = "#FF0000";
						break;
					default:
						ctx.fillStyle = "#000000";
						ctx.strokeStyle = "#0000FF";
				}
			} 
			else {
				switch (lvl) {
					case 1:
						ctx.fillStyle = "#AA00FF";
						ctx.strokeStyle = "#00FF87";
						break;
					case 2:
						ctx.fillStyle = "#FFFF00";
						ctx.strokeStyle = "#44FF00";
						break;
					case 3:
						ctx.fillStyle = "#00FF00";
						ctx.strokeStyle = "#00FFFF";
						break;
					case 4:
						ctx.fillStyle = "#FF9900";
						ctx.strokeStyle = "#FF0000";
						break;
					default:
						ctx.fillStyle = "#000000";
						ctx.strokeStyle = "#0000FF";
				}
			}
        ctx.fill();
        ctx.stroke();
        ctx.closePath();

        if (snakeX == trail[i].x && snakeY == trail[i].y){
            if (i != trail.length - 1 &&
                i != trail.length - 2 &&
                i != trail.length - 3) {
                for (i = 1; i < snakeLength; i++) {
                    trail.shift();
                }
                snakeLength = 1;
            }
        }


    }
    if(trail.length > snakeLength){
        trail.shift();
    }
}

function gotHit() {
    snakeLength = 1;
    for (i = 1; i <= snakeLength; i++) {
        trail.shift();
    }
    dx = 0;
    dy = 0;
    if (lvl == 3) {
        snakeX = Math.floor(gridWMax/ 2);
        snakeY = Math.floor(gridHMax - 2)
    } else if (lvl == 5) {
        snakeY = Math.floor(gridHMax-2);
        snakeX = Math.floor(gridWMax/ 2);
    } else {
        snakeX = Math.floor(gridWMax/3*2);
        snakeY = Math.floor(gridHMax-2);
    }
    lives = lives - 1;
}

function drawFruit() {
    ctx.beginPath();
    ctx.arc(fruitX*partW+partW/2, fruitY*partH+partH/2,
        fruitS/2, Math.PI * 2, false);
    ctx.fillStyle = "purple";
    ctx.fill();
    ctx.closePath();
}

function drawExit() {
    if (snakeLength - 1 >= lvlUp * lvl) {
        if(exitDefined == false){
            exitX = Math.floor(Math.random() * gridWMax);
            exitY = Math.floor(Math.random() * gridHMax);
            while(gridInfo[exitX][exitY] == 1){
                exitX = Math.floor(Math.random() * gridWMax);
                exitY = Math.floor(Math.random() * gridHMax);
            }
            exitDefined = true;
        }
        ctx.beginPath();
        ctx.rect(exitX*partW, exitY*partH,
            partW, partH);
        ctx.fillStyle = "#00FFFF";
        ctx.fill();
        ctx.closePath();
        ctx.beginPath();
        ctx.rect(exitX*partW + partW * 0.25, exitY*partH + partH * 0.25,
            partW*0.5, partH*0.5);
        ctx.fillStyle = "#000000";
        ctx.fill();
        ctx.closePath();
        if (snakeX == exitX && snakeY == exitY){
                /*sleep(1000);*/
                for (i = 1; i < snakeLength; i++) {
                    trail.shift();
                }
                dx = 0;
                dy = 0;
                snakeLength = 1;
                lvl++;
				setupLevel(lvl);
                sp = defaultSp + 2*lvl;
                if (lvl == 3) {
					snakeX = Math.floor(gridWMax/ 2);
					snakeY = Math.floor(gridHMax - 2)
				} 
				else if (lvl == 5) {
					snakeY = Math.floor(gridHMax-2);
					snakeX = Math.floor(gridWMax/ 2);
				} 
				else {
					snakeX = Math.floor(gridWMax/3*2);
					snakeY = Math.floor(gridHMax-2);
                }
        }
    }
    else{
        exitDefined = false;
    }
}


function wallCollisionDetection(){
	if(gridInfo[snakeX][snakeY] == 1){
		gotHit();
	}
	
}

function drawWall() {
    ctx.beginPath();
		
	for(var x=0;x<gridWMax;x++){
			for(var y=0;y<gridHMax;y++){
				if(gridInfo[x][y] == 1){
					ctx.rect(x*partW, y*partH, partW, partH);
				}
			}
	}
    ctx.fillStyle = "#0000FF";
    ctx.fill();
    ctx.closePath();
}

function fruitPosition() {
	if (play == true) {
		fruitX = Math.floor(Math.random()*gridWMax);
		fruitY = Math.floor(Math.random()*gridHMax);
		while(gridInfo[fruitX][fruitY] == 1){
			fruitX = Math.floor(Math.random()*gridWMax);
			fruitY = Math.floor(Math.random()*gridHMax);
		}
	}
}

document.addEventListener('keyup', function(event) {
    var x = event.keyCode;
    if (x == 87 || x == 38) {
        if (dy != 1) {
            dy = -1;
            dx = 0;
        }
    }
    if (x == 83 || x == 40) {
        if (dy != -1) {
            dy = 1;
            dx = 0;
        }
    }
    if (x == 65 || x == 37) {
        if (dx != 1) {
            dx = -1;
            dy = 0;
        }
    }
    if (x == 68 || x == 39) {
        if (dx != -1) {
            dx = 1;
            dy = 0;
        }
    }
})

function pAgain(thing, thang) {
	
    if (thang != 0) {
        thang.style.display = "none";
    }
    thing.style.display = "none";
    play = true;
    canv.style.display = "block";
    //con.style.display = "block";
	lvl = 1;
	setupLevel(lvl);
	
}

function pStop() {
    snakeLength = 1;
	for (var i = 1; i <= snakeLength; i++) {
        trail.shift();
    }
    dx = 0;
    dy = 0;
    if (crazyM == true) {
        sp = defaultSp+3;
    } else {
        sp = defaultSp;
    }
    play = false;
	lives = 5;
    snakeX = Math.floor(gridWMax/2);
    snakeY = Math.floor(gridHMax/2);
	lvl = 1;
	setupLevel(lvl);
}

function draw() {
    if (play == true) {

        snakeX += dx;
        snakeY += dy;
        /*out of bonds*/
        if (snakeX >= gridWMax) {
            snakeX = 0;
        }
        if (snakeX < 0) {
            snakeX = gridWMax-1;
        }
        if (snakeY >= gridHMax) {
            snakeY = 0;
        }
        if (snakeY < 0) {
            snakeY = gridHMax-1;
        }

        ctx.clearRect(0, 0, canv.width, canv.height);
		drawGrid();
        drawSnake();
        drawFruit();
        if (endlessM == false) {
            drawWall();
            drawExit();
        }
		
		wallCollisionDetection();

        
        if (snakeX == fruitX && snakeY == fruitY) {
                snakeLength = snakeLength + fruitG;
                fruitPosition();
        }
		
        if (lives == 0) {
            pStop();
            losr.style.display = "block";
        }
        if (lvl == 6) {
            pStop();
            winr.style.display = "block";
        }
        liv.innerHTML = lives;
        scor.innerHTML = snakeLength - 1;
    }
}
setInterval(draw, (1000/sp));
setInterval(fruitPosition, 5000);
                    </script>
    </body>
</html>  
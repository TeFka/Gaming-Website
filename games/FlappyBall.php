<!DOCTYPE html>
<html>
   <head>
	<link rel = 'stylesheet' href = '../siteCSS.css' />
   <link rel = 'stylesheet' href = './FlappyBall.css' />
	<title>FlappyBall</title>
</head>
    <body>
	<?php include('../parts/header.php'); ?>
	<div class="gameArea">
    <div id="manu">
    <h1>Flappy ball</h1>
    <button onClick="pAgain(manu)">
    Play</button>
    <button>Difficulty</button>
    <button>***</button>
    </div>
    <div id="losx">
    <h1>You lost</h1>
    <h2>Score: <span id="scor"></span></h2>
    <button onClick="pAgain(losx)">Play again</button>
    <button onClick="goMenu(losx)">Menu</button>
    </div>
    <canvas id="canv" width="1000" height="600"></canvas>
	</div>
	<?php include('../parts/bottomFotter.php');?>
    <script>
    function id(di){
        return document.getElementById(di);
    }
    var canv=id("canv");
    var losx=id("losx");
    var manu=id("manu");
    var scor=id("scor");
    var ctx=canv.getContext("2d");
    
    var w=canv.width;
    var h=canv.height;
    var ballX=50;
    var ballY=h/2;
    var ballS=15;
    
    var holeS=120;
    var pillars=[];
    var pillarW=50;
    var minPH=20;
    
    var speedX=2;
    var speedY=0;
    var gravity=0;
    
    var score = 0; 
    
    var hit = false;
    var play = false;
    
    for(i=1;i<=5;i++){
        var x=500+200*i;
        var y1=0;
        var y2=
 Math.random()*(h-2*minPH-holeS)+minPH+holeS;
        var pH1=y2-holeS;
        var pH2=h-y2
     pillars.push({x:x,y1:y1,y2:y2,
                   h1:pH1,h2:pH2});
    }
    
    function goMenu(windv){
        windv.style.display="none";
        manu.style.display="block";
    }
    
    function pAgain(windv){
        for(i=0;i<pillars.length;i++){
        pillars[i].x=500+i*200  
        }
        ballY=h/2;
        speedX=5;
        speedY=0;
        gravity=0;
        score=0;
		canv.style.display = "block";
        windv.style.display="none";
        hit=false;
        play=true;
    }
    
    function drawBall(){
        ctx.beginPath();
        ctx.arc(ballX,ballY, 
         ballS,Math.PI*2,false)
        ctx.fillStyle="#6600FF";
        ctx.strokeStyle="#0000FF";
        ctx.fill();
        ctx.stroke();
        ctx.closePath();
        if(ballY-ballS<0){
            ballY=ballS;
            speedX=0;
            gravity=4;
            hit=true;
        }
    }
    function drawPillars(){
    for(i=0;i<pillars.length;i++){
        ctx.beginPath();
        ctx.rect(pillars[i].x,pillars[i].y1,
        pillarW,pillars[i].h1);
        ctx.rect(pillars[i].x,pillars[i].y2,
        pillarW,pillars[i].h2);
        ctx.fillStyle="#00FF00";
        ctx.strokeStyle="#000000";
        ctx.fill();
        ctx.stroke();
        ctx.closePath();
        
        pillars[i].x-=speedX;
        
        if(pillars[i].x+2*pillarW<0){
            pillars[i].x=pillars[i].x+1000;
            pillars[i].y2=
 Math.random()*(h-2*minPH-holeS)+minPH+holeS;
           pillars[i].h1=pillars[i].y2-holeS;
           pillars[i].h2=h-pillars[i].y2;
        }
        
        if(ballX+ballS>pillars[i].x &&
           ballX<pillars[i].x+pillarW){
            if(ballY-ballS<pillars[i].h1 ||
            ballY+ballS>pillars[i].y2){
                speedX=0;
                gravity=4;
                hit=true;
            }
           }
 if(ballX>=pillars[i].x+pillarW/2-speedX/2 &&
    ballX<pillars[i].x+pillarW/2+speedX/2){
             score+=1;
         }
       }
    }
    
    function drawScore(){
        ctx.font="20px Arial";
        ctx.fillStyle="#F00000";
        ctx.fillText("Score: "+score,10,20);
    }
    
    function addForce(){
    if(gravity==0){
        gravity=2;
    }
    if(hit==false){
        speedY=15;
        }
    }
	
	document.addEventListener('keyup', function (event) {
			var x = event.keyCode;
			if (x == 32) {
				addForce();
			}
	});
    
    function draw(){
    if(play==true){
    ctx.clearRect(0,0,w,h);
      speedY-=gravity;
      ballY-=speedY;
      
      if(ballY+ballS>=h){
          speedX=0;
          ballY=h;
          play=false;
          scor.innerHTML=score;
          losx.style.display="block";
      }
      
      drawBall();
      drawPillars();
      drawScore();
      }
    }
    setInterval(draw,50);
    </script>  
    </body>
</html>
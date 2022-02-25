<!DOCTYPE html>
<html>
    <head>
	<link rel = 'stylesheet' href = '../siteCSS.css' />
    <link rel = 'stylesheet' href = './ShotBall.css' />
	<title>ShotBall</title>
	</head>
    <body>
	<?php include('../parts/header.php'); ?>
	<div class="gameArea">
    <div id="menu">
    <h1>Shotex</h1>
    <svg width="340" height="350"></svg>
    <button onClick="pAgain(menu)">Play</button>
    <button onClick="showP(modes)">
    Mode</button>
    <button onClick="showP('diff')">
    Difficulty</button>
    </div>
    <div id="modes">
        <div class="close"
        onClick="closeP(modes)"></div>
        <h2>Modes</h2>
        <button onclick="chMode(1)">
        1 Player</button>
        <button onClick="chMode(2)">
        2 Players</button>
    </div>
    <div id="diff">
        <div class="close"
         onClick="closeP(difx)"></div>
        <h2>Difficulty</h2>
        <button id="ez" onClick="chDiff(1)">
        Easy</button>
        <button id="nm" onClick="chDiff(2)">
        Normal</button>
        <button id="hr" onClick="chDiff(3)">
        Hard</button>
        <button id="ins" onClick="chDiff(4)">
        Insane</button>
    </div>
    <div id="winx1">
        <h1>Blue Wins</h1>
        <button onClick="pAgain(winx1)">
        Play Again</button>
        <button onClick="showM(winx1)">
        Menu</button>
    </div>
    <div id="winx2">
        <h1>Red Wins</h1>
        <button onClick="pAgain(winx2)">
        Play Again</button>
        <button onClick="showM(winx2)">
        Menu</button>
    </div>
     <canvas id="boom" width="1000" height="600"
     ></canvas>
     </div>
	 <?php include('../parts/bottomFotter.php');?>
     <script>
  var canv = document.getElementById("boom");
 var con1=document.getElementById("contrl1");
 var con2=document.getElementById("contrl2");
 var menuS=document.getElementById("menu");
 var winx1=document.getElementById("winx1");
 var winx2=document.getElementById("winx2");
 var modes=document.getElementById("modes");
 var difx=document.getElementById("diff");
      var ctx = canv.getContext("2d");
      
      var W=canv.width;
      var H=canv.height;
      
      var shipH=10;
      var shipW=30;
      
      var move = 10;
      
      var shots1=[];
      var shots2=[];
      var shotS=shipW/8;
      var shotSp = canv.width/20;
      var shotn1 = false;
      var shotn2 = false;
         
      var ship1X = canv.width/2-shipW/2;
      var ship1Y = canv.height-shipH;
      
      var ship2X = canv.width/2-shipW/2;
      var ship2Y = 0;
      
      var shipSp = canv.width/50;
      
      var ship1Sp = 0;
      var ship2Sp = 0;
      
      var ship1hp = 5;
      var ship2hp = 5;
      
      var ball1X = canv.width/2;;
      var ball1Y = canv.height/4*3;
      var ball2X = canv.width/2;
      var ball2Y = canv.height/4;;
      var ballS = 7;
      var ballSp1X = 4;
      var ballSp1Y = 4;
      var ballSp2X = 4;
      var ballSp2Y = 4
      
      var dmgMult1 = 0;
      var dmgMult2 = 0;
    
      var wallW = 5;
      var bWallL = 50;
      var bWall1X=Math.random()*(W-bWallL);
      var bWall1Y=H/4*3;
      var bWall2X=Math.random()*(W-bWallL);
      var bWall2Y=H/4;
      
      var oneP = true;
      var twoP = false;
      
      var diff = 0;
      
      var play = false;
      
      function sleep(ms){
         var begin = new Date().getTime();
         for(i=0;i<1e7;i++){
           if(new Date().getTime()-begin>ms){
              break; 
           }
         }
      }
      
      function showM(page){
		  menuS.style.display="block";
          page.style.display="none";
          canv.style.display="none";
          con1.style.display="none";
          con2.style.display="none";   
      }
      
      function showP(page){
          document.getElementById(page).style.display="block";
      }
      
      function closeP(page){
          page.style.display="none";
      }
      
      function chMode(but){
         switch(but){
             case 1:
             oneP=true;
             twoP=false;
             break;
             case 2:
             oneP=false;
             twoP=true;
         } 
      }
      
      function chDiff(num){
    var ez=document.getElementById("ez");
    var nm=document.getElementById("nm");
    var hr=document.getElementById("hr");
    var ins=document.getElementById("ins");
    var chosen=ez;
    var digs=[ez,nm,hr,ins];
    switch(num){
        case 1: chosen=ez; break;
        case 2: chosen=nm; break;
        case 3: chosen=hr; break;
        case 4: chosen=ins; break;
    }
    for(i=0;i<4;i++){
        if(digs[i]==chosen){
            digs[i].style.color="#FF0000";
      digs[i].style.borderColor="#FF0000";
        }
        else{
            digs[i].style.color="#00FF00";
      digs[i].style.borderColor="#00FF00";
        }
    }
          diff = num;
      }
      
      
      function pAgain(aWind){
          play=true;
		  aWind.style.display="none";
		  menuS.style.display="none";
          canv.style.display="block";
          ship1hp=5;
          ship2hp=5;
          ship1Sp=0;
          ship2Sp=0;
          ship1X=canv.width/2-shipW/2;
          ship2X=canv.width/2-shipW/2;
          ball1X=canv.width/2;
          ball1Y=canv.height/4*3;
          ball2X=canv.width/2;
          ball2Y=canv.height/4;
          ballSp1X=Math.random()*-6;
          ballSp1Y=4;
          ballSp2X=Math.random()*-6;
          ballSp2Y=4;
      }
	  
      function drawShip1(){
         ctx.beginPath();
         ctx.rect(ship1X-shipW/3,
                  canv.height-shipH/5,
                  shipW/3*5, shipH/5);
         ctx.rect(ship1X,ship1Y,shipW,shipH);
         ctx.rect(ship1X+shipW/4,
         ship1Y-shipH,
         shipW/2, shipH);
         ctx.rect(ship1X+shipW/8*3,
          ship1Y-2*shipH,
          shipW/4, shipH);
         ctx.fillStyle='#0000FF';
         ctx.strokeStyle='#00FF00';
         ctx.fill();
         ctx.stroke();
         ctx.closePath();
         
         if(ship1X<=0 && ship1Sp<0 || 
      ship1X+shipW>=canv.width && ship1Sp>0){
            ship1Sp=0; 
         }
         ship1X+=ship1Sp;
      }
      
      function drawShip2(){
          ctx.beginPath();
          ctx.rect(ship2X-shipW/3,0,
                   shipW/3*5, shipH/5);
          ctx.rect(ship2X, ship2Y,
           shipW,shipH);
          ctx.rect(ship2X+shipW/4,shipH,
           shipW/2, shipH);
          ctx.rect(ship2X+shipW/8*3, 2*shipH,
         shipW/4, shipH);
          ctx.fillStyle="#FF0066";
          ctx.strokeStyle="#00FF00";
          ctx.fill();
          ctx.stroke();
          ctx.closePath();
          
          if(ship2X<=0 && ship2Sp<0 ||
      ship2X+shipW>=canv.width && ship2Sp>0){
          ship2Sp=0;
      }
      ship2X+=ship2Sp
      
      if(oneP==true){
       switch(diff){
           case 1:
           if(ball2Y<canv.height/4){
            if(ball2X<ship2X+shipW/2){
                ship2Sp=-shipSp;
            }
            else if(ball2X>ship2X+shipW/2){
                ship2Sp=shipSp
            }
            else{
                ship2Sp=0;
            }
           }
           else{
               ship2Sp=0;
           }
           break;
           case 2:
            if(ball2Y<canv.height/10*4){
              if(ball2X<ship2X+shipW/2){
                ship2Sp=-shipSp;
              }
              else if(ball2X>ship2X+shipW/2){
                  ship2Sp=shipSp;
              }
              else{
                  ship2Sp=0;
              }
            }
            else{
                ship2Sp=0;
            }
            if(ship2X+shipW/2>= ship1X &&
             ship2X+shipW/2<=ship1X+shipW){
                shoot2();
            }
           break;
           case 3:
            if(ball2X<ship2X+shipW/2){
            ship2Sp=-shipSp*1.5;
            }
            else if(ball2X>ship2X+shipW/2){
            ship2Sp=shipSp*1.5;
            }
            else{
            ship2Sp=0;
            }
            if(ship2X+shipW/2>=ship1X &&
            ship2X+shipW/2<=ship1X+shipW){
                shoot2();
            }
           break;
           case 4:
           if(ball2X<ship2X+shipW/2){
            ship2Sp=-shipSp*2;
            }
           else if(ball2X>ship2X+shipW/2){
            ship2Sp=shipSp*2   
           }
           else{
               ship2Sp=0;
           }
           if(ship2X+shipW/2>=ship1X &&
           ship2X+shipW/2<=ship1X+shipW){
               shoot2();
               shotn2=false;
           }
            
           break;
       }  
      }
      
      }
      function drawShot(){
         if(shots1.length!=0){
         for(i=0;i<shots1.length;i++){
             ctx.beginPath();
             ctx.arc(shots1[i].x,shots1[i].y,
             shotS,Math.PI*2, false);
             ctx.fillStyle="#0000FF";
             ctx.fill();
             ctx.closePath();
             shots1[i].y-=shotSp;
             if(shots1[i].y+shotS<0){
                 shots1.shift();
             }
            
            if(shots1.length!=0){
             if(shots1[i].x+shotS>=ship2X &&
            shots1[i].x+shotS<=ship2X+shipW||
            shots1[i].x-shotS<=ship2X+shipW&&
             shots1[i].x-shotS>=ship2X){
             if(shots1[i].y+shotS<=2*shipH &&
               shots1[i].y+shotS>0 ||
               shots1[i].y-shotS<=2*shipH &&
               shots1[i].y-shotS>=0){
                   shots1.shift();
                   ship2hp=ship2hp-1;
               }
             }
            }
         }
         }
         if(shots2.length!=0){
            for(i=0;i<shots2.length;i++){
                ctx.beginPath();
             ctx.arc(shots2[i].x,shots2[i].y,
                shotS, Math.PI*2, false);
                ctx.fillStyle="#FF0000";
                ctx.fill();
                ctx.closePath();
                shots2[i].y+=shotSp;
           if(shots2[i].y-shotS>canv.height){
                shots2.shift();
            }
           if(shots2.length!=0){
             if(shots2[i].x+shotS>=ship1X &&
           shots2[i].x+shotS<=ship1X+shipW ||
           shots2[i].x-shotS<=ship1X+shipW &&
           shots2[i].x-shotS>=ship1X){
 if(shots2[i].y+shotS>=canv.height-2*shipH &&
    shots2[i].y+shotS<=canv.height ||
    shots2[i].y-shotS>=canv.height-2*shipH &&
    shots2[i].y-shotS<=canv.height){
        shots2.shift();
        ship1hp=ship1hp-1;
    }
           }  
           }
            }
         }
}
      function drawWall(){
        ctx.beginPath();
        ctx.rect(0, canv.height/2-wallW/2,
        canv.width, wallW);
        ctx.fillStyle="#00FF00";
        ctx.fill();
        ctx.closePath();
        
        ctx.beginPath();
        ctx.rect(bWall1X,bWall1Y,
         bWallL, wallW);
        ctx.rect(bWall2X,bWall2Y,
         bWallL, wallW)
        ctx.fillStyle="#6600FF";
        ctx.fill();
        ctx.closePath();
        
      }
      
      function bWallPos(){
          bWall1X=Math.random()*(W-bWallL);
          bWall2X=Math.random()*(W-bWallL);
      }
      
      function drawBalls(){
        ctx.beginPath();
        ctx.arc(ball1X, ball1Y, ballS,
        Math.PI*2, false);
        ctx.arc(ball2X, ball2Y, ballS,
        Math.PI*2, false);
        ctx.fillStyle="#6600FF";
        ctx.fill();
        ctx.closePath();
        
        ball1X+=ballSp1X;
        ball1Y-=ballSp1Y;
        ball2X+=ballSp2X;
        ball2Y+=ballSp2Y;
        
        var spChange1=Math.random()*5+diff;
        var spChange2=Math.random()*-5-diff;
        /*Ball1*/
        if(ball1X+ballS>=canv.width &&
         ballSp1X>0 ||
        ball1X-ballS<=0 && ballSp1X<0){
         if(ballSp1X<0){
          ballSp1X=spChange1;
          }
         else{
          ballSp1X=-spChange1;
         }
        }
     if(ball1Y-ballS<=canv.height/2+wallW/2||
     ball1Y+ballS>=canv.height &&
      ball1X>=ship1X-shipW/3 && 
      ball1X<=ship1X+shipW/3*4){
          ballSp1Y=-ballSp1Y;
      }
      if(ball1Y>=canv.height){
          ballSp1Y=-ballSp1Y;
          ball1X=canv.width/2;
          ball1Y=canv.height-7*shipH;
          ship1hp=ship1hp-2;
          
      }
      if(ball1X+ballS>=bWall1X &&
         ball1X+ballS<bWall1X+bWallL ||
         ball1X-ballS<=bWall1X+bWallL &&
         ball1X-ballS>bWall1X){
         
      if(ball1Y+ballS>=bWall1Y &&  ball1Y+ballS<bWall1Y+wallW ||
      ball1Y-ballS<=bWall1Y+wallW && 
      ball1Y-ballS>bWall1Y+wallW-ballSp1Y){
             ballSp1Y=-ballSp1Y;
         }
      else if(ball1Y>bWall1Y &&
           ball1Y<bWall1Y+wallW){
          if(ballSp1X<0){
          ballSp1X=spChange1;
          }
          else{
           ballSp1X=-spChange1;
          }
      }
         }
      /*ball2*/
      if(ball2X+ballS>=canv.width &&
      ballSp2X>0||
      ball2X-ballS<=0 && ballSp2X<0){
       if(ballSp2X<0){
          ballSp2X=-spChange2;
          }
       else{
          ballSp2X=spChange2;
       }
      }
      if(ball2Y+ballS>=canv.height/2-wallW||
         ball2Y-ballS<=0 &&
         ball2X>=ship2X-shipW/3 && 
         ball2X<=ship2X+shipW/3*4){
          ballSp2Y=-ballSp2Y;
      }
      if(ball2Y<=0){
          ballSp2Y=-ballSp2Y;
          ball2X=canv.width/2;
          ball2Y=7*shipH;
          ship2hp=ship2hp-2;
      }
      if(ball2X+ballS>=bWall2X &&
         ball2X+ballS<bWall2X+bWallL ||
         ball2X<=bWall2X+bWallL &&
         ball2X>bWall2X){
         
      if(ball2Y+ballS>=bWall2Y &&
         ball2Y+ballS<bWall2Y+wallW ||
         ball2Y-ballS<=bWall2Y+wallW &&
         ball2Y-ballS>bWall2Y){
            ballSp2Y=-ballSp2Y; 
         }
      else if(ball2Y>bWall2Y &&
              ball2Y<bWall2Y+wallW){
          if(ballSp2X<0){
            ballSp2X=-spChange2;
            }
          else{
            ballSp2X=spChange2;
          }
      }  
         }
      }
      
      function drawHp(){
          for(i=1;i<=ship1hp;i++){
            ctx.beginPath();
            ctx.arc(canv.width-5, 
            canv.height-i*7,
            3, Math.PI*2, false);
            ctx.fillStyle="#0000FF";
            ctx.fill();
            ctx.closePath();  
          }
          for(i=1;i<=ship2hp;i++){
            ctx.beginPath();
            ctx.arc(5, i*7, 
            3, Math.PI*2, false);
            ctx.fillStyle="#FF0000"
            ctx.fill();
            ctx.closePath();
          }
      }
	  
	  function shotReset(){
          if(shotn1==true){
              shotn1=false;
          }
          if(shotn2==true){
              shotn2=false;
          }
      }
      
	  document.addEventListener('keyup', function (event) {
			var x = event.keyCode;
			if (x == 87) {
       if(ship1hp>0 &&shotn1==false){
        shots1.push({x:ship1X+shipW/2,
        y:ship1Y-shipH*2.5});
        shotn1=true;
        }
			}
      if (x == 38) {
       if(ship2hp>0 && shotn2==false){
        shots2.push({x:ship2X+shipW/2,
        y:ship2Y+shipH*2.5});
        shotn2=true;
        }
      }
      
      if (x == 65){
      if(ship1X>=0){
          ship1Sp=-shipSp;
          }
      }
      
      if (x == 68){
       if(ship1X+shipW<=canv.width){
          ship1Sp=shipSp;
          }
      }
      
      if (x == 39){
          if(ship2X+shipW<=canv.width){
              ship2Sp=shipSp;
          }
      }
      
      if (x == 37){
          if(ship2X>=0){
              ship2Sp=-shipSp;
          }
      }
      })
	  
      function stop1(){
         ship1Sp=0; 
      }
      
      function stop2(){
         ship2Sp=0; 
      }
      function draw(){
       if(play==true){
   ctx.clearRect(0,0,canv.width,canv.height);
   drawWall();
   drawBalls();
   drawHp();
     if(ship1hp>0){
         drawShip1(); 
         }
     if(ship2hp>0){
         drawShip2();
         }
         drawShot();
   if(ship1hp<=0 || ship2hp<=0){
       if(ship1hp<=0){
           winx2.style.display="block";
       }
       else{
           winx1.style.display="block"
       }
       play=false;
   }
       
   }
   }
      chDiff(1);
      setInterval(draw, 50);   
      setInterval(shotReset, 1000);
      setInterval(bWallPos, 5000);
     </script>   
    </body>
    
</html>
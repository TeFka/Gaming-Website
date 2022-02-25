<!DOCTYPE html>
<html>
    <head>
		<link rel = 'stylesheet' href = '../siteCSS.css' />
		<link rel = 'stylesheet' href = './Survivec.css' />
        <title>Survival</title>
    </head>
    <body>
	<?php include('../parts/header.php'); ?>
    <div id="manu">
        <h1>Survavic</h1>
        <button onClick="playG(1,manu)">
        Play</button>
        <button>***</button>
        <button>***</button>
    </div>
    <div id="losx">
      <h1>You are dead</h1>
      <button onClick="playG(0,losx)">
      Respawn</button>  
      <button onClick="showM(losx)">
      Menu</button>
    </div>
    <div id="craftG">
    <button onClick="showW(inv,0)">
    Inventory</button>
    <div id="close" onClick="closeW(craftG)">
    </div>
    <h1>Crafting</h1>
    <div id="recipes">
     <ul id="recep">
     </ul>
     <div id="scrl1">
       <div id="scrlUp"
     onClick="moveThings(recipes,0)">
           <svg width="36" height="56">
              <polyline 
            style="stroke-linejoin:miter;
             stroke:rgba(0,0,0,1.0);
             stroke-width:2;"
            points="4 40, 18 16, 32 40";
              />  
           </svg>
       </div>
       <div id="scrlDown"
     onClick="moveThings(recipes,1)">
           <svg width="36" height="56">
              <polyline 
            style="stroke-linejoin:miter;
             stroke:rgba(0,0,0,1.0);
             stroke-width:2;"
            points="4 16, 18 40, 32 16";
              />    
           </svg>
       </div>
     </div>
    </div>
    <h2 id="pickCraf"></h2>
    <div id="matCraf"></div>
    <div id="crift" onClick="craftM()">
    Craft</div>
    </div>
    <div id="inventory">
    <div id="close" onClick="closeW(inv)">
    </div>
    <h1>Inventory</h1>
      <div id="thingsInv">
        <ul id="inv">   
        </ul>
        <div id="scrl2">
          <div id="scrlUp" 
       onClick="moveThings(items,0)">
            <svg>
              <polyline 
            style="stroke-linejoin:miter;
             stroke:rgba(0,0,0,1.0);
             stroke-width:3;"
             points="4 40, 18 16,32 40";
              />
            </svg>  
          </div>
          <div id="scrlDown"
       onClick="moveThings(items,1)">
            <svg width="36" height="56">
              <polyline 
            style="stroke-linejoin:miter;
             stroke:rgba(0,0,0,1.0);
             stroke-width:3;"
             points="4 16, 18 40,32 16";
              />
            </svg> 
          </div>
        </div>
      </div>
    </div>
    <canvas id="canv" 
    width="1200" height="600">
    </canvas>
	<?php include('../parts/bottomFotter.php');?>
    <script>
    function id(di) {
	return document.getElementById(di);
}
var canv = id("canv");
var ctx = canv.getContext("2d");
var craftG = id("craftG");
var inv = id("inventory");
var tInv = id("inv");
var recep = id("recep");
var manu = id("manu");
var losx = id("losx");
var pickC = id("pickCraf");
var matC = id("matCraf");

var drawSp = 60;

var player = {
	life: 1,
	x: canv.width / 2,
	y: canv.height / 2,
	hp: 20,
	size: 20,
	sp: 12,
	weapon: [0, 0],
	reach: 3,
	dmg: 1,
	knb: 3,
	helm: [0, 0],
	chPlat: [0, 0],
	gloves: [0, 0],
	legns: [0, 0],
	boots: [0, 0],
	armorHp: 0,
	minePow: 9
};

var maxHp = player.hp;
var baseHp = player.hp;
var midPosX = player.x;
var midPosY = player.y;

var mapRange = player.size * 150;

var time = 12;
var real1Sec = 0;
var day = true;
var night = false;

var treePos = [];

var rockPos = [];

var enemy = [];
var enemyNr = 0;

var borderW = 2 * player.size;

var faceS = 1;

var leg1X = player.x - player.size * 0.4;
var leg2X = player.x + player.size * 0.05;
var leg1Y = player.y - player.size * 0.175;
var leg2Y = player.y - player.size * 0.175;
var legW = player.size * 0.35;

var arm1X = player.x - player.size * 0.95;
var arm2X = player.x + player.size * 0.55;
var arm1Y = player.y - player.size * 0.2;
var arm2Y = player.y - player.size * 0.2;
var armW = player.size * 0.4;

var animP = 0;


var rightS = false;
var leftS = false;
var upS = false;
var downS = false;

var attax = false;
var mItemW = 0;
var mItemH = 0;

var playerShots = [];
var enemShots = [];
var shotSpNorm = 5;

var recipes = [];
var items = [];
var placedB = [];
var mItem = 0;

var craftLos = [];

var world = 1;
var hellRocks = [];
var lavaGems = [];

var play = false;

function createWorld() {
	treePos = [];
	var x;
    var y;
	var treeS = player.size * 1.5;
	for (var i = -900; i <= 900; i++) {
		if (i < 0) {
			if (i % 2 == 0) {
				/*trees*/
				
			} else {
				x = Math.random() * -mapRange;
				y = Math.random() * -mapRange;
			}
		} else {
			if (i % 2 == 0) {
				x = Math.random() * mapRange;
				y = Math.random() * mapRange;
			} else {
				x = Math.random() * mapRange;
				y = Math.random() * -mapRange;
			}
		}
		treePos.push({
			x: x,
			y: y,
			s: treeS,
			l: 3,
			exs: 1
		});
	}

	rockPos = [];
	var rockS = player.size * 0.3;
	for (var i = -700; i <= 700; i++) {
		if (i < 0) {
			if (i % 2 == 0) {
				x = Math.random() * -mapRange;
				y = Math.random() * mapRange;
			} else {
				x = Math.random() * -mapRange;
				y = Math.random() * -mapRange;
			}
		} else {
			if (i % 2 == 0) {
				x = Math.random() * mapRange;
				y = Math.random() * mapRange;
			} else {
				x = Math.random() * mapRange;
				y = Math.random() * -mapRange;
			}
		}

		var r = 1;
		if (i % 3 == 0) {
			r = 2;
		}
		if (i % 5 == 0) {
			r = 3;
		}
		if (i % 11 == 0) {
			r = 4;
		}

		rockPos.push({
			x: x,
			y: y,
			r: r,
			s: rockS,
			l: r * 2,
			exs: 1
		});
	}
}

function createHell() {
	hellRocks = [];
	lavaGems = [];
	var x;
    var y;
	var mRockX = 0;
	var mRockY = 0;
	var rockS = player.size * 2;
	var gemS = player.size * 0.6;
	for (var i = -500; i <= 500; i++) {
		if (i < 0) {
			if (i % 2 == 0) {
				if (i % 5 == 0) {
					x = Math.random() * mapRange;
					y = Math.random() * mapRange;
					mRockX = x;
					mRockY = y;
				} else {
					x = mRockX - rockS + Math.random() * 2 * rockS;
					y = mRockY - rockS + Math.random() * 2 * rockS;
				}
			} else {
				if (i % 5 == 0) {
					x = Math.random() * -mapRange;
					y = Math.random() * mapRange;
					mRockX = x;
					mRockY = y;
				} else {
					x = mRockX - rockS + Math.random() * 2 * rockS;
					y = mRockY - rockS + Math.random() * 2 * rockS;
				}
			}
		} else {
			if (i % 2 == 0) {
				if (i % 5 == 0) {
					x = Math.random() * mapRange;
					y = Math.random() * -mapRange;
					mRockX = x;
					mRockY = y;
				} else {
					x = mRockX - rockS + Math.random() * 2 * rockS;
					y = mRockY - rockS + Math.random() * 2 * rockS;
				}
			} else {
				if (i % 5 == 0) {
					x = Math.random() * -mapRange;
					y = Math.random() * -mapRange;
					mRockX = x;
					mRockY = y;
				} else {
					x = mRockX - rockS + Math.random() * 2 * rockS;
					y = mRockY - rockS + Math.random() * 2 * rockS;
				}
			}
		}
		hellRocks.push({
			x: x,
			y: y,
			s: rockS,
			l: 4,
			exs: 1
		});
	}
	for (var i = -300; i <= 300; i++) {
		if (i < 0) {
			if (i % 2 == 0) {
				x = Math.random() * mapRange;
				y = Math.random() * mapRange;
			} else {
				x = Math.random() * -mapRange;
				y = Math.random() * mapRange;
			}
		} else {
			if (i % 2 == 0) {
				x = Math.random() * mapRange;
				y = Math.random() * -mapRange;
			} else {
				x = Math.random() * -mapRange;
				y = Math.random() * -mapRange;
			}
		}
		lavaGems.push({
			x: x,
			y: y,
			r: 4,
			l: 8,
			s: gemS,
			exs: 1
		});
	}
}

function closeW(windv) {
	windv.style.display = "none";
}

function showW(windv, wm) {
	windv.style.display = "block";
	if (windv == craftG) {
		craftLos = [];
		pickC.innerHTML = "Recipe";
		matC.innerHTML = "Materials";
	}
	if (wm != 0) {
		wm.style.display = "none";
	}
}

function showM(vind) {
	manu.style.display = "block";
	canv.style.display = "none";
	vind.style.display = "none";
}

function getMineral(min, num) {
	if (num == 1) {
		switch (min) {
			case 1:
				return "#8B4513";
				break;
			case 2:
				return "#F0F0F0";
				break;
			case 3:
				return "#FF0000";
				break;
			case 4:
				return "#00FFFF";
				break;
			case 5:
				return "#000000";
				break;
			case 6:
				return "#F0A000";
				break;
		}
	} else if (num == 2) {
		switch (min) {
			case 1:
				return "#F0F0F0";
				break;
			case 2:
				return "#000000";
				break;
			case 3:
				return "#FF0000";
				break;
			case 4:
				return "#0000FF";
				break;
			case 5:
				return "#6600FF";
				break;
			case 6:
				return "#F0F000";
				break;
		}
	}
}

function playG(num, wind) {
	enemy = [];
	midPosX = player.x;
	midPosY = player.y;
	world = 0;
	player.hp = 20;
	if (num == 1) {
		createWorld();
		createHell();

	}
	canv.style.display = "block";
	wind.style.display = "none";
	play = true;
}

function removeArrItem(arr, itm) {
	var lArr = [];
	var found = 0;
	for (var i = 0; i < arr.length; i++) {
		if (i != itm) {
			if (found == 0) {
				lArr[i] = arr[i];
			} else {
				lArr[i - 1] = arr[i];
			}
		} else {
			found = 1;
		}
	}
	return lArr;
}

function moveThings(arr, dir) {
	var sepElem;
	/*if(arr.length>5){*/
	if (dir == 0) {
		sepElem = arr[0];
		for (var i = 0; i < arr.length - 1; i++) {
			arr[i] = arr[i + 1];
		}
		arr[arr.length - 1] = sepElem;
	}
	if (dir == 1) {
		sepElem = arr[arr.length - 1];
		for (var i = arr.length - 1; i > 0; i--) {
			arr[i] = arr[i - 1];
		}
		arr[0] = sepElem;
	}
	updateInventory();
	updateRecipes(0);
}

function updateInventory() {
	tInv.innerHTML = "";
	var showItems = 3;
	var nam;
	for (var i = 0; i < items.length; i++) {
		var t = items[i];
		if (showItems > 0) {
			if (t.c > 0) {
				if (t.t == 0) {
					nam = "<li>" + t.n + ":" +
						t.c + "</li>";
				} else if (t.t >= 11) {
					nam = "<li onClick=equipM(" + t.t + "," +
						t.u + ")>" + t.n + ":" + t.c + "</li>";
				} else {
					nam = "<li onClick=equipM(" + t.t + "," + t.u + ")>" + t.n + "<div class='descp'>" + "<h5>Dmg +" + t.inf[0] + "</h5>" + "<h5>Knb +" + t.inf[1] + "</h5>" + "<h5>Rch +" + t.inf[2] + "</h5>" + "<h5>mineP +" + t.inf[3] + "</h5></div></li>";
				}
				tInv.innerHTML += nam;
				showItems--;
			}
		} else {
			removeArrItem(items, i);
			i--;
		}

	}
}

function updateRecipes(gotItm) {
	recep.innerHTML = "";
	var showRecep = 3;
	if (gotItm == 1) {
		recipes = [];
		var woodAm = 0;
		var stoneAm = 0;
		var rubAm = 0;
		var diamAm = 0;
		var obsAm = 0;
		for (var i = 0; i < items.length; i++) {
			switch (items[i].n) {
				case "Wood":
					woodAm = items[i].c;
					break;
				case "Stone":
					stoneAm = items[i].c;
					break;
				case "Ruby":
					rubAm = items[i].c;
					break;
				case "Diamond":
					diamAm = items[i].c;
					break;
				case "Obsidian glass":
					obsAm = items[i].c;
					break;
			}
		}
		//Recipes
		//Hand item
		if (woodAm >= 5) {
			recipes.push({
				n: "Wooden sword",
				m: 1,
				t: 1,
				u: 1,
				inf: [2, 5, armW * 2, 0],
				it: [{
					n: "Wood",
					c: 5
				}]
			});
		}
		if (stoneAm >= 10) {
			recipes.push({
				n: "Stone sword",
				m: 2,
				t: 1,
				u: 2,
				inf: [3, 6, armW * 2, 0],
				it: [{
					n: "Stone",
					c: 10
				}]
			});
		}
		if (rubAm >= 15) {
			recipes.push({
				n: "Ruby sword",
				m: 3,
				t: 1,
				u: 3,
				inf: [3, 8, armW * 4, 0],
				it: [{
					n: "Ruby",
					c: 15
				}]
			});
		}
		if (diamAm >= 10) {
			recipes.push({
				n: "Diamond sword",
				m: 4,
				t: 1,
				u: 4,
				inf: [5, 7, armW * 2, 0],
				it: [{
					n: "Diamond",
					c: 10
				}]
			});
		}
		if (obsAm >= 10) {
			recipes.push({
				n: "OG sword",
				m: 5,
				t: 1,
				u: 5,
				inf: [7, 7, armW * 2, 0],
				it: [{
					n: "Obsidian glass",
					c: 10
				}]
			});
		}
		if (woodAm >= 5) {
			recipes.push({
				n: "Wooden pick",
				m: 21,
				t: 1,
				u: 1,
				inf: [1, 2, armW, 1],
				it: [{
					n: "Wood",
					c: 5
				}]
			});
		}
		if (stoneAm >= 10) {
			recipes.push({
				n: "Stone pick",
				m: 22,
				t: 1,
				u: 2,
				inf: [2, 3, armW, 2],
				it: [{
					n: "Stone",
					c: 10
				}]
			});
		}
		if (rubAm >= 15) {
			recipes.push({
				n: "Ruby pick",
				m: 23,
				t: 1,
				u: 3,
				inf: [3, 5, armW, 3],
				it: [{
					n: "Ruby",
					c: 15
				}]
			});
		}
		if (diamAm >= 10) {
			recipes.push({
				n: "Diamond pick",
				m: 24,
				t: 1,
				u: 4,
				inf: [4, 4, armW, 4],
				it: [{
					n: "Diamond",
					c: 10
				}]
			});
		}
		if (obsAm >= 10) {
			recipes.push({
				n: "OG pick",
				m: 25,
				t: 1,
				u: 5,
				inf: [3, 4, armW, 5],
				it: [{
					n: "Obsidian glass",
					c: 10
				}]
			});
		}
		//Armor
		if (rubAm >= 5) {
			recipes.push({
				n: "Ruby helm",
				m: 6,
				t: 1,
				u: 3,
				inf: [0, 0, 2, 10],
				it: [{
					n: "Ruby",
					c: 5
				}]
			});
		}
		if (diamAm >= 5) {
			recipes.push({
				n: "Diamond helm",
				m: 7,
				t: 1,
				u: 4,
				inf: [3, 0, 3, 5],
				it: [{
					n: "Diamond",
					c: 5
				}]
			});
		}
		if (obsAm >= 7) {
			recipes.push({
				n: "OG helm",
				m: 8,
				t: 2,
				u: 5,
				inf: [0, 0, 8, 0],
				it: [{
					n: "Obsidian glass",
					c: 5
				}]
			});
		}
		if (rubAm >= 9) {
			recipes.push({
				n: "Ruby chestPl",
				m: 9,
				t: 1,
				u: 3,
				inf: [0, 0, 4, 15],
				it: [{
					n: "Ruby",
					c: 9
				}]
			});
		}
		if (diamAm >= 9) {
			recipes.push({
				n: "Diamond chestPl",
				m: 10,
				t: 1,
				u: 4,
				inf: [4, 0, 5, 7],
				it: [{
					n: "Diamond",
					c: 9
				}]
			});
		}
		if (obsAm >= 12) {
			recipes.push({
				n: "OG chestPl",
				m: 11,
				t: 2,
				u: 5,
				inf: [0, 0, 13, 0],
				it: [{
					n: "Obsidian glass",
					c: 12
				}]
			});
		}
		if (rubAm >= 4) {
			recipes.push({
				n: "Ruby gloves",
				m: 12,
				t: 1,
				u: 3,
				inf: [2, 0, 2, 7],
				it: [{
					n: "Ruby",
					c: 4
				}]
			});
		}
		if (diamAm >= 4) {
			recipes.push({
				n: "Diamond gloves",
				m: 13,
				t: 1,
				u: 4,
				inf: [5, 0, 3, 0],
				it: [{
					n: "Diamond",
					c: 4
				}]
			});
		}
		if (obsAm >= 5) {
			recipes.push({
				n: "OG gloves",
				m: 14,
				t: 2,
				u: 5,
				inf: [3, 0, 7, 0],
				it: [{
					n: "Obsidian glass",
					c: 5
				}]
			});
		}
		if (rubAm >= 5) {
			recipes.push({
				n: "Ruby pants",
				m: 15,
				t: 1,
				u: 3,
				inf: [0, 0, 2, 10],
				it: [{
					n: "Ruby",
					c: 5
				}]
			});
		}
		if (diamAm >= 5) {
			recipes.push({
				n: "Diamond pants",
				m: 16,
				t: 1,
				u: 4,
				inf: [3, 0, 3, 5],
				it: [{
					n: "Diamond",
					c: 5
				}]
			});
		}
		if (obsAm >= 7) {
			recipes.push({
				n: "OG pants",
				m: 17,
				t: 2,
				u: 5,
				inf: [0, 0, 8, 0],
				it: [{
					n: "Obsidian glass",
					c: 7
				}]
			});
		}
		if (rubAm >= 4) {
			recipes.push({
				n: "Ruby boots",
				m: 18,
				t: 1,
				u: 3,
				inf: [0, 0, 2, 8],
				it: [{
					n: "Ruby",
					c: 4
				}]
			});
		}
		if (diamAm >= 4) {
			recipes.push({
				n: "Diamond boots",
				m: 19,
				t: 1,
				u: 4,
				inf: [2, 0, 3, 3],
				it: [{
					n: "Diamond",
					c: 4
				}]
			});
		}
		if (obsAm >= 5) {
			recipes.push({
				n: "OG boots",
				m: 20,
				t: 2,
				u: 5,
				inf: [0, 0, 8, 0],
				it: [{
					n: "Obsidian glass",
					c: 5
				}]
			});
		}
		if (woodAm >= 3) {
			/*&&stoneAm>=3&&
			      rubAm>=3&&diamAm>=3&&obsAm>=3){*/
			recipes.push({
				n: "Strange crystal",
				m: 30,
				t: 11,
				u: 10,
				inf: [0, 0, 0, 0],
				it: [{
					n: "Wood",
					c: 3
				}, {
					n: "Stone",
					c: 3
				}, {
					n: "Ruby",
					c: 3
				}, {
					n: "Diamond,c:3"
				}, {
					n: "Obsidian",
					c: 3
				}]
			});
		}
	}
	//Recipes
	for (var i = 0; i < recipes.length; i++) {
		if (showRecep > 0) {
			var nam =
				"<li onClick='chRec(" + recipes[i].m + ")'>" + recipes[i].n + "</li>";
			recep.innerHTML += nam;
			showRecep--;
		} else {
			removeArrItem(recipes, i);
			i--;
		}
	}
}

function chRec(nam) {
	matC.innerHTML = "";
	craftLos = [];
	for (var i = 0; i < recipes.length; i++) {
		if (nam == recipes[i].m) {
			pickC.innerHTML = recipes[i].n;
			for (m = 0; m < recipes[i].it.length; m++) {
				var mat = recipes[i].it[m];
				var mit = mat.n + ": " + mat.c;
				craftLos.push({
					n: mat.n,
					c: mat.c,
					m: recipes[i].m
				});
				matC.innerHTML += mit;
			}
		}
	}
}

function drawBorder() {
	ctx.beginPath();
	ctx.rect(midPosX - mapRange - borderW,
		midPosY - mapRange - borderW,
		borderW, mapRange * 2 + borderW * 2);
	ctx.rect(midPosX - mapRange,
		midPosY - mapRange - borderW,
		mapRange * 2, borderW);
	ctx.rect(midPosX + mapRange,
		midPosY - mapRange - borderW,
		borderW, mapRange * 2 + 2 * borderW);
	ctx.rect(midPosX - mapRange,
		midPosY + mapRange,
		mapRange * 2, borderW);
	ctx.fillStyle = "#000000";
	ctx.fill();
	ctx.closePath();

	if (player.x < midPosX - mapRange) {
		leftS = false;
		midPosX = player.x + mapRange;
	}
	if (player.x > midPosX + mapRange) {
		rightS = false;
		midPosX = player.x - mapRange;
	}
	if (player.y < midPosY - mapRange) {
		upS = false;
		midPosY = player.y + mapRange;
	}
	if (player.y > midPosY + mapRange) {
		downS = false;
		midPosY = player.y - mapRange;
	}
}

function drawThings(array, mPosX, mPosY, num) {
	for (var i = 0; i < array.length; i++) {
		var ar = array[i];
		if (array[i].exs == 1) {
			ctx.beginPath();
			ctx.rect(mPosX + ar.x, mPosY + ar.y,
				ar.s, ar.s);
			if (num == 0) {
				ctx.fillStyle = "#55FF00";
				ctx.strokeStyle = "#000000";
			} else if (num == 1) {
				ctx.fillStyle = "#F00000";
				ctx.strokeStyle = "#000000";
			}
			ctx.fill();
			ctx.closePath();
			ctx.beginPath();
			ctx.rect(mPosX + ar.x + ar.s / 4,
				mPosY + ar.y + ar.s / 4,
				ar.s / 2, ar.s / 2);
			ctx.strokeStyle = "#000000";
			ctx.stroke();
			ctx.closePath();
		}
		if (ar.l <= 0 &&
			ar.exs == 1) {
			ar.exs = 0;
			var amount = Math.random() * 10;
			amount = Math.ceil(amount);
			var first = true;
			for (i = 0; i < items.length; i++) {
				if (num == 0) {
					if (items[i].n == "Wood") {
						items[i].c += amount;
						first = false;
					}
				} else if (num == 1) {
					if (items[i].n == "Hellrock") {
						items[i].c += amount;
						first = false;
					}
				}
			}
			if (first == true) {
				if (num == 0) {
					items.push({
						n: "Wood",
						c: amount,
						t: 11,
						u: 1
					});
				} else if (num == 1) {
					items.push({
						n: "Hellrock",
						c: amount,
						t: 11,
						u: 7
					});
				}
			}
			updateInventory();
			updateRecipes(1);
		}
	}
}

function drawMinerals(array,
	mPosX, mPosY, num) {
	for (var i = 0; i < array.length; i++) {
		var ar = array[i];
		if (ar.exs == 1) {
			ctx.beginPath();
			ctx.rect(mPosX + ar.x, mPosY + ar.y,
				ar.s, ar.s);
			if (num == 0) {
				ctx.fillStyle = getMineral(ar.r + 1, 1);
				ctx.strokeStyle = getMineral(ar.r + 1, 2);
			} else {
				ctx.fillStyle = "#F0A000";
				ctx.strokeStyle = "#F0F000";
			}
			ctx.fill();
			ctx.stroke();
			ctx.closePath();
		}

		if (ar.l <= 0 &&
			ar.exs == 1) {
			rockPos[i].exs = 0;
			var amount = Math.random() * 5;
			amount = Math.ceil(amount);
			var first = true;
			var minr = "";
			switch (ar.r) {
				case 1:
					minr = "Stone";
					break;
				case 2:
					minr = "Ruby";
					break;
				case 3:
					minr = "Diamond";
					break;
				case 4:
					if (num == 0) {
						minr = "Obsidian glass";
					} else if (num == 1) {
						minr = "Lava gem";
					}
					break;
			}
			for (i = 0; i < items.length; i++) {
				if (items[i].n == minr) {
					items[i].c += amount;
					first = false;
				}
			}
			if (first == true) {
				items.push({
					n: minr,
					c: amount,
					t: 0,
					u: 0
				});
			}
			updateInventory();
			updateRecipes(1);
		}
	}
}
var porCount = 0;

function drawPlacedB() {
	if (placedB.length != 0) {
		for (var i = 0; i < placedB.length; i++) {
			var p = placedB[i];
			var x = p.x + midPosX;
			var y = p.y + midPosY;
			if (p.l == 10) {
				ctx.beginPath();
				ctx.arc(x + p.s * 2, y + p.s * 2,
					4 * p.s, 2 * Math.PI, false);
				ctx.fillStyle = "#FF00FF";
				ctx.strokeStyle = "#500050";
				ctx.fill();
				ctx.stroke();
				ctx.closePath();
				if (player.x > x - 4 * p.s &&
					player.x < x + 4 * p.s &&
					player.y > y - 4 * p.s &&
					player.y < y + 4 * p.s) {
					porCount++;
					if (porCount >= 2000 / drawSp) {
						if (world == 0) {
							world = 1;
						} else {
							world = 0;
						}
						porCount = 0;
					}
				}

			} else {
				if (p.w == world) {
					ctx.beginPath();
					ctx.rect(p.x - p.s / 2 + midPosX,
						p.y - p.s / 2 + midPosY, p.s, p.s);
					ctx.fillStyle = p.u;
					ctx.fill();
					ctx.closePath();
				}
			}
		}
	}
}

function dayNightCycle(num) {
	if (num == 0) {
		var alpha = 0;
		time += drawSp / 1000;
		if (time >= 24) {
			time = 0;
		}
		if (time >= 9 && time <= 21 && day == false) {
			day = true;
			night = false;
		}
		if (time > 21 || time < 9 && night == false) {
			night = true;
			day = false;
		}
		if (time >= 12 && time <= 18) {
			alpha = 0;
		} else if (time >= 0 && time <= 6) {
			alpha = 0.5;
		} else if (time > 18 && time < 24) {
			alpha = (time - 18) * 0.09;
		} else if (time > 6 && time < 12) {
			alpha = (12 - time) * 0.09;
		}
		ctx.beginPath();
		ctx.rect(0, 0, canv.width, canv.height);
		ctx.fillStyle = "rgba(0,0,255," + alpha + ")";
		ctx.fill();
		ctx.closePath();
	} else if (num == 1) {
		ctx.beginPath();
		ctx.rect(0, 0, canv.width, canv.height);
		ctx.fillStyle = "rgba(100,0,0,0.5)";
		ctx.fill();
		ctx.closePath();
	}
}

function drawPlayer() {
	/*arms and legs*/
	ctx.beginPath();
	ctx.rect(leg1X, leg1Y, legW, legW);
	ctx.rect(leg2X, leg2Y, legW, legW);
	ctx.rect(arm1X, arm1Y, armW, armW);
	ctx.rect(arm2X, arm2Y, armW, armW);
	ctx.fillStyle = "#FF7700";
	ctx.fill();
	ctx.closePath();

	/*boots*/
	if (player.boots[0] != 0) {
		ctx.beginPath();
		switch (faceS) {
			case 1:
				ctx.rect(leg1X, leg1Y, legW, legW / 2);
				ctx.rect(leg2X, leg2Y, legW, legW / 2);
				break;
			case 2:
				ctx.rect(leg1X + legW / 2, leg1Y,
					legW / 2, legW);
				ctx.rect(leg2X + legW / 2, leg2Y,
					legW / 2, legW);
				break;
			case 3:
				ctx.rect(leg1X, leg1Y + legW / 2,
					legW, legW / 2);
				ctx.rect(leg2X, leg2Y + legW / 2,
					legW, legW / 2);
				break;
			case 4:
				ctx.rect(leg1X, leg1Y, legW / 2, legW);
				ctx.rect(leg2X, leg2Y, legW / 2, legW);
				break;
		}
		ctx.fillStyle = getMineral(player.boots[0], 1);
		ctx.strokeStyle = getMineral(player.boots[0], 2);
		ctx.fill();
		ctx.stroke();
		ctx.closePath();
	}
	/*leggings*/
	if (player.legns[0] != 0) {
		ctx.beginPath();
		switch (faceS) {
			case 1:
				ctx.rect(leg1X, leg1Y + legW / 2,
					legW, legW / 2);
				ctx.rect(leg2X, leg2Y + legW / 2,
					legW, legW / 2);
				break;
			case 2:
				ctx.rect(leg1X, leg1Y, legW / 2, legW);
				ctx.rect(leg2X, leg2Y, legW / 2, legW);
				break;
			case 3:
				ctx.rect(leg1X, leg1Y, legW, legW / 2);
				ctx.rect(leg1X, leg2Y, legW, legW / 2);
				break;
			case 4:
				ctx.rect(leg1X + legW / 2, leg1Y,
					legW / 2, legW);
				ctx.rect(leg2X + legW / 2, leg2Y,
					legW / 2, legW);
				break;
		}
		ctx.fillStyle = getMineral(player.legns[0], 1);
		ctx.strokeStyle = getMineral(player.legns[0], 2);
		ctx.fill();
		ctx.stroke();
		ctx.closePath();

	}

	/*gloves*/
	if (player.gloves[0] != 0) {
		ctx.beginPath();
		switch (faceS) {
			case 1:
				ctx.rect(arm1X, arm1Y, armW, armW / 2);
				ctx.rect(arm2X, arm2Y, armW, armW / 2);
				break;
			case 2:
				ctx.rect(arm1X + armW / 2, arm1Y,
					armW / 2, armW);
				ctx.rect(arm2X + armW / 2, arm2Y,
					armW / 2, armW);
				break;
			case 3:
				ctx.rect(arm1X, arm1Y + armW / 2,
					armW, armW / 2);
				ctx.rect(arm2X, arm2Y + armW / 2,
					armW, armW / 2);
				break;
			case 4:
				ctx.rect(arm1X, arm1Y, armW / 2, armW);
				ctx.rect(arm2X, arm2Y, armW / 2, armW);
				break;
		}
		ctx.fillStyle = getMineral(player.gloves[0],
			1);
		ctx.strokeStyle = getMineral(player.gloves[0],
			2);
		ctx.fill();
		ctx.stroke();
		ctx.closePath();
	}

	/*hand Item*/
	if (player.weapon[0] != 0) {
		if (player.weapon[0] == 11) {
			mItemW = armW;
			mItemL = armW;
		} else {
			mItemW = player.size * 0.1;
			mItemL = player.reach;
		}
		ctx.beginPath();
		switch (faceS) {
			case 1:
				ctx.rect(arm2X +
					armW / 2 - mItemW / 2,
					arm2Y - mItemL,
					mItemW, mItemL);
				break;
			case 2:
				ctx.rect(arm2X + armW,
					arm2Y + armW / 2 - mItemW / 2,
					mItemL, mItemW);
				break;
			case 3:
				ctx.rect(arm1X +
					armW / 2 - mItemW / 2,
					arm1Y + armW, mItemW, mItemL);
				break;
			case 4:
				ctx.rect(arm1X - mItemL,
					arm1Y + armW / 2 - mItemW / 2,
					mItemL, mItemW);
				break;
		}
		if (player.weapon[1] == 1) {
			ctx.fillStyle = "#F0F0F0";
			ctx.strokeStyle = "#000";
		} else if (player.weapon[0] == 10) {
			ctx.fillStyle = "#00FFAA";
			ctx.strokeStyle = "#F000F0";
		} else {
			ctx.fillStyle = getMineral(player.weapon[0], 1);
			ctx.strokeStyle = getMineral(player.weapon[0], 2);
		}
		ctx.fill();
		ctx.stroke();
		ctx.closePath();

		if (player.weapon[1] == 1) {
			ctx.beginPath();
			switch (faceS) {
				case 1:
					ctx.rect(arm2X - armW * 0.2,
						arm2Y - mItemL * 0.9, armW * 1.4, mItemW);
					break;
				case 2:
					ctx.rect(arm2X + armW + mItemL * 0.8,
						arm2Y - armW * 0.2, mItemW, armW * 1.4);
					break;
				case 3:
					ctx.rect(arm1X - armW * 0.2,
						arm1Y + armW + mItemL * 0.8,
						armW * 1.4, mItemW);
					break;
				case 4:
					ctx.rect(arm1X - mItemL * 0.9,
						arm1Y - armW * 0.2, mItemW, armW * 1.4);
					break;
			}
			ctx.fillStyle =
				getMineral(player.weapon[0], 1);
			ctx.strokeStyle =
				getMineral(player.weapon[0], 2);
			ctx.fill();
			ctx.stroke();
			ctx.closePath();
		}
	}

	/*body*/
	ctx.beginPath();
	ctx.rect(player.x - player.size / 2,
		player.y - player.size / 2,
		player.size, player.size);
	ctx.fillStyle = "#F0F0F0";
	ctx.fill();
	ctx.closePath();

	/*shoulders*/
	ctx.beginPath();
	if (faceS == 1 || faceS == 3) {
		ctx.rect(player.x - player.size,
			player.y - player.size / 4,
			player.size / 2, player.size / 2);
		ctx.rect(player.x + player.size / 2,
			player.y - player.size / 4,
			player.size / 2, player.size / 2);
	} else if (faceS == 2 || faceS == 4) {
		ctx.rect(player.x - player.size / 4,
			player.y - player.size,
			player.size / 2, player.size / 2);
		ctx.rect(player.x - player.size / 4,
			player.y + player.size / 2,
			player.size / 2, player.size / 2);
	}
	ctx.fillStyle = "#FF7700";
	ctx.fill();
	ctx.closePath();

	/*chesplate*/
	if (player.chPlat[0] != 0) {
		ctx.beginPath();
		ctx.rect(player.x - player.size / 2,
			player.y - player.size / 2,
			player.size, player.size);
		if (faceS == 1 || faceS == 3) {
			ctx.rect(player.x - player.size,
				player.y - player.size / 4,
				player.size / 2, player.size / 2);
			ctx.rect(player.x + player.size / 2,
				player.y - player.size / 4,
				player.size / 2, player.size / 2);
		} else if (faceS == 2 || faceS == 4) {
			ctx.rect(player.x - player.size / 4,
				player.y - player.size,
				player.size / 2,
				player.size / 2);
			ctx.rect(player.x - player.size / 4,
				player.y + player.size / 2,
				player.size / 2, player.size / 2);
		}
		ctx.fillStyle = getMineral(player.chPlat[0],
			1);
		ctx.strokeStyle = getMineral(player.chPlat[0],
			2);
		ctx.fill();
		ctx.stroke();
		ctx.closePath();
	}
	/*head*/
	ctx.beginPath();
	ctx.arc(player.x, player.y,
		player.size / 4, Math.PI * 2, false);
	ctx.fillStyle = "#FF7700";
	ctx.fill();
	ctx.closePath();

	/*helmet*/
	if (player.helm[0] != 0) {
		ctx.beginPath();
		switch (faceS) {
			case 1:
				ctx.rect(player.x - player.size / 4,
					player.y - player.size / 16,
					player.size / 2, player.size / 2);
				break;
			case 2:
				ctx.rect(player.x - player.size / 16 * 7,
					player.y - player.size / 4,
					player.size / 2, player.size / 2);
				break;
			case 3:
				ctx.rect(player.x - player.size / 4,
					player.y - player.size / 16 * 7,
					player.size / 2, player.size / 2);
				break;
			case 4:
				ctx.rect(player.x - player.size / 16,
					player.y - player.size / 4,
					player.size / 2, player.size / 2);
				break;
		}
		ctx.fillStyle = getMineral(player.helm[0], 1);
		ctx.strokeStyle = getMineral(player.helm[0], 2);
		ctx.fill();
		ctx.stroke();
		ctx.closePath();
	}
	/*eyes*/
	ctx.beginPath();
	switch (faceS) {
		case 1:
			ctx.arc(player.x - player.size / 8,
				player.y - player.size / 8,
				player.size / 16, 2 * Math.PI, false);
			ctx.arc(player.x + player.size / 8,
				player.y - player.size / 8,
				player.size / 16, 2 * Math.PI, false);
			break;
		case 2:
			ctx.arc(player.x + player.size / 8,
				player.y - player.size / 8,
				player.size / 16, 2 * Math.PI, false);
			ctx.arc(player.x + player.size / 8,
				player.y + player.size / 8,
				player.size / 16, 2 * Math.PI, false);
			break;
		case 3:
			ctx.arc(player.x - player.size / 8,
				player.y + player.size / 8,
				player.size / 16, 2 * Math.PI, false);
			ctx.arc(player.x + player.size / 8,
				player.y + player.size / 8,
				player.size / 16, 2 * Math.PI, false);
			break;
		case 4:
			ctx.arc(player.x - player.size / 8,
				player.y - player.size / 8,
				player.size / 16, 2 * Math.PI, false);
			ctx.arc(player.x - player.size / 8,
				player.y + player.size / 8,
				player.size / 16, 2 * Math.PI, false);
			break;
	}
	ctx.fillStyle = "#000000";
	ctx.fill();
	ctx.closePath();

	/*ctx.beginPath();
	ctx.rect(leg1X,leg1Y,legW,legW);
	ctx.rect(leg2X,leg2Y,legW,legW);
	ctx.rect(arm1X,arm1Y,armW,armW);
	ctx.rect(arm2X,arm2Y,armW,armW);
	ctx.fillStyle="#0000FF";
	ctx.fill();
	ctx.closePath();*/
}

function drawHealth() {
	ctx.beginPath();
	ctx.rect(canv.width - maxHp * 5, 0,
		player.hp * 5, 15);
	ctx.fillStyle = "#00F000";
	ctx.fill();
	ctx.closePath();
	ctx.beginPath();
	ctx.rect(canv.width - maxHp * 5 + player.hp,
		0, (maxHp - player.hp) * 5, 15);
	ctx.fillStyle = "#F00000";
	ctx.fill();
	ctx.closePath();

	if (player.hp < maxHp) {
		player.hp += drawSp / 2000;
	}

}


function drawEnemy() {
	for (var i = 0; i < enemy.length; i++) {
		var en = enemy[i];
		if (en.w == world) {
			if (en.exs == 1) {
				if (day == true && world == 0) {
					if (real1Sec >= 1) {
						en.hp -= 2;
						en.hit = 1;
					}
				}
				en.x = en.x + midPosX;
				en.y = en.y + midPosY;
				/*drawing*/
				switch (en.r) {
					case 1:
						ctx.beginPath();
						ctx.rect(en.x - en.s / 2, en.y - en.s * 0.3,
							enemy[i].s, enemy[i].s * 0.6);
						ctx.rect(en.x - en.s * 0.42,
							en.y - en.s * 0.6,
							en.s * 0.15, en.s * 1.2);
						ctx.rect(en.x - en.s * 0.19,
							en.y - en.s * 0.6,
							en.s * 0.15, en.s * 1.2);
						ctx.rect(en.x + en.s * 0.04,
							en.y - en.s * 0.6,
							en.s * 0.15, en.s * 1.2);
						ctx.rect(en.x + en.s * 0.27,
							en.y - en.s * 0.6,
							en.s * 0.15, en.s * 1.2);
						if (en.x < player.x) {
							ctx.rect(en.x - en.s * 1.4,
								en.y - en.s * 0.45,
								en.s * 0.9, en.s * 0.9);
						} else {
							ctx.rect(en.x + en.s * 0.5,
								en.y - en.s * 0.45,
								en.s * 0.9, en.s * 0.9);
						}
						if (en.hit > 0) {
							ctx.fillStyle = "#FF0000";
							en.hit -= 1;
						} else {
							ctx.fillStyle = "#000000";
						}
						ctx.strokeStyle = "#006000";
						ctx.fill();
						ctx.stroke();
						ctx.closePath();
						break;
					case 2:
						var leg = en.s / 2;
						ctx.beginPath();
						ctx.rect(en.x - en.s / 2 - leg / 2, en.y - en.s / 2 - leg / 2, leg, leg);
						ctx.rect(en.x + en.s / 2 - leg / 2,
							en.y - en.s / 2 - leg / 2, leg, leg);
						ctx.rect(en.x - en.s / 2 - leg / 2,
							en.y + en.s / 2 - leg / 2, leg, leg);
						ctx.rect(en.x + en.s / 2 - leg / 2,
							en.y + en.s / 2 - leg / 2, leg, leg);
						ctx.rect(en.x - en.s / 2,
							en.y - en.s / 2, en.s, en.s);
						ctx.rect(en.x - en.s / 4,
							en.y - en.s / 4, en.s / 2, en.s / 2);
						if (en.hit > 0) {
							ctx.fillStyle = "#FF0000";
							en.hit -= 1;
						} else {
							ctx.fillStyle = "#00F0F0";
						}
						ctx.strokeStyle = "#0000F";
						ctx.fill();
						ctx.stroke(),
							ctx.closePath();

						if (player.x < en.x - en.s / 2) {
							mX = en.x - en.s / 4;
							mspX = -shotSpNorm;
						} else if (player.x > en.x + en.s / 2) {
							mX = en.x + en.s / 4;
							mspX = shotSpNorm;
						} else {
							mX = en.x;
							mspX = 0;
						}
						if (player.y < en.y - en.s / 2) {
							mY = en.y - en.s / 4;
							mspY = -shotSpNorm;
						} else if (player.y > en.y + en.s / 2) {
							mY = en.y + en.s / 4;
							mspY = shotSpNorm;
						} else {
							mY = en.y;
							mspY = 0;
						}
						ctx.beginPath();
						ctx.rect(mX - en.s / 8,
							mY - en.s / 8, en.s / 4, en.s / 4);
						ctx.rect(mX - en.s / 16,
							mY - en.s / 16, en.s / 8, en.s / 8);
						ctx.fillStyle = "#F0F0F0";
						ctx.strokeStyle = "#F00000";
						ctx.fill();
						ctx.stroke();
						ctx.closePath();
						break;
					case 3:
						var xRange = en.x - player.x / Math.sqrt((en.x - player.x) * (en.x - player.x));
						var yRange = en.y - player.y /
							Math.sqrt((en.y - player.y) * (en.y - player.y));
						/* ctx.beginPath();
						 ctx.arc();
						 ctx.arc();
						 ctx.arc();
						 ctx.rect();
						 ctx.rect();
						 ctx.closePath();*/
						break;
					case 4:
						var legNum = 20;
						var shX = [];
						var shY = [];
						var shT = 0;
						var ls = 3 * en.s / legNum;
						ctx.beginPath();
						ctx.arc(en.x - en.s, en.y,
							ls, 2 * Math.PI, false);
						shX[shT] = -en.s;
						shY[shT] = 0;
						shT++;
						ctx.arc(en.x + en.s, en.y,
							ls, 2 * Math.PI, false);
						shX[shT] = en.s;
						shY[shT] = 0;
						shT++;
						ctx.arc(en.x, en.y - en.s,
							ls, 2 * Math.PI, false);
						shX[shT] = 0;
						shY[shT] = -en.s;
						shT++;
						ctx.arc(en.x, en.y + en.s,
							ls, 2 * Math.PI, false);
						shX[shT] = 0;
						shY[shT] = en.s;
						shT++;

						for (var m = ((legNum - 4) / -4); m <= ((legNum - 4) / 4); m++) {
							if (m != 0) {
								var lx = m * en.s / (legNum / 4);
								shX[shT] = lx;
								shY[shT] = -Math.sqrt(en.s * en.s - lx * lx);
								shT++;
								ctx.arc(en.x + lx,
									en.y - Math.sqrt(en.s * en.s - lx * lx),
									ls, 2 * Math.PI, false);
							}
						}
						for (var m = ((legNum - 4) / -4); m <= ((legNum - 4) / 4); m++) {
							if (m != 0) {
								var lx = m * en.s / (legNum / 4);
								shX[shT] = lx;
								shY[shT] = Math.sqrt(en.s * en.s - lx * lx);
								shT++;
								ctx.arc(en.x + lx,
									en.y + Math.sqrt(en.s * en.s - lx * lx),
									ls, 2 * Math.PI, false);
							}
						}
						ctx.fillStyle = "#FF5500";
						ctx.strokeStyle = "#000000";
						ctx.fill();
						ctx.stroke();
						ctx.closePath();
						ctx.beginPath();
						ctx.arc(en.x, en.y, en.s,
							Math.PI * 2, false);
						ctx.arc(en.x, en.y, en.s / 2,
							Math.PI * 2, false);
						ctx.fillStyle = "#550000";
						ctx.strokeStyle = "#FF5500";
						ctx.fill();
						ctx.stroke();
						ctx.closePath();
						if (en.x <= canv.width + 200 &&
							en.x >= 0 - 200 &&
							en.y >= 0 - 200 &&
							en.y <= canv.height + 200) {
							en.actInv++;
							if (en.actInv >= 2000 / drawSp) {
								var deltaX = player.x - en.x;
								var deltaY = player.y - en.y;
								en.x += (deltaX * Math.random() * 0.8);
								en.y += (deltaY * Math.random() * 0.8);
								for (var m = 0; m < legNum; m++) {
									var spX = shotSpNorm * shX[m] / en.s;
									var spY = shotSpNorm * shY[m] / en.s;
									en.shots.push({
										x: en.x + shX[m] - midPosX,
										y: en.y + shY[m] - midPosY,
										spX: spX,
										spY: spY
									});
								}
								en.actInv = 0;
							}
						}
						break;
				}
				/*action*/
				if (en.x <= canv.width + 200 &&
					en.x >= 0 - 200 && en.y >= 0 - 200 &&
					en.y <= canv.height + 200 && en.sh < 2) {
					if (en.x < player.x) {
						en.x += en.sp;
					} else if (en.x > player.x) {
						en.x -= en.sp;
					}
					if (en.y < player.y) {
						en.y += en.sp;
					} else if (en.y > player.y) {
						en.y -= en.sp;
					}

				}

				if (en.x + en.s / 2 >= player.x - player.size / 2 &&
					en.x + en.s / 2 <= player.x + player.size / 2 ||
					en.x - en.s / 2 <= player.x + player.size / 2 &&
					en.x - en.s / 2 >= player.x - player.size / 2) {
					if (en.y + en.s / 2 >= player.y - player.size / 2 &&
						en.y + en.s / 2 <= player.y + player.size / 2 ||
						en.y - en.s / 2 <= player.y + player.size / 2 &&
						en.y - en.s / 2 >= player.y - player.size / 2) {
						var dmg = en.dmg - player.armorHp;
						if (dmg < 1) {
							dmg = 1;
						}
						player.hp -= dmg;

						if (player.x > en.x) {
							midPosX -= en.k;
							enemyPos(-en.k, 0);
						} else if (player.x < en.x) {
							midPosX += en.k;
							enemyPos(en.k, 0);
						}
						if (player.y > en.y) {
							midPosY -= en.k;
							enemyPos(0, -en.k);
						} else if (player.y < en.y) {
							midPosY += en.k;
							enemyPos(0, en.k);
						}
					}
				}

				if (en.sh == 1) {
					if (en.x < canv.width &&
						en.x > 0 && en.y > 0 &&
						en.y < canv.height) {
						en.actInv = en.actInv + 1;
						if (en.actInv > 2000 / drawSp) {
							en.shots.push({
								x: en.x - midPosX,
								y: en.y - midPosY,
								spX: mspX,
								spY: mspY
							});
							en.actInv = 0;
						}
					}
				}
				if (en.shots.length > 0) {
					for (g = 0; g < en.shots.length; g++) {
						var shX = en.shots[g].x + midPosX;
						var shY = en.shots[g].y + midPosY;
						en.shots[g].x += en.shots[g].spX;
						en.shots[g].y += en.shots[g].spY;
						ctx.beginPath();
						ctx.arc(shX, shY, en.s / 10,
							Math.PI * 2, false);
						ctx.fillStyle = "#F00000";
						ctx.strokeStyle = "#FFF";
						ctx.fill();
						ctx.stroke();
						ctx.closePath();
						if (shX >= player.x - player.size / 2 &&
							shX <= player.x + player.size / 2 &&
							shY >= player.y - player.size / 2 &&
							shY <= player.y + player.size / 2) {
							var dmg = en.dmg - player.armorHp;
							if (dmg < 1) {
								dmg = 1;
							}
							player.hp -= dmg;
							en.shots = removeArrItem(en.shots, g);
						}
						if (shX < player.x - 500 ||
							shY < player.y - 500 ||
							shX > player.x + 500 ||
							shY > player.y + 500) {
							en.shots = removeArrItem(en.shots, g);
						}
					}
				}
			}
		}
		if (en.hp <= 0) {
			en.exs = 0;
		}
		en.x = en.x - midPosX;
		en.y = en.y - midPosY;
	}
}

function spawnEnemy() {
	if (play == true) {
	    var x;
	    var y;
		if (enemyNr < 20) {
			var n = Math.random() * 10;
			var g = Math.random() * 10;
			if (n <= 2.5) {
				x = Math.random() * canv.width;
				y = -100;
			} else if (n <= 5) {
				x = canv.width + 100;
				y = Math.random() * canv.height;
			} else if (n <= 7.5) {
				x = Math.random() * canv.width;
				y = canv.height + 100;
			} else {
				x = 0 - 100;
				y = Math.random() * canv.height;
			}
			x = x - midPosX;
			y = y - midPosY;
			if (world == 0) {
				if (night == true) {
					if (g <= 4) {
						var r = 1;
						var size = player.size;
						var d = 5;
						var sp = player.sp / 3;
						var hp = 3;
						var knb = 15;
						var sh = 0;
					} else if (g <= 7) {
						var r = 3;
						var size = player.size;
						var d = 5;
						var sp = player.sp / 10;
						var hp = 7;
						var knb = 5;
						var sh = 2;
					} else if (g <= 10) {
						var r = 2;
						var size = player.size * 2;
						var d = 15;
						var sp = player.sp / 6;
						var hp = 15;
						var knb = 25;
						var sh = 1;
					}
					enemy.push({
						x: x,
						y: y,
						r: r,
						s: size,
						hp: hp,
						dmg: d,
						k: knb,
						sp: sp,
						w: world,
						sh: sh,
						shots: [],
						actInv: 0,
						hit: 0,
						exs: 1
					});
				}
				if (day == true) {
					for (i = 0; i < enemy.length; i++) {
						if (enemy[enemy.length - 1].exs == 0) {
							enemy.shift();
						}
					}
				}
			}
			if (world == 1) {
				if (g <= 10) {
					var r = 4;
					var size = player.size;
					var d = 4;
					var sp = 2;
					var hp = 30;
					var knb = 30;
					var sh = 2;
				}
				enemy.push({
					x: x,
					y: y,
					r: r,
					s: size,
					hp: hp,
					dmg: d,
					k: knb,
					sp: sp,
					w: world,
					sh: sh,
					shots: [],
					actInv: 0,
					hit: 0,
					exs: 1
				});
			}
			enemyNr++;
		}
	}
}

function enemyPos(x, y) {
	for (var m = 0; m < enemy.length; m++) {
		enemy[m].x += x;
		enemy[m].y += y;
	}
}

function move(side) {
	if (animP == 0) {
		animP = 1;
		if (side == 3 || side == 4) {
			leg1X = player.x - player.size * 0.4;
			leg2X = player.x + player.size * 0.05;
			leg1Y = player.y - player.size * 0.175;
			leg2Y = player.y - player.size * 0.175;
			arm1X = player.x - player.size * 0.95;
			arm2X = player.x + player.size * 0.55;
			arm1Y = player.y - player.size * 0.2;
			arm2Y = player.y - player.size * 0.2;
		} else {
			leg1X = player.x - player.size * 0.175;
			leg2X = player.x - player.size * 0.175;
			leg1Y = player.y - player.size * 0.4;
			leg2Y = player.y + player.size * 0.05;
			arm1X = player.x - player.size * 0.2;
			arm2X = player.x - player.size * 0.2;
			arm1Y = player.y - player.size * 0.95;
			arm2Y = player.y + player.size * 0.55;
		}
	}
	switch (side) {
		case 1:
			leftS = true;
			faceS = 4;
			midPosX += player.size / 3;
			break;
		case 2:
			rightS = true;
			faceS = 2;
			midPosX -= player.size / 3;
			break;
		case 3:
			upS = true;
			faceS = 1;
			midPosY += player.size / 3;
			break;
		case 4:
			downS = true;
			faceS = 3;
			midPosY -= player.size / 3;
			break;
	}
}

function stop(side) {
	animP = 0;
	switch (side) {
		case 1:
			leftS = false;
			break;
		case 2:
			rightS = false;
			break;
		case 3:
			upS = false;
			break;
		case 4:
			downS = false;
			break;

	}
}

function action() {
	attax = true;
	if (mItem == 0) {
		for (var i = 0; i < enemy.length; i++) {
			var enX = enemy[i].x + midPosX;
			var enY = enemy[i].y + midPosY;
			if (faceS == 3 || faceS == 1) {
				if (player.x - player.size <= enX &&
					player.x + player.size >= enX) {
					if (faceS == 3 &&
						player.y < enY &&
						player.y + player.size / 2 + player.reach >= enY - enemy[i].s / 2) {
						enemy[i].hp -= player.dmg;
						enemy[i].y += player.knb;
						enemy[i].hit = 1;
					} else if (faceS == 1 &&
						player.y > enY &&
						player.y - player.size / 2 -
						player.reach < enY + enemy[i].s / 2) {
						enemy[i].hp -= player.dmg;
						enemy[i].y -= player.knb;
						enemy[i].hit = 1;
					}

				}
			} else if (faceS == 2 || faceS == 4) {
				if (player.y + player.size >= enY &&
					player.y - player.size <= enY) {
					if (faceS == 2 &&
						player.x <= enX &&
						player.x + player.size / 2 + player.reach >= enX - enemy[i].s / 2) {
						enemy[i].hp -= player.dmg;
						enemy[i].x += player.knb;
						enemy[i].hit = 1;
					} else if (faceS == 4 &&
						player.x > enX &&
						player.x - player.size / 2 -
						player.reach < enX + enemy[i].s / 2) {
						enemy[i].hp -= player.dmg;
						enemy[i].x -= player.knb;
						enemy[i].hit = 1;
					}
				}
			}
		}
		if (world == 0) {
			for (var i = 0; i < treePos.length; i++) {
				var t = treePos[i];
				if (t.exs == 1) {
					if (player.x >= midPosX + t.x &&
						player.x <= midPosX + t.x + t.s &&
						player.y >= midPosY + t.y &&
						player.y <= midPosY + t.y + t.s) {
						t.l -= 1;
					}
				}
			}
			for (var i = 0; i < rockPos.length; i++) {
				var r = rockPos[i];
				if (r.exs == 1) {
					if (r.x + midPosX > player.x - player.size &&
						r.x + midPosX < player.x + player.size &&
						r.y + midPosY > player.y - player.size &&
						r.y + midPosY < player.y + player.size) {
						if (player.minePow >= r.r) {
							r.l -= 1;
						}
					}
				}
			}
		} else if (world == 1) {

		}
	} else if (mItem == 1) {
		var x = 0;
		var y = 0;
		var s = player.size / 4;
		switch (faceS) {
			case 1:
				x = player.x + player.size / 4;
				y = player.y - player.size / 2 - s / 2;
				break;
			case 2:
				x = player.x + player.size / 2 + s / 2;
				y = player.y + player.size / 4;
				break;
			case 3:
				x = player.x - player.size / 4;
				y = player.y + player.size / 2 + s / 2;
				break;
			case 4:
				x = player.x - player.size / 2 - s / 2;
				y = player.y - player.size / 4;
				break;
		}
		var col = getMineral(player.weapon[0], 1);
		var l = player.weapon[0];
		placedB.push({
			x: x - midPosX,
			y: y - midPosY,
			u: col,
			s: s,
			l: l,
			w: world
		});
		for (var i = 0; i < items.length; i++) {
			if (items[i].t == 11) {
				if (items[i].u == player.weapon[0]) {
					items[i].c -= 1;
					if (items[i].c <= 0) {
						mItem = 0;
						player.weapon[0] = 0;
					}
				}
			}
		}
		updateInventory();
		updateRecipes(1);
	}
}

document.addEventListener('keydown', function(event) {
	var x = event.keyCode;
	if (x == 87) {
		move(3);
	} else if (x == 83) {
		move(4);
	}
	if (x == 65) {
		move(1);
	} else if (x == 68) {
		move(2);
	}

});

document.addEventListener('keyup', function(event) {
	var x = event.keyCode;

	if (x == 87) {
		stop(3);
	} else if (x == 83) {
		stop(4);
	}
	if (x == 65) {
		stop(1);
	} else if (x == 68) {
		stop(2);
	}

	if (x == 70) {
		action();
	}
	if (x == 71) {
		showW(craftG, 0);
	}

});

function craftM() {
	var cL = craftLos.length;
	for (var i = 0; i < cL; i++) {
		for (var k = 0; k < items.length; k++) {
			if (craftLos[i].n == items[k].n) {
				items[k].c -= craftLos[i].c;
			}
		}
	}
	for (var g = 0; g < recipes.length; g++) {
		if (craftLos[0].m == recipes[g].m) {
			items.push({
				n: recipes[g].n,
				c: 1,
				t: recipes[g].t,
				u: recipes[g].u,
				e: 0,
				inf: recipes[g].inf
			});
		}
	}
	craftLos = [];
	pickC.innerHTML = "Item";
	matC.innerHTML = "Materials";
	updateInventory();
	updateRecipes(1);
}

function equipM(itm, tip) {
	var itk = [];
	if (itm < 11) {
		mItem = 0;
		for (var i = 0; i < items.length; i++) {
			if (itm == items[i].t &&
				tip == items[i].u) {
				itk = items[i].inf;
			}
		}
		switch (itm) {
			case 1:
				if (player.weapon[0] != tip) {
					player.weapon[0] = tip;
					drawPlayer();
					player.weapon[1] = itk[0];
					player.knb = itk[1];
					player.minePow = 1 + itk[3];
					player.reach = itk[2];
				} else {
					player.weapon[0] = 0;
					player.weapon[1] = 0;
					player.knb = 2;
					player.reach = 5;
					player.minePow = 2;
				}
				break;
			case 2:
				if (player.helm[0] != tip) {
					player.helm[0] = tip;
					player.helm[1] = itk[2];
					player.helm[2] = itk[3];
					player.helm[3] = itk[0];
				} else {
					player.helm[0] = 0;
					player.helm[1] = 0;
					player.helm[2] = 0;
					player.helm[3] = 0;
				}
				break;
			case 3:
				if (player.chPlat[0] != tip) {
					player.chPlat[0] = tip;
					player.chPlat[1] = itk[2];
					player.chPlat[2] = itk[3];
					player.chPlat[3] = itk[0];
				} else {
					player.chPlat[0] = 0;
					player.chPlat[1] = 0;
					player.chPlat[2] = 0;
					player.chPlat[3] = 0;
				}
				break;
			case 4:
				if (player.gloves[0] != tip) {
					player.gloves[0] = tip;
					player.gloves[1] = itk[2];
					player.gloves[2] = itk[3];
					player.gloves[3] = itk[0];
				} else {
					player.gloves[0] = 0;
					player.gloves[1] = 0;
					player.gloves[2] = 0;
					player.gloves[3] = 0;
				}
				break;
			case 5:
				if (player.legns[0] != tip) {
					player.legns[0] = tip;
					player.legns[1] = itk[2];
					player.legns[2] = itk[3];
					player.legns[3] = itk[0];
				} else {
					player.legns[0] = 0;
					player.legns[1] = 0;
					player.legns[2] = 0;
					player.legns[3] = 0;
				}
				break;
			case 6:
				if (player.boots[0] != tip) {
					player.boots[0] = tip;
					player.boots[1] = itk[2];
					player.boots[2] = itk[3];
					player.boots[3] = itk[0];
				} else {
					player.boots[0] = 0;
					player.boots[1] = 0;
					player.boots[2] = 0;
					player.boots[3] = 0;
				}
				break;
		}
		player.armorHp = player.helm[1] + player.chPlat[1] + player.gloves[1] + player.legns[1] + player.boots[1];

		player.hp = baseHp + player.helm[2] + player.chPlat[2] + player.gloves[2] + player.legns[2] + player.boots[2];

		player.dmg = 1 + player.weapon[2] + player.helm[3] + player.chPlat[3] + player.gloves[3] + player.legns[3] + player.boots[3];
	} else if (itm >= 11) {
		mItem = 1;
		player.weapon[0] = tip;
		player.weapon[1] = itm;
	}


}

function draw() {
	if (play == true) {
		real1Sec += drawSp / 1000;
		ctx.clearRect(0, 0, canv.width, canv.height);
		drawBorder();
		if (world == 0) {
			drawMinerals(rockPos,
				midPosX, midPosY, 0);
		} else if (world == 1) {
			drawMinerals(lavaGems,
				midPosX, midPosY, 1);
		}
		drawPlacedB();
		drawEnemy();
		drawPlayer();
		if (world == 0) {
			drawThings(treePos,
				midPosX, midPosY, 0);
		} else if (world == 1) {
			drawThings(hellRocks,
				midPosX, midPosY, 1);
		}
		if (world == 0) {
			dayNightCycle(0);
		} else if (world == 1) {
			dayNightCycle(1);
		}
		drawHealth();
		if (rightS == true) {
			if (leg1X > player.x + player.size * 0.325) {
				animP = 2;
			}
			if (leg1X < player.x - player.size * 0.625) {
				animP = 1;
			}
			if (animP == 1) {
				leg1X += player.sp / 10;
				leg2X -= player.sp / 10;
				arm1X -= player.sp / 20;
				arm2X += player.sp / 20;

			}
			if (animP == 2) {
				leg1X -= player.sp / 10;
				leg2X += player.sp / 10;
				arm1X += player.sp / 20;
				arm2X -= player.sp / 20;
			}
			if (faceS == 4) {
				midPosX = midPosX - player.sp / 2;
			} else {
				midPosX = midPosX - player.sp;
			}
			/*enemyPos(-player.sp,0);*/
		}
		if (leftS == true) {
			if (leg2X < player.x - player.size * 0.625) {
				animP = 2;
			}
			if (leg2X > player.x + player.size * 0.325) {
				animP = 1;
			}
			if (animP == 1) {
				leg1X += player.sp / 10;
				leg2X -= player.sp / 10;
				arm1X -= player.sp / 20;
				arm2X += player.sp / 20;
			}
			if (animP == 2) {
				leg1X -= player.sp / 10;
				leg2X += player.sp / 10;
				arm1X += player.sp / 20;
				arm2X -= player.sp / 20;
			}
			if (faceS == 2) {
				midPosX = midPosX + player.sp / 2;
			} else {
				midPosX = midPosX + player.sp;
			}
			/*enemyPos(player.sp,0);*/
		}

		if (upS == true) {
			if (leg1Y < player.y - player.size * 0.625) {
				animP = 2;
			}
			if (leg1Y > player.y + player.size * 0.325) {
				animP = 1;
			}
			if (animP == 1) {
				leg1Y -= player.sp / 10;
				leg2Y += player.sp / 10;
				arm1Y += player.sp / 20;
				arm2Y -= player.sp / 20;
			}
			if (animP == 2) {
				leg1Y += player.sp / 10;
				leg2Y -= player.sp / 10;
				arm1Y -= player.sp / 20;
				arm2Y += player.sp / 20;
			}
			if (faceS == 3) {
				midPosY = midPosY + player.sp / 2;
			} else {
				midPosY = midPosY + player.sp;
			}
			/*enemyPos(0,player.sp);*/
		}
		if (downS == true) {
			if (leg2Y > player.y + player.size * 0.325) {
				animP = 2;
			}
			if (leg2Y < player.y - player.size * 0.625) {
				animP = 1;
			}
			if (animP == 1) {
				leg1Y -= player.sp / 10;
				leg2Y += player.sp / 10;
				arm1Y += player.sp / 20;
				arm2Y -= player.sp / 20;
			}
			if (animP == 2) {
				leg1Y += player.sp / 10;
				leg2Y -= player.sp / 10;
				arm1Y -= player.sp / 20;
				arm2Y += player.sp / 20;
			}
			if (faceS == 1) {
				midPosY = midPosY - player.sp / 2;
			} else {
				midPosY = midPosY - player.sp;
			}
			/*enemyPos(0,-player.sp);*/
		}

		if (attax == true) {
			switch (faceS) {
				case 1:
					arm2X -= player.sp * 0.1;
					arm2Y -= player.sp * 0.2;
					if (arm2Y < player.y - player.size / 4 - armW) {
						attax = false;
						arm2X = player.x + player.size * 0.55;
						arm2Y = player.y - player.size * 0.2;
					}
					break;
				case 2:
					arm2X += player.sp * 0.2;
					arm2Y -= player.sp * 0.1;
					if (arm2X > player.x + player.size / 4) {
						attax = false;
						arm2X = player.x - player.size * 0.2;
						arm2Y = player.y + player.size * 0.55;
					}
					break;
				case 3:
					arm1X += player.sp * 0.1;
					arm1Y += player.sp * 0.2;
					if (arm1Y > player.y + player.size / 4) {
						attax = false;
						arm1X = player.x - player.size * 0.95;
						arm1Y = player.y - player.size * 0.2;
					}
					break;
				case 4:
					arm1X -= player.sp * 0.2;
					arm1Y += player.sp * 0.1;
					if (arm1X < player.x - player.size / 4 - armW) {
						attax = false;
						arm1X = player.x - player.size * 0.2;
						arm1Y = player.y - player.size * 0.95;
					}
					break;
			}
		}
		if (real1Sec >= 1) {
			real1Sec = 0;
		}

		if (player.hp <= 0) {
			losx.style.display = "block";
			play = false;
		}
	}
}

setInterval(spawnEnemy, 7000);
setInterval(draw, drawSp);
    </script> 
    </body>
</html>
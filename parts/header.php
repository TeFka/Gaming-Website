<body>
	<div class='container'>
        <div id="daHeader">
		<div>
			<h1><a href='../index.php' id='go'>Go</a>Games</h1>
			</div>
			<nav>
			<ul>
			<li><a class="link" href=''>Contact</a></li>
			<li><a class="link" href=''>About</a></li>
			<li><a class="link" href=''>Support</a></li>
			<li><button class = "buttn"  onClick="form(1)">Log in</button></li>
			<li><button class = "buttn" onClick="form(2)">Register</button></li>
			</ul>
			</nav>
        </div>
		</div>
		<script>
		var logIn = document.getElementById("login");
		var regist = document.getElementById("register");
		var g = document.getElementById("go");
		function form(num){
			if(num==1){
				logIn.style.display ="block";
				g.style.color = "#FF0000";
			}
			if(num==2){
				regist.style.display = "block";	
			}
		}
		</script>

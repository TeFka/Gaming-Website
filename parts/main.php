
<?php 

//people
$pass = $email = $nickname = '';
$errors = array('email'=>'','nickname'=>'','password'=>'');
//echo $_SERVER['PHP_SELF'].'<br />';
	$daSq = mysqli_connect('localhost', 'admin', 'something123', 'players');
	if(!$daSq){
	  echo 'no database: '.mysqli_connect_error;
  }
if(isset($_POST['submit'])){
	if(empty($_POST['email'])){
		$errors['email'] = " missing email<br />";
	}
	else{
		$email = $_POST['email'];
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$errors['email'] = "Invalid input";
		}
		else{
			echo htmlspecialchars($_POST['email']).'<br />';
		}
	}
	if(empty($_POST['nickname'])){
		$errors['nickname'] = " missing nickname";
	}
	else{
		$nick = $_POST['nickname'];
		if(!preg_match('/^[a-zA-Z\s]+$/',$nick)){
			$errors['nickname'] = "Invalid input";
		}
		else{
			echo htmlspecialchars($_POST['nickname']).'<br />';
		}
	}
	if(empty($_POST['password'])){
	$errors['password'] = " missing password";
	}
	else{
		$password = $_POST['password'];
		if(!preg_match('/^[0-9]+$/',$password)){
			$errors['password'] = "invalid input<br />";
		}
		else{
			echo htmlspecialchars($_POST['password']).'<br />';
		}
	echo htmlspecialchars($_POST['password']).'<br />';
	}
	
	if(array_filter($errors)){
		echo "Error";
	}
	else{
		$email = mysqli_real_escape_string($daSq,$_POST['email']);
		$nickname = mysqli_real_escape_string($daSq,$_POST['nickname']);
		$password = mysqli_real_escape_string($daSq,$_POST['password']);
		
		$sql = "INSERT INTO players(nickname,email,password,points,rank) VALUES('
		$email','$nickname','$password', 100,'new')";
		//save and check
		
		if(!mysqli_query($daSq,$sql)){
		echo "Error: ".mysqli_error($sql);
		}
		else{
			echo "Good enough";
		}
		header("location: index.php");
	}
}
	
  //check
  $sqData = 'SELECT nickname,email,password, points, rank,ID FROM playerinfo';
  
  //query
  
  $rez = mysqli_query($daSq, $sqData);
  
  //fetch rez
  
  $people = mysqli_fetch_all($rez,MYSQLI_ASSOC);
  
  mysqli_free_result($rez);
  mysqli_close($daSq);
  
  //games
  $name = $author = $theme = '';
$errors = array('name'=>'','author'=>'','theme'=>'');
//echo $_SERVER['PHP_SELF'].'<br />';
	$daSq = mysqli_connect('localhost', 'admin', 'something123', 'games');
	if(!$daSq){
	  echo 'no database: '.mysqli_connect_error;
  }
if(isset($_POST['submit'])){
	if(empty($_POST['name'])){
		$errors['name'] = " missing email<br />";
	}
	else{
		$name = $_POST['name'];
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$errors['name'] = "Invalid input";
		}
		else{
			echo htmlspecialchars($_POST['name']).'<br />';
		}
	}
	if(empty($_POST['author'])){
		$errors['author'] = " missing author";
	}
	else{
		$nick = $_POST['author'];
		if(!preg_match('/^[a-zA-Z\s]+$/',$nick)){
			$errors['author'] = "Invalid input";
		}
		else{
			echo htmlspecialchars($_POST['author']).'<br />';
		}
	}
	if(empty($_POST['theme'])){
	$errors['theme'] = " missing theme";
	}
	else{
		$pass = $_POST['theme'];
		if(!preg_match('/^[0-9]+$/',$pass)){
			$errors['theme'] = "invalid input<br />";
		}
		else{
			echo htmlspecialchars($_POST['theme']).'<br />';
		}
	echo htmlspecialchars($_POST['theme']).'<br />';
	}
	
	if(array_filter($errors)){
		echo "Error";
	}
	else{
		$name = mysqli_real_escape_string($daSq,$_POST['name']);
		$author = mysqli_real_escape_string($daSq,$_POST['author']);
		$theme = mysqli_real_escape_string($daSq,$_POST['theme']);
		
		$sql = "INSERT INTO games(name,author,theme) VALUES('$name','$author','$theme')";
		//save and check
		
		if(!mysqli_query($daSq,$sql)){
		echo "Error: ".mysqli_error($sql);
		}
		else{
			echo "Good enough";
		}
		header("location: index.php");
	}
}
	
  //check
  $sqData = 'SELECT name,author,theme FROM gameinfo';
  
  //query
  
  $rez = mysqli_query($daSq, $sqData);
  
  //fetch rez
  
  $games = mysqli_fetch_all($rez,MYSQLI_ASSOC);
  
  mysqli_free_result($rez);
  mysqli_close($daSq);
  
?>

<div class = "container">
<div id="main">
<div id="mainL">
	<h1>News</h1>
	<a href=""><img src="../img/download.jfif"/></a>
	<a href=""><img src="../img/downloadx.jfif"/></a>
	<a href=""><img src="../img/downloady.jfif"/></a>
	<a href=""><img src="../img/downloadn.png"/></a>
	<a href=""><img src="../img/images.jfif"/></a>
</div>
<div id="mainM">

<div id = "login">
<?php include('./parts/logIn.php'); ?>
</div>
<div id = "register">  
<?php include('./parts/register.php'); ?>
</div>

<div class="front">
	<h1>The games</h1>
	<div id = "gameList">
	<?php foreach($games as $game){ ?>
	
			<div class = "playGame">
				<h4><?php echo $game['name']?></h4>
				<a href = "games/<?php echo $game['name']?>.php"><img src="./resources/<?php echo $game['name']?>.png" /></a>
			</div>
		  <?php } ?>
	</div>
</div>

</div>
<div id="mainR">
<h1>Other gamers</h1>
<div id = "peopleList">
	<?php foreach($people as $person){ ?>
			<div class = "visitPerson">
				<img src="../img/yes.png" /> 
				<a href = "parts/personDetails.php?ID=<?php echo $person['ID']?>"><?php echo $person['nickname']?></a>
			</div>
		  <?php } ?>
</div>
</div>
</div>
</div>
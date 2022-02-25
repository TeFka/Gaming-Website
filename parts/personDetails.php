<?php  
$daSq = mysqli_connect('localhost', 'admin', 'something123', 'players');
	if(!$daSq){
	  echo 'error';
	}
	if(isset($_POST['del'])){
		
		$IDToDel = mysqli_real_escape_string($daSq,$_POST['delID']);
		
		$sql = "DELETE FROM playerinfo WHERE ID = $IDToDel";
		
		if(!mysqli_query($daSq,$sql)){
			echo "Error:".mysqli_error($daSq);
		}
		else{
			echo "all good";
			header('Location: ../index.php');
		}
	}
	if(isset($_GET['ID'])){
		$id = mysqli_real_escape_string($daSq,$_GET['ID']);
		$sqData = "SELECT * FROM playerinfo WHERE ID =$id";
		$results = mysqli_query($daSq,$sqData);
		
		$player = mysqli_fetch_assoc($results);
		
		mysqli_free_result($results);
		mysqli_close($daSq);
		/*print_r($player);*/
	}
	else{
		echo "Error bam";
	}

?>

<html>
<head>
   <link rel = 'stylesheet' href = '../siteCSS.css' />
	<title>the Site</title>
</head>
<?php include('./header.php'); ?>
<div class = "container">
<div id="profile">
<h1><?php echo $player['nickname'];?></h1>
<div><h3><?php echo $player['rank'];?></h3><h3>Points: <?php echo $player['points'];?></h3></div>
<h4><?php echo $player['email'];?></h4>
</div>
</div>
<div class = "container">
<form action="personDetails.php" method="POST">

<input type="hidden" name="delID" value="<?php echo $player['ID'];?>"> 
<input type="submit" name="del" value="delete">
</form>

</div>

<?php include('./bottomFotter.php'); ?>
</html>
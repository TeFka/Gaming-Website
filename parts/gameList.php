


<div class = "container">
<h1>Games</h1>
<div id = "peopleList">
	<?php foreach($douches as $douche){ ?>
			<div class = "personInList">
			<div class = "persQuickInfo">
			
			</div>
			<div class = "visitPerson">
				<a href = "parts/personDetails.php?id=<?php echo $douche['id']?>">Visit</a>
			</div>
			</div>
		  <?php } ?>
</div>
</div>
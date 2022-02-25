<div class = "form">
	<h3>Register</h3>
<form id = "registerForm" action="index.php" method="POST">
<label>Email</label>
<input type = "text" name = "email">
<div class = "errorMsg"><?php echo $errors['email']; ?></div>
<label>Nickname</label>
<input type = "text" name = "nick">
<div class = "errorMsg"><?php echo $errors['nickname']; ?></div>
<label>password</label>
<input type = "password" name = "pass">
<div class = "errorMsg"><?php echo $errors['password']; ?></div>
<input type="submit" name="submit" value="submit" >
</form>
</div>
<script>
var logIn = document.getElementById("logIn");
function closL(){
	logIn.style.display = "none";
}
</script>
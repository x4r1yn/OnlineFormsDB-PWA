<?php
@session_start();
if( !empty($_SESSION['user_login']) && $_SESSION['login_status'] == 1){
		include 'detect/user_agents.php';
		$detect = new UserAgent();
		if($detect->is_mobile()){
			header("Location: mobile-panel.php");
		}else{
			header("Location: panel.php");
		}
	
	die();
}

set_include_path ('includes');
include 'details.php';
include 'header.php';

?>

<div id="main" class="clearfix">
	<div class="box clearfix">
		<div id="loginpage">
			<div class="head-title">
			<a href="index.php"><img src="images/logo.png"></a>
			<div class="title">
					<h1>FORM</h1>
					<h2>Database</h2>
				</div>
			</div>
			<form id="loginform" action="" method="post">
				<input type="text" id="username" name="username" placeholder="Username"required>
				<input type="password" id="password" name="password" placeholder="Password" required>
				<input type="submit" id="loginbtn" name="login" value="Login">
			</form>
			<p class="forgot_pass"><a href="forgot-password.php">Forgot your password?</a></p>
			<p class="create_user"><a href="index.php"><span>&laquo;</span> Create User</a></p>
			<div class="msg"></div>
			<div class="se-pre-con"></div>
		</div>
	</div>
</div>
</body>
</html>

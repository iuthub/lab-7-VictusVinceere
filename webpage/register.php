<?php  



error_reporting(0);

include('connection.php');
$username = $_REQUEST["username"];
$fullname = $_REQUEST["fullname"];
$email = $_REQUEST["email"];
$pwd = $_REQUEST["pwd"];
$confpassword = $_REQUEST["confirm_pwd"];

$isPost = $_SERVER["REQUEST_METHOD"]=="POST";
$isGet = $_SERVER["REQUEST_METHOD"]=="GET";

$isFullnameError = $isPost && !preg_match('/^[a-z0-9]{2,}$/i',$fullname);
$isEmailError = $isPost && !preg_match('/^\w+@[a-zA-Z]+?\.[a-zA-Z]{2,3}$/', $email);
$isUsernameError = $isPost && !preg_match('/^[a-z0-9-]{5,}$/i',$username);
$isPasswordError = $isPost && !preg_match('/^[a-z0-9]{8,}$/i',$pwd);
$isConfpasswordError = $isPost && $pwd != $confpassword;

$isFormError = $isNameError || $isEmailError || $isUsernameError || $isPasswordError || $isConfpasswordError;
?>






<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>My Blog - Registration Form</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
	</head>
	
	<body>
		<?php include('header.php'); ?>
			<?php if($isGet || $isFormError) { ?>

		<h2>User Details Form</h2>
		<h4>Please, fill below fields correctly</h4>
		<form action="register.php" method="post">
				<ul class="form">
					<li>
						<label for="username">Username <span class="error"><?=$isUsernameError? " At least five characters":""?></span></label>
						<input type="text" name="username" id="username" required/>
					</li>
					<li>
						<label for="fullname">Full Name <span class="error"><?=$isFullnameError? " At least two characters":""?></span></label>
						<input type="text" name="fullname" id="fullname" required/>
					</li>
					<li>
						<label for="email">Email</label>
						<input type="email" name="email" id="email" />
					</li>
					<li>
						<label for="pwd">Password<span class="error"><?=$isPasswordError? " At least 8 characters with numbers":""?></span></label>
						<input type="password" name="pwd" id="pwd" required/>
					</li>
					<li>
						<label for="confirm_pwd">Confirm Password <span class="error"><?=$isConfpasswordError? "Repeat password correctly":""?></span></label>
						<input type="password" name="confirm_pwd" id="confirm_pwd" required />
					</li>
					<li>
						<input type="submit" value="Submit" /> &nbsp; Already registered? <a href="index.php">Login</a>
					</li>
				</ul>
		</form>
		<?php } else { 

		
		try{	
		
			$blogdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$regs = $blogdb->prepare("INSERT INTO USERS (username, fullname, email, password) VALUES (?, ?, ?, ?)");
			$regs -> bindParam(1, $username);
			$regs -> bindParam(2, $fullname);
			$regs -> bindParam(3, $email);
			$regs -> bindParam(4, $pwd);
			$regs -> execute();
		 }catch(PDOException $ex)  { ?>
	
	<p>Sorry, a database error occured. Please try again later.</p>
	<p>(Error details: <?= $ex->getMessage()?>)</p>

<?php } ?>

		<?php 
		   header('Location: index.php');
		   exit();
         } ?>
	</body>
</html>
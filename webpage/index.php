<?php
error_reporting(0);
include('connection.php');
session_start();

$checked =$_REQUEST["remember"];
$username = $_REQUEST["username"];
$pwd = $_REQUEST["pwd"];
$title = $_REQUEST["title"];
$body = $_REQUEST["body"];
$publishDate = date("Y-m-d");
$username = $blogdb->quote($username);
$pwd = $blogdb->quote($pwd);
$count = $blogdb->query("SELECT COUNT(*) FROM users WHERE username=$username AND password =$pwd")->fetchColumn();
$stmt = $blogdb->prepare("SELECT id FROM users WHERE username=$username AND password = $pwd");
$userId = $stmt->fetchAll();

var_dump($userId);

if(isset($checked)){
	setcookie("username", $username, time()+60*60*24*365);
} else{
	setcookie("username", "", time()-1);
}


if($count==1){
	$_SESSION["username"] = $username;
} else {
	$error = True;

}

if(isset($_GET["logout"])){
	$_SESSION["username"] = NULL;
	$error = False;
	session_destroy();
}



$posts = $blogdb->prepare("INSERT INTO posts (title, body, publishDate,userId) VALUES (?, ?, ?, ?)");
			$posts -> bindParam(1, $title);
			$posts -> bindParam(2, $body);
			$posts -> bindParam(3, $publishDate);
			$posts -> bindParam(4, $userId);
			$posts -> execute();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>My Personal Page</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
	</head>
	
	<body>
		<?php include('header.php'); ?>
		<!-- Show this part if user is not signed in yet -->
		<?php if( !isset($_SESSION["username"])){?>
		<div class="twocols">
			<form action="index.php" method="post" class="twocols_col">
				<ul class="form">
					<li>
						<label for="username">Username<span class="error"><?=$error? "Your login or password is invalid":""?></span></label>
						<input type="text" name="username" id="username" value=<?=$_COOKIE["username"]?>/>
					</li>
					<li>
						<label for="pwd">Password</label>
						<input type="password" name="pwd" id="pwd" />
					</li>
					<li>
						<label for="remember">Remember Me</label>
						<input type="checkbox" name="remember" id="remember" checked />
					</li>
					<li>
						<input type="submit" value="Submit" /> &nbsp; Not registered? <a href="register.php">Register</a>
					</li>
				</ul>
			</form>
			<div class="twocols_col">
				<h2>About Us</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur libero nostrum consequatur dolor. Nesciunt eos dolorem enim accusantium libero impedit ipsa perspiciatis vel dolore reiciendis ratione quam, non sequi sit! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio nobis vero ullam quae. Repellendus dolores quis tenetur enim distinctio, optio vero, cupiditate commodi eligendi similique laboriosam maxime corporis quasi labore!</p>
			</div>
		</div>
		<?php } else { ?>
		<!-- Show this part after user signed in successfully -->
		<div class="logout_panel"><a href="register.php">My Profile</a>&nbsp;|&nbsp;<a href="index.php?logout=1">Log Out</a></div>
		<h2>New Post</h2>
		<form action="index.php" method="post">
			<ul class="form">
				<li>
					<label for="title">Title</label>
					<input type="text" name="title" id="title" />
				</li>
				<li>
					<label for="body">Body</label>
					<textarea name="body" id="body" cols="30" rows="10"></textarea>
				</li>
				<li>
					<input type="submit" value="Post" />
				</li>
			</ul>
		</form>
		<div class="onecol">
			<div class="card">
				<h2>TITLE HEADING</h2>
				<h5>Author, Sep 2, 2017</h5>
				<p>Some text..</p>
				<p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
			</div>
			<div class="card">
				<h2>TITLE HEADING</h2>
				<h5>Author, Sep 2, 2017</h5>
				<p>Some text..</p>
				<p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
			</div>
		</div>
	<?php } ?>
	</body>
</html>
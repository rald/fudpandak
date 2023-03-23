<?php

session_start();

include "config.php";

$email="";
$password="";
$msg="";
   
if(isset($_POST['submit'])) {

		if($_POST['submit']=="Register") {
			header('location: register.php');	
		}

		if(!empty($_POST['email'])) $email = $_POST['email'];
	  if(!empty($_POST['password'])) $password = $_POST['password'];

	if(empty($_POST['email'])) {
		$msg="email is empty";
	} else if(empty($_POST['password'])) {
		$msg="password is empty";
	} else {

		$stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE email=? AND password=?");

		mysqli_stmt_bind_param($stmt, "ss", $email, $password);

		mysqli_execute($stmt);

		$result=mysqli_stmt_get_result($stmt);

		$user_matched = mysqli_num_rows($result);

		if ($user_matched > 0) {
    	$row=$result->fetch_assoc();
 			$_SESSION['user_email']=$row['email'];
			$_SESSION['user_role']=$row['role'];
			$_SESSION['user_id']=$row['id'];

			switch($_SESSION['user_role']) {
			case 'Customer':
				header('location: customer_page.php');
				break;
			case 'Rider':
				header('location: rider_page.php');
				break;
			default:
				$msg="Invalid role";
			}
		} else {
			$msg="Invalid email or password";
		}
	}
}
	  
mysqli_close($conn);

?>

<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>

    <center><?=$msg?></center>

		<form method="POST" action="login.php">
			<table align="center">
				<caption><h3>Login</h3></caption>
				<tr>
					<td>			
						<label for="email">Email</label>
					</td>
					<td>
						<input name="email" type="email" placeholder="Email" value="<?=$email?>">
					</td>
				</tr>
				<tr>
					<td>			
						<label for="password">Password</label>
					</td>
					<td colspan="2">			
						<input name="password" type="password" placeholder="Password" value="<?=$password?>">
					</td>
				</td>
				<tr>
					<td colspan="2" align="right">
						<input name="submit" type="submit" value="Register">
						<input type="reset" value="Reset">
						<input name="submit" type="submit" value="Submit">
					</td>
				</tr>
			</table>
		</form>

	</body>
</html>

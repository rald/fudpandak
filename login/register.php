<?php

include "config.php";

$email="";
$role="";
$password1="";
$password2="";
$msg="";
   
if(isset($_POST['submit'])) {

		if($_POST['submit']=="Login") {
			header('location: login.php');	
		}

		if(!empty($_POST['email'])) $email = $_POST['email'];
	  if(!empty($_POST['password1'])) $password1 = $_POST['password1'];
	  if(!empty($_POST['password2'])) $password2 = $_POST['password2'];
	  if(!empty($_POST['role'])) $role = $_POST['role'];

	if(empty($_POST['email'])) {
		$msg="email is empty";
	} else if(empty($_POST['password1'])) {
		$msg="password is empty";
	} else if(empty($_POST['password2'])) {
		$msg="please verify password";
	} else {


		if($password1!=$password2) {
			$msg="passwords dont match";
	  } else {

			$stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE email=? AND password=?");

			mysqli_stmt_bind_param($stmt, "ss", $email, $password1);

			mysqli_execute($stmt);

			$result=mysqli_stmt_get_result($stmt);

			$user_matched = mysqli_num_rows($result);

			if ($user_matched > 0) {
				$msg="Error: User already exists with the email \"$email\".";
			} else {

				$stmt = mysqli_prepare($conn, "INSERT INTO user(email,password,role) VALUES(?,?,?);");

				mysqli_stmt_bind_param($stmt, "sss", $email, $password1, $role);

				mysqli_execute($stmt);

				if(mysqli_affected_rows($conn) > 0) {
					$msg="User registered successfully.";
					$email="";
					$role="";
					$password1="";
					$password2="";
				} else {
					$msg="Registration error. Please try again." . mysqli_error($conn);
				}
			}
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

		<form method="POST" action="register.php">
			<table align="center">
				<caption><h3>Register</h3></caption>
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
						<label for="password1">Password</label>
					</td>
					<td colspan="2">			
						<input name="password1" type="password" placeholder="Password" value="<?=$password1?>">
					</td>
				</td>
				<tr>
					<td>			
						<label for="password2">Verify Password</label>
					</td>
					<td colspan="2">			
						<input name="password2" type="password" placeholder="Verify Password" value="<?=$password2?>">
					</td>
				</td>
				<tr>
					<td>			
						<label for="role">Role</label>
					</td>
					<td>
						<select name="role">
							<option value="Customer" <?=$role=="Customer"?"selected":""?> >Customer</option>
							<option value="Rider" <?=$role=="Rider"?"selected":""?>>Rider</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="right">
						<input name="submit" type="submit" value="Login">
						<input type="reset" value="Reset">
						<input name="submit" type="submit" value="Submit">
					</td>
				</tr>
			</table>
		</form>

	</body>
</html>

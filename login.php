<!DOCTYPE html>
	<head>
			<!-- Latest compiled and minified CSS -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

			<!-- jQuery library -->	
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

			<!-- Latest compiled JavaScript -->	
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

			<link rel="stylesheet" href="css/style.css">

			<title>beautifymycity</title>

			<nav class="navbar-inverse" style="background-color:#1f1f14;">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="homepage.html" style="color:white;"><b><span style="color:#ef0739;font-family:Courier New;">beautify<span style="color:white;">Mycity</span></b></a>
					</div>
						<ul class="nav navbar-nav navbar-right">
      						<li><a id="signup" href="homepage.html"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      						<li><a id="login" href="homepage.html"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      						<li><a id="admin" href="admin.php"><span class="glyphicon glyphicon-bell"></span> Admin</a></li>
   						 </ul>

					
				</div>
			</nav>


	</head>
	<body>
		<h2> Invalid Entry. Go back and try again</h2>
		</body>
		</html>
<?php

$servername="localhost";
	$username="sandra";
	$password="tiger";
	$dbname="beautifymycity";
	
	$conn= new mysqli($servername, $username, $password, $dbname);

    $email=$_POST["email"];
	$password=$_POST["password"];
	$pass=MD5($password);

	$sql= "SELECT * FROM Member where Email_Id='$email'";

	$result= $conn->query($sql);
		
		if ($result->num_rows > 0) 
			{
				while($row = $result->fetch_assoc()) 
					 {
					 	if($row['Password']==$pass)

					 	{
					 		 $_SESSION[''] = $username;
					 		header('Location:userpage.php');
					 	}
					 }

					}
	?>
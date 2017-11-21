Invalid Entry
<?php

$servername="localhost";
	$username="sandra";
	$password="tiger";
	$dbname="beautifymycity";
	
	$conn= new mysqli($servername, $username, $password, $dbname);

    $name=$_POST["name"];
	$password=$_POST["password"];


	$sql= "SELECT * FROM Admin where Username='$name'";

	$result= $conn->query($sql);
		
		if ($result->num_rows > 0) 
			{
				while($row = $result->fetch_assoc()) 
					 {
					 	if($row['Password']==$password)
					 	{
					 		header('Location:dash.php');
					 	}
					 }

					}
	?>
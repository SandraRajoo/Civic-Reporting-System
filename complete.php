<?php

$servername="localhost";
	$username="sandra";
	$password="tiger";
	$dbname="beautifymycity";
	
	$conn= new mysqli($servername, $username, $password, $dbname);

    $id=$_GET['id'];

    $true=1;
    $value="yes";

    $sql="UPDATE alerts SET IsComplete='$true', Completed='$value'   WHERE Alert_Id='$id'";

    if ($conn->query($sql) === TRUE) {
    header('Location:dash.php');
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>

<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

			<!-- jQuery library -->	
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

			<!-- Latest compiled JavaScript -->	
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			<link rel="stylesheet" href="css/style1.css">

<nav class="navbar-inverse" style="background-color:#1f1f14;">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="homepage.html" style="color:white;"><b><span style="color:#ef0739;font-family:Courier New;">beautify<span style="color:white;">Mycity</span></b></a>
                    </div>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a id="signup" href="homepage.html"><span class="glyphicon glyphicon-share"></span> Log Out</a></li>
                            
                         </ul>

                    
                </div>
            </nav>  
</head>

<body>
		
		<form action="" method="post" style="margin-left:490px;padding-top:190px;">
			<h3><b >Traffic Density <select name="traffic"></b></h3>
							<option value="high">High</option>
							<option value="med">Medium</option>
							<option value="low">Low</option>
							</select>
			<br><br>
			<h3><b>Road Condition <select name="road"></b></h3>
							<option value="good">Good</option>
							<option value="bad">Bad</option>
							<option value="worse">Worse</option>
							</select>
			<br><br>		
			<h3><b>Schools and Hospitals near by <select name="SH"></b></h3>
											<option value="many">Many</option>
											<option value="few">Few</option>
											<option value="none">None</option>
											</select>
											<br><br>
			<input type="submit" name="submit" class="btn btn-danger">
			</form>
			
			
</body>
</html>
<?php


$servername="localhost";
	$username="sandra";
	$password="tiger";
	$dbname="beautifymycity";
	
	$conn= new mysqli($servername, $username, $password, $dbname);

    $id=$_GET['id'];
   // echo $id;

    if (isset($_POST['submit']))
    {

    $traffic=$_POST['traffic'];
    //echo $traffic;
    $road=$_POST["road"];
    //echo $road;

    $sh=$_POST["SH"];

    //echo $sh;
   // $priority="Hey";
    //echo $priority;

    if($traffic=='high' || $road=='worse'||$sh=='many')
     	$priority="High";
    
    else if($traffic=='medium'||$road=='bad'||$sh=='few')
    			$priority="Medium";
    
		else if($traffic=='low'||$road=='good'||$sh=='none')
					$priority="Low";
		

		//echo $priority;

		$sql= "UPDATE alerts SET Priority='$priority' WHERE Alert_Id='$id'";

	

		if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
}
$conn->close();
?>
<html>
<body>
<br>
<br><a href="dash.php"><input style="margin-left:1px;" type="button" class="btn btn-danger" value="Go Back"></body></a>
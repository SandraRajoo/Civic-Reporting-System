<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

            <!-- jQuery library --> 
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

            <!-- Latest compiled JavaScript --> 
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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

<form action="" method="post" style="margin-left:480px;padding-top:100px;">
<h3>Are you sure you want to terminate?</h3><select name="sel">
                                        <option value="yes">Yes </option>
                                        <option  value="no">No</option>
                                        </select> <br><br>
<input type="textarea" placeholder="Reason for termination" name="reason"><br><br>
<input type="submit" name="submit" class="btn btn-danger"></input>
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
    //echo $id;

    if (isset($_POST['submit']))
    {

    $value=$_POST['sel'];
    //echo $value;
    $reason=$_POST['reason'];
    //echo $reason;
    $true=1;
if($value=='yes')
{
    

    $sql="UPDATE alerts SET closed='$true' ,close_reason='$reason' WHERE Alert_Id='$id'";

    if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
}
}
$conn->close();
?>
<html>
<body>
<br>
<a href="dash.php"><input style="margin-left:600px;" type="button" class="btn btn-danger" value="Go Back"></body></a>


<?php

require_once('includes/config.php');

 //if not logged in redirect to login page
//if (!$user->is_logged_in()) {
    //header('Location: login.php');
//}



################ Save & delete markers #################
if($_POST) //run only if there's a post data
{
	//make sure request is comming from Ajax
	$xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'; 
	if (!$xhr){ 
		header('HTTP/1.1 500 Error: Request must come from Ajax!'); 
		exit();	
	}
	
	// get marker position and split it for database
	$mLatLang	= explode(',',$_POST["latlang"]);
	$mLat 		= filter_var($mLatLang[0], FILTER_VALIDATE_FLOAT);
	$mLng 		= filter_var($mLatLang[1], FILTER_VALIDATE_FLOAT);
	
	//Delete Marker
	if(isset($_POST["del"]) && $_POST["del"]==true)
	{
		$results = $db->query("DELETE FROM alerts WHERE lat=$mLat AND lng=$mLng");
		if (!$results) {  
		  header('HTTP/1.1 500 Error: Could not delete Markers!'); 
		  exit();
		} 
		exit("Done!");
	}
	
	$mName 		= filter_var($_POST["name"], FILTER_SANITIZE_STRING);
	$mDescription 	= filter_var($_POST["description"], FILTER_SANITIZE_STRING);
	$mType		= filter_var($_POST["type"], FILTER_SANITIZE_STRING);
	
	$results = $db->query("INSERT INTO alerts (Name, Description, Lat, Lng, Type) VALUES ('$mName','$mDescription',$mLat, $mLng, '$mType')");
	if (!$results) {  
		  header('HTTP/1.1 500 Error: Could not create marker!'); 
		  exit();
	} 
	
	$output = '<h1 class="marker-heading">'.$mName.'</h1><p>'.$mDescription.'</p>';
	exit($output);
}


################ Continue generating Map XML #################

//Create a new DOMDocument object
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers"); //Create new element node
$parnode = $dom->appendChild($node); //make the node show up 

// Select all the rows in the markers table
$results = $mysqli->query("SELECT * FROM alerts WHERE 1");
if (!$results) {  
	header('HTTP/1.1 500 Error: Could not get markers!'); 
	exit();
} 

//set document header to text/xml
header("Content-type: text/xml"); 

// Iterate through the rows, adding XML nodes for each
while($obj = $results->fetch_object())
{
  $node = $dom->createElement("marker");  
  $newnode = $parnode->appendChild($node);   
  $newnode->setAttribute("name",$obj->Name);
  $newnode->setAttribute("address", $obj->Description);  
  $newnode->setAttribute("lat", $obj->Lat);  
  $newnode->setAttribute("lng", $obj->Lng);  
  $newnode->setAttribute("type", $obj->Type);	
}

echo $dom->saveXML();
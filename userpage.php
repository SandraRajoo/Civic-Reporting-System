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
                            <li><a id="signup" href="homepage.html"><span class="glyphicon glyphicon-share"></span> Log Out</a></li>
                        
                         </ul>

                    
                </div>
            </nav>  
            
    </head>

<?php require('includes/config.php'); 

 //if not logged in redirect to login page
//if (!$user->is_logged_in()) {
   // header('Location: login.php');
//} else if (!$user->is_admin_logged_in())
 //{
    //header('Location: memberpage.php');
//}


//define page title


$title = 'User Portal';

//include header template
require('layout/header.php'); 
?>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBu1DEhlMwrY8UO1OU05X81tvw8wZ122tg&sensor=false&libraries=places"></script>
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {

                var mapCenter = new google.maps.LatLng(9.317945, 76.617804); //Google map Coordinates
                var map;

                map_initialize(); // initialize google map

                //############### Google Map Initialize ##############
                function map_initialize()
                {
                    var googleMapOptions =
                            {
                                center: mapCenter, // map center
                                zoom: 17, //zoom level, 0 = earth view to higher value
                                maxZoom: 18,
                                minZoom: 16,
                                zoomControlOptions: {
                                    style: google.maps.ZoomControlStyle.SMALL //zoom control size
                                },
                                scaleControl: true, // enable scale control
                                mapTypeId: google.maps.MapTypeId.ROADMAP // google map type
                            };

                    map = new google.maps.Map(document.getElementById("google_map"), googleMapOptions);

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function (position) {
                            var pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };
                            map.setCenter(pos);
                        }, function () {
                        });
                    } else {
                        // Browser doesn't support Geolocation
                        // default to location
                    }

                    /*
                     * Link map search box with events
                     */
                    var input = document.getElementById('pac-input');
                    var searchBox = new google.maps.places.SearchBox(input);
                    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);
                    map.addListener('bounds_changed', function () {
                        searchBox.setBounds(map.getBounds());
                    });
                    var markers = [];
                    /* Listen for the event fired when the user selects a prediction and retrieve
                     more details for that place. */
                    searchBox.addListener('places_changed', function () {
                        var places = searchBox.getPlaces();

                        if (places.length == 0) {
                            return;
                        }

                        // Clear out the old markers.
                        markers.forEach(function (marker) {
                            marker.setMap(null);
                        });
                        markers = [];

                        // For each place, get the icon, name and location.
                        var bounds = new google.maps.LatLngBounds();
                        places.forEach(function (place) {
                            if (!place.geometry) {
                                console.log("Returned place contains no geometry");
                                return;
                            }
                            var icon = {
                                url: place.icon,
                                size: new google.maps.Size(71, 71),
                                origin: new google.maps.Point(0, 0),
                                anchor: new google.maps.Point(17, 34),
                                scaledSize: new google.maps.Size(25, 25)
                            };

                            // Create a marker for each place.
                            markers.push(new google.maps.Marker({
                                map: map,
                                icon: icon,
                                title: place.name,
                                position: place.geometry.location
                            }));

                            if (place.geometry.viewport) {
                                // Only geocodes have viewport.
                                bounds.union(place.geometry.viewport);
                            } else {
                                bounds.extend(place.geometry.location);
                            }
                        });
                        map.fitBounds(bounds);
                    });

                    //Load Markers from the XML File, Check (map_process.php)
                    $.get("map_process.php", function (data) {
                        $(data).find("marker").each(function () {
                            var name = $(this).attr('name');
                            var description = '<p>' + $(this).attr('description') + '</p>';
                            var type = $(this).attr('type');
                            var point = new google.maps.LatLng(parseFloat($(this).attr('lat')), parseFloat($(this).attr('lng')));
                            var iconUrl = get_marker(type);
                            create_marker(point, name, description, false, false, false, iconUrl);
                        });
                    });

                    //Right Click to Drop a New Marker
                    google.maps.event.addListener(map, 'rightclick', function (event) {
                        //Edit form to be displayed with new marker
                        var EditForm = '<p><div class="marker-edit">' +
                                '<form action="ajax-save.php" method="POST" name="SaveMarker" id="SaveMarker">' +
                                '<label for="pName"><span>Place Name :</span><input type="text" name="pName" class="save-name" placeholder="Enter Title" maxlength="40" /></label>' +
                                '<label for="pDesc"><span>Description :</span><textarea name="pDesc" class="save-desc" placeholder="Enter Description" maxlength="150"></textarea></label>' +
                                '<label for="pType"><span>Type :</span> <select name="pType" class="save-type">'+
                                '<option value="pothole">Pothole</option>'+
                                '<option value="garbage">Garbage</option>' +
                                '<option value="leak">Leak</option></select>'+
                                '<option value="stray">Stray</option></select>'
                                '<option value="other">Others</option></select>'
                                '</label>' +
                                '</form>' +
                                '</div></p><button name="save-marker" class="save-marker">Save Marker Details</button>';

                        //Drop a new Marker with our Edit Form
                        create_marker(event.latLng, 'New Marker', EditForm, true, true, true, "http://www.google.com/mapfiles/ms/micons/red-pushpin.png");
                    });

                }

                //############### Create Marker Function ##############
                function create_marker(MapPos, MapTitle, MapDesc, InfoOpenDefault, DragAble, Removable, iconPath)
                {

                    //new marker
                    var marker = new google.maps.Marker({
                        position: MapPos,
                        map: map,
                        draggable: DragAble,
                        animation: google.maps.Animation.DROP,
                        title: MapTitle,
                        icon: iconPath
                    });

                    //Content structure of info Window for the Markers
                    var contentString = $('<div class="marker-info-win">' +
                            '<div class="marker-inner-win"><span class="info-content">' +
                            '<h1 class="marker-heading">' + MapTitle + '</h1>' +
                            MapDesc +
                            '</span><button name="remove-marker" class="remove-marker" title="Remove Marker">Remove Marker</button>' +
                            '</div></div>');


                    //Create an infoWindow
                    var infowindow = new google.maps.InfoWindow();
                    //set the content of infoWindow
                    infowindow.setContent(contentString[0]);

                    //Find remove button in infoWindow
                    var removeBtn = contentString.find('button.remove-marker')[0];
                    var saveBtn = contentString.find('button.save-marker')[0];

                    //add click listner to remove marker button
                    google.maps.event.addDomListener(removeBtn, "click", function (event) {
                        remove_marker(marker);
                    });

                    if (typeof saveBtn !== 'undefined') //continue only when save button is present
                    {
                        //add click listner to save marker button
                        google.maps.event.addDomListener(saveBtn, "click", function (event) {
                            var mReplace = contentString.find('span.info-content'); //html to be replaced after success
                            var mName = contentString.find('input.save-name')[0].value; //name input field value
                            var mDesc = contentString.find('textarea.save-desc')[0].value; //description input field value
                            var mType = contentString.find('select.save-type')[0].value; //type of marker

                            if (mName == '' || mDesc == '')
                            {
                                alert("Please enter Name and Description!");
                            } else {
                                save_marker(marker, mName, mDesc, mType, mReplace); //call save marker function
                            }
                        });
                    }

                    //add click listner to save marker button        
                    google.maps.event.addListener(marker, 'click', function () {
                        infowindow.open(map, marker); // click on marker opens info window 
                    });

                    if (InfoOpenDefault) //whether info window should be open by default
                    {
                        infowindow.open(map, marker);
                    }
                }

                //############### Remove Marker Function ##############
                function remove_marker(Marker)
                {

                    /* determine whether marker is draggable 
                     new markers are draggable and saved markers are fixed */
                    if (Marker.getDraggable())
                    {
                        Marker.setMap(null); //just remove new marker
                    } else
                    {
                        //Remove saved marker from DB and map using jQuery Ajax
                        var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
                        var myData = {del: 'true', latlang: mLatLang}; //post variables
                        $.ajax({
                            type: "POST",
                            url: "map_process.php",
                            data: myData,
                            success: function (data) {
                                Marker.setMap(null);
                                alert(data);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(thrownError); //throw any errors
                            }
                        });
                    }

                }

                //############### Save Marker Function ##############
                function save_marker(Marker, mName, mDesc, mType, replaceWin)
                {
                    //Save new marker using jQuery Ajax
                    var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
                    var myData = {name: mName, description: mDesc, latlang: mLatLang, type: mType}; //post variables
                    var iconUrl = get_marker(mType);
                    console.log(replaceWin);
                    $.ajax({
                        type: "POST",
                        url: "map_process.php",
                        data: myData,
                        success: function (data) {
                            replaceWin.html(data); //replace info window with new html
                            Marker.setDraggable(false); //set marker to fixed
                            Marker.setIcon(iconUrl); //replace icon
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError); //throw any errors
                        }
                    });
                }

                //############# Find marker icon ###################
                function get_marker(mType) {
                    var iconUrl = 'http://www.google.com/mapfiles/kml/paddle/';
                    if (mType == 'pothole') {
                        iconUrl += 'P-lv.png';
                    } else if (mType == 'garbage') {
                        iconUrl += 'G-lv.png';
                    } else if (mType == 'leak') {
                        iconUrl += 'L-lv.png';
                    }else if (mType == 'stray'){
                        iconUrl += 'S-lv.png';
                    } else if (mType == 'other'){
                        iconUrl += 'O-lv.png';
                    } else {
                        iconUrl += 'stop';
                    }
                    return iconUrl;
                }
                
                $('#alertstable').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax": "server_processing.php"
                } );
                

            });
        </script>

        <style type="text/css">
            h1.heading{padding:0px;margin: 0px 0px 10px 0px;text-align:center;font: 18px Georgia, "Times New Roman", Times, serif;}

            /* width and height of google map */
            #google_map {width: 90%; height: 500px;margin-top:0px;margin-left:auto;margin-right:auto;}

            /* Marker Edit form */
            .marker-edit label{display:block;margin-bottom: 5px;}
            .marker-edit label span {width: 100px;float: left;}
            .marker-edit label input, .marker-edit label select{height: 24px;}
            .marker-edit label textarea{height: 60px;}
            .marker-edit label input, .marker-edit label select, .marker-edit label textarea {width: 60%;margin:0px;padding-left: 5px;border: 1px solid #DDD;border-radius: 3px;}

            /* Marker Info Window */
            h1.marker-heading{color: #585858;margin: 0px;padding: 0px;font: 18px "Trebuchet MS", Arial;border-bottom: 1px dotted #D8D8D8; width: 300px}
            div.marker-info-win {max-width: 300px;margin-right: -20px;}
            div.marker-info-win p{padding: 0px;margin: 10px 0px 10px 0;}
            div.marker-inner-win{padding: 5px;}
            button.save-marker, button.remove-marker{border: none;background: rgba(0, 0, 0, 0);color: #00F;padding: 0px;text-decoration: underline;margin-right: 10px;cursor: pointer;
            }

            /* Search box*/
            #pac-input {background-color: #fff; font-family: Roboto; font-size: 15px; font-weight: 300; margin-left: 12px; padding: 9px; text-overflow: ellipsis; width: 300px; }
            #pac-input:focus { border-color: #4d90fe; }


        </style>


<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            
                <h2 style="text-align:center;">Member Page- Welcome </h2>
               
                <hr>

        </div>
    </div>
    
    
        <ul class="nav nav-pills">
            <li class="active"><a href="#mapview" data-toggle="tab">Map</a></li>
            <li><a href="#alertview" data-toggle="tab">Manage</a></li>
        </ul>
  
        <div class="tab-content">
            <div class="tab-pane active" id="mapview">
                <h1 class="heading">Community Submissions</h1>
                <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                <div id="google_map"></div>
                <br/>    
                
            </div>
            <div class="tab-pane" id="alertview">
                <h1 class="heading">Manage Alerts</h1>
                <table id="alertstable" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Name</th>
                            <th>Close Reason</th>
                            <th>Completed</th>
                        </tr>
                    </thead>
                    
                
            </div>
        </div>

</div>


<?php 
//include header template
require('layout/footer.php'); 
?>


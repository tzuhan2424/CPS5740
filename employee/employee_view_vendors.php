<?php
include 'helperFunction.php';
include "../dbconfig.php";

session_start();
checkLoginAndRedirect();

echo "<a href='employee_logout.php'>Employee logout</a><br>";


try{
    $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
    $sql = "select vendor_id, name, address, city, state, zipcode, latitude, Longitude from CPS5740.VENDOR";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) == 0){
        echo "<br><font color= 'red'>No records found.</font>";
    }
    else{ 
        
        echo "<style>";
        echo "table { width: 60%; margin: 0 auto; font-size: 12px; border-collapse: collapse; }";
        echo "td, th { padding: 2px; border: 1px solid black; }";
        echo "div.center-text { text-align: center; }";
        echo "</style>";
        echo "<div class='center-text'>The following vendors are in the database.<div>";
        echo "<TABLE border=1>\n<br>";
        echo "<TR><TH>ID<TH>Name<TH>Address<TH>Ciry<TH>State<TH>Zipcode<TH>Location(Latitude,Longitude)\n";
        $vendorData = [];

        while($row = mysqli_fetch_array($result)){
            $vendor_id=$row['vendor_id'];
            $name=$row['name'];
            $address = $row['address'];
            $city = $row['city'];
            $state = $row['state'];
            $zipcode = $row['zipcode'];
            $latitude = $row['latitude'];
            $longitude = $row['Longitude'];
            $vendorData[] = [$vendor_id, $name, $latitude, $longitude];

            echo "<tr>";
            echo "<td>{$vendor_id}</td>";
            echo "<td>{$name}</td>";
            echo "<td>{$address}</td>";
            echo "<td>{$city}</td>";
            echo "<td>{$state}</td>";
            echo "<td>{$zipcode}</td>";
            echo "<td>({$latitude}, {$longitude})</td>";
            echo "</tr>";
        }
        echo "</table>";

    
        $jsonLocations = json_encode($vendorData);

        // Include the JavaScript for Google Maps
        echo <<<HTML
        <script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
        <script>
            function initialize() {
                var mapOptions = {
                    zoom: 4,
                    center: new google.maps.LatLng(39.521741, -96.848224),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                var infowindow = new google.maps.InfoWindow();

                var markerIcon = {
                    scaledSize: new google.maps.Size(80, 80),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(32,65),
                    labelOrigin: new google.maps.Point(40,33)
                };

                // Use PHP-generated JSON in JavaScript
                var MarkerLocations = $jsonLocations;

                    MarkerLocations.forEach(function(location) {
                        var latLng = new google.maps.LatLng(location[2], location[3]);
                        var marker = new google.maps.Marker({ 
                            map: map, 
                            position: latLng, 
                            icon: markerIcon,    
                            label: {
                                text: location[0],
                                color: "black",
                                fontSize: "16px",
                                fontWeight: "bold"
                            }
                        });

                        google.maps.event.addListener(marker, 'click', function() {
                            infowindow.setContent("Vendor Name: " + location[1]);
                            infowindow.open(map, marker);
                        });
                });
            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
        HTML;
        echo "<br>";
        echo "<div id='map-canvas' style='height: 400px; width: 60%; margin: 0 auto;'></div>";





    }
}catch(Exception $e){
    $error = $e->getMessage();
    echo $error;
}


?>
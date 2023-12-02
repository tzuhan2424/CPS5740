<?php


try{
    $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) == 0){
        echo "<br><font color= 'red'>No records found.</font>";
    }
    else{ 
        echo "<TABLE border=1>\n<br>";
        echo "<TR><TH>ProductID<TH>Product Name<TH>Description<TH>Cost<TH>Sell Price<TH>Available quantity<TH>Vendor name<TH>Last update by\n";        
        while($row = mysqli_fetch_array($result)){
        }
    }
}
catch (Exception $e){
    $error = $e->getMessage();
    echo $error;
}


        



?>
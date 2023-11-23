<?php
    include '../dbconfig.php';
    
    $sql = "select * from 2023F_lintzuh.CUSTOMER";
    
try{
    $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) == 0){
        echo "<br><font color= 'red'>No records found.</font>";
    }
    else{ 
        echo "The following customers are in the database.";
        echo "<TABLE border=1>\n<br>";
        echo "<tr><th>ID</th><th>Login</th><th>Password</th><th>Last Name</th><th>First Name</th><th>TEL</th><th>Address</th><th>City</th><th>Zipcode</th><th>State</th></tr>";        
        while($row = mysqli_fetch_array($result)){
            $id = $row['customer_id']; 
            $login = $row['login_id']; 
            $password = $row['password']; 
            $lastName = $row['last_name']; 
            $firstName = $row['first_name']; 
            $tel = $row['tel']; 
            $address = $row['address']; 
            $city = $row['city']; 
            $zipcode = $row['zipcode']; 
            $state = $row['state']; 
            echo "<tr><td>$id</td><td>$login</td><td>$password</td><td>$lastName</td><td>$firstName</td><td>$tel</td><td>$address</td><td>$city</td><td>$zipcode</td><td>$state</td></tr>";
        }
    }
}
catch (Exception $e){
    $error = $e->getMessage();
    echo $error;
}





?>
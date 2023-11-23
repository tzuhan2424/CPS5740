<?php
    include '../dbconfig.php';
    
    $sql = "select * from CPS5740.EMPLOYEE2;";
    
try{
    $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) == 0){
        echo "<br><font color= 'red'>No records found.</font>";
    }
    else{ 
        echo "The following employee are in the database.";
        echo "<TABLE border=1>\n<br>";
        echo "<TR><TH>ID<TH>Login<TH>Password<TH>Name<TH>Role\n";        
        while($row = mysqli_fetch_array($result)){
            $id=$row['employee_id'];
            $login = $row['login'];
            $password = $row['password'];
            $name = $row['name'];
            $role = $row['role'];
            echo "<TR><TD>$id<TD>$login<TD>$password<TD>$name<TD>$role";
        }
    }
}
catch (Exception $e){
    $error = $e->getMessage();
    echo $error;
}





?>
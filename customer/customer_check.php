<?php

include "../dbconfig.php";
include 'customerHelpFunction.php';
session_start();

if (checkCustomerSession() && checkCustomerCookie()) {
    header("Location: customer_check_p2.php");
    exit();
} 


try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $login=$_POST['login_id'];
        $password_attempt=$_POST['password'];
        $sql = "select customer_id, login_id, password, first_name, last_name, CONCAT(address, ', ', city, ', ', state, ' ', zipcode) AS full_address from 2023F_lintzuh.CUSTOMER where login_id = '$login';";
        $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) == 0){
            die("<br>There is no such customer\n");
        }
        else{
            $row = mysqli_fetch_array($result);
            $usr_password=$row["password"];            
            if (!checkPassword($usr_password, $password_attempt)){
                die("<br>Login failed, @\n");
            }
    
            $customer_id = $row['customer_id'];
            $name = $row['first_name'] . ' ' . $row['last_name'];
            $full_address=$row['full_address'];
            
            setCustomerSession($customer_id, $name, $full_address);
            setCustomerCookie($customer_id, $name);
            // redirect
            header("Location: customer_check_p2.php");
            exit();
        }  
    }
}catch (Exception $e){
    $error = $e->getMessage();
    echo $error;
}





?>
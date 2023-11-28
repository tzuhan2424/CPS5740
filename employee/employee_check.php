<?php
include "../dbconfig.php";
include "helperFunction.php";


session_start();

if (checkEmployeeSession() && checkEmployeeCookie()) {
    // Redirect to the Employee Home Page
    header("Location: employee_home.php");
    exit();
} 




try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $login=$_POST['login_id'];
        $password_attempt=$_POST['password'];
        $sql = "select employee_id, login, password, name, role from CPS5740.EMPLOYEE2 where login = '$login';";
        $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) == 0){
            die("<br>There is no such employee\n");
        }
        else{
            $row = mysqli_fetch_array($result);
            $usr_password=$row["password"];
            $hashed_password_attempt = hash('sha256', $password_attempt);
            
            if (!checkPassword($usr_password, $hashed_password_attempt)){
                die("<br>Login failed, @\n");
            }
    
            $employee_id = $row['employee_id'];
            $name = $row['name'];
            $role=$row['role'];
            
            setEmployeeSession($employee_id, $role, $name);
            setEmployeeCookie($employee_id, $role, $name);
            // redirect
            header("Location: employee_home.php");
            exit();
        }  
    }
}catch (Exception $e){
    $error = $e->getMessage();
    echo $error;
}
?>


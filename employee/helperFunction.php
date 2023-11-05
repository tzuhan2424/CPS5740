<?php

function checkPassword($usr_password, $password_att) {
    return $usr_password === $password_att;

}

function setEmployeeCookie($employee_id, $employee_role){
	setcookie("employee_id", "$employee_id", time() + 3600); //set cookies(id)
	setcookie("employee_role", "$employee_role", time() + 3600);//set cookies(name)
}
function setEmployeeSession($employee_id, $employee_role, $employee_name){
    session_start();
    $_SESSION["employee_id"] = $employee_id;
    $_SESSION["employee_role"] = $employee_role;
    $_SESSION["employee_name"] = $employee_name;

}



function FullNameRole($role) {
    if ($role == 'M') {
        return 'Manager';
    } elseif ($role == 'E') {
        return 'Employee';
    } else {
        return 'Unknown Role';
    }
}

function checkEmployeeCookie() {
    return (isset($_COOKIE["employee_id"]) && isset($_COOKIE["employee_role"]));
}
function checkEmployeeSession(){
    return (isset($_SESSION['employee_id']) && isset($_SESSION['employee_role']) &&isset($_SESSION['employee_name']));
}

function deleteSession(){

    session_start();
    $_SESSION = array();
    session_destroy();
}
function deleteEmployeeCookie(){
    //delete cookie
    $cookie_name1 = "employee_id";
    $cookie_name2 = "employee_role";
    unset($_COOKIE[$cookie_name1]);
    unset($_COOKIE[$cookie_name2]);
    // empty value and expiration one hour before
    $res1 = setcookie($cookie_name1, '', time() - 3600);
    $res2 = setcookie($cookie_name2, '', time() - 3600);

    echo "You successfully logout<br>";

}
function vendorDropdownlist(){
    include '../dbconfig.php';

    $sql="select vendor_id, name from CPS5740.VENDOR";
    $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
    try{
        $options = "";

        $result = mysqli_query($con,$sql);
        if ($result->num_rows > 0) {
            // assoc array
            while($row = $result->fetch_assoc()) {
                $options .= "<option value='{$row['vendor_id']}'>{$row['name']}</option>";
            }
        } else {
            $options = "<option value=''>No vendors found</option>";
        }

        // Close the connection
        $con->close();

        // Return the options string
        return $options;



    }catch(Exception $e){
        $error = $e->getMessage();
        echo $error;
    }
}


function validateCostAndSellPrice($cost, $sellPrice) {
    // Check if cost and sell price are numbers
    if (!is_numeric($cost) || !is_numeric($sellPrice)) {
        echo 'Cost and Sell Price must be numbers.<br>';
        echo '<button onclick="history.go(-1);">Go Back</button>';
        exit();
    }

    // Ensure cost and sell price are non-negative
    $cost = floatval($cost);
    $sellPrice = floatval($sellPrice);

    if ($cost < 0 || $sellPrice < 0) {
        echo 'Cost and Sell Price must be non-negative.<br>';
        echo '<button onclick="history.go(-1);">Go Back</button>';
        exit();
    }
    
    // Ensure cost is less than sell price
    if ($cost >= $sellPrice) {
        echo 'Cost must be less than Sell Price.<br>';
        echo '<button onclick="history.go(-1);">Go Back</button>';
        exit();
    }
}


function validateQuantity($quantity){
    // Check if quantity is a number
    if (!is_numeric($quantity)) {
        echo 'Quantity must be a number.<br>';
        echo '<button onclick="history.go(-1);">Go Back</button>';
        exit();
    }
    
    // Ensure quantity is non-negative
    $quantity = intval($quantity);
    if ($quantity < 0) {
        echo 'Quantity must be non-negative.<br>';
        echo '<button onclick="history.go(-1);">Go Back</button>';
        exit();
    }
}

?>
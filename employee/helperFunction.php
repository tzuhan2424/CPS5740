<?php

function checkPassword($usr_password, $password_att) {
    return $usr_password === $password_att;

}

function setEmployeeCookie($employee_id, $employee_role){
	setcookie("employee_id", "$employee_id", time() + 3600); //set cookies(id)
	setcookie("employee_role", "$employee_role", time() + 3600);//set cookies(name)
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

?>
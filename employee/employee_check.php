<?php
include "../dbconfig.php";
include "helperFunction.php";


$login=$_POST['login_id'];
$password_attempt=$_POST['password'];

$sql = "select employee_id, login, password, name, role from CPS5740.EMPLOYEE2 where login = '$login';";
$con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
// echo "$sql";


try {
    $result = mysqli_query($con,$sql);
    if (mysqli_num_rows($result) == 0){
        die("<br>There is no such employee\n");
    }
    else{
        $row = mysqli_fetch_array($result);
        $usr_password=$row["password"];
        $hashed_password_attempt = hash('sha256', $password_attempt);
        if (!checkPassword($usr_password, $hashed_password_attempt)){
            die("<br>Login failed\n");
        }


        // interface
        $employee_id = $row['employee_id'];
        $name=$row['name'];
        $role=$row['role'];
        setEmployeeCookie($employee_id, $role);
        $fullNameRole = FullNameRole($role);

        // interface
        echo "<div>employee id: $employee_id </div>";
        echo "<div>Welcome $fullNameRole : $name</div>";
        echo "<a href='employee_logout.php'>Employee logout</a><br>";
        
        echo <<<HTML
            <br><a href="CPS5740_product_add.php">Add products</a>
            <br><a href="CPS5740_view_vendors_p2.php">View all vendors</a>
            <br><a href="CPS5740_employee_search_product.php">Search & update product</a>
            <form name="input" action="CPS5740_view_report.php" method="post">
                View Reports - period:
                <select name='report_period'>
                    <option value="all">all</option>
                    <option value="past_week">past week (Sun-Sat)</option>
                    <option value="last_7days">last 7 days</option>
                    <option value="current_month">current month</option>
                    <option value="past_month">past month (1-31)</option>
                    <option value="last_30days">last 30 days</option>
                    <option value="this_year">this year (Jan to now)</option>
                    <option value="last_365days">last 365 days</option>
                    <option value="past_year">past year (Jan-Dec)</option>
                </select>
            , by:
                <select name='report_type'>
                    <option value="all">all sales</option>
                    <option value="products">products</option>
                    <option value="vendors">vendors</option>
                </select>
                <input type="submit" value="Submit">
            </form>
        HTML;
        






    }



}catch (Exception $e){
    $error = $e->getMessage();
    echo $error;
}



?>


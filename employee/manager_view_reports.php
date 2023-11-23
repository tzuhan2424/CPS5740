<?php
include "../dbconfig.php";
include 'helperFunction.php';
session_start();
checkLoginAndRedirect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['report_period'])) {
        $reportPeriod = $_POST['report_period'];
    }
    if (isset($_POST['report_type'])) {
        $reportType = $_POST['report_type'];
    }

    if ($reportType == 'all'){
        echo 'all';
    }elseif ($reportType == 'products') {
        ProductReport($reportPeriod, $reportType);    
    }elseif ($reportType == 'vendors'){
        echo 'ven';
    }else{
        echo 'wrong';
    }

}

function ProductReport($reportPeriod, $reportType){
    include "../dbconfig.php";
    $sql = "CALL 2023F_lintzuh.pProject_Product_report_withTime('{$reportPeriod}')";
    $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) == 0){
        echo "<br><font color= 'red'>No records found.</font>";
    }
    else{ 
        echo "Report by <B>{$reportType}</B> during period: <B>$reportPeriod</B>";
        echo "<TABLE border=1>\n<br>";
        echo "<tr><th>#<th>Product Name</th><th>Vendor Name</th><th>Cost</th><th>Current Quantity</th><th>Sold Quantity</th><th>Sell Price</th><th>Total Sales</th><th>Profit</th></tr>\n";
        
        $rowCount = mysqli_num_rows($result);
        $currentRow = 0;

        while($row = mysqli_fetch_array($result)){
            $currentRow++;

            $productName = $row['Product_name'];
            $vendorName = $row['Vendor_name'];
            $cost = $row['Cost'];
            $currentQty = $row['Current_QTY'];
            $soldQty = $row['Sold_QTY'];
            $sellPrice = $row['Sell_price'];
            $totalSales = $row['Total_sale'];
            $profit = $row['profit'];


            // Check if this is the last row
            if ($currentRow == $rowCount) {
                echo "<tr><td>Total<td><td><td><td><td><td><td>$totalSales<td>$profit</tr>";
            }else{
                echo "<tr><td>$currentRow<td>$productName</td><td>$vendorName</td><td>$cost</td><td>$currentQty</td><td>$soldQty</td><td>$sellPrice</td><td>$totalSales</td><td>$profit</td></tr>\n";

            }
        }

        echo "</table>";
        echo '<br><a href="employee_home.php"><button>Go to Employee Home Page</button></a>';
        echo '<br><a href="../index.html"><button>Go to Project Home Page</button></a>';


    }
    mysqli_close($con); // Close the database connection

}







?>
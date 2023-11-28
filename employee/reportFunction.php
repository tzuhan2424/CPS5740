<?php
function VendorReport($reportPeriod, $reportType){
    include "../dbconfig.php";
    $sql = "CALL 2023F_lintzuh.pProject_Vendor_report_withTime('{$reportPeriod}')";
    $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) == 0){
        echo "<br><font color= 'red'>No records found.</font>";
    }
    else{ 
        echo "Report by <B>{$reportType}</B> during period: <B>$reportPeriod</B>";
        echo "<TABLE border=1 class='table-small'>\n<br>";
        echo "<tr><th>#</th><th>Vendor Name</th><th>Quantity in Stock</th><th>Total Cost</th><th>Sold Quantity</th><th>Total Sale</th><th>Profit</th></tr>\n";
        
        $rowCount = mysqli_num_rows($result);
        $currentRow = 0;

        while($row = mysqli_fetch_array($result)){
            $currentRow++;

            $vendorName = $row['Vendor_name'];
            $quantityInStock = $row['stock_QTY'];
            $totalCost = $row['Cost'];
            $soldQty = $row['Sold_QTY'];
            $totalSales = $row['Total_sale'];
            $profit = $row['profit'];




            // Check if this is the last row
            if ($currentRow == $rowCount) {
                echo "<tr><td>Total<td><td><td>$totalCost<td><td>$totalSales<td>$profit</tr>";
            }else{
                echo "<tr><td>$currentRow<td>$vendorName</td><td>$quantityInStock</td><td>$totalCost</td><td>$soldQty</td><td>$totalSales</td><td>$profit</td></tr>\n";

            }
        }

        echo "</table>";
        echo '<br><a href="employee_home.php"><button>Go to Employee Home Page</button></a>';
        echo '<br><a href="../index.html"><button>Go to Project Home Page</button></a>';


    }
    mysqli_close($con); // Close the database connection



}



function AllSalesReport($reportPeriod, $reportType){
    include "../dbconfig.php";
    $sql = "CALL 2023F_lintzuh.pProject_AllSales_report_withTime('{$reportPeriod}')";
    $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) == 0){
        echo "<br><font color= 'red'>No records found.</font>";
    }
    else{ 
        echo "Report by <B>{$reportType}</B> during period: <B>$reportPeriod</B>";
        echo "<TABLE border=1 class='table-small'>\n<br>";
        echo "<tr><th>#<th>Product Name</th><th>Vendor Name</th><th>Unit Cost</th><th>Current Quantity</th><th>Sold Quantity</th><th>Sell Unit Price</th><th>Total Sales</th><th>Profit</th><th>Customer Name<th>Order Date</tr>\n";
        
        $rowCount = mysqli_num_rows($result);
        $currentRow = 0;

        while($row = mysqli_fetch_array($result)){
            $currentRow++;

            $productName = $row['Product_name'];
            $vendorName = $row['Vendor_name'];
            $unitCost = $row['unit_cost']; 
            $currentQty = $row['Current_QTY'];
            $soldQty = $row['Sold_QTY'];
            $soldUnitPrice = $row['Sold_Unit_Price'];
            $totalSales = $row['Total_sale'];
            $profit = $row['profit'];
            $customerName = $row['Customer_Name']; 
            $orderDate = $row['order_date']; 


            // Check if this is the last row
            if ($currentRow == $rowCount) {
                echo "<tr><td>Total<td><td><td><td><td><td><td>$totalSales<td>$profit</tr>";
            }else{
                echo "<tr><td>$currentRow<td>$productName</td><td>$vendorName</td><td>$unitCost</td><td>$currentQty</td><td>$soldQty</td><td>$soldUnitPrice</td><td>$totalSales</td><td>$profit</td><td>$customerName<td>$orderDate</tr>\n";

            }
        }

        echo "</table>";
        echo '<br><a href="employee_home.php"><button>Go to Employee Home Page</button></a>';
        echo '<br><a href="../index.html"><button>Go to Project Home Page</button></a>';


    }
    mysqli_close($con); // Close the database connection



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
        echo "<TABLE border=1 class='table-small'>\n<br>";
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
<?php
include "../dbconfig.php";
include 'customerHelpFunction.php';
session_start();
checkLoginAndRedirect();

$customer_address = $_SESSION['customer_address'];
$customer_name = $_SESSION['customer_name'];
$customer_id = $_SESSION['customer_id'];
$con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
// echo "cust: '$customer_id'<br>";

$order_id_array=getOrderID($con);
// foreach ($order_id_array as $order_id) {
//     echo $order_id . "<br>";
// }

$totalSale_report=0;


echo "Your order history:";
foreach ($order_id_array as $order_id) {
    $procedure_sql = "call 2023F_lintzuh.pProject_customer_orderHistory('{$customer_id}','{$order_id}')";
    $result = mysqli_query($con, $procedure_sql);
    if ($result) {
        $loopNum=0;
        do {
            if (mysqli_num_rows($result) == 0) {
                echo "<br><span style='color: red;'>No records found.</span>";
            } else {
                if ($loopNum>0){ // because it will loop twice every time, due to the stored procedure
                    break;
                }else{
                    echo "<TABLE border=1 class='table-small'>\n<br>";
                    echo "<tr><th>Order_ID<th>Product Name<th>Order Quantity<th>Unit Price<th>Sub total<th>Order Date\n"; 
                    $rowCount = mysqli_num_rows($result);
                    $currentRow = 0;
                    while($row = mysqli_fetch_array($result)){
                        $currentRow++;
                        $order_id=$row['order_id'];
                        $product_name = $row['Product_name'];
                        $soldQTY=$row['soldQTY'];
                        $sell_price=$row['sell_price'];
                        $sub_total=$row['sub_total'];
                        $order_date=$row['order_date'];


                        if ($currentRow == $rowCount) {
                            $totalSale_report += $sub_total;

                            echo "<tr><td></td><td>order_paid</td><td></td><td></td><td>$sub_total</td><td></td></tr>\n";
                        }
                        else{
                            echo "<tr><td>$order_id</td><td>$product_name</td><td>$soldQTY</td><td>$sell_price</td><td>$sub_total</td><td>$order_date</td></tr>\n";
                        }
                    }
    
                    echo "</table>";
                }
               $loopNum+=1;
            }
        } while (mysqli_more_results($con) && mysqli_next_result($con));
        mysqli_free_result($result); // Free result set
    }
    else {
        echo "<br>Error in calling procedure: " . mysqli_error($con);
    }  
}
mysqli_close($con);



echo "<TABLE border=1 class='table-small'>\n<br>";
echo "<tr><td>Total paid<td>{$totalSale_report}</tr>";
echo "</TABLE>";

echo '<br><a href="customer_check_p2.php"><button>Go to Customer Home Page</button></a>';
echo '<br><a href="../index.html"><button>Go to Project Home Page</button></a>';














?>
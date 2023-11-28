<?php
    include "../dbconfig.php";
    include 'customerHelpFunction.php';
    session_start();
    checkLoginAndRedirect();
    echo "<a href='customer_logout.php'>customer logout</a><br>";


    $search_items = $_GET['search_items'];
    echo "Available product list for search keyword: ".$search_items;
    $sql = customerSearchQueryNonCaseSensitive($search_items);

    // echo "<br>".$sql;

    try{
        $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
        $result = mysqli_query($con, $sql);

        if(mysqli_num_rows($result) == 0){
            echo "<br><font color= 'red'>No records found.</font>";
        }
        else{ 
            echo "<form action='customer_order_product.php' method='post'>";
            echo "<TABLE border=1>\n<br>";
            echo "<tr><th>Product Name</th><th>Description</th><th>Sell Price</th><th>Available Quantity</th><th>Order Quantity</th><th>Vendor Name</th></tr>";
            while($row = mysqli_fetch_array($result)){
                $db_id=$row['id'];
                $product_name=$row['product_name'];
                $db_desc = $row['description'];
                $db_sellprice = $row['sell_price'];
                $db_quantity = $row['quantity'];
                $vendor_name = $row['vendor_name'];
                   
                
                // Create a new row for each record
                echo "<tr>";
                echo "<td>" . htmlspecialchars($product_name) . "</td>";
                echo "<td>" . htmlspecialchars($db_desc) . "</td>";
                echo "<td>" . htmlspecialchars($db_sellprice) . "</td>";
                echo "<td>" . htmlspecialchars($db_quantity) . "</td>";

                // Order Quantity - Assuming a text input for user to enter quantity
                echo "<td><input type='text' name='order_quantity[{$db_id}]' /></td>"; // Array format to handle multiple items

                echo "<td>" . htmlspecialchars($vendor_name) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<input type='submit' value='Place Order'></form>";



                
        }
        echo '<br><a href="customer_check_p2.php"><button>Go to Customer Home Page</button></a>';
        echo '<br><a href="../index.html"><button>Go to Project Home Page</button></a>';

    }catch (Exception $e){
        $error = $e->getMessage();
        echo $error;
    }
    
?>
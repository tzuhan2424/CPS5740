<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Customer.css">
</head>
<body>
<?php
include "../dbconfig.php";
include 'customerHelpFunction.php';
session_start();
checkLoginAndRedirect();
echo "<a href='customer_logout.php'>customer logout</a><br>";

$ordered_quantities = $_POST['order_quantity'];
$product_ids = array_keys($ordered_quantities);
$product_names = $_POST['product_names'];
$customer_id = $_SESSION['customer_id'];


$isValidTransactionList=true;
list($isValidTransactionList, $valid_quantities) = validationOfInputList($ordered_quantities,$product_names, $isValidTransactionList);



if ($isValidTransactionList) {
    // Proceed with the transaction
    // echo "<div class='my-success-message'>valid order</div>";
    list($productIDsString, $quantitiesString) =prepareInputArray($valid_quantities);




    $sql = "CALL processOrder(?, ?)";
    try{
        $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        // Prepare and execute the stored procedure
        if ($stmt = $con->prepare("CALL processOrder(?, ?, ?, @orderID)")) {
            // echo $productIDsString;
            // echo "<br>";
            // echo $quantitiesString;
            // Bind the input parameters
            $stmt->bind_param("sss", $productIDsString, $quantitiesString, $customer_id);
            
            if ($stmt->execute()) {
                // Retrieve the order ID
                $result = $con->query("SELECT @orderID as orderID")->fetch_assoc();
                $orderID = $result['orderID'];
                dispalyOrder($orderID, $con);
            } else {
                echo "Error executing statement: " . $stmt->error;
            }
            // Close the statement
            $stmt->close();
        } else {
            // Handle the prepared statement error if necessary
            echo "Error: " . $con->error;
        }

        // Close the database connection
        $con->close();
    }catch (Exception $e){
        echo "Error: " . $e->getMessage();

    }











} else {
    // Handle invalid transaction
    echo "<div class='my-error-message'>Invalid Order, please enter correct quantity</div>";
}


echo '<br><a href="customer_check_p2.php"><button>Go to Customer Home Page</button></a>';
echo '<br><a href="../index.html"><button>Go to Project Home Page</button></a>';




function dispalyOrder($orderID, $mysqli){
    $orderDetails = $mysqli->prepare("select E.id, C.name, C.sell_price as unit_price, D.quantity, D.quantity*C.sell_price as subtotal
                                        from `ORDER` E 
                                        join PRODUCT_ORDER D on E.id=D.order_id 
                                        join PRODUCT C on D.product_id = C.id
                                        where E.id = ?");
    $orderDetails->bind_param("i", $orderID);

    if ($orderDetails->execute()) {
        $result = $orderDetails->get_result();

        $ALLSUM = 0;
        echo "<div>Order Details</div>";
        echo "<TABLE border=1 class='table-small'>\n<br>";
        echo "<tr><th>Product Name<th>Unit Price<th>Quantity<th>Sub total\n"; 
        
        while ($row = $result->fetch_assoc()) {
            $productname=$row['name'];
            $unit_price = $row['unit_price'];
            $quantity = $row['quantity'];
            $subtotal = $row['subtotal'];

            $ALLSUM = $ALLSUM + $subtotal;
            echo "<tr><td>$productname<td>$unit_price<td>$quantity<td>$subtotal</tr>";
        }
        echo "<tr><td colSpan=3>Total<td>$ALLSUM</tr>";
        echo "</table>";
        $orderDetails->close();
    }
}

?>
</body>
</html>
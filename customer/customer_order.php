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
    echo "<div class='my-success-message'>valid order</div>";
    list($productIDsString, $quantitiesString) =prepareInputArray($valid_quantities);




    $sql = "CALL processOrder(?, ?)";
    try{
        $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        // Prepare and execute the stored procedure
        if ($stmt = $con->prepare("CALL processOrder(?, ?, ?)")) {
            // echo $productIDsString;
            // echo "<br>";
            // echo $quantitiesString;
            // Bind the input parameters
            $stmt->bind_param("sss", $productIDsString, $quantitiesString, $customer_id);
            $stmt->execute();

            




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

?>
</body>
</html>
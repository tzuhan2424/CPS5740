<?php
include "../dbconfig.php";
include 'customerHelpFunction.php';
session_start();
checkLoginAndRedirect();
echo "<a href='customer_logout.php'>customer logout</a><br>";

$ordered_quantities = $_POST['order_quantity'];
$product_ids = array_keys($ordered_quantities);
$product_names = $_POST['product_names'];


$isValidTransactionList=true;
list($isValidTransactionList, $valid_quantities) = validationOfInputList($ordered_quantities,$product_names, $isValidTransactionList);



if ($isValidTransactionList) {
    // Proceed with the transaction
    echo "valid order";
    


} else {
    // Handle invalid transaction
    echo "invalid order";
}


echo '<br><a href="customer_check_p2.php"><button>Go to Customer Home Page</button></a>';
echo '<br><a href="../index.html"><button>Go to Project Home Page</button></a>';
























?>
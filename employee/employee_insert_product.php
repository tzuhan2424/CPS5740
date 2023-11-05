<?php
include '../dbconfig.php';
include "helperFunction.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];
    $sellPrice = $_POST['sell_price'];
    $quantity = $_POST['quantity'];
    $vendorId = $_POST['vendor_id'];
    $employeeId = $_POST['employee_id'];

    // Process data, e.g., insert it into a database




    // For now, just print the data
    echo 'product you want to add<br>';
    echo "Product Name: $productName<br>";
    echo "Description: $description<br>";
    echo "Cost: $cost<br>";
    echo "Sell Price: $sellPrice<br>";
    echo "Quantity: $quantity<br>";
    echo "Vendor ID: $vendorId<br>";
    echo "Employee ID: $employeeId<br>";


    // Validate input data
    validateCostAndSellPrice($cost, $sellPrice);
    validateQuantity($quantity);

    // insert product
    try{
        $query = "SELECT name FROM 2023F_lintzuh.PRODUCT WHERE name = '$productName'";
        $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "A product with the same name $productName already exists.<br>";
            echo '<button onclick="history.go(-1);">Go Back</button>';
            exit();
        }
        
        // Insert data into database
        $query = "INSERT INTO 2023F_lintzuh.PRODUCT (name, description, cost, sell_price, quantity, vendor_id, employee_id)
                VALUES ('$productName', '$description', $cost, $sellPrice, $quantity, $vendorId, $employeeId)";
        
        if (mysqli_query($con, $query)) {
            echo "New product $productName added successfully.";
            echo '<br><a href="employee_home_redirect.php"><button>Go to Employee Home Page</button></a>';
            echo '<br><a href="../index.html"><button>Go to Project Home Page</button></a>';
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
        

    } 
    catch (Exception $e){
        $error = $e->getMessage();
        echo $error;
    }


}
?>

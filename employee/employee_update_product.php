<?php


echo "<a href='employee_logout.php'>Employee logout</a><br>";
session_start();
include "../dbconfig.php";
include "validationFunction.php";
include "helperFunction.php";
// fetch employee_id in session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE 2023F_lintzuh.PRODUCT SET 
        name = ?, 
        description = ?, 
        cost = ?, 
        sell_price = ?, 
        quantity = ?, 
        vendor_id = ?
        WHERE id = ?";
    $val_errors = []; // Initialize your errors array
    $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
    $updateNo=0;
    $attemp=0;

    try {
        if ($stmt = mysqli_prepare($con, $sql)) {
            foreach ($_POST['id'] as $i => $product_id) {
                $name = ($_POST['name'][$i]);
                $description = ($_POST['description'][$i]);
                $cost = ($_POST['cost'][$i]);
                $sell_price = ($_POST['sell_price'][$i]);
                $quantity = ($_POST['quantity'][$i]);
                $vendor_id = ($_POST['vendor_id'][$i]);

                // Validate the inputs
                validateName($name, $product_id, $val_errors);
                validateDescription($description, $product_id, $val_errors);
                validateCostSellPrice($cost, $sell_price, $product_id, $val_errors);
                validateQuantityUpdated($quantity, $product_id, $val_errors);
                validateVendorID($vendor_id, $product_id, $val_errors);

                if (!empty($val_errors[$product_id])) {
                    $attemp++;
                    continue;
                }

                // Bind the parameters and execute the statement for each product
                mysqli_stmt_bind_param($stmt, "ssddiii", 
                $name, 
                $description, 
                $cost, 
                $sell_price, 
                $quantity, 
                $vendor_id,
                $product_id  
                );
            
                // Execute the statement
                if (mysqli_stmt_execute($stmt)) {
                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        echo "Record for product ID {$product_id} updated successfully.<br>";
                        
                        // update the employee_id
                        updateLastUpdated($product_id, $con);
                        $updateNo++;

                    }
                } else {
                    // Update failed
                    echo "ERROR: Could not execute query for product ID {$product_id}. " . mysqli_error($con) . "<br>";
                }
            }
        }
    }
    catch (Exception $e){
        $error = $e->getMessage();
        echo $error;
    }

    foreach ($val_errors as $product_id => $product_errors) {
        if (!empty($product_errors)) {
            echo "Errors for product ID $product_id:<br>";
            foreach ($product_errors as $error_msg) {
                echo htmlspecialchars($error_msg) . "<br>";
            }
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

if ($updateNo==0 and $attemp==0){
    echo "No product was updated, because you didn't update anything.";
}

echo '<br><a href="employee_home.php"><button>Go to Employee Home Page</button></a>';
echo '<br><a href="../index.html"><button>Go to Project Home Page</button></a>';
// Close connection
mysqli_close($con);








?>
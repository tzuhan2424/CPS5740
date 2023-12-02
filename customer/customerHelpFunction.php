<?php
function setCustomerSearchHistoryCookie($search_items){
    setcookie("customer_search", $search_items, time() + 3600, '/'); // Set cookie for customer ID
}


function setCustomerCookie($customer_id, $name){
    setcookie("customer_id", $customer_id, time() + 3600, '/'); // Set cookie for customer ID
    setcookie("customer_name", $name, time() + 3600, '/'); // Set cookie for customer role
}

function setCustomerSession($customer_id, $name, $customer_address){
    session_start();
    $_SESSION["customer_id"] = $customer_id;
    $_SESSION["customer_name"] = $name;
    $_SESSION["customer_address"] = $customer_address;
}

function checkLoginAndRedirect() {
    if (!(checkCustomerSession() && checkCustomerCookie())) {
        echo "You must login.";
        echo '<a href="./customer_login.php">
                  <button type="button">Go to Login</button>
              </a>';
        exit();
    } 
}

function checkCustomerCookie() {
    return (isset($_COOKIE["customer_id"]) && isset($_COOKIE["customer_name"]));
}

function checkCustomerSession(){
    return (isset($_SESSION['customer_id']) && isset($_SESSION['customer_name']));
}
function checkPassword($usr_password, $password_att) {
    return $usr_password === $password_att;

}

function deleteSession(){

    session_start();
    $_SESSION = array();
    session_destroy();
}
function deleteCustomerCookie(){
    //delete cookie
    $cookie_name1 = "customer_id";
    $cookie_name2 = "customer_name";
    $cookie_name3='customer_address';
    unset($_COOKIE[$cookie_name1]);
    unset($_COOKIE[$cookie_name2]);
    unset($_COOKIE[$cookie_name3]);

    // empty value and expiration one hour before
    $res1 = setcookie($cookie_name1, '', time() - 3600, '/');
    $res2 = setcookie($cookie_name2, '', time() - 3600, '/');
    $res3 = setcookie($cookie_name3, '', time() - 3600, '/');

    echo "You successfully logout<br>";

}

function getOrderID($con){
    $customer_id = $_SESSION['customer_id'];
    $sql = "SELECT E.id AS order_id FROM 2023F_lintzuh.CUSTOMER F JOIN 2023F_lintzuh.`ORDER` E ON F.customer_id = E.customer_id WHERE F.customer_id = '$customer_id'";
    $result = mysqli_query($con, $sql);

    $order_ids = [];
    if (mysqli_num_rows($result) > 0) {
        // Store order_id in an array
        while($row = mysqli_fetch_assoc($result)) {
            $order_ids[] = $row['order_id'];
        }
    } else {
        echo "0 results";
    }
    return $order_ids;

}



function customerSearchQueryNonCaseSensitive($search_input){
    if ($search_input == '*') {
        $sql = "SELECT p.id, p.name as product_name, description, sell_price, quantity, v.name as vendor_name 
                FROM 2023F_lintzuh.PRODUCT p, CPS5740.VENDOR v
                where p.vendor_id = v.vendor_id
                order by id;";
        return $sql;
    }else{
        $search_terms = explode(' ', $search_input);
        $conditions = [];
        foreach ($search_terms as $term) {
            $conditions[] = "(LOWER(p.name) LIKE LOWER('%{$term}%') OR LOWER(p.description) LIKE LOWER('%{$term}%'))";
        }
        $condition_str = implode(' OR ', $conditions);
    
        $sql = "SELECT p.id, p.name as product_name, description, sell_price, quantity, v.name as vendor_name 
                FROM 2023F_lintzuh.PRODUCT p, CPS5740.VENDOR v
                WHERE p.vendor_id = v.vendor_id AND ($condition_str)
                ORDER BY id;";
        return $sql;
    }
}




function ADrecommendationSQL(){
    $lastSearch = isset($_COOKIE['customer_search']) ? $_COOKIE['customer_search'] : null;
    // echo $lastSearch;
    if ($lastSearch){
      $search_terms = explode(' ', $lastSearch ?? '');
      $conditions = [];
      foreach ($search_terms as $term) {
          $conditions[] = "(LOWER(category) LIKE LOWER('%{$term}%') OR LOWER(description) LIKE LOWER('%{$term}%'))";
      }
      $condition_str = implode(' OR ', $conditions);
      $sql= "select category, image, description, url from CPS5740.Advertisement where ($condition_str) limit 1;";
    }
    else{
      $sql = "select category, image, description, url from CPS5740.Advertisement where category = 'OTHER'";
    }
  
    return $sql;
  }

function validationOfInputList($ordered_quantities, $product_names ,&$isValidTransactionList){
    // echo '<pre>';
    // echo 'Ordered Quantities: ';
    // print_r($ordered_quantities);
    
    
    $valid_quantities = []; // Array to store valid quantities
    
    foreach ($ordered_quantities as $product_id => $quantity) {
        $name = isset($product_names[$product_id]) ? htmlspecialchars($product_names[$product_id]) : "Unknown Product";
    
        if (!is_numeric($quantity) || preg_match('/^0+[0-9]+$/', $quantity) || strpos($quantity, '.') !== false) {
            if (!empty($quantity)){
                echo "Invalid Quantity for '$name': '$quantity' is not a valid number.<br>";
                $isValidTransactionList=false;
            }
        }
        elseif($quantity < 0){
            echo "Invalid Quantity for '$name': Quantity cannot be negative. Entered: $quantity.<br>";
            $isValidTransactionList=false;
        }
        elseif($quantity!=0){
            $valid_quantities[$product_id] = (int)$quantity;
        }
    }
    echo '<pre>';    
    echo '<br>Valid Quantities: ';
    print_r($valid_quantities);
    echo '</pre>';
    
    if (empty($valid_quantities)) {
        // Handle the case where all quantities are null or zero
        echo "You have no valid quantity for the orders<br>";
        $isValidTransactionList=false;
    }

    return [$isValidTransactionList, $valid_quantities];
}


?>
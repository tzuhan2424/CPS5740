<?php
// The '&' before '$errors' indicates that the array is passed by reference,
// allowing the function to modify the original array.
function validateName($name, $product_id, &$errors) {
    if ($name === '') {
        $errors[$product_id][] = "Product name cannot be empty.";
    }
}
function validateDescription($description, $product_id, &$errors) {
    if (trim($description) === '') {
        $errors[$product_id][] = "Description cannot be empty or just whitespace.";
    }
}

function validateCostSellPrice($cost, $sell_price,$product_id, &$errors) {
    if (!is_numeric($cost) || $cost < 0) {
        $errors[$product_id][] = "Cost must be a non-negative number.";
    }

    if (!is_numeric($sell_price) || $sell_price < 0) {
        $errors[$product_id][] = "Sell price must be a non-negative number.";
    }

    if (is_numeric($cost) && is_numeric($sell_price) && ($cost >= $sell_price)) {
        $errors[$product_id][] = "Cost must be less than sell price.";
    }
}



function validateQuantityUpdated($quantity, $product_id, &$errors) {
    if (!is_numeric($quantity) || $quantity < 0) {
        $errors[$product_id][] = "Quantity must be a non-negative number.";
    }
}
function validateVendorID($vendor_id, $product_id, &$errors) {
    if ($vendor_id === '') {
        $errors[$product_id][] = "Vendor ID cannot be empty.";
    }
}

?>
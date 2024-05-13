<?php
include "../dbconfig.php";
include 'customerHelpFunction.php';
session_start();
checkLoginAndRedirect();

$customer_address = $_SESSION['customer_address'];
$customer_name = $_SESSION['customer_name'];
$customer_id = $_SESSION['customer_id'];

echo <<<HTML
<HTML>
<head>
<link rel="stylesheet" type="text/css" href="Customer.css">
</head>
Welcome customer: <b>{$customer_name}</b>
<br>{$customer_address}
<br><a href='customer_logout.php'>Customer logout</a>
<br><a href='customer_order_history.php'>View my order history</a>
<br>Search product (* for all):
<form name="input" action="search_product.php" method="get">
  <input type="text" name="search_items">
  <input type="submit" value="Search">
</form>
HTML;




$sql = ADrecommendationSQL();

try{
  $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
  $result = mysqli_query($con, $sql);
  if(mysqli_num_rows($result) == 0){
    // fetch default content
    $sql2="select category, image, description, url from CPS5740.Advertisement where category = 'OTHER'";
    $result2 = mysqli_query($con, $sql2);
    $ad = mysqli_fetch_assoc($result2);
  }else{
    $ad = mysqli_fetch_assoc($result);
  }


  if($ad) {
    echo '<a href="' . htmlspecialchars($ad['url'] ?? '') . '">';
    echo "<br><img src='data:image/jpeg;base64," . base64_encode($ad['image']) . "' class='my-custom-image'/>\n";
    echo '</a>';
    echo '<p>' . htmlspecialchars($ad['description']) . '</p>';
  }else {
      echo 'Default Ad Content Here';
  }

  mysqli_close($con);

}catch (Exception $e){
  $error = $e->getMessage();
  echo $error;
}


// <br>Your Ad here from $50
echo "<br><br><a href='../index.html'>project home page</a>";




?>

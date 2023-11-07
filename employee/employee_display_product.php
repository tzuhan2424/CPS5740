<?php
    include 'helperFunction.php';
    include '../dbconfig.php';
    session_start();
    checkLoginAndRedirect();
    echo "<a href='employee_logout.php'>Employee logout</a><br>";



    $search_input = $_POST['search_items'];
    echo "Product list for search keyword: ".$search_input;    
    $sql = searchQueryNonCaseSensitive($search_input);


    // echo "<br>".$sql;

    try{
        $con = mysqli_connect($db_server, $db_login, $db_password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");
        $result = mysqli_query($con, $sql);

        if(mysqli_num_rows($result) == 0){
            echo "<br><font color= 'red'>No records found.</font>";
        }
        else{ 
            //display all thing
            echo "<form action='employee_update_product.php' method='post'>";
            echo "<TABLE border=1>\n<br>";
            echo "<TR><TH>ProductID<TH>Product Name<TH>Description<TH>Cost<TH>Sell Price<TH>Available quantity<TH>Vendor name<TH>Last update by\n";
            
            $i=0;
            while($row = mysqli_fetch_array($result)){
                $db_id=$row['id'];
                $db_name=$row['name'];
                $db_desc = $row['description'];
                $db_cost = $row['cost'];
                $db_sellprice = $row['sell_price'];
                $db_quantity = $row['quantity'];
                $db_vendorID = $row['vendor_id'];
                $db_employeeID = $row['employee_id'];


                

                echo "<tr>";
                echo "<td>{$db_id}</td>";
                echo "<input type='hidden' name='id[$i]' value='{$db_id}'>";
                echo "<td><input type='text' name='name[$i]' value='{$db_name}'></td>";
                echo "<td><input type='text' name='description[$i]' value='{$db_desc}'></td>";
                echo "<td><input type='text' name='cost[$i]' value='{$db_cost}'></td>";
                echo "<td><input type='text' name='sell_price[$i]' value='{$db_sellprice}'></td>";
                echo "<td><input type='text' name='quantity[$i]' value='{$db_quantity}'></td>";
                
                
                // vendor name dropdown list
                echo "<td><select name='vendor_id[$i]'>";
                $vendor_sql = "select vendor_id, name from CPS5740.VENDOR"; 
                $vendor_result = mysqli_query($con, $vendor_sql);
                while($vendor_row = mysqli_fetch_array($vendor_result)) {
                    $vendorID = $vendor_row['vendor_id']; 
                    $vendorName = $vendor_row['name']; 
                    echo "<option value='{$vendorID}'" . ($vendorID == $db_vendorID ? ' selected="selected"' : '') . ">{$vendorName}</option>";
                }
                echo "</select></td>";    
                
                

                // employee name display
                $employee_sql = "select name from CPS5740.EMPLOYEE2 where employee_id = '$db_employeeID'";
                $employee_result = mysqli_query($con, $employee_sql);
                while($row = mysqli_fetch_array($employee_result)){
                    $employee_name = $row['name'];
                    echo "<td>{$employee_name}</td>";
                }
                echo "</tr>\n";
                $i++;





            }

            echo "</table>";
            echo "<input type='submit' value='Update Products'></form>";


            echo '<br><a href="employee_home.php"><button>Go to Employee Home Page</button></a>';
            echo '<br><a href="../index.html"><button>Go to Project Home Page</button></a>';



        }

    } 
    catch (Exception $e){
        $error = $e->getMessage();
        echo $error;
    }






function vendorDropdownlistUpdat(){

}




?>
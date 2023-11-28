<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="./table.css">
</head>
<body>
    <?php
        include "../dbconfig.php";
        include 'helperFunction.php';
        include 'reportFunction.php';
        session_start();
        checkLoginAndRedirect();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['report_period'])) {
                $reportPeriod = $_POST['report_period'];
            }
            if (isset($_POST['report_type'])) {
                $reportType = $_POST['report_type'];
            }

            if ($reportType == 'all'){
                AllSalesReport($reportPeriod, $reportType);
            }elseif ($reportType == 'products') {
                ProductReport($reportPeriod, $reportType);    
            }elseif ($reportType == 'vendors'){
                VendorReport($reportPeriod, $reportType);
            }else{
                echo 'wrong';
            }

        }
    ?>
</body>
</html>


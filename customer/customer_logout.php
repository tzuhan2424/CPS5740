<?php
include 'customerHelpFunction.php';
deleteSession();
deleteCustomerCookie();
?>
<!DOCTYPE html>
<html>
<body>
    <p>You have been logged out. Redirecting to the home page in 1 seconds...</p>

    <script>
        setTimeout(function() {
            window.location.href = '../index.html';
        }, 1000); // 3000 milliseconds = 3 seconds
    </script>
</body>
</html>

<?php
include 'helperFunction.php';
deleteEmployeeCookie();
?>
<!DOCTYPE html>
<html>
<body>
    <p>You have been logged out. Redirecting to the home page in 3 seconds...</p>

    <script>
        setTimeout(function() {
            window.location.href = '../index.html';
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>
</body>
</html>

<?php require'config/function.php'; ?>

<?php
if(isset($_SESSION['loggedIn'])){

    loggoutSession();
    redirect('login.php','Logged Out Successfully.');
}
?>
<?php
    define('DB_SEVER',"sql12.freesqldatabase.com");
    define('DB_USERNAME',"sql12810641");
    define('DB_PASSWORD',"vYDVH7xKya");
    define('DB_DATABASE','sql12810641');

    $conn = mysqli_connect(DB_SEVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    
    if(!$conn){
        die("Connection Failed:".mysqli_connect_error());
    }
 ?> 
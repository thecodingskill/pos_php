<?php
session_start();

require 'dbcon.php';


// Input Field Validation
function validate($inputData)
{
    global $conn;

    $validateData =  mysqli_real_escape_string($conn, $inputData);
    return trim($validateData);
}


// Redirect from 1 page to another Page with the message
function redirect($url, $status)
{
    $_SESSION['status'] = $status;
    header('Location:' . $url);
    exit(0);
}

//  Display message or status after any process.

function alertMessage()
{

    if (isset($_SESSION['status'])) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            ' . $_SESSION['status'] . '
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        // from bostrap
        unset($_SESSION['status']);
    }
}

// Insert record using this function    

function insert($tableName,$data){

    global $conn;

    $table =  validate($tableName);

    $columns = array_keys($data);
    $values = array_values($data);

    $finalColumn = implode(',',$columns);
    $finalValues = "'".implode("','", $values)."'";

    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";

    $result = mysqli_query($conn,$query);

    return $result;
}


// function insert($tableName,$data)
// {
//     global $conn;
//     $table = validate($tableName);
//     $cols = array_keys($data);
//     $vals = array_values($data);
//     $finalCols = implode(',', $cols);
//     $finalVals = "''" .implode("''",$vals)."''";
//     $query = "INSERT INTO $table($finalCols) VALUES($finalVals)";
//     $result = mysqli_query($conn, $query);
//     return  $result;    
 
// }

// Update data using this function

function update($tableName, $id, $data)
{

    global $conn;

    $table =  validate($tableName);
    $id = validate($id);

    $updateDataString = "";

    foreach ($data as $columns => $values) {
        $updateDataString .= $columns . '=' . "'$values',";
    }

    $finalUpdateData = substr(trim($updateDataString), 0, -1);

    $query = "UPDATE $table SET $finalUpdateData WHERE id ='$id'";
    $result = mysqli_query($conn, $query);
    return $result;
}
//  Get all data 

function getAll($tableName, $status = NULL)
{

    global $conn;

    $table = validate($tableName);
    $status = validate($status);

    if ($status == 'status') {

        $query = "SELECT * FROM $table where status='0'";
    } else {
        $query = "SELECT * FROM $table";
    }
    return mysqli_query($conn, $query);
}
// get data using id
function getByid($tableName, $id)
{

    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id ='$id' LIMIT 1 ";
    $result = mysqli_query($conn, $query);

    if ($result) {

        if (mysqli_num_rows($result) == 1) {

            // $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $row = mysqli_fetch_assoc($result);  //choice
            $respone = [
                'status' => 200,
                'data' => $row,
                'message' => 'Record Found!'
            ];
            return $respone;
        } else {
            $respone = [
                'status' => 404,
                'message' => 'No Data Found!'
            ];
            return $respone;
        }
    } else {
        $respone = [
            'status' => 500,
            'message' => 'Something Went Wrong!'
        ];
        return $respone;
    }
}

// Delete Data from database using id

function delete($tableName, $id)
{
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    return $result;
}

function checkParamId($type){
    
    if(isset($_GET[$type])){
        if($_GET[$type] != ''){
            return $_GET[$type];

        }else{
            return '<h5>No Id Found!</h5>';

        }

    }else{
        return'<h5>No Id Given</h5>';
    }
}


// <!-- Logged Out Function -->

function loggoutSession(){
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}

// <!-- Json Respone -->

function jsonRespone($status,$status_type,$message){

    $respone =[
        'status' => $status,
        'status_type'=>$status_type,
        'message' => $message
    ];
    echo json_encode($respone);
    return;
}
// Count Function
function getcount($tableName){

    global $conn;
    $table = validate($tableName);
    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($conn,$query);

    if($query_run){

        $totalCount = mysqli_num_rows($query_run);
        return $totalCount;

    }else{
        return 'Something Went Wrong!';
    }

}

function getcountStock($tableName, $lowerStockThreshold) {
    global $conn;

    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $tableName);

    // Prepare and execute the query
    $query = "SELECT COUNT(*) AS totalCount FROM $table WHERE quantity = 0 OR quantity < $lowerStockThreshold";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $row = mysqli_fetch_assoc($query_run);
        return $row['totalCount'];
    } else {
        return 'Something Went Wrong!';
    }
}

?>


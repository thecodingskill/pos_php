<?php
require '../config/function.php';
$customer_id = checkParamId('id');
if (is_numeric($customer_id)) {

   $customer_id = validate($customer_id);

    $customer = getByid('customers', $customer_id);

    if ($customer['status'] == 200) {

        $customerDeleteRes = delete('customers', $customer_id);

        if ($customerDeleteRes) {

            redirect('customers.php', 'Customer Deleted Successfully');
        } else {
            redirect('customers.php',  'Something Went Wrong.');
        }
    } else {
        redirect('categories.php', $customer_id['message']);
    } 
} else {
    redirect('customers.php', 'Id is not a number!');
}

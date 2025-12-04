<?php
require '../config/function.php';

$supplier_id = checkParamId('id');
if (is_numeric($supplier_id)) {

   $supplier_id = validate($supplier_id);

    $suppler = getByid('suppliers', $supplier_id);

    if ($suppler['status'] == 200) {

        $supplierDeleteRes = delete('suppliers', $supplier_id);

        if ($supplierDeleteRes) {

            redirect('suppliers.php', 'Supplier Deleted Successfully');
        } else {
            redirect('suppliers.php',  'Something Went Wrong.');
        }
    } else {
        redirect('suppliers.php', $supplier_id['message']);
    } 
} else {
    redirect('suppliers.php', 'Id is not a number!');
}

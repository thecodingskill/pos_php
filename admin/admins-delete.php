<?php
require '../config/function.php';
$paraResultId = checkParamId('id');
if (is_numeric($paraResultId)) {

    $adminId = validate($paraResultId);

    $admin = getByid('admins', $adminId);

    if ($admin['status'] == 200) {
        $admin_deleteRes = delete('admins', $adminId);

        if ($admin_deleteRes) {

            redirect('admins.php', 'Admin Deleted Successfully');
        } else {
            redirect('admins.php',  'Something Went Wrong.');
        }
    } else {
        redirect('admins.php', $adminId['message']);
    } 
} else {
    redirect('admins.php', 'Something Went Wrong.');
}

<?php
require '../config/function.php';
$produt_id = checkParamId('id');

if (is_numeric($produt_id)) {

    $product_id = validate($produt_id);

    $productData = getByid('products', $product_id);
 
    if ($productData['status'] == 200) {

        $adminDeleteRes = delete('products', $product_id);

        if ($adminDeleteRes) {

            $deleteImage = "../".$productData['data']['image'];
            
        if(file_exists($deleteImage)){
            unlink($deleteImage);

        }

            redirect('products.php', 'Product Deleted Successfully');
        } else {
            redirect('products.php',  'Something Went Wrong.');
        }
    } else {
        redirect('products.php', $product_id['message']);
    }
} else {
    redirect('products.php', 'Id is not a number');
}

<?php
include('../config/function.php');
// Insert Admins
if (isset($_POST['saveAdmin'])) {
    // Validation Data From Form

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = validate($_POST['is_ban']) == true ? 1 : 0;



    if ($name != '' && $email != '' && $password != '') {
        // To check data validation --> If not empty return true ---> False

        if (!is_numeric($phone) || strlen($phone) != 9 && strlen($phone) != 10) {
            redirect('admins-create.php', 'Invalid phone number.');
            exit;
        }


        $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email ='$email'");
        if ($emailCheck) {

            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('admins-create.php', "Email Already used by another user");
            } else {
                $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

                $data = [
                    'name' => $name,
                    'email' => $email,
                    'password' => $bcrypt_password,
                    'phone' => $phone,
                    'is_ban' => $is_ban
                ];
                $result = insert('admins', $data);
            }

            if ($result) {
                redirect('admins.php', 'Admin Created Successfully!');
            } else {
                redirect('admins-create.php', 'Something went wrong! Please try again.');
            }
        }
    } else {
        redirect('admins-create.php', 'Please fill requiered fields.');
    }
}

//  Update Admins

if (isset($_POST['updateAdmin'])) {

    // Validate data & select data by id using function

    $adminId = validate($_POST['adminId']);
    $adminData = getByid('admins', $adminId);
    if ($adminData['status'] != 200) {  // check if no data row return to endit back
        redirect('admins-edit.php', 'Please fill requiered fields.');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = validate($_POST['is_ban']) == true ? 1 : 0;

    if ($password != '') {
        $hashedpassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedpassword = $adminData['data']['password'];
    }

    if ($name != '' && $email != '' && $phone != '') {

        if (!is_numeric($phone) || strlen($phone) != 9 && strlen($phone) != 10) {
            redirect('admins-edit.php?id=' . $adminId, 'Invalid phone number.');
            exit;
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedpassword,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];
        $result = update('admins', $adminId, $data);

        if ($result) {
            redirect('admins-edit.php?id=' . $adminId, 'Admin Updated Successfully!');
        } else {
            redirect('admins-edit.php', 'Something went wrong! Please try again.');
        }
    } else {

        redirect('admins-edit.php?id=' . $adminId, 'Please fill requiered fields.');
    }
}

// Category Insert

if (isset($_POST['saveCategory'])) {

    $name = validate($_POST['name']);
    $dec = validate($_POST['dec']);
    $status = isset($_POST['status']) == true ? 1 : 0;


    $data = [
        'name' => $name,
        'description' => $dec,
        'status' => $status
    ];
    $result = insert('categories', $data);

    if ($result) {
        redirect('Categories.php', 'Category Created Successfully!');
    } else {
        redirect('categories-create.php', 'Something went wrong! Please try again.');
    }
}

// Update Category
if (isset($_POST['updateCategory'])) {

    $paramValue = validate($_POST['categoryId']);

    $category = getByid('categories', $paramValue);

    if ($category['status'] != 200) {
        redirect('categories-edit.php', 'Please fill requiered fields.');
    }

    $name = validate($_POST['name']);
    $dec = validate($_POST['dec']);
    $status = validate($_POST['status']) == true ? 1 : 0;

    if ($name != '') {

        $data = [
            'name' => $name,
            'description' => $dec,
            'status' => $status
        ];
        $result = update('categories', $paramValue, $data);

        if ($result) {
            redirect('categories-edit.php?id=' . $paramValue, 'Category Updated Successfully!');
        } else {
            redirect('categories-edit.php', 'Something went wrong! Please try again.');
        }
    } else {

        redirect('categories-edit.php?id=' . $paramValue, 'Please fill requiered fields.');
    }
}


// Saving products

if (isset($_POST['saveProduct'])) {

    $categoryId = validate($_POST['category_id']);
    $supplierId = validate($_POST['supplier_id']);
    $adminId = validate($_POST['admin_id']);
    $name = validate($_POST['name']);
    $dec = validate($_POST['dec']);
    $status = isset($_POST['status']) == true ? 1 : 0;
    $size = validate($_POST['size']);
    $color = validate($_POST['color']);
    $quantity = validate($_POST['quantity']);
    $purchasePrice = validate($_POST['purchase_price']);
    $salePrice = validate($_POST['sale_price']);



    if($name != '' && $categoryId != '' && $supplierId != '' && $adminId != '' && $size !='' && $color 
    !='' && $salePrice !='' && $purchasePrice !=''){

    if ($_FILES['image']['size'] > 0) {

        //if image export will move to the path of image_forlder 

        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $fileName = time() . '.' . $image_ext;

        move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $fileName);

        $finalImage = "assets/uploads/products/" . $fileName;
    } else {
        $finalImage = "";
    }

    $data = [
        'name' => $name,
        'category_id' => $categoryId,
        'supplier_id' => $supplierId,
        'admin_id' => $adminId,
        'description' => $dec,
        'image' => $finalImage,
        'status' => $status,
        'sale_price' => $salePrice,
        'purchase_price' => $purchasePrice,
        'color' => $color,
        'size' => $size,
        'quantity' => $quantity
    ];
    $result = insert('products', $data);

    if ($result) {
        redirect('products.php', 'Product Created Successfully!');
    } else {
        redirect('products-create.php', 'Something went wrong! Please try again.');
    }
} else{
    redirect('products-create.php', 'Please fill in all required fields.');
}

}

//Update Product

if (isset($_POST['updateProduct'])) {

    $product_id = validate($_POST['product_id']);

    $productData = getByid('products', $product_id);

    if (!$productData) {
        redirect('products.php', 'No such product found');
        exit;
    }

    $categoryId = validate($_POST['category_id']);
    $supplierId = validate($_POST['supplier_id']);
    $adminId = validate($_POST['admin_id']);
    $name = validate($_POST['name']);
    $dec = validate($_POST['dec']);
    $status = isset($_POST['status']) == true ? 1 : 0;
    $size = validate($_POST['size']);
    $color = validate($_POST['color']);
    $quantity = validate($_POST['quantity']);
    $purchasePrice = validate($_POST['purchase_price']);
    $salePrice = validate($_POST['sale_price']);

    if($name != '' && $categoryId != '' && $supplierId != '' && $adminId != ''
     && $salePrice !='' && $purchasePrice !=''){


    if ($_FILES['image']['size'] > 0) {


        $path = "../assets/uploads/products";

        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $fileName = time() . '.' . $image_ext;

        move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $fileName);

        $finalImage = "assets/uploads/products/" . $fileName;

        $deleteImage = "../" . $productData['data']['image'];

        if (file_exists($deleteImage)) {
            unlink($deleteImage);
        }
    } else {
        $finalImage = $productData['data']['image'];
    }

    $data = [
        'name' => $name,
        'category_id' => $categoryId,
        'supplier_id' => $supplierId,
        'admin_id' => $adminId,
        'description' => $dec,
        'image' => $finalImage,
        'status' => $status,
        'sale_price' => $salePrice,
        'purchase_price' => $purchasePrice,
        'size' => $size,
        'color' => $color,
        'quantity' => $quantity
    ];
    $result = update('products', $product_id, $data);

    if ($result) {
        redirect('products-edit.php?id=' . $product_id, ' Updated Successfully!');
    } else {
        redirect('products-edit.php?id=' . $product_id, 'Something went wrong! Please try again.');
    }
}else{
    redirect('products-edit.php?id=' . $product_id, ' Please fill in all required fields.');
}
}

// Insert Customer

if (isset($_POST['saveCustomer'])) {

    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    if ($name != '') {

        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('customers-create.php', 'Email Already used by another customer');
            }
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status
        ];
        $result = insert('customers', $data);

        if ($result) {
            redirect('Customers.php', 'Customer Created Successfully!');
        } else {
            redirect('customers-create.php', 'Something went wrong! Please try again.');
        }
    } else {
        redirect('customers-create.php', 'Please fill requiered fields.');
    }
}

// Update Customer

if (isset($_POST['updateCustomer'])) {

    $customer_id = validate($_POST['customer_id']);

    $customer = getByid('customers', $customer_id);

    if ($customer['status'] != 200) {
        redirect('customers-edit.php', 'Please fill requiered fields.');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = validate($_POST['status']) == true ? 1 : 0;

    if ($name != '') {

        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email' AND id !='$customer_id'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('customers-edit.php?id=' . $customer_id, 'Email Already used by another customer');
            }
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status
        ];
        $result = update('customers', $customer_id, $data);

        if ($result) {
            redirect('customers-edit.php?id=' . $customer_id, 'Customer Updated Successfully!');
        } else {
            redirect('customers-edit.php', 'Something went wrong! Please try again.');
        }
    } else {

        redirect('customers-edit.php?id=' . $customer_id, 'Please fill requiered fields.');
    }
}

// Save Supplier

if (isset($_POST['saveSupplier'])) {
    $phone = validate($_POST['phone']);
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $address = validate($_POST['address']);
    $company = validate($_POST['company']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    if ($phone && $name   && $company !='') {

        if (!is_numeric($phone) || strlen($phone) != 9 && strlen($phone) != 10) {
            redirect('suppliers-create.php', 'Invalid phone number.');
            exit;
        }

        $emailCheck = mysqli_query($conn, "SELECT * FROM suppliers WHERE email = '$email'");

        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('suppliers-create.php', 'Email Already used by another Supplier.');
            }
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'company' => $company,
            'status' => $status

        ];

        $result = insert('suppliers', $data);

        if ($result) {
            redirect('suppliers.php', 'Supplier Created Successfully.');
        } else {
            redirect('suppliers-create.php', 'Something Went Wrong!');
        }
    }else{
        redirect('suppliers-create.php', 'Please fill required fields!');
      
    }
}

// Update Supplier

if (isset($_POST['updateSupplier'])) {

    $supplier_id = validate($_POST['supplier_id']);

    $supplier = getByid('suppliers', $supplier_id);

    if ($supplier['status'] != 200) {
        redirect('suppliers-edit.php', 'Please fill requiered fields.');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $address = validate($_POST['address']);
    $company = validate($_POST['company']);
    $status = validate($_POST['status']) == true ? 1 : 0;

    if ($phone && $name && $company !='') {

        $emailCheck = mysqli_query($conn, "SELECT * FROM suppliers WHERE email = '$email' AND id != '$supplier_id'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('suppliers-edit.php?id='. $supplier_id, 'Email Already used by another Supplier');
            }
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'company' => $company,
            'status' => $status
        ];

        $result = update('suppliers', $supplier_id, $data);

        if ($result) {
            redirect('suppliers-edit.php?id=' . $supplier_id, 'Supplier Updated Successfully!');
        } else {
            redirect('suppliers-edit.php', 'Something went wrong! Please try again.');
        }
    } else {

        redirect('suppliers-edit.php?id='. $supplier_id, 'Please fill requiered fields.');
    }
}


?>
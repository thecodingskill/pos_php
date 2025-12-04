<?php
include('../config/function.php');

if (!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}

if (!isset($_SESSION['productItemIds'])) {
    $_SESSION['productItemIds'] = [];
}


if (isset($_POST['addItem'])) {

    $pro_id = validate($_POST['product_id']);
    $qty = validate($_POST['qty']);

    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id = '$pro_id' LIMIT 1");

    if ($checkProduct) {

        if (mysqli_num_rows($checkProduct) > 0) {

            $row = mysqli_fetch_assoc($checkProduct);

            if ($row['quantity'] < $qty) {
                redirect('orders-create.php', 'Only' . ' ' . $row['quantity'] . ' ' . 'Quantity available!');
            }

            $proData = [
                'product_id' => $row['id'],
                'name' => $row['name'],
                'size' => $row['size'],
                'color' => $row['color'],
                'image' => $row['image'],
                'sale_price' => $row['sale_price'],
                'quantity' => $qty
            ];

            // The right Value is the name to store in the  SESSION

            if (!in_array($row['id'], $_SESSION['productItemIds'])) {

                array_push($_SESSION['productItemIds'], $row['id']);
                array_push($_SESSION['productItems'], $proData);
            } else {

                foreach ($_SESSION['productItems'] as $key => $proSessionItem) {

                    if ($proSessionItem['product_id'] == $row['id']) {

                        $newQuantity = $proSessionItem['quantity'] + $qty;

                        $proData = [
                            'product_id' => $row['id'],
                            'name' => $row['name'],
                            'size' => $row['size'],
                            'color' => $row['color'],
                            'image' => $row['image'],
                            'sale_price' => $row['sale_price'],
                            'quantity' => $newQuantity
                        ];
                        $_SESSION['productItems'][$key] = $proData;
                    }
                }
            }
            redirect('orders-create.php', 'Item added' . ' ' . $row['name']);
        } else {
            redirect('orders-create.php', 'No such product found!');
        }
    } else {
        redirect('orders-create.php', 'Something Went Wrong!');
    }
}

// Increment and Discrement Product Value from the Custom.Js

if (isset($_POST['productIncDec'])) {
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $flag = false;

    foreach ($_SESSION['productItems'] as $key => $item) {

        if ($item['product_id'] == $productId) {

            $flag = true;

            $_SESSION['productItems'][$key]['quantity'] = $quantity;
        }
    }
    if ($flag) {

        jsonRespone(200, 'Success', 'Quantity Updated!');
    } else {

        jsonRespone(500, 'error', 'Something Went Wrong. Please re-fresh');
    }
}

// Place the order

if (isset($_POST['processedToPlaceBtn'])) {
    $cphone = validate($_POST['cphone']);
    $payment_method = validate($_POST['payment_method']);

    // checking the customer by phone number input to place the order 

    $checkCustomer = mysqli_query($conn,  "SELECT * FROM customers WHERE phone = '$cphone' LIMIT 1");

    if ($checkCustomer) {
        if (mysqli_num_rows($checkCustomer) > 0) {
            $_SESSION['invoice_no'] = "INV" . rand(111111, 999999);
            $_SESSION['cphone'] = $cphone;
            $_SESSION['payment_method'] = $payment_method;
            jsonRespone(200, 'success', 'Customer Found');
        } else {
            $_SESSION['cphone'] = $cphone;
            jsonRespone(404, 'error', 'Customer Not Found');
        }
    } else {
        jsonRespone(500, 'error', 'Something Went Wrong');
    }
}

// Svae the Customer form the Pop Up Form 

if (isset($_POST['saveCustomerBtn'])) { // The SaveCustomerBtn From JQuery Code
    $name  = validate($_POST['name']);
    $phone  = validate($_POST['phone']);
    $email  = validate($_POST['email']);

    if ($name != '' && $phone != '') {

        $data = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,

        ];
        $result = insert('customers', $data);

        if ($result) {
            jsonRespone(200, 'success', 'Customer Created Successfully');
        } else {
            jsonRespone(500, 'error', 'Something Went Wrong');
        }
    } else {
        jsonRespone(422, 'warning', 'Please fll required fields');
    }
}

// Save Order_To_DB

if (isset($_POST['saveOrder'])) { // The SaveCustomerBtn From JQuery Code

    $phone = validate($_SESSION['cphone']);  // Stored in the Place order code
    $invoice_no  = validate($_SESSION['invoice_no']);  // Stored in the Place order code
    $payment_method  = validate($_SESSION['payment_method']);  // Stored in the Place order code
    $order_placed_by_id = validate($_SESSION['loggedInUser']['user_id']); // user loggin code

    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone = '$phone' LIMIT 1 ");

    if (!$checkCustomer) {

        jsonRespone(500, 'error', 'Something Went Wrong!');
    }
    if (mysqli_num_rows($checkCustomer) > 0) {

        $customerData = mysqli_fetch_assoc($checkCustomer);

        if (!isset($_SESSION['productItems'])) {
            jsonRespone(404, 'warning', 'No Items to place the order!');
        }

        $SessionProducts = $_SESSION['productItems']; // Total Amount using foreach to loop the data 
        $totalAmount = 0;

        foreach ($SessionProducts as $amtItem) {

            $totalAmount +=  $amtItem['sale_price'] * $amtItem['quantity'];
        }

        $data =  [
            'customer_id' => $customerData['id'],
            'tracking_no' => rand(111111, 999999),
            'invoice_no' => $invoice_no,
            'total_amount' => $totalAmount,
            'order_date' => date('Y-m-d'),
            'order_status' => 'booked',
            'payment_method' => $payment_method,
            'order_placed_by_id' => $order_placed_by_id
        ];
        $result = insert('orders', $data);

        $last_OrderId = mysqli_insert_id($conn);

        foreach ($SessionProducts as $proItem) {

            $productId = $proItem['product_id'];
            $sale_price = $proItem['sale_price'];
            $quantity = $proItem['quantity'];

            // Insert Order_item

            $dataOrderItem = [
                'order_id' => $last_OrderId,
                'product_id' => $productId,
                'sale_price' => $sale_price,
                'quantity' => $quantity

            ];
            $orderItemQuery = insert('order_items', $dataOrderItem);

            // Cheking for the quantity and decreasing quantity and making total Quantity

            $checkProductQtyQuery = mysqli_query($conn, "SELECT * FROM products WHERE id = '$productId'");

            $productQtyData = mysqli_fetch_array($checkProductQtyQuery);

            $totalProductQty = $productQtyData['quantity'] - $quantity;

            $dateProductUpdate = [
                'quantity' => $totalProductQty

            ];

            $updateProductqty = update('products', $productId, $dateProductUpdate);
        }
        unset($_SESSION['productItemIds']);
        unset($_SESSION['productItems']);
        unset($_SESSION['cphone']);
        unset($_SESSION['payment_method']);
        unset($_SESSION['invoice_no']);

        jsonRespone(200, 'success', 'Order Placed Sucessfully');
    } else {
        jsonRespone(404, 'warning', 'No Customer Found!'); // If cus < 0 
    }
}

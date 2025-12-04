<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <!-- shadow-small -->
        <div class="card-header">
            <h4 class="mb-0">Orders
                <a href="orders-view-print.php?tracking=<?= $_GET['tracking']; ?>" class="btn btn-info mx-2 btn-sm float-end">Print</a>
                <a href="orders.php" class="btn btn-danger mx-2 btn-sm float-end">Back</a>
            </h4>
        </div>

        <div class="card-body">

            <?php alertMessage() ?>

            <?php
                if(isset($_GET['tracking'])){

                    if($_GET['tracking'] == ''){
                        ?>
                        <div class="text-center py-5">
                        <h5>Tracking Number Not Found</h5>
                        <a href="orders.php" class="btn btn-primary mt-4 w-25">Go Back to Orders</a>
                    </div>

                    <?php
                        return false;
                    }

                    $trackingNo  = validate($_GET['tracking']);

                    $orders = mysqli_query($conn, "SELECT o.*, a.* FROM orders o, admins a 
                    WHERE a.id = o.order_placed_by_id AND tracking_no ='$trackingNo' ORDER by o.id DESC");

                    if($orders){
                        if(mysqli_num_rows($orders) > 0){

                            $orderData = mysqli_fetch_assoc($orders);
                            $OrderId = $orderData['id'];

                            ?>

                            <div class="card card-body shadow border-1 mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Order Details</h4>

                                        <label class="mb-1">
                                            Tracking No: <span  class="fw-bold"><?= $orderData['tracking_no']; ?></span>
                                        </label>
                                        <br>

                                        <label class="mb-1">
                                            Order Date: <span class="fw-bold"><?= $orderData['order_date']; ?></span>
                                        </label>
                                        <br>

                                        <label class="mb-1">
                                            Order Status: <span class="fw-bold"><?= $orderData['order_status']; ?></span>
                                        </label>
                                        <br>

                                        <label class="mb-1">
                                           Payment Method: <span class="fw-bold"><?= $orderData['payment_method']; ?></span>
                                        </label>
                                    </div>

                                    <div class="col-md-6">
                                        <h4>User Details</h4>

                                        <label class="mb-1">
                                            Full Name:
                                            <span class="fw-bold"><?= $orderData['name']; ?></span>
                                        </label>
                                        <br>

                                        <label class="mb-1">
                                            Email Address:
                                            <span class="fw-bold"><?= $orderData['email']; ?></span>
                                        </label>
                                        <br>

                                        <label class="mb-1">
                                           Phone Number:
                                            <span class="fw-bold"><?= $orderData['phone']; ?></span>
                                        </label>
                                        <br>

                                    </div>
                                </div>
                            </div>

                            <?php
                             $orderItemQuery = mysqli_query($conn,"SELECT oi.quantity as orderItemQuantity,
                             oi.sale_price as orderItemPrice, o.*, oi.*, p.* 
                             FROM orders as o, order_items as oi, products as p
                             WHERE oi.order_id = o.id AND p.id = oi.product_id 
                             AND o.tracking_no='$trackingNo'");

                             if($orderItemQuery){

                                if(mysqli_num_rows($orderItemQuery) > 0){
                                    ?>

                                    <h4 class="my-3">Order Items Details</h4>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Color</th>
                                                <th>Size</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($orderItemQuery as $orderItemRow): ?>
                                                <tr>
                                                    <td>
                                                        <img src=" <?= $orderItemRow['image'] != '' ? '../' .$orderItemRow['image']: '../assets/images/no-img.jpg';?> "
                                                        style="width:50px; height:50px;"
                                                         alt="img">

                                                         <?= $orderItemRow['name'];?>
                                                    </td>

                                                    <td width="15%" class="fw-bold text-center">
                                                        <?= ($orderItemRow['size']); ?>
                                                    </td>

                                                    <td width="15%" class="fw-bold text-center">
                                                        <?= ($orderItemRow['color']); ?>
                                                    </td>

                                                    <td width="15%" class="fw-bold text-center">
                                                        <?= number_format($orderItemRow['orderItemPrice']); ?>
                                                    </td>
                                            
                                                    <td width="15%" class="fw-bold text-center">
                                                        <?= $orderItemRow['orderItemQuantity']; ?>
                                                    </td>
                                                    <td width="15%" class="fw-bold text-center">
                                                        <?= number_format($orderItemRow['orderItemPrice'] * $orderItemRow['orderItemQuantity']); ?>
                                                    </td>
                                                </tr>

                                                <?php endforeach; ?>

                                                <tr>
                                                    <td class="text-end fw-bold">Total Price:</td>
                                                    <td colspan="3" class="fw-bold text-end">Dollar($): <?= number_format($orderItemRow['total_amount'],0) ?></td>
                                                </tr>
                                        </tbody>

                                    </table>

                                    <?php

                                }else{
                                    echo'<h5>Something Went Wrong!</h5>';
                                    return false;

                                }

                             }else{
                                echo'<h5>Something Went Wrong!</h5>';
                                return false;
                             }

                            ?>

                            <?php

                        }else{
                            echo'<h5>No Record Found!</h5>';
                            return false;
                        }

                    }else{
                        echo'<h5>Something Went Wrong!</h5>';
                    }

                }else{
                    ?>
                    <div class="text-center py-5">
                        <h5>Tracking Number Not Found</h5>
                        <a href="orders.php" class="btn btn-primary mt-4 w-25">Go Back to Orders</a>
                    </div>

                    <?php
                }
            ?>

        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>
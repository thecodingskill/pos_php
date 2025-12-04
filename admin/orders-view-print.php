<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <!-- shadow-small -->
        <div class="card-header">
            <h4 class="mb-0">Print Order
                <a href="orders.php" class="btn btn-danger btn-sm float-end">Back</a>
            </h4>
        </div>

        <div class="card-body">

            <?php alertMessage() ?>

            <div id="myBillingArea">
                <?php

                if (isset($_GET['tracking'])) {

                    $trackingNo = validate($_GET['tracking']);
                    if ($trackingNo == '') {
                ?>
                        <div class="text-center py-5">
                            <h5>Please Provide Tracking Number</h5>
                            <a href="orders.php" class="btn btn-primary mt-4 w-25">Go Back to Orders</a>
                        </div>
                    <?php
                    }

                    $orderQueryRes = mysqli_query($conn, "SELECT o.*, c.* FROM orders o, customers c 
                WHERE c.id = customer_id AND tracking_no = '$trackingNo' LIMIT 1");

                    if (!$orderQueryRes) {
                        echo '<h5>Something Went Wrong!</h5>';
                        return false;
                    }

                    if (mysqli_num_rows($orderQueryRes) > 0) {

                        $orderDataRow = mysqli_fetch_assoc($orderQueryRes);
                    ?>

                        <table style="width:100%; margin-bottom: 20px;">
                            <tbody>
                                <tr>
                                    <td style="text-align:center;" colspan="2">
                                        <h4 style="font-size: 23px; line-height: 30px; margin: 2px; padding: 0;">Group 01 POS System</h4>
                                        <p style="font-size: 16px; line-height: 24px; margin: 2px; padding: 0;">#453X, 2rd street, Krong Battambang</p>
                                        <p style="font-size: 16px; line-height: 24px; margin: 2px; padding: 0;">Regional Polytechnic Institute Techo Sen Battambang</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <h5 style="font-size: 20px; line-height: 30px; margin: 0px; padding: 0;">Customer Details</h5>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer Name: <?= $orderDataRow['name']; ?> </p>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer Phone No: <?= $orderDataRow['phone'] ?> </p>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer Email Id: <?= $orderDataRow['email']; ?> </p>

                                    </td>
                                    <td align="end">

                                        <h5 style="font-size: 20px; line-height: 30px; margin: 0px; padding: 0;">Invoice Details</h5>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Invoice No: <?= $orderDataRow['invoice_no']; ?> </p>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Invoice Date: <?= date("l jS \of F Y"); ?> </p>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Address: #453X, 2rd street, Krong Battambang</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php

                    } else {
                        echo '<h5>No Data Found!</h5>';
                        return false;
                    }

                    $orderItemRs = mysqli_query($conn, "SELECT oi.quantity as orderItemQuantity, oi.sale_price as orderItemPrice,
                    o.*, oi.*, p.* FROM orders o, order_items oi, products p 
                    WHERE oi.order_id=o.id AND p.id=oi.product_id AND o.tracking_no='$trackingNo' ");

                    if ($orderItemRs) {
                        if (mysqli_num_rows($orderItemRs) > 0) {
                            mysqli_fetch_assoc($orderItemRs);
                        ?>
                            <div class="table-responsive mb-3">
                                <table style="width:100%;" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="5%">ID</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;">Prodcut Name</th>  
                                            <th align="start" style="border-bottom: 1px solid #ccc;">Size</th>  
                                            <th align="start" style="border-bottom: 1px solid #ccc;">Color</th>  
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Price</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Quantity</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Price Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($orderItemRs as $key => $row) :

                                        ?>

                                            <tr>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['size']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['color']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= number_format($row['orderItemPrice'], 0) ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['orderItemQuantity']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                                    <?= number_format($row['orderItemPrice'] * $row['orderItemQuantity'], 0) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;">Grand Total: </td>
                                            <td colspan="1" style="font-weight: bold;"><?= number_format($row['total_amount'], 0); ?> </td>
                                        </tr>

                                        <tr>
                                            <td colspan="5">Payment Method: <?= $row['payment_method']; ?></td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                    <?php
                        } else {
                            echo '<h5>No Data Found!</h5>';
                            return false;
                        }
                    } else {
                        echo '<h5>Something Went Wrong!</h5>';
                        return false;
                    }
                } else {
                    ?>
                    <div class="text-center py-5">
                        <h5>Tracking Number Not Found</h5>
                        <a href="orders.php" class="btn btn-primary mt-4 w-25">Go Back to Orders</a>
                    </div>
                <?php
                }



                ?>
            </div>

            <div class="mt-4 text-end">
                <button class="btn btn-info px-4 mx-1" onclick="printMyBillingArea()">Print</button>
                <button class="btn btn-primary px-4 mx-1" onclick="downloadPDF('<?= $orderDataRow['invoice_no']; ?>')">Download PDF</button>

            </div>
        </div>

    </div>
</div>

<?php include('includes/footer.php'); ?>
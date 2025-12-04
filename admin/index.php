<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <?php alertMessage() ?>
            <h1 class="mt-4">Dashboard</h1>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body bg-primary p-3">
                <p class="text-sm mb-0 text-capitalize text-white">Total Categories</p>
                <h5 class="fw-bold mb-0 text-white">
                <?= getcount('categories');?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body bg-warning  p-3 ">
                <p class="text-sm mb-0 text-capitalize">Total Products</p>
                <h5 class="fw-bold mb-0">
                <?= getcount('products');?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body bg-info p-3">
                <p class="text-sm mb-0 text-capitalize">Total Admins</p>
                <h5 class="fw-bold mb-0">
                <?= getcount('admins');?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body p-3 bg-light">
                <p class="text-sm mb-0 text-capitalize">Total Customers</p>
                <h5 class="fw-bold mb-0">
                <?= getcount('customers');?>
                </h5>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <hr>
            <h5>Orders</h5>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3 bg-primary text-white">
                <p class="text-sm mb-0 text-capitalize">Totay Orders</p>
                <h5 class="fw-bold mb-0">
                <?php
                $todayDate = date('Y-m-d');
                $todayOrder  = mysqli_query($conn,"SELECT * FROM orders WHERE order_date='$todayDate'");

                if($todayOrder){

                    if(mysqli_num_rows($todayOrder) > 0){
                        $totalCountOrders = mysqli_num_rows($todayOrder);
                        echo $totalCountOrders;

                    }else{
                        echo '0';
                    }

                }else{
                    echo '<h5>Something Went Wrong!</h5>';
                }

                ?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body p-3 bg-success text-white">
                <p class="text-sm mb-0 text-capitalize">Total Orders</p>
                <h5 class="fw-bold mb-0">
                <?= getcount('orders');?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
       <?php $lowerStockThreshold = 10 ?>
            <div class="card card-body p-3 bg-danger text-white">
                <p class="text-sm mb-0 text-capitalize">Lower Stock</p>
                <h5 class="fw-bold mb-0">
                <?=getcountStock('products',$lowerStockThreshold);?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
       <?php $lowerStockThreshold = 0 ?>
            <div class="card card-body p-3 bg-danger text-white">
                <p class="text-sm mb-0 text-capitalize">Out of Stock</p>
                <h5 class="fw-bold mb-0">
                <?=getcountStock('products',$lowerStockThreshold);?>
                </h5>
            </div>
        </div>

    </div>

</div>

<?php include('includes/footer.php') ?>
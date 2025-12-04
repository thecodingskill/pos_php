<?php include('includes/header.php');
?>
<!-- Modal -->
<div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" databs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Customer</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="">Enter Customer Name</label>
                    <input type="text" class="form-control" id="c_name">
                </div>
                <div class="mb-3">
                    <label for="">Enter Customer Phone No.</label>
                    <input type="text" class="form-control" id="c_phone">
                </div>

                <div class="mb-3">
                    <label for="">Enter Customer Email(optional)</label>
                    <input type="email" class="form-control" id="c_email">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary saveCustomer">Add Customer</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Create Order

                <a href="orders.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>

        <div class="card-body">
            <!--Product Area is the id for JQuery to show the messag -->

            <?php alertMessage(); ?>

            <form action="orders-code.php" method="POST">

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="name" class="form-label">Select Product *</label>
                        <select name="product_id" class="form-select mySelect2">
                            <option value="">--Select Product--</option>

                            <?php
                            $products = getAll('products');

                            if ($products) {
                                if (mysqli_num_rows($products) > 0) {
                                    foreach ($products as $proItem) {
                            ?>
                                        <option value="<?= $proItem['id']; ?>"><?= $proItem['name']; ?></option>
                            <?php
                                    }
                                } else {
                                    echo '<option value="">No product found!</option>';
                                }
                            } else {
                                echo '<option value="">Something Went Wrong!</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="qty" class="form-label">Quantity *</label>
                        <input type="number" id="qty" name="qty" value="1" class="form-control">
                    </div>

                    <div class="col-md-3 md-3 text-end">
                        <br>
                        <button type="submit" name="addItem" class="btn btn-primary">Add Item</button>
                    </div>
                </div>
            </form>

        </div>
    </div>


    <!-- Create_order_list -->

    <div class="card mt-3">
        <div class="card-header">
            <h4 class="mb-0">Product</h4>
        </div>
        <div class="card-body" id="productArea">
            <?php
            if (isset($_SESSION['productItems'])) {

                $sessionProducts = $_SESSION['productItems'];

                //Uset the Session When the No Added Product Data

                if (empty($sessionProducts)) {
                    unset($_SESSION['productItemIds']);
                    unset($_SESSION['productItems']);
                }
            ?>
                <div class="table-responsive m-3" id="productContent">
                    <!--ProductContent is the id for JQuery to show the messag -->
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Product Name</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1 ?>

                            <?php foreach ($sessionProducts as $key => $proItem) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $proItem['name']; ?></td>
                                    <td><?= $proItem['size']; ?></td>
                                    <td><?= $proItem['color']; ?></td>
                                    <td><?= $proItem['sale_price']; ?></td>

                                    <td>
                                        <div class="input-group qtyBox">
                                            <input type="hidden" name="product_id" value="<?= $proItem['product_id']; ?>" class="proId">
                                            <!-- Defined the class name to work with jquery -->
                                            <button class="input-group-text decrement">-</button>
                                            <input type="text" value="<?= $proItem['quantity']; ?>" class="qty quantityInput">
                                            <button class="input-group-text increment">+</button>
                                        </div>
                                    </td>

                                    <td><?= number_format($proItem['sale_price'] * $proItem['quantity'], 0) ?></td>

                                    <td>
                                        <a href="orders-item-delete.php?index=<?= $key; ?>" class="btn btn-danger">Remove</a>
                                    </td>

                                </tr>
                        </tbody>
                    <?php endforeach; ?>
                    </table>
                </div>

                <hr>

                <!-- Check Customer -->

                <div class="mt-2">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="payment_method">Payment Method</label>
                            <select id="payment_method" class="form-select">
                                <option value="">--Select Payment--</option>
                                <option value="Cash Payment">Cash Payment</option>
                                <option value="Online Payment">Online Payment</option>
                            </select>

                        </div>

                        <div class="col-md-4">
                            <label for="">Customer Phone Number</label>
                            <input type="number" id="cphone" class="form-control" value="">

                        </div>

                        <div class="col-md-4">
                            <br>
                            <button type="button" class="btn btn-warning w-100  processedToPlace">Process to place the order</button>
                        </div>

                    </div>
                </div>
            <?php
            } else {
                echo '<h5 class="text-center">No Items added</h5>';
            }
            ?>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
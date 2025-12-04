<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Product

                <a href="products.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>

        <div class="card-body">

            <?php alertMessage(); ?>

            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#insertProDetail"> Add Product Details
                </div>
            </div>
            <form action="code.php" method="POST" enctype="multipart/form-data">

                <div class="modal fade" id="insertProDetail" data-bs-backdrop="static" databs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product Details</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="size" class="form-label">Size:</label>
                                    <select name="size" id="size" class="form-select">
                                        <option value="">Select Size</option>
                                        <option value="XS">XS</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                        <option value="XXL">XXL</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                        <option value="32">32</option>
                                        <option value="33">33</option>
                                        <option value="34">34</option>
                                        <option value="35">35</option>
                                        <option value="36">36</option>
                                    </select>

                                    <label for="color" class="form-label">Color:</label>
                                    <select name="color" id="color" class="form-select">
                                        <option value="">Select Color</option>
                                        <option value="Red">Red</option>
                                        <option value="Blue">Blue</option>
                                        <option value="Green">Green</option>
                                        <option value="Gold">Gold</option>
                                        <option value="Black">Black</option>
                                        <option value="White">White</option>
                                        <option value="Yellow">Yellow</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="quantity">Quantity.</label>
                                    <input type="number" class="form-control" name="quantity">
                                </div>

                                <div class="mb-3">
                                    <label for="purchase_price">Enter Purchase Price.</label>
                                    <input type="number" class="form-control" name="purchase_price" id="purchase_price">
                                </div>

                                <div class="mb-3">
                                    <label for="sale_price">Enter Sale Price</label>
                                    <input type="number" class="form-control" name="sale_price">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="saveProduct" class="btn btn-primary ">Save</button>
                            </div>
                        </div>
                    </div>
        </div>
        <div class="row">

            <div class="col-md-4 mb-3">
                <label class="form-label">Select Category</label>
                <select name="category_id" class="form-select">
                    <option value="">Select Category</option>
                    <?php
                    $categories = getAll('categories');

                    if ($categories) {
                        if (mysqli_num_rows($categories) > 0) {
                            foreach ($categories as $cateItem) {
                                echo '<option value="' . $cateItem['id'] . '">' . $cateItem['name'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No Category found</option>;';
                        }
                    } else {
                        echo '<option value="">Something Went Wrong!</option>;';
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Select Supplier</label>
                <select name="supplier_id" class="form-select">
                    <option value="">Select Supplier</option>
                    <?php
                    $suppliers = getAll('suppliers');

                    if ($suppliers) {
                        if (mysqli_num_rows($suppliers) > 0) {
                            foreach ($suppliers as $supItem) {
                                echo '<option value="' . $supItem['id'] . '">' . $supItem['name'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No Supplier found</option>;';
                        }
                    } else {
                        echo '<option value="">Something Went Wrong!</option>;';
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Select Admin</label>
                <select name="admin_id" class="form-select">
                    <option value="">Select Admin</option>
                    <?php
                    $admins = getAll('admins');

                    if ($admins) {
                        if (mysqli_num_rows($admins) > 0) {
                            foreach ($admins as $adminItem) {
                                echo '<option value="' . $adminItem['id'] . '">' . $adminItem['name'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No Admin found</option>;';
                        }
                    } else {
                        echo '<option value="">Something Went Wrong!</option>;';
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label for="name">Product Name *</label>
                <input type="text" id="name" name="name" require class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <label for="dec">Description *</label>
                <textarea name="dec" id="dec" require class="form-control" rows="3"></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label for="image">Image *</label>
                <input type="file" id="image" name="image" require class="form-control">
            </div>

            <div class="col-md-6">
                <label for="status">Status (UnChacked = Visible, Checked = Hidden)</label>
                <br>
                <input type="checkbox" name="status" style="width: 30px; height: 30px;">
            </div>
        </div>
    </div>
    </form>

</div>
</div>

<?php include('includes/footer.php'); ?>
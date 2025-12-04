<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Product

                <a href="products.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>

            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#insertProDetail"> Edit Product Details
                </div>
            </div>


            <form action="code.php" method="POST" enctype="multipart/form-data">

                <?php

                $product_id =  checkParamId('id');

                if (!is_numeric($product_id)) {
                    echo '<h5>Id is not a number</h5>';
                    return false;
                }

                $product = getByid('products', $product_id);

                if ($product['status'] == 200) {
                    $color = isset($product['color']) ? $product['color'] : '';
                    $size = isset($product['size']) ? $product['size'] : '';
                    echo $color;
                ?>
                    <div class="modal fade" id="insertProDetail" data-bs-backdrop="static" databs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product Details</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12 mb-4">
                                        <label for="size" class="form-label">Select Size:</label>
                                        <select name="size" id="size" class="form-select">
                                            <option value="">Select Size</option>
                                            <option value="XS" <?= isset($product['data']['size']) && $product['data']['size'] == 'XS' ? 'selected' : ''; ?>>XS</option>
                                            <option value="S" <?= isset($product['data']['size']) && $product['data']['size'] == 'S' ? 'selected' : ''; ?>>S</option>
                                            <option value="M" <?= isset($product['data']['size']) && $product['data']['size'] == 'M' ? 'selected' : ''; ?>>M</option>
                                            <option value="L" <?= isset($product['data']['size']) && $product['data']['size'] == 'L' ? 'selected' : ''; ?>>L</option>
                                            <option value="XL" <?= isset($product['data']['size']) && $product['data']['size'] == 'XL' ? 'selected' : ''; ?>>XL</option>
                                            <option value="XXL" <?= isset($product['data']['size']) && $product['data']['size'] == 'XXL' ? 'selected' : ''; ?>>XXL</option>
                                            <option value="28" <?= isset($product['data']['size']) && $product['data']['size'] == '28' ? 'selected' : ''; ?>>28</option>
                                            <option value="29" <?= isset($product['data']['size']) && $product['data']['size'] == '29' ? 'selected' : ''; ?>>29</option>
                                            <option value="30" <?= isset($product['data']['size']) && $product['data']['size'] == '30' ? 'selected' : ''; ?>>30</option>
                                            <option value="31" <?= isset($product['data']['size']) && $product['data']['size'] == '31' ? 'selected' : ''; ?>>31</option>
                                            <option value="32" <?= isset($product['data']['size']) && $product['data']['size'] == '32' ? 'selected' : ''; ?>>32</option>
                                            <option value="33" <?= isset($product['data']['size']) && $product['data']['size'] == '33' ? 'selected' : ''; ?>>33</option>
                                            <option value="34" <?= isset($product['data']['size']) && $product['data']['size'] == '34' ? 'selected' : ''; ?>>34</option>
                                            <option value="35" <?= isset($product['data']['size']) && $product['data']['size'] == '35' ? 'selected' : ''; ?>>35</option>
                                            <option value="36" <?= isset($product['data']['size']) && $product['data']['size'] == '36' ? 'selected' : ''; ?>>36</option>
                                        </select>

                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="color" class="form-label">Select Color:</label>
                                        <select name="color" id="color" class="form-select">
                                            <option value="">Select Color</option>
                                            <option value="Red" <?= isset($product['data']['color']) && $product['data']['color'] == 'Red' ? 'selected' : ''; ?>>Red</option>
                                            <option value="Blue" <?= isset($product['data']['color']) && $product['data']['color'] == 'Blue' ? 'selected' : ''; ?>>Blue</option>
                                            <option value="Green" <?= isset($product['data']['color']) && $product['data']['color'] == 'Green' ? 'selected' : ''; ?>>Green</option>
                                            <option value="Gold" <?= isset($product['data']['color']) && $product['data']['color'] == 'Gold' ? 'selected' : ''; ?>>Gold</option>
                                            <option value="Black" <?= isset($product['data']['color']) && $product['data']['color'] == 'Black' ? 'selected' : ''; ?>>Black</option>
                                            <option value="White" <?= isset($product['data']['color']) && $product['data']['color'] == 'White' ? 'selected' : ''; ?>>White</option>
                                            <option value="Yellow" <?= isset($product['data']['color']) && $product['data']['color'] == 'Yellow' ? 'selected' : ''; ?>>Yellow</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="quantity" class="form-label">Quantity.</label>
                                        <input type="number" class="form-control" name="quantity" value="<?= isset($product['data']['quantity']) ? $product['data']['quantity'] : ''; ?>">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="purchase_price" class="form-label">Enter Purchase Price.</label>
                                        <input type="number" class="form-control" name="purchase_price" value="<?= isset($product['data']['purchase_price']) ? $product['data']['purchase_price'] : ''; ?>">
                                    </div>

                                    <div class="col-mb-12 mb-3">
                                        <label for="sale_price" class="form-label">Enter Sale Price.</label>
                                        <input type="number" class="form-control" name="sale_price" value="<?= isset($product['data']['sale_price']) ? $product['data']['sale_price'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="updateProduct" class="btn btn-primary ">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="product_id" value="<?= $product['data']['id']; ?>">

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

                                ?>
                                            <option value="<?= $cateItem['id']; ?>" <?= $product['data']['category_id'] == $cateItem['id'] ? 'selected' : ''; ?>>

                                                <?= $cateItem['name']; ?>
                                            </option>
                                <?php

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

                                ?>
                                            <option value="<?= $supItem['id']; ?>" <?= $product['data']['supplier_id'] == $supItem['id'] ? 'selected' : ''; ?>>

                                                <?= $supItem['name']; ?>
                                            </option>
                                <?php

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

                                ?>
                                            <option value="<?= $adminItem['id']; ?>" <?= $product['data']['admin_id'] == $adminItem['id'] ? 'selected' : ''; ?>>

                                                <?= $adminItem['name']; ?>
                                            </option>
                                <?php

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
                        <div class="col-12 mb-3">
                            <label for="name">Name *</label>
                            <input type="text" id="name" name="name" value="<?= $product['data']['name']; ?>" require class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="dec">Description *</label>
                            <textarea name="dec" id="dec" require class="form-control" rows="3"> <?= $product['data']['description']; ?></textarea>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="image">Image *</label>
                            <input type="file" id="image" name="image" require class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <img src="../<?= $product['data']['image']; ?>" style="width: 100px; height:100px" class="mt-3" alt="Image">
                        </div>

                        <div class="col-md-6">
                            <label for="status">Status (UnChacked = Visible, Checked = Hidden)</label>
                            <br>
                            <input type="checkbox" name="status" value="1" <?= $product['data']['status'] == true ? 'checked' : ''; ?> style="width: 30px; height: 30px;">
                        </div>

                    <?php } else {
                    echo '<h5>' . $product['message'] . '</h5>';
                }
                    ?>
            </form>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>
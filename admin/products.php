<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <!-- shadow-small -->
        <div class="card-header">
            <h4 class="mb-0">Products
                <a href="products-create.php" class="btn btn-primary float-end">Add Product</a>
            </h4>
        </div>

        <div class="card-body">
            <?php alertMessage() ?>

            <?php
            $product = getAll('products');  // Fetch all records from the 'admins' table

            if (!$product) {
                echo '<h4>Something Went Wrong!</h4>';
                return false;
            }
            if (mysqli_num_rows($product) > 0) {
            ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Stock Available</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Sale Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($product as $item) : ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td>
                                        <img src="../<?= $item['image']; ?>" style="wiidh:50px; height:50px" alt="Img">
                                    <td><?= $item['name'] ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td><?= $item['size'] ?></td>
                                    <td><?= $item['color'] ?></td>
                                    <td><?= $item['sale_price'] ?></td>
                                    <td>
                                        <?php
                                        if ($item['status'] == 0) {
                                            echo '<span class="badge bg-danger">Hidden</span>';
                                        } else {
                                            echo '<span class="badge bg-primary">Visible</span>';
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <a href="products-edit.php?id=<?= $item['id'] ?>" ; class="btn btn-success btn-sm">Edit</a>
                                        <a href="products-delete.php?id=<?= $item['id'] ?>" ; class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete this image?')">
                                            Delete
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php
            } else {
            ?>

                <div class="alert alert-warning" role="alert">
                    No Record found!
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
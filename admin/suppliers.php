<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <!-- shadow-small -->
        <div class="card-header">
            <h4 class="mb-0">Suppliers
                <a href="suppliers-create.php" class="btn btn-primary float-end">Add Supplier</a>
            </h4>
        </div>

        <div class="card-body">
            <?php alertMessage() ?>

            <?php
            $supplier = getAll('suppliers');  // Fetch all records from the 'admins' table

            if (!$supplier) {
                echo '<h4>Something Went Wrong!</h4>';
                return false;
            }

            if (mysqli_num_rows($supplier) > 0) {
            ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Company</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($supplier as $item) : ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= $item['email'] ?></td>
                                    <td><?= $item['phone'] ?></td>
                                    <td><?= $item['address'] ?></td>
                                    <td><?= $item['company'] ?></td>
                                    <td>
                                        <?php
                                            if($item['status'] == 0){
                                                echo'<span class="badge bg-danger">Hidden</span>';
                                            }else{
                                                echo'<span class="badge bg-primary">Visible</span>';
                                            }
                                        ?>
                                    </td>

                                    <td>
                                        <a href="suppliers-edit.php?id=<?= $item['id'] ?>" ; class="btn btn-success btn-sm">Edit</a>
                                        <a href="suppliers-delete.php?id=<?= $item['id'] ?>" ; class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete this image?')">
                                        Delete
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
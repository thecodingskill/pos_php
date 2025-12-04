<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <!-- shadow-small -->
        <div class="card-header">
            <h4 class="mb-0">Categories
                <a href="categories-create.php" class="btn btn-primary float-end">Add Category</a>
            </h4>
        </div>

        <div class="card-body">
            <?php alertMessage() ?>

            <?php
            $category = getAll('categories');  // Fetch all records from the 'admins' table

            if (! $category ) {
                echo '<h4>Something Went Wrong!</h4>';
                return false;
            }
            if (mysqli_num_rows( $category ) > 0) {
            ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($category as $item) : ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['name'] ?></td>
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
                                        <a href="categories-edit.php?id=<?= $item['id'] ?>" ; class="btn btn-success btn-sm">Edit</a>
                                        <a href="javascript:void(0);" onclick="confirmDeletion(<?= $item['id'] ?>);" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php
            } else {
            ?>

                <!-- <tr>
                    <td colspan="4">No Record found!</td>
                </tr> -->

                <div class="alert alert-warning" role="alert">
                    No Record found!
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<script>
    function confirmDeletion(adminId) {
        if (confirm("Are you sure you want to delete this category?")) {
            window.location.href = 'categories-delete.php?id=' + adminId;
        }
    }
</script>

<?php include('includes/footer.php'); ?>
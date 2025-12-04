<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <!-- shadow-small -->
        <div class="card-header">
            <h4 class="mb-0">Admins/Staff

                <a href="admins-create.php" class="btn btn-primary float-end">Add Admin</a>
            </h4>
        </div>

        <div class="card-body">
            <?php alertMessage() ?>

            <?php
            $admin = getAll('admins');  // Fetch all records from the 'admins' table
                if(!$admin){
                    echo'<h4>Something Went Wrong!</h4>';
                    return false;
                }
            if (mysqli_num_rows($admin) > 0) {
            ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Is Ban</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admin as $adminItem) : ?>
                                <tr>
                                    <td><?= $adminItem['id'] ?></td>
                                    <td><?= $adminItem['name'] ?></td>
                                    <td><?= $adminItem['email'] ?></td>
                                    
                                    <td>
                                        <?php
                                            if($adminItem['is_ban'] == 1){
                                                echo'<span class="badge bg-danger">Banned</span>';
                                            }else{
                                                echo'<span class="badge bg-primary">Active</span>';
                                            }
                                        ?>
                                    </td>

                                    <td>
                                        <a href="admins-edit.php?id=<?= $adminItem['id']?>"; class="btn btn-success btn-sm">Edit</a>
                                        <!-- <a href="admins-delete.php?id=<?= $adminItem['id']?>"; class="btn btn-danger btn-sm">Delete</a> -->
                                        <a href="javascript:void(0);" onclick="confirmDeletion(<?= $adminItem['id'] ?>);" class="btn btn-danger btn-sm">Delete</a>
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
            if (confirm("Are you sure you want to delete this admin?")) {
                window.location.href = 'admins-delete.php?id=' + adminId;
            }
        }
    </script>
    
<?php include('includes/footer.php'); ?>
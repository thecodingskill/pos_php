<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Admin

                <a href="admins.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>

            <form action="code.php" method="POST">

                <?php

                if (isset($_GET['id'])) {

                    if ($_GET['id'] != '') {
                        $adminId = $_GET['id'];
                    } else {
                        echo '<h5>No Id Founds</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>No Id given params</h5>';
                    return false;
                }


                $adminData = getByid('admins', $adminId); // The Function Call


                if ($adminData) {
                    if ($adminData['status'] == 200) {
                ?>
                        <!-- Hidden input field ID -->
                        <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Name *</label>
                                <input type="text" id="name" name="name" require value="<?= $adminData['data']['name']; ?>" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" value="<?= $adminData['data']['email']; ?>" require class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password">Password *</label>
                                <input type="password" id="password" name="password"  require class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone">Phone Number *</label>
                                <input type="text" id="phone" name="phone" value="<?= $adminData['data']['phone']; ?>" require class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="is_ban">Is Ban</label>
                                <input type="checkbox" id="is_ban" name="is_ban" value="1"<?= $adminData['data']['is_ban'] == true? 'checked' :  ''; ?> style="width:30px;height:30px;">
                            </div>

                            <div class="col-md-12 md-3 text-end">
                                <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                <?php

                    } else {    
                        echo '<h5>' . $adminData['message'] . '</h5>';
                    }
                } else {
                    echo 'Something Went Wrong!';
                    return false;
                }
                ?>

            </form>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
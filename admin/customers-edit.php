<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Customer

                <a href="customers.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>

        <div class="card-body">

            <?php alertMessage(); ?>

            <form action="code.php" method="POST">

                <?php
                $customer_id =  checkParamId('id');

                if (!is_numeric($customer_id)) {
                    echo '<h5>' . $customer_id. '</h5>';
                    return false;
                }

                $customer = getByid('customers', $customer_id);

                if ($customer['status'] == 200) {

                ?>
                    <input type="hidden" name="customer_id" value="<?=$customer['data']['id']; ?>">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" id="name" name="name" value="<?= $customer['data']['name']; ?>" require class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="text" id="email" name="email" value="<?= $customer['data']['email']; ?>" require class="form-control">
                        </div>
                      
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone *</label>
                            <input type="text" id="phone" name="phone" value="<?= $customer['data']['phone']; ?>" require class="form-control">
                        </div>

                    
                        <div class="col-md-6">
                            <label for="status">Status (UnChacked = Visible, Checked = Hidden)</label>
                            <br>
                            <input type="checkbox" name="status" value="1" <?= $customer['data']['status'] == true ? 'checked' : ''; ?> style="width: 30px; height: 30px;">
                        </div>

                        <div class="col-md-6 md-3 text-end">
                            <br>
                            <button type="submit" name="updateCustomer" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                <?php } else {
                    echo '<h5>' . $customer['message'] . '</h5>';
                }
                ?>
            </form>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
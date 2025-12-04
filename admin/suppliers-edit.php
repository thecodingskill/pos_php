<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Supplier

                <a href="suppliers.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>

        <div class="card-body">

            <?php alertMessage(); ?>

            <form action="code.php" method="POST">

                <?php
                $paramId =  checkParamId('id');

                if (!is_numeric($paramId)) {
                    echo '<h5>' . $paramId. '</h5>';
                    return false;
                }

                $supplier = getByid('suppliers', $paramId);

                if ($supplier['status'] == 200) {

                ?>
                    <input type="hidden" name="supplier_id" value="<?=$supplier['data']['id']; ?>">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" id="name" name="name" value="<?= $supplier['data']['name']; ?>" require class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="text" id="email" name="email" value="<?= $supplier['data']['email']; ?>" require class="form-control">
                        </div>
                      
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone *</label>
                            <input type="text" id="phone" name="phone" value="<?= $supplier['data']['phone']; ?>" require class="form-control">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <input type="text" id="address" name="address" value="<?= $supplier['data']['address']; ?>" require class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="company" class="form-label">Company *</label>
                            <input type="text" id="company" name="company" value="<?= $supplier['data']['company']; ?>" require class="form-control">
                        </div>

                    
                        <div class="col-md-6">
                            <label for="status">Status (UnChacked = Visible, Checked = Hidden)</label>
                            <br>
                            <input type="checkbox" name="status" value="1" <?= $supplier['data']['status'] == true ? 'checked' : ''; ?> style="width: 30px; height: 30px;">
                        </div>

                        <div class="col-md-6 md-3 text-end">
                            <br>
                            <button type="submit" name="updateSupplier" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                <?php } else {
                    echo '<h5>' . $supplier['message'] . '</h5>';
                }
                ?>
            </form>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
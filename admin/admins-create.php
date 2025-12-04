<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Admin

                <a href="admins.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" require class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" require class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" require class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone">Phone Number *</label>
                        <input type="text" id="phone" name="phone" require class="form-control">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="is_ban">Is Ban</label>
                        <input type="checkbox" id="is_ban" name="is_ban" style="width:30px;height:30px;">
                    </div>
                    
                    <div class="col-md-12 md-3 text-end">
                        <button type="submit" name="saveAdmin" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
           
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
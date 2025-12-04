<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Category

                <a href="categories.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">

                <?php
                $paramValue =  checkParamId('id');

                if (!is_numeric($paramValue)) {
                    echo '<h5>' . $paramValue . '</h5>';
                    return false;
                }

                $category = getByid('categories', $paramValue);

                if ($category['status'] == 200) {

                ?>
                    <input type="hidden" name="categoryId" value="<?= $category['data']['id'];?>" >
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name">Name *</label>
                            <input type="text" id="name" name="name" value="<?= $category['data']['name'];?>" require class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="dec">Description *</label>
                            <textarea name="dec" id="dec"  require class="form-control" rows="3"> <?= $category['data']['description'];?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="status">Status (UnChacked = Visible, Checked = Hidden)</label>
                            <br>
                            <input type="checkbox" name="status" value="1" <?= $category['data']['status'] == true ? 'checked':''; ?> style="width: 30px; height: 30px;">
                        </div>

                        <div class="col-md-6 md-3 text-end">
                            <br>
                            <button type="submit" name="updateCategory" class="btn btn-primary">Update</button>
                        </div>
                    </div>
               <?php } else {
                    echo '<h5>'.$category['message'].'</h5>';
                }
                ?>
            </form>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
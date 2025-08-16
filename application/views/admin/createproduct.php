<!-- Begin Page Content -->
<div class="container-fluid">
    <a href="<?= base_url('admin/product') ?>"><button class="btn btn-warning mb-3">Cancle</button></a>

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"></h1> -->

    <?= form_open_multipart('admin/CreateProduct'); ?>
    <div class="form-group ">
        <label for="">Product Name</label>
        <input type="text" class="form-control form-control-user" id="product_name" name="product_name" placeholder="Product Name" value="<?= set_value('product_name') ?>">
        <?= form_error('product_name', '<small class="text-danger ">', '</small>') ?>

    </div>
    <div class="form-group ">
        <label for="">Price</label>
        <input type="number" class="form-control form-control-user" id="price" name="price" placeholder="Produck Price" value="<?= set_value('price') ?>">
        <?= form_error('price', '<small class="text-danger ">', '</small>') ?>

    </div>
    <div class="form-group ">
        <label for="">Image</label>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="image" name="image" aria-describedby="inputGroupFileAddon04">
                <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
            </div>
        </div>
        <?= form_error('image', '<small class="text-danger ">', '</small>') ?>

    </div>

    <div class="form-group ">
        <label for="">Category</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Category</label>
            </div>
            <select class="custom-select" id="category" name="category">
                <?php foreach ($categoryproduct as $c) { ?>
                    <option value="<?= $c->id ?>"><?= $c->category ?></option>
                <?php } ?>
            </select>
        </div>

    </div>
    <button type="submit" class="btn btn-primary btn-user btn-block">
        Submit
    </button>
    <!-- <?= form_close(); ?> -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
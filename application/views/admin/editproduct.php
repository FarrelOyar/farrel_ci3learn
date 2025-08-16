<!-- Begin Page Content -->
<div class="container-fluid">
    <a href="<?= base_url('admin/product') ?>"><button class="btn btn-warning mb-3">Cancle</button></a>

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"></h1> -->



    <?= form_open_multipart('admin/editProduct/' . $product->id); ?>
    <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="product_name" class="form-control"
            value="<?= set_value('product_name', $product->product_name); ?>">
        <?= form_error('product_name', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label>Price</label>
        <input type="number" name="price" class="form-control"
            value="<?= set_value('price', $product->price); ?>">
        <?= form_error('price', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label>Image</label><br>
        <img src="<?= base_url('uploads/' . $product->image) ?>" width="100"><br><br>
        <input type="file" name="image" class="form-control">
    </div>

    <div class="form-group">
        <label>Category</label>
        <select name="category" class="form-control">
            <?php foreach ($categoryproduct as $c): ?>
                <option value="<?= $c->id ?>" <?= ($product->category_id == $c->id) ? 'selected' : '' ?>>
                    <?= $c->category ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Product</button>
    <?= form_close(); ?>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
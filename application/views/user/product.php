<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"> <?= $title ?></h1>
    <?= $this->session->flashdata('message'); ?>
    <div class="row">
        <?php $num = 1;
        foreach ($product as $p) { ?>
            <div class="col-md-3">
                <div class="card product" style="width: 100%;">
                    <div class="image" style="background-image:url(<?= base_url('uploads/' . $p->image) ?>) ;"></div>
                    <!-- <img src="<?= base_url('uploads/' . $p->image) ?>" alt="<?= $p->product_name ?>" width="100%" height="200"> -->
                    <div class="card-body">
                        <h5 class="card-title"><?= $p->product_name ?></h5>
                        <p class="card-text">Rp <?= number_format($p->price, 0, ',', '.') ?></p>
                        <!-- <a href="#" class="btn btn-primary"><i  class="fas fa-cart-plus mr-2"></i>Add to Chart</a> -->
                        <a href="<?= base_url('user/addToChart/' . $p->id) ?>" class="btn btn-primary">
                            <i class="fas fa-cart-plus mr-2"></i>Add to Chart
                        </a>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<style>
    .card.product .image {
        width: 100%;
        height: 200px;
        background-position: center;
        background-size: cover;
    }
</style>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
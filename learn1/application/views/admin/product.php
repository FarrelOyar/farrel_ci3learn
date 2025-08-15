 <div class="container-fluid">
     <a href="<?= base_url('admin/CreateProduct') ?>"><button class="btn btn-success mb-3">Add Product</button></a>
     <?= $this->session->flashdata('message'); ?>

     <!-- DataTales Example -->
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <h6 class="m-0 font-weight-bold text-primary">Product Manage</h6>
         </div>
         <div class="card-body">
             <div class="table-responsive">
                 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                         <tr>
                             <th>No</th>
                             <th>Product Name</th>
                             <th>Price</th>
                             <th>Image</th>
                             <th>category</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php $num = 1;
                            foreach ($product as $p) { ?>
                             <tr>
                                 <td><?= $num ?></td>
                                 <td><?= $p->product_name ?></td>
                                 <td>Rp <?= number_format($p->price, 0, ',', '.') ?></td>
                                 <td> <img src="<?= base_url('uploads/' . $p->image) ?>" alt="<?= $p->product_name ?>" width="100"></td>
                                 <td><?= $p->category ?></td>
                                 <td style="text-align: center;align-content: center;">
                                     <a href="<?= base_url('admin/editProduct/' . $p->id) ?>"
                                         class="btn btn-warning btn-circle">
                                         <i class="fas fa-pen"></i>
                                     </a>

                                     <a href="<?= base_url('admin/deleteProduct/' . $p->id) ?>" class="btn btn-danger btn-circle" onclick="return confirm('Yakin hapus produk ini?')">
                                         <i class="fas fa-trash"></i>
                                     </a>

                                 </td>
                             </tr>
                         <?php $num++;
                            } ?>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>

 </div>
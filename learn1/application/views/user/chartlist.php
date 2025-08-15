 <div class="container-fluid">
     <?= $this->session->flashdata('message'); ?>

     <!-- DataTales Example -->
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <h6 class="m-0 font-weight-bold text-primary">Chart List</h6>
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
                             <th>qty</th>
                             <th>DELETE</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php $num = 1;
                            foreach ($chart as $c) { ?>
                             <tr>
                                 <td><?= $num ?></td>
                                 <td><?= $c->product_name ?></td>
                                 <td>Rp <?= number_format($c->price, 0, ',', '.') ?></td>
                                 <td> <img src="<?= base_url('uploads/' . $c->image) ?>" alt="<?= $c->product_name ?>" width="100"></td>
                                 <td>
                                     <a href="<?= base_url('user/minQty/' . $c->id) ?>" class="btn btn-warning btn-circle ">
                                         <i class="fas fa-minus"></i>
                                     </a>
                                     <input type="number" value="<?= $c->qty ?>" readonly style="width: 50px; text-align: center;">
                                     <a href="<?= base_url('user/plusQty/' . $c->id) ?>" class="btn btn-warning btn-circle">
                                         <i class="fas fa-plus"></i>
                                     </a>
                                 </td>

                                 <td>
                                     <a href="<?= base_url('user/deleteChart/' . $c->id) ?>" class="btn btn-danger btn-circle" onclick="return confirm('Yakin hapus produk ini?')">
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
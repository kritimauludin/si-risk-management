<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger  alert-dismissible" role="alert">
                    <?= validation_errors(); ?>
                    <button type="button" class="close" data-dismiss="alert" onclick="<?php unset($_SESSION['message']); ?>" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php elseif ($this->session->flashdata('message')) : ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <?= $this->session->flashdata('message'); ?>
                    <button type="button" class="close" data-dismiss="alert" onclick="<?php unset($_SESSION['message']); ?>" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php else : ?>
            <?php endif; ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark d-inline"><?= $title; ?></h6>
                    <!-- <a href="javascript_void(0)" class="float-right" data-toggle="modal" data-target="#addLikelihoodModal"><i class="fas fa-fw fa-plus"></i></a> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">Peringkat</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Frekuensi</th>
                                    <th scope="col">Kemungkinan Terjadi</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($likelihood as $ll) : ?>
                                    <tr>
                                        <th scope="row"><?= $ll['peringkat'] ?> </th>
                                        <th scope="row"><?= $ll['deskripsi'] ?> </th>
                                        <th scope="row"><?= $ll['keterangan'] ?> </th>
                                        <th scope="row"><?= $ll['frekuensi'] ?> </th>
                                        <th scope="row"><?= $ll['kemungkinan_terjadi'] ?> </th>
                                        <th scope="row">
                                            <a href="" data-toggle="modal" data-target="#updateLikelihoodModal<?= $ll['peringkat']; ?>" class="badge badge-success">edit</a>
                                            <!-- <a class="badge badge-danger" href="<?= base_url(); ?>klasifikasi/deletelikelihood/<?= $ll['peringkat']; ?> " onclick="confirm('Hapus data tersebut?')">delete</a> -->
                                        </th>
                                    </tr>
                                    <?php $i++ ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Modal -->
<div class="modal fade" id="addLikelihoodModal" tabindex="-1" aria-labelledby="addLikelihoodModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLikelihoodModalLabel">Add New Likelihood</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form active <?= base_url('klasifikasi/likelihood'); ?> method="POST">
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi" required>
                    </div>
					<div class="form-group mb-3">
						<textarea name="keterangan" id="keterangan" cols="10" rows="2" class="form-control" required placeholder="Keterangan"></textarea>
					</div>
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="frekuensi" name="frekuensi" placeholder="Frekuensi" required>
                    </div>
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="kemungkinan_terjadi" name="kemungkinan_terjadi" placeholder="Kemungkinan Terjadi" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php $i = 0; ?>
<?php foreach ($likelihood as $ll) : $i++ ?>
    <div class="modal fade" id="updateLikelihoodModal<?= $ll['peringkat']; ?>" tabindex="-1" aria-labelledby="updateLikelihoodModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateLikelihoodModalLabel">Edit Kemungkinan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('klasifikasi/updateLikelihood'); ?>
                    <input type="text" class="form-control" id="peringkat" name="peringkat" value="<?= $ll['peringkat']; ?>" hidden>
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?= $ll['deskripsi'] ?>" required>
                    </div>
					<div class="form-group mb-3">
						<textarea name="keterangan" id="keterangan" cols="10" rows="2" class="form-control" required><?= $ll['keterangan'] ?></textarea>
					</div>
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="frekuensi" name="frekuensi" value="<?= $ll['frekuensi'] ?>" required>
                    </div>
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="kemungkinan_terjadi" name="kemungkinan_terjadi" value="<?= $ll['kemungkinan_terjadi'] ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10">
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
                    <!-- <a href="javascript_void(0)" class="float-right" data-toggle="modal" data-target="#addImpactModal"><i class="fas fa-fw fa-plus"></i></a> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">Peringkat</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($impact as $ll) : ?>
                                    <tr>
                                        <th scope="row"><?= $ll['peringkat'] ?> </th>
                                        <th scope="row"><?= $ll['deskripsi'] ?> </th>
                                        <th scope="row">
                                            <a href="" data-toggle="modal" data-target="#updateImpactModal<?= $ll['peringkat']; ?>" class="badge badge-success">edit</a>
                                            <!-- <a class="badge badge-danger" href="<?= base_url(); ?>klasifikasi/deleteImpact/<?= $ll['peringkat']; ?> " onclick="confirm('Hapus data tersebut?')">delete</a> -->
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
<div class="modal fade" id="addImpactModal" tabindex="-1" aria-labelledby="addImpactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addImpactModalLabel">Add New Impact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form active <?= base_url('klasifikasi/Impact'); ?> method="POST">
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi" required>
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
<?php foreach ($impact as $ll) : $i++ ?>
    <div class="modal fade" id="updateImpactModal<?= $ll['peringkat']; ?>" tabindex="-1" aria-labelledby="updateImpactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateImpactModalLabel">Edit Kemungkinan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('klasifikasi/updateImpact'); ?>
                    <input type="text" class="form-control" id="peringkat" name="peringkat" value="<?= $ll['peringkat']; ?>" hidden>
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?= $ll['deskripsi'] ?>" required>
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

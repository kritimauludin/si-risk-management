<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
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
                    <a href="javascript_void(0)" class="float-right" data-toggle="modal" data-target="#addMeetingRoomModal"><i class="fas fa-fw fa-plus"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Ruang Meeting</th>
                                    <th scope="col">Jam Operasional</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($meetingRoom as $room) : ?>
                                    <tr>
                                        <th scope="row"><?= $i ?> </th>
                                        <th scope="row"><?= $room['room'] ?> </th>
                                        <th scope="row"><?= $room['operational_hours'] ?> </th>
                                        <th scope="row">
                                            <a href="" data-toggle="modal" data-target="#updateMeetingRoomModal<?= $room['id']; ?>" class="badge badge-success">edit</a>
                                            <a class="badge badge-danger" href="<?= base_url(); ?>opsi/deleteroom/<?= $room['id']; ?> " onclick="confirm('Hapus data ruangan?')">delete</a>
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
<div class="modal fade" id="addMeetingRoomModal" tabindex="-1" aria-labelledby="addMeetingRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMeetingRoomModalLabel">Add New Meeting Room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form active <?= base_url('opsi/meetingroom'); ?> method="POST">
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="room" name="room" placeholder="Nama Ruangan" required>
                    </div>
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="operational_hours" name="operational_hours" placeholder="Jam Operasi ex:(08:00 WIB - 17:00 WIB)" required>
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
<?php foreach ($meetingRoom as $room) : $i++ ?>
    <div class="modal fade" id="updateMeetingRoomModal<?= $room['id']; ?>" tabindex="-1" aria-labelledby="updateMeetingRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateMeetingRoomModalLabel">Edit Kemungkinan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('opsi/updateMeetingRoom'); ?>
                    <input type="text" class="form-control" id="id" name="id" value="<?= $room['id']; ?>" hidden>
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="room" name="room" value="<?= $room['room'] ?>" required>
                    </div>
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="operational_hours" name="operational_hours" value="<?= $room['operational_hours'] ?>" required>
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

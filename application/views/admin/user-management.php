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
					<a href="javascript_void(0)" class="float-right" data-toggle="modal" data-target="#addUserModal"><i class="fas fa-fw fa-plus"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Divisi</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($users as $u) : ?>
                                    <tr>
                                        <th scope="row"><?= $i ?> </th>
                                        <th scope="row"><?= $u['name'] ?> </th>
                                        <th scope="row"><?= $u['email'] ?> </th>
                                        <th scope="row"><?= $u['role'] ?> </th>
                                        <th scope="row">
                                            <a href="" data-toggle="modal" data-target="#updateUserModal<?= $u['id']; ?>" class="badge badge-success">edit</a>
                                            <a class="badge badge-danger" href="<?= base_url(); ?>admin/deleteuser/<?= $u['id']; ?> ">delete</a>
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

<?php $i = 0; ?>
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addUserModalLabel">Tambah Data User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?= form_open_multipart('admin/usermanagement'); ?>
				<div class=" form-group mb-3">
					<input type="text" class="form-control" id="name" name="name" placeholder="Nama Pengguna" required>                        
				</div>
				<div class=" form-group mb-3">
					<input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="No HP" required>                        
				</div>
				<div class=" form-group mb-3">
					<input type="text" class="form-control" id="email" name="email" placeholder="Email" required>                     
				</div>
				<div class="form-group mb-3">
					<select name="role_id" id="role_id" class="form-control">
						<?php foreach ($roles as $r) : ?>
							<option value="<?= $r['id'] ?>" required><?= $r['role'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class=" form-group mb-3">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password baru">                
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

<?php foreach ($users as $u) : $i++ ?>
    <div class="modal fade" id="updateUserModal<?= $u['id']; ?>" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModalLabel">Edit Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('admin/updateuser'); ?>
                    <input type="text" class="form-control" id="id" name="id" value="<?= $u['id']; ?>" hidden>
                    <div class=" form-group mb-3">
                        <input type="text" class="form-control" id="update_name" name="update_name" value="<?= $u['name']; ?>" required>                        
                    </div>
                    <div class=" form-group mb-3">
                        <input type="number" class="form-control" id="update_no_hp" name="update_no_hp" value="<?= $u['no_hp']; ?>" required>                        
                    </div>
                    <div class=" form-group mb-3">
						<input type="text" class="form-control" id="update_email" name="update_email" value="<?= $u['email']; ?>" required>                     
                    </div>
					<div class="form-group mb-3">
                        <select name="updaterole_id" id="updaterole_id" class="form-control">
                            <option value="<?= $u['role_id'] ?>" required><?= $u['role']; ?></option>
                            <?php foreach ($roles as $r) : ?>
                                <option value="<?= $r['id'] ?>" required><?= $r['role'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class=" form-group mb-3">
                        <input type="password" class="form-control" id="update_password" name="update_password" placeholder="Password baru">   
						<p class="text-danger text-sm">hanya diisi jika ingin merubah password</p>                    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>

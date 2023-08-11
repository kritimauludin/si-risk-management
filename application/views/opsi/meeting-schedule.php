<!-- Begin Page Content -->
<div class="container-fluid">

	<div class="row">
		<div class="col-lg-12">
			<?php if (validation_errors()) : ?>
				<div class="alert alert-danger" role="alert">
					<?= validation_errors(); ?>
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
					<a href="" class="float-right" data-toggle="modal" data-target="#addMeetingModal"><i class="fas fa-fw fa-plus"></i></a>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th scope="col">Id</th>
									<th scope="col">Inisiasi</th>
									<th scope="col">Ruangan</th>
									<th scope="col">Pelaksanaan</th>
									<th scope="col">Agenda</th>
									<th scope="col">Partisipan</th>
									<th scope="col">Status</th>
									<th scope="col">Action</th>

								</tr>
							</thead>
							<tbody>
								<?php foreach ($meeting as $meet) : ?>
									<tr>
										<th scope="row"><?= $meet['id'] ?> </th>
										<th scope="row"><?= $meet['role'] ?> </th>
										<th scope="row"><?= $meet['room'] ?> </th>
										<th scope="row"><?= $meet['meeting_date'] ?> </th>
										<th scope="row"><?= $meet['agenda'] ?> </th>
										<th scope="row">
											<?php $meetId = $meet['id']; ?>
											<?php foreach ($participant[$meetId] as $data) : ?>
												| <?= $data['role']. ' |'?>
											<?php endforeach;?>
										</th>
										<th scope="row">
											<?php if (date("Y-m-d") >= $meet['meeting_date']  && $meet['status'] == 200) : ?>
												<span class="text-info">Terlaksana</span>
											<?php elseif ($meet['status'] == 202) : ?>
												<span class="text-warning">Menunggu Approve</span>
											<?php elseif (date("Y-m-d") < $meet['meeting_date'] && $meet['status'] == 200) : ?>
												<span class="text-success">Approved - Menunggu Pelaksanaan</span>
											<?php elseif ($meet['status'] == 201) : ?>
												<span class="text-danger">Rapat Ditolak</span>
											<?php endif; ?>
										</th>
										<th scope="row">
											<?php if ($user['role_id'] == $meet['initiate_id'] || $user['role_id'] == 1) : ?>
												<a href="" data-toggle="modal" data-target="#updateMeetingModal<?= $meet['id'] ?>" class="badge badge-success">edit</a>
												<a class="badge badge-danger" href="<?= base_url(); ?>opsi/deletemeeting/<?= $meet['id'] ?>" onclick="confirm('Batalkan meeting tersebut?')">cancle</a>
											<?php endif; ?>
											<hr>
											<?php if ($user['role_id'] == 1 && $meet['status'] == 202) : ?>
												<a class="badge badge-primary" href="<?= base_url(); ?>opsi/approvemeeting/<?= $meet['id']?>" onclick="confirm('Approve meeting ini?')">approve</a>
												<a class="badge badge-danger" href="<?= base_url(); ?>opsi/rejectmeeting/<?= $meet['id']?>" onclick="confirm('Tolak meeting ini?')">reject</a>
											<?php endif; ?>
										</th>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->

	</div>
	<!-- End of Main Content -->


	<!-- Modal -->
	<div class="modal fade" id="addMeetingModal" tabindex="-1" aria-labelledby="addMeetingModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<div class="text-center">
						<h5 class="modal-title" id="addMeetingModalLabel">Jadwalkan Meeting</h5>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?= form_open_multipart('opsi/meeting'); ?>
					<div class="row mb-3">
						<div class="col-lg-4">
							<div class="row">
								<div class="col-lg-12">
									<label for="meeting_date">Waktu Pelaksanaan</label>
									<input type="datetime-local" name="meeting_date" id="meeting_date" class="form-control mb-3" required>
								</div>
								<div class="col-lg-12">
									<select name="room_id" id="room_id" class="form-control mb-3" required>
										<option value="">Pilih Ruangan</option>
										<?php foreach ($meeting_room as $room) : ?>
											<option value="<?= $room['id'] ?>"><?= $room['room'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-8">
							<textarea name="agenda" id="agenda" cols="100" rows="5" class="form-control mb-3" placeholder="Agenda" required></textarea>
						</div>
					</div>
					<div class="row mb-3">
						<div class="text-center col-lg-12">
							<p>Undangan Partisipan</p>
							<hr>
						</div>
						<div class="col-lg-4 text-center">
							<button type="button" class="btn btn-outline-primary float-right mb-3" id="search-divisi-button" data-toggle="modal" data-target="#rolesModal" style="display: block;">Cari Divisi</button>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<div class="form-group mb-3 mr-1">
									<input type="hidden" id="participant_id[0]" name="participant_id[0]">
									<input type="text" id="role_name[0]" name="role_name[0]" placeholder="Divisi (auto)" readonly class="form-control mb-3 text-center mb-3" required>
								</div>
								<div class="field-divisi"></div>
							</div>
						</div>
						<div class="col-lg-12 text-center">
							<a href="javascript:void(0);" id="add-field-divisi" class="h3" style="display: none;"><i class="fas fa-fw fa-plus"></i></a>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Tambah</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<?php foreach ($meeting as $meet) : ?>
		<div class="modal fade" id="updateMeetingModal<?= $meet['id'] ?>" tabindex="-1" aria-labelledby="updateMeetingModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="updateMeetingModalLabel">Edit Isu</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?= form_open_multipart('opsi/updateMeeting'); ?>
						<input type="hidden" name="meeting_id" id="meeting_id" value="<?= $meet['id'] ?>">
						<div class="row mb-3">
							<div class="col-lg-4">
								<div class="row">
									<div class="col-lg-12">
										<label for="meeting_date">Waktu Pelaksanaan</label>
										<input type="datetime-local" name="meeting_date" id="meeting_date" class="form-control mb-3" value="<?= $meet['meeting_date'] ?>" required>
									</div>
									<div class="col-lg-12">
									<select name="room_id" id="room_id" class="form-control mb-3" required>
										<option value="<?=$meet['room_id']?>"><?=$meet['room']?></option>
										<?php foreach ($meeting_room as $room) : ?>
											<option value="<?= $room['id'] ?>"><?= $room['room'] ?></option>
										<?php endforeach; ?>
									</select>
									</div>
								</div>
							</div>
							<div class="col-lg-8">
								<textarea name="agenda" id="agenda" cols="100" rows="5" class="form-control mb-3" placeholder="Agenda" required><?= $meet['agenda'] ?></textarea>
							</div>
						</div>
						<div class="row mb-3">
							<div class="text-center col-lg-12">
								<p>Undangan Partisipan</p>
								<hr>
							</div>
							<div class="col-lg-4 text-center">
								<!-- <button type="button" class="btn btn-outline-primary float-right mb-3" id="search-divisi-button" data-toggle="modal" data-target="#rolesModal" style="display: block;">Cari Divisi</button> -->
							</div>
							<div class="col-lg-6 text-center">
								<span class="text-danger text-xs ">Klik pada divisi yang ingin diubah</span>
								<div class="form-group mb-3">
									<?php $i = 1;
									$meetId = $meet['id']; ?>
									<?php foreach ($participant[$meetId] as $data) : ?>
										<input type="hidden" id="id[<?= $data['id'] ?>]" name="id[<?= $data['id'] ?>]" value="<?= $data['id'] ?>">
										<input type="hidden" id="participant_id[<?= $data['id'] ?>]" name="participant_id[<?= $data['id'] ?>]" value="<?= $data['participant_id'] ?>">
										<input type="text" id="role_name[<?= $data['id'] ?>]" name="role_name[<?= $data['id'] ?>]" value="<?= $data['role'] ?>" readonly onclick="changeDivisi(<?= $data['id'] ?>)" class="form-control mb-3 text-center mb-3" required>
									<?php $i++;
									endforeach; ?>
								</div>
								<!-- <div class="field-divisi"></div> -->
							</div>
							<div class="col-lg-12 text-center">
								<!-- <a href="javascript:void(0);" id="add-field-divisi" class="h3" style="display: none;"><i class="fas fa-fw fa-plus"></i></a> -->
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Ubah</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	<?php endforeach;  ?>


	<div class="modal fade" id="rolesModal" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="text-center">
						<h5 class="modal-title" id="rolesModalLabel">Data Role</h5>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>klik dibaris data untuk memilih pelanggan</p>
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTableRoles" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Divisi</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;
								foreach ($roles as $role) : ?>
									<tr class="RoleData" data-role-id="<?= $role['id'] ?>" class="RoleData" data-role-name="<?= $role['role'] ?>">
										<th scope="row"><?= $i++ ?> </th>
										<td><?= $role['role'] ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div><!-- End customer centered Modal-->

	<div class="modal fade" id="rolesEditModal" tabindex="-1" aria-labelledby="rolesEditModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="text-center">
						<h5 class="modal-title" id="rolesEditModalLabel">Data Role</h5>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>klik dibaris data untuk memilih pelanggan</p>
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTableRoles" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Divisi</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;
								foreach ($roles as $role) : ?>
									<tr class="RoleEditData" data-role-id="<?= $role['id'] ?>" data-role-name="<?= $role['role'] ?>">
										<th scope="row"><?= $i++ ?> </th>
										<td><?= $role['role'] ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div><!-- End customer centered Modal-->

	<script type="text/javascript">
		var addButton = $('#add-field-divisi');
		var searchDivisiButton = $('#search-divisi-button');
		var field = $('.field-divisi');
		var divisiIndex = 0;
		var fieldHtml = '';

		//no isu generate
		$.ajax({
			type: 'GET',
			url: "<?= base_url('isu/getnoisu'); ?>",
			success: function(response) {
				var response = JSON.parse(response);
				$('#id').val(response);
			}
		});

		// Modal customer
		function changeDivisi(divisiEditIndex) {
			$('#rolesEditModal').modal('show');
			$(".RoleEditData").attr('data-divisi-id', divisiEditIndex);

			$(document).on('click', '.RoleEditData', function(e) {
				document.getElementById("participant_id[" + $(this).attr('data-divisi-id') + "]").value = $(this).attr('data-role-id');
				document.getElementById("role_name[" + $(this).attr('data-divisi-id') + "]").value = $(this).attr('data-role-name');
				console.log($(this).attr('data-divisi-id'));
				$('#rolesEditModal').modal('hide');
			});
		};


		$(document).on('click', '.RoleData', function(e) {
			document.getElementById("participant_id[" + divisiIndex + "]").value = $(this).attr('data-role-id');
			document.getElementById("role_name[" + divisiIndex + "]").value = $(this).attr('data-role-name');
			divisiIndex += 1;
			fieldHtml =
				`<div class="form-group mb-3 mr-1">
					<input type="hidden" id="participant_id[` + divisiIndex + `]" name="participant_id[` + divisiIndex + `]">
					<input type="text" id="role_name[` + divisiIndex + `]" name="role_name[` + divisiIndex + `]" placeholder="Divisi (auto)" readonly class="form-control mb-3 text-center" required>
				</div>`;
			searchDivisiButton.removeAttr('style').hide();
			addButton.show();
			$('#rolesModal').modal('hide');
		});

		$(addButton).click(function() {
			searchDivisiButton.show();
			addButton.removeAttr("style").hide();
			$(field).append(fieldHtml);
		});

		$(document).ready(function() {
			$('#dataTableRoles').DataTable();
		});
	</script>

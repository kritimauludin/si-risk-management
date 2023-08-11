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
					<a href="" class="float-right" data-toggle="modal" data-target="#addIsuModal"><i class="fas fa-fw fa-plus"></i></a>
					<a href="<?=base_url('pdfview/reportisu')?>" class="float-right btn btn-sm btn-outline-info mr-3" target="_blank">Generate Report</a>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">No Isu</th>
									<th scope="col">Dept. Penerbit</th>
									<th scope="col">Uraian Isu</th>
									<th scope="col">Sumber</th>
									<th scope="col">Tgl. Target</th>
									<th scope="col">Lampiran Isu</th>
									<th scope="col">Bobot</th>
									<th scope="col">Action</th>

								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>
								<?php foreach ($daftar_isu as $isu) : ?>
									<tr>
										<th scope="row"><?= $i ?> </th>
										<th scope="row"><?= $isu['no_isu'] ?> </th>
										<th scope="row"><?= $isu['role'] ?> </th>
										<th scope="row"><a href="javascript:void(0)" onclick="alert('<?= $isu['uraian_isu'] ?> ')">Lihat disini</a></th>
										<th scope="row"><?= $isu['sumber'] ?> </th>
										<th scope="row"><?= date('Y-m-d', strtotime($isu['tgl_target'])) ?> </th>
										<th scope="row">
											<?php if ($isu['url_lampiran_isu'] == null) : ?>
												<a href="#" onclick="alert('Lampiran isu tidak tersedia!');">Klik disini</a>
											<?php else : ?>
												<a href="<?= base_url() . 'uploads/lampiran-isu/' . $isu['url_lampiran_isu'] ?>" target="_blank">Klik disini</a>
											<?php endif; ?>
										</th>
										<th scope="row">
											<?php if ($isu['bobot'] <= 7) : ?>
												<span class="text-success">Low</span>
											<?php elseif ($isu['bobot'] >= 8 && $isu['bobot'] <= 12) : ?>
												<span class="text-warning">Medium</span>
											<?php else : ?>
												<span class="text-danger">High</span>
											<?php endif; ?>
										</th>
										<th scope="row">
											<?php if ($user['role_id'] == $isu['dept_penerbit']) : ?>
												<a href="" data-toggle="modal" data-target="#updateIsuModal<?= $isu['id'] ?>" class="badge badge-success">edit</a>
												<a class="badge badge-danger" href="<?= base_url(); ?>isu/deletedata/<?= base64_encode($isu['no_isu']); ?>" onclick="confirm('Hapus data ISU tersebut?')">delete</a>
											<?php endif; ?>
												<a class="badge badge-info" href="<?= base_url(); ?>isu/lihatisu/<?= base64_encode($isu['no_isu']); ?>">lihat</a>
											<a class="badge badge-primary" href="<?= base_url(); ?>pdfview/isu/<?= base64_encode($isu['no_isu']); ?>" target="_blank">cetak</a>
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
		<!-- /.container-fluid -->

	</div>
	<!-- End of Main Content -->


	<!-- Modal -->
	<div class="modal fade" id="addIsuModal" tabindex="-1" aria-labelledby="addIsuModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<div class="text-center">
						<h5 class="modal-title" id="addIsuModalLabel">RISK & OPPORTUNITY MANAGEMENT</h5>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?= form_open_multipart('isu'); ?>
					<div class="row mb-3">
						<div class="col-lg-3 mt-1">
							<p>Tanggal : <?= date('d/m/y') ?></p>
						</div>
						<div class="col-lg-3">
							<input type="text" name="no_isu" id="no_isu" class="form-control mb-3" placeholder="No Isu" readonly required>
						</div>
						<div class="text-center col-lg-1">Id Divisi</div>
						<div class="col-lg-2">
							<input type="text" name="dept_penerbit" id="dept_penerbit" class="form-control mb-3" placeholder="Dept. Penerbit" value="<?= $user['role_id'] ?>" readonly required>
						</div>
						<div class="col-lg-3">
							<select name="sumber" id="sumber" class="form-control mb-3">
								<option value="">Sumber Isu</option>
								<option value="Internal">Internal</option>
								<option value="Eksternal">Eksternal</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-lg-4">
							<div class="row">
								<div class="col-lg-12">
									<label for="tgl_target">Tgl.Target</label>
									<input type="date" name="tgl_target" id="tgl_target" class="form-control mb-3" placeholder="Tgl. Target" required>
								</div>
								<div class="col-lg-12">
									<select name="terhadap" id="terhadap" class="form-control mb-3" required>
										<option value="">Terhadap</option>
										<option value="Q">Q</option>
										<option value="C">C</option>
										<option value="D">D</option>
										<option value="Lain-lain">Lain-lain</option>
									</select>
								</div>
								<div class="col-lg-12 mb-3">
									<span>Dampak : </span>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="ket_dampak" id="ket_dampak" value="Positif">
										<label class="form-check-label" for="ket_dampak">Positif</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="ket_dampak" id="ket_dampak" value="Negatif">
										<label class="form-check-label" for="ket_dampak">Negatif</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-8">
							<textarea name="uraian_isu" id="uraian_isu" cols="100" rows="6" class="form-control mb-3" placeholder="Uraian Isu" required></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 mb-3  text-center">
							<input type="file" name="url_lampiran_isu" id="url_lampiran_isu" class="form-control" placeholder="Lampiran (optional)">
							<span class="text-danger text-xs">lampiran bersifat optional dan hanya(pdf, png, jpeg, jpg)</span>
						</div>
						<div class="col-lg-4 mb-3">
							<select name="kemungkinan" id="kemungkinan" class="form-control mb-3" required>
								<option value="">Pilih Kemungkinan</option>
								<?php foreach ($daftar_kemungkinan as $kemungkinan) : ?>
									<option value="<?= $kemungkinan['peringkat'] ?>"><?= $kemungkinan['deskripsi'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-lg-4 mb-3">
							<select name="dampak" id="dampak" class="form-control mb-3" required>
								<option value="">Pilih Dampak</option>
								<?php foreach ($daftar_dampak as $dampak) : ?>
									<option value="<?= $dampak['peringkat'] ?>"><?= $dampak['deskripsi'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<div class="text-center col-lg-12">
							<p>Distribusi</p>
							<hr>
						</div>
						<div class="col-lg-4 text-center">
							<button type="button" class="btn btn-outline-primary float-right mb-3" id="search-divisi-button" data-toggle="modal" data-target="#rolesModal" style="display: block;">Cari Divisi</button>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<div class="form-group mb-3 mr-1">
									<input type="hidden" id="role_id[0]" name="role_id[0]">
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

	<?php foreach ($daftar_isu as $isu) : ?>
		<div class="modal fade" id="updateIsuModal<?= $isu['id'] ?>" tabindex="-1" aria-labelledby="updateIsuModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="updateIsuModalLabel">Edit Isu</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?= form_open_multipart('isu/updateisu'); ?>
						<div class="row mb-3">
							<div class="col-lg-3 mt-1">
								<p>Tanggal : <?= date('d/m/y') ?></p>
							</div>
							<div class="col-lg-3">
								<input type="text" name="no_isu" id="no_isu" class="form-control mb-3" value="<?= $isu['no_isu'] ?>" readonly required>
							</div>
							<div class="col-lg-2">

								<input type="text" name="dept_penerbit" id="dept_penerbit" class="form-control mb-3" placeholder="Dept. Penerbit" value="<?= $user['role_id'] ?>" readonly required>
							</div>
							<div class="col-lg-3">
								<select name="sumber" id="sumber" class="form-control mb-3">
									<option value="<?= $isu['sumber'] ?>"><?= $isu['sumber'] ?></option>
									<option value="Internal">Internal</option>
									<option value="Eksternal">Eksternal</option>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-4">
								<div class="row">
									<div class="col-lg-12">
										<label for="tgl_target">Tgl.Target</label>
										<input type="date" name="tgl_target" id="tgl_target" class="form-control mb-3" placeholder="Tgl. Target" value="<?= date('Y-m-d', strtotime($isu['tgl_target'])) ?>" required>
									</div>
									<div class="col-lg-12">
										<select name="terhadap" id="terhadap" class="form-control mb-3" required>
											<option value="<?= $isu['terhadap'] ?>"><?= $isu['terhadap'] ?></option>
											<option value="Q">Q</option>
											<option value="C">C</option>
											<option value="D">D</option>
											<option value="Lain-lain">Lain-lain</option>
										</select>
									</div>
									<div class="col-lg-12 mb-3">
										<span>Dampak : </span>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="ket_dampak" id="ket_dampak" value="Positif" <?= ($isu['ket_dampak']== 'Positif') ? 'checked' : '';?>>
											<label class="form-check-label" for="ket_dampak">Positif</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="ket_dampak" id="ket_dampak" value="Negatif"  <?= ($isu['ket_dampak']== 'Negatif') ? 'checked' : '';?>>
											<label class="form-check-label" for="ket_dampak">Negatif</label>
										</div>	
									</div>
								</div>
							</div>
							<div class="col-lg-8">
								<textarea name="uraian_isu" id="uraian_isu" cols="100" rows="5" class="form-control mb-3" placeholder="Uraian Isu" required><?= $isu['uraian_isu'] ?></textarea>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-4 mb-3 text-center">
								<input type="file" name="url_lampiran_isu" id="url_lampiran_isu" class="form-control" placeholder="Isi jika ingin ubah lampiran">
								<span class="text-danger text-xs ">upload lampiran baru untuk merubah file sebelumnya dan hanya(pdf, png, jpeg, jpg)</span>
							</div>
							<div class="col-lg-4">
								<select name="kemungkinan" id="kemungkinan" class="form-control mb-3" required>
									<?php foreach ($daftar_kemungkinan as $kemungkinan) : ?>
										<?php if ($isu['kemungkinan'] == $kemungkinan['peringkat']) : ?>
											<option value="<?= $isu['kemungkinan'] ?>" selected><?= $kemungkinan['deskripsi'] ?></option>
										<?php endif; ?>
										<option value="<?= $kemungkinan['peringkat'] ?>"><?= $kemungkinan['deskripsi'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="dampak" id="dampak" class="form-control mb-3" required>
									<option value="">Pilih Dampak</option>
									<?php foreach ($daftar_dampak as $dampak) : ?>
										<?php if ($isu['dampak'] == $dampak['peringkat']) : ?>
											<option value="<?= $isu['dampak'] ?>" selected><?= $dampak['deskripsi'] ?></option>
										<?php endif; ?>
										<option value="<?= $dampak['peringkat'] ?>"><?= $dampak['deskripsi'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<div class="text-center col-lg-12">
								<p>Distribusi</p>
								<hr>
							</div>
							<div class="col-lg-4 text-center">
								<!-- <button type="button" class="btn btn-outline-primary float-right mb-3" id="search-divisi-button" data-toggle="modal" data-target="#rolesModal" style="display: block;">Cari Divisi</button> -->
							</div>
							<div class="col-lg-6 text-center">
								<span class="text-danger text-xs ">Klik pada divisi yang ingin diubah</span>
								<div class="form-group mb-3">
									<?php $i=1; $noIsu = $isu['no_isu'];?>
									<?php foreach($tindakan[$noIsu] as $data) :?>
										<input type="hidden" id="no_tindakan[<?=$data['id']?>]" name="no_tindakan[<?=$data['id']?>]" value="<?= $data['no_tindakan'] ?>">
										<input type="hidden" id="role_id[<?=$data['id']?>]" name="role_id[<?=$data['id']?>]" value="<?= $data['dept_penerima'] ?>">
										<input type="text" id="role_name[<?=$data['id']?>]" name="role_name[<?=$data['id']?>]" value="<?= $data['role'] ?>" readonly onclick="changeDivisi(<?=$data['id']?>)" class="form-control mb-3 text-center mb-3" required>
									<?php $i++; endforeach;?>
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
				$('#no_isu').val(response);
			}
		});

		// Modal customer
		function changeDivisi(divisiEditIndex) {
			$('#rolesEditModal').modal('show');
			$(".RoleEditData").attr('data-divisi-id', divisiEditIndex);

			$(document).on('click', '.RoleEditData', function(e) {
				document.getElementById("role_id[" + $(this).attr('data-divisi-id') + "]").value = $(this).attr('data-role-id');
				document.getElementById("role_name[" + $(this).attr('data-divisi-id') + "]").value = $(this).attr('data-role-name');
				$('#rolesEditModal').modal('hide');
			});
		};


		$(document).on('click', '.RoleData', function(e) {
			document.getElementById("role_id[" + divisiIndex + "]").value = $(this).attr('data-role-id');
			document.getElementById("role_name[" + divisiIndex + "]").value = $(this).attr('data-role-name');
			divisiIndex += 1;
			fieldHtml =
				`<div class="form-group mb-3 mr-1">
					<input type="hidden" id="role_id[` + divisiIndex + `]" name="role_id[` + divisiIndex + `]">
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

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
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">No Isu</th>
									<th scope="col">Uraian Isu</th>
									<th scope="col">Sumber</th>
									<th scope="col">Dept. Penerbit</th>
									<th scope="col">Tgl. Target</th>
									<th scope="col">Tgl. Aktual</th>
									<th scope="col">Lampiran Isu</th>
									<th scope="col">Lampiran Tindakan</th>
									<th scope="col">Bobot</th>
									<th scope="col">Status Isu</th>
									<th scope="col">Action</th>

								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>
								<?php foreach ($daftar_tindakan as $tindak) : ?>
									<tr>
										<th scope="row"><?= $i ?> </th>
										<th scope="row"><?= $tindak['no_isu'] ?> </th>
										<th scope="row"><a href="javascript:void(0)" onclick="alert('<?= $tindak['uraian_isu'] ?> ')">Lihat disini</a></th>
										<th scope="row"><?= $tindak['sumber'] ?> </th>
										<th scope="row"><?= $tindak['role'] ?> </th>
										<th scope="row"><?= date('Y-m-d', strtotime($tindak['tgl_target'])) ?> </th>
										<th scope="row"><?= (isset($tindak['tgl_aktual'])) ? $tindak['tgl_aktual'] : '-'; ?> </th>
										<th scope="row">
											<?php if ($tindak['url_lampiran_isu'] == null) : ?>
												<a href="#" onclick="alert('Lampiran isu tidak tersedia!');">Klik disini</a>
											<?php else : ?>
												<a href="<?= base_url() . 'uploads/lampiran-isu/' . $tindak['url_lampiran_isu'] ?>" target="_blank">Klik disini</a>
											<?php endif; ?>
										</th>
										<th scope="row">
											<?php if ($tindak['url_lampiran_tindakan'] == null) : ?>
												<a href="#" onclick="alert('Lampiran tindakan tidak tersedia!');">Klik disini</a>
											<?php else : ?>
												<a href="<?= base_url() . 'uploads/lampiran-tindakan/' . $tindak['url_lampiran_tindakan'] ?>" target="_blank">Klik disini</a>
											<?php endif; ?>
										</th>
										<th scope="row">
											<?php if ($tindak['bobot'] <= 7) : ?>
												<span class="text-success">Low</span>
											<?php elseif ($tindak['bobot'] >= 8 && $tindak['bobot'] <= 12) : ?>
												<span class="text-warning">Medium</span>
											<?php else : ?>
												<span class="text-danger">High</span>
											<?php endif; ?>
										</th>
										<th scope="row">
											<?php if ($tindak['status_isu'] == 200) : ?>
												<span class="text-danger">closed</span>
											<?php elseif ($tindak['status_isu'] == 201) : ?>
												<span class="text-warning">on going</span>
											<?php else : ?>
												<span class="text-success">open</span>
											<?php endif; ?>
										</th>
										<th scope="row">
											<?php if ($tindak['status'] == 202) : ?>
												<a href="javascipt:void(0)" data-toggle="modal" data-target="#tindakanModal<?= $tindak['id']; ?>" class="badge badge-success">Isi Tindakan</a>
											<?php else : ?>
												<a class="badge badge-info" href="javascipt:void(0)" data-toggle="modal" data-target="#lihatTindakanModal<?= $tindak['id']; ?>">Lihat Tindakan</a>
											<?php endif; ?>
											<?php if ($tindak['status_isu'] != 200 && $tindak['status'] == 200) : ?>
												<a href="javascipt:void(0)" data-toggle="modal" data-target="#editTindakanModal<?= $tindak['id']; ?>" class="badge badge-success">Edit Tindakan</a>
											<?php endif; ?>
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
	<?php foreach ($daftar_tindakan as $tindak) : ?>
		<div class="modal fade" id="tindakanModal<?= $tindak['id']; ?>" tabindex="-1" aria-labelledby="tindakanModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="tindakanModalLabel">Isi Tindakan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?= form_open_multipart('isu/tindakan'); ?>
						<div class="row mb-3">
							<div class="text-center col-lg-12">
								<p>Data Isu</p>
								<hr>
							</div>
							<div class="col-lg-3 mt-1">
								<p>Tanggal : <?= $tindak['created_at'] ?></p>
							</div>
							<div class="col-lg-3">
								<input type="text" name="no_isu" id="no_isu" class="form-control mb-3" value="<?= $tindak['no_isu'] ?>" readonly required>
								<input type="hidden" name="no_tindakan" id="no_tindakan" class="form-control mb-3" value="<?= $tindak['no_tindakan'] ?>" readonly required>
							</div>
							<div class="col-lg-2">

								<input type="text" name="dept_penerbit" id="dept_penerbit" class="form-control mb-3" placeholder="Dept. Penerbit" value="<?= $user['role_id'] ?>" readonly required>
							</div>
							<div class="col-lg-3">
								<select name="sumber" id="sumber" class="form-control mb-3" readonly>
									<option value="<?= $tindak['sumber'] ?>"><?= $tindak['sumber'] ?></option>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-3">
								<div class="row">
									<div class="col-lg-12">
										<label for="tgl_target">Tgl.Target</label>
										<input type="text" name="tgl_target" id="tgl_target" class="form-control mb-3" placeholder="Tgl. Target" value="<?= $tindak['tgl_target'] ?>" readonly required>
									</div>
									<div class="col-lg-12">
										<select name="terhadap" id="terhadap" class="form-control mb-3" readonly required>
											<option value="<?= $tindak['terhadap'] ?>"><?= $tindak['terhadap'] ?></option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-9">
								<textarea name="uraian_isu" id="uraian_isu" cols="100" rows="5" class="form-control mb-3" placeholder="Uraian Isu" readonly required><?= $tindak['uraian_isu'] ?></textarea>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-4">
								<a href="<?= base_url() . 'uploads/lampiran-isu/' . $tindak['url_lampiran_isu'] ?>" target="_blank">Lampiran Isu klik disini</a>
							</div>
							<div class="col-lg-4">
								<select name="kemungkinan" id="kemungkinan" class="form-control mb-3" readonly required>
									<?php foreach ($daftar_kemungkinan as $kemungkinan) : ?>
										<?php if ($tindak['kemungkinan'] == $kemungkinan['peringkat']) : ?>
											<option value="<?= $tindak['kemungkinan'] ?>" selected><?= $kemungkinan['deskripsi'] ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="dampak" id="dampak" class="form-control mb-3" readonly required>
									<option value="">Pilih Dampak</option>
									<?php foreach ($daftar_dampak as $dampak) : ?>
										<?php if ($tindak['dampak'] == $dampak['peringkat']) : ?>
											<option value="<?= $tindak['dampak'] ?>" selected><?= $dampak['deskripsi'] ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<div class="text-center col-lg-12">
								<p>Tindakan Divisimu</p>
								<hr>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-4">
								<div class="row">
									<div class="col-lg-12">
										<input type="hidden" name="tgl_target" id="tgl_target" class="form-control mb-3" value=" <?= $tindak['tgl_target']; ?>" readonly required>
										<label for="tgl_aktual">Tgl. Aktual</label>
										<input type="text" name="tgl_aktual" id="tgl_aktual" class="form-control mb-3" value=" <?= date("Y-m-d H:i:s", time()); ?>" readonly required>
									</div>
									<div class="col-lg-12  text-center">
										<input type="file" name="url_lampiran_tindakan" id="url_lampiran_tindakan" class="form-control" placeholder="Lampiran (optional)">
										<span class="text-danger text-xs">lampiran bersifat optional dan hanya(pdf, png, jpeg, jpg)</span>
									</div>
								</div>
							</div>
							<div class="col-lg-8">
								<textarea name="uraian_tindakan" id="uraian_tindakan" cols="100" rows="5" class="form-control mb-3" placeholder="Uraian tindakan" required></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Kirim</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	<?php endforeach;  ?>

	<?php foreach ($daftar_tindakan as $tindak) : ?>
		<div class="modal fade" id="editTindakanModal<?= $tindak['id']; ?>" tabindex="-1" aria-labelledby="editTindakanModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editTindakanModalLabel">Lihat Tindakan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?= form_open_multipart('isu/edittindakan'); ?>
						<div class="row mb-3">
							<div class="text-center col-lg-12">
								<p>Data Isu</p>
								<hr>
							</div>
							<div class="col-lg-3 mt-1">
								<p>Tanggal : <?= $tindak['created_at'] ?></p>
							</div>
							<div class="col-lg-3">
								<input type="text" name="no_isu" id="no_isu" class="form-control mb-3" value="<?= $tindak['no_isu'] ?>" readonly required>
								<input type="hidden" name="no_tindakan" id="no_tindakan" class="form-control mb-3" value="<?= $tindak['no_tindakan'] ?>" readonly required>
							</div>
							<div class="col-lg-2">

								<input type="text" name="dept_penerbit" id="dept_penerbit" class="form-control mb-3" placeholder="Dept. Penerbit" value="<?= $user['role_id'] ?>" readonly required>
							</div>
							<div class="col-lg-3">
								<select name="sumber" id="sumber" class="form-control mb-3" readonly>
									<option value="<?= $tindak['sumber'] ?>"><?= $tindak['sumber'] ?></option>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-3">
								<div class="row">
									<div class="col-lg-12">
										<label for="tgl_target">Tgl.Target</label>
										<input type="text" name="tgl_target" id="tgl_target" class="form-control mb-3" placeholder="Tgl. Target" value="<?= $tindak['tgl_target'] ?>" readonly required>
									</div>
									<div class="col-lg-12">
										<select name="terhadap" id="terhadap" class="form-control mb-3" readonly required>
											<option value="<?= $tindak['terhadap'] ?>"><?= $tindak['terhadap'] ?></option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-9">
								<textarea name="uraian_isu" id="uraian_isu" cols="100" rows="5" class="form-control mb-3" placeholder="Uraian Isu" readonly required><?= $tindak['uraian_isu'] ?></textarea>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-4">
								<?php if ($tindak['url_lampiran_isu'] == null) : ?>
									<a href="#" onclick="alert('Lampiran isu tidak tersedia!');">Lampiran isu klik disini</a>
								<?php else : ?>
									<a href="<?= base_url() . 'uploads/lampiran-isu/' . $tindak['url_lampiran_isu'] ?>" target="_blank">Lampiran isu klik disini</a>
								<?php endif; ?>
							</div>
							<div class="col-lg-4">
								<select name="kemungkinan" id="kemungkinan" class="form-control mb-3" readonly required>
									<?php foreach ($daftar_kemungkinan as $kemungkinan) : ?>
										<?php if ($tindak['kemungkinan'] == $kemungkinan['peringkat']) : ?>
											<option value="<?= $tindak['kemungkinan'] ?>" selected><?= $kemungkinan['deskripsi'] ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="dampak" id="dampak" class="form-control mb-3" readonly required>
									<option value="">Pilih Dampak</option>
									<?php foreach ($daftar_dampak as $dampak) : ?>
										<?php if ($tindak['dampak'] == $dampak['peringkat']) : ?>
											<option value="<?= $tindak['dampak'] ?>" selected><?= $dampak['deskripsi'] ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<div class="text-center col-lg-12">
								<p>Tindakan Divisimu</p>
								<hr>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-4">
								<div class="row">
									<div class="col-lg-12">
										<input type="hidden" name="tgl_target" id="tgl_target" class="form-control mb-3" value=" <?= $tindak['tgl_target']; ?>" readonly required>
										<label for="tgl_aktual">Tgl. Aktual</label>
										<input type="text" name="tgl_aktual" id="tgl_aktual" class="form-control mb-3" value=" <?= date("Y-m-d H:i:s", time()); ?>" readonly required>
									</div>
									<div class="col-lg-12  text-center">
										<input type="file" name="update_lampiran_tindakan" id="update_lampiran_tindakan" class="form-control" placeholder="Lampiran (optional)">
										<span class="text-danger text-xs">lampiran bersifat optional, timpa untuk edit file sebelumnya dan hanya(pdf, png, jpeg, jpg)</span>
									</div>
								</div>
							</div>
							<div class="col-lg-8">
								<textarea name="uraian_tindakan" id="uraian_tindakan" cols="100" rows="5" class="form-control mb-3" placeholder="Uraian tindakan" required><?= $tindak['uraian_tindakan'];?></textarea>
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

	<?php foreach ($daftar_tindakan as $tindak) : ?>
		<div class="modal fade" id="lihatTindakanModal<?= $tindak['id']; ?>" tabindex="-1" aria-labelledby="lihatTindakanModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="lihatTindakanModalLabel">Lihat Tindakan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?= form_open_multipart('isu/tindakan'); ?>
						<div class="row mb-3">
							<div class="text-center col-lg-12">
								<p>Data Isu</p>
								<hr>
							</div>
							<div class="col-lg-3 mt-1">
								<p>Tanggal : <?= $tindak['created_at'] ?></p>
							</div>
							<div class="col-lg-3">
								<input type="text" name="no_isu" id="no_isu" class="form-control mb-3" value="<?= $tindak['no_isu'] ?>" readonly required>
								<input type="hidden" name="no_tindakan" id="no_tindakan" class="form-control mb-3" value="<?= $tindak['no_tindakan'] ?>" readonly required>
							</div>
							<div class="col-lg-2">

								<input type="text" name="dept_penerbit" id="dept_penerbit" class="form-control mb-3" placeholder="Dept. Penerbit" value="<?= $user['role_id'] ?>" readonly required>
							</div>
							<div class="col-lg-3">
								<select name="sumber" id="sumber" class="form-control mb-3" readonly>
									<option value="<?= $tindak['sumber'] ?>"><?= $tindak['sumber'] ?></option>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-3">
								<div class="row">
									<div class="col-lg-12">
										<label for="tgl_target">Tgl.Target</label>
										<input type="text" name="tgl_target" id="tgl_target" class="form-control mb-3" placeholder="Tgl. Target" value="<?= $tindak['tgl_target'] ?>" readonly required>
									</div>
									<div class="col-lg-12">
										<select name="terhadap" id="terhadap" class="form-control mb-3" readonly required>
											<option value="<?= $tindak['terhadap'] ?>"><?= $tindak['terhadap'] ?></option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-9">
								<textarea name="uraian_isu" id="uraian_isu" cols="100" rows="5" class="form-control mb-3" placeholder="Uraian Isu" readonly required><?= $tindak['uraian_isu'] ?></textarea>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-4">
								<?php if ($tindak['url_lampiran_isu'] == null) : ?>
									<a href="#" onclick="alert('Lampiran isu tidak tersedia!');">Lampiran isu klik disini</a>
								<?php else : ?>
									<a href="<?= base_url() . 'uploads/lampiran-isu/' . $tindak['url_lampiran_isu'] ?>" target="_blank">Lampiran isu klik disini</a>
								<?php endif; ?>
							</div>
							<div class="col-lg-4">
								<select name="kemungkinan" id="kemungkinan" class="form-control mb-3" readonly required>
									<?php foreach ($daftar_kemungkinan as $kemungkinan) : ?>
										<?php if ($tindak['kemungkinan'] == $kemungkinan['peringkat']) : ?>
											<option value="<?= $tindak['kemungkinan'] ?>" selected><?= $kemungkinan['deskripsi'] ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="dampak" id="dampak" class="form-control mb-3" readonly required>
									<option value="">Pilih Dampak</option>
									<?php foreach ($daftar_dampak as $dampak) : ?>
										<?php if ($tindak['dampak'] == $dampak['peringkat']) : ?>
											<option value="<?= $tindak['dampak'] ?>" selected><?= $dampak['deskripsi'] ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<div class="text-center col-lg-12">
								<p>Tindakan Divisimu</p>
								<hr>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-4">
								<div class="row">
									<div class="col-lg-12">
										<input type="hidden" name="tgl_target" id="tgl_target" class="form-control mb-3" value=" <?= $tindak['tgl_target']; ?>" readonly required>
										<label for="tgl_aktual">Tgl. Aktual</label>
										<input type="text" name="tgl_aktual" id="tgl_aktual" class="form-control mb-3" value="<?= $tindak['tgl_aktual']; ?>" readonly required>
									</div>
									<div class="col-lg-12  text-center">
										<?php if ($tindak['url_lampiran_tindakan'] == null) : ?>
											<a href="#" onclick="alert('Lampiran tindakan tidak tersedia!');">Lampiran tindakan klik disini</a>
										<?php else : ?>
											<a href="<?= base_url() . 'uploads/lampiran-tindakan/' . $tindak['url_lampiran_tindakan'] ?>" target="_blank">Lampiran tindakan klik disini</a>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="col-lg-8">
								<textarea name="uraian_tindakan" id="uraian_tindakan" cols="100" rows="5" class="form-control mb-3" readonly required><?= $tindak['uraian_tindakan'] ?></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	<?php endforeach;  ?>

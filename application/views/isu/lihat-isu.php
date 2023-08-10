<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->

	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3 text-center">
					<h6 class="m-0 font-weight-bold text-dark d-inline">ISU <?= $dataIsu->no_isu ?></h6>
				</div>
				<div class="card-body">
					<div class="p-2">
						<div class="row mb-3">
							<div class="col-lg-3 mt-1">
								<p>Tanggal : <?= date('d/m/y', strtotime($dataIsu->created_at)) ?></p>
							</div>
							<div class="col-lg-3">
								<input type="text" name="no_isu" id="no_isu" class="form-control mb-3" value="<?= $dataIsu->no_isu ?>" readonly>
							</div>
							<div class="text-center col-lg-1">Id Divisi</div>
							<div class="col-lg-2">
								<input type="text" name="dept_penerbit" id="dept_penerbit" class="form-control mb-3" value="<?= $dataIsu->role ?>" readonly required>
							</div>
							<div class="col-lg-3">
								<select name="sumber" id="sumber" class="form-control mb-3" readonly>
									<option value="<?= $dataIsu->sumber ?>"><?= $dataIsu->sumber ?></option>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-4">
								<div class="row">
									<div class="col-lg-12">
										<label for="tgl_target">Tgl.Target</label>
										<input type="text" name="tgl_target" id="tgl_target" class="form-control mb-3" value="<?= date('Y-m-d', strtotime($dataIsu->tgl_target)) ?>" readonly>
									</div>
									<div class="col-lg-12">
										<select name="terhadap" id="terhadap" class="form-control mb-3" readonly>
											<option value="<?= $dataIsu->terhadap ?>"><?= $dataIsu->terhadap ?></option>
										</select>
									</div>
									<div class="col-lg-12 mb-3">
										<span>Dampak : (<?= $dataIsu->ket_dampak ?>) </span>
									</div>
								</div>
							</div>
							<div class="col-lg-8">
								<textarea name="uraian_isu" id="uraian_isu" cols="100" rows="6" class="form-control mb-3" readonly><?= $dataIsu->uraian_isu ?></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 mb-3  text-center">
								<a href="<?= base_url('uploads/lampiran-isu/') . $dataIsu->url_lampiran_isu ?>" target="_blank">Lihat lampiran isu</a>
							</div>
							<div class="col-lg-4 mb-3">
								<select name="kemungkinan" id="kemungkinan" class="form-control mb-3" readonly>
									<?php foreach ($daftar_kemungkinan as $kemungkinan) : ?>
										<?php if ($dataIsu->kemungkinan == $kemungkinan['peringkat']) : ?>
											<option value="<?= $kemungkinan['peringkat'] ?>"><?= $kemungkinan['deskripsi'] ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-lg-4 mb-3">
								<select name="dampak" id="dampak" class="form-control mb-3" readonly>
									<?php foreach ($daftar_dampak as $dampak) : ?>
										<?php if ($dataIsu->dampak == $dampak['peringkat']) : ?>
											<option value="<?= $dampak['peringkat'] ?>"><?= $dampak['deskripsi'] ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card shadow mb-4">
				<div class="card-header py-3 text-center">
					<h6 class="m-0 font-weight-bold text-dark d-inline">Data Tindakan</h6>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered " width="100%" cellspacing="0">
							<thead>
								<tr class="text-center">
									<th>No</th>
									<th>Tindakan</th>
									<th>PIC</th>
									<th>Target</th>
									<th>Aktual</th>
									<th>Lampiran</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php $Nomor = 1; ?> 
								<?php foreach ($daftarTindakan as $tindakan) : ?>
								<?php if ($tindakan["status"] == 200) : ?> <tr>
									<td><?= $Nomor++ ?></td>
									<td><?= $tindakan['uraian_tindakan'] ?></td>
									<td><?= $tindakan["role"] ?></td>
									<td><?= date('d-m-Y', strtotime($tindakan["tgl_target"])) ?></td>
									<td><?= date('d-m-Y', strtotime($tindakan["tgl_aktual"])) ?></td>
									<td><a href="<?= base_url('uploads/lampiran-tindakan/') . $tindakan['url_lampiran_tindakan'] ?>" target="_blank">Lihat lampiran tindakan</a></td>
									<td>ditindak</td>
									</tr>
								<?php else : ?>
									<tr>
										<td><?= $Nomor++ ?></td>
										<td>-</td>
										<td><?= $tindakan["role"] ?></td>
										<td><?= date('d-m-Y', strtotime($tindakan["tgl_target"])) ?></td>
										<td>-</td>
										<td>-</td>
										<td>-</td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
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

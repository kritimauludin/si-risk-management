<html>
<head>
	<title><?= $title ?></title>
	<style>
		.text-bold {
			font-weight: bold;
			display: inline;
		}
		.text-center {
			text-align: center;
		}
	</style>
</head>
<body>
<div style="text-align: center;">
	<h4 style="margin: 0px;">PT. MURNI CAHAYA PRATAMA</h4>
	<h5 style="margin-top: 0px;">RISK & OPPORTUNITY MANAGEMENT</h5>
	<h5 style="margin-top: 0px;">Pengendalian Risiko & Peluang</h5>
</div>

<table width="100%" style="font-size: 12px;">
  <tr>
	<td align="right"><p>No. : <?= $title ?></p></td>
  </tr>
</table>
<hr>
<div style="text-align: center;">
	<h5 style="margin: 0px;">Dept. Penerbit ISU</h5>
</div>
<hr>

<table width="100%" style="font-size: 12px;">
	<tr>
		<td><p><div class="text-bold">Dept. Penerbit :   <?= $dataIsu->role;?></div></p></td>
		<td><p>Tanggal : <?= date('d/m/Y', strtotime($dataIsu->created_at));?></p></td>
		<td><p>Sumber : <?= $dataIsu->sumber;?></p></td>
	</tr>
</table>
<hr>

<table width="100%"  style="font-size: 12px;">
  <tr>
	<th style="background-color: #F5F5F5; color: black; padding: 3px;"  align="left"><p>(1) Uraian ISU</p></th>
  </tr>
  <tr >
	<td style="height: 100px; text-align: justify;">
		<p><?= $dataIsu->uraian_isu ?></p>
	</td>
  </tr>
</table>

<table width="100%"  style="font-size: 12px;">
  <tr>
	<th style="background-color: #F5F5F5; color: black; padding: 3px;"  align="left"><p>(2) Dampak ISU</p></th>
  </tr>
  <tr>
  		<td><p>
			<div class="text-bold">Dampak&nbsp;&nbsp;&nbsp;&nbsp;: (<?= $dataIsu->ket_dampak?>) </div>
		</p></td>
		<td><p><div class="text-bold">Terhadap : (<?= $dataIsu->terhadap;?>)</div></p></td>
  </tr>
  <tr>
  		<td><p>
			<div class="text-bold">Bobot ISU&nbsp;: (
				<?php if($dataIsu->bobot <= 7) : ?>
					<span class="text-success">Low</span>
				<?php elseif($dataIsu->bobot >= 8 && $dataIsu->bobot <= 12) : ?>
					<span class="text-warning">Medium</span>
				<?php else : ?>
					<span class="text-danger">High</span>
				<?php endif; ?>)
			</div>
		</p></td>
  </tr>
</table>

<div>
<table class="TabelTandaTangan" style="text-align: center; font-size=15px; margin-left: 850px;">
	<?php
	echo '
		  <tr>
		  	<td>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
			  <p>_____________________________________</p>
			  <p><b>Ttd. Minimal Asst. Mgr.</b></p>
			</td>
		</tr>';
	?>
</table>
</div>
<hr>

<div style="text-align: center;">
	<h5 style="margin: 0px;">Dept. Terkait</h5>
</div>
<hr>

<table width="100%"  style="font-size: 12px;"> 
  <tr>
	<th style="background-color: #F5F5F5; color: black; padding: 3px;"  align="left"><p>(3) Uraian Tindakan</p></th>
  </tr>
</table>
<div>
<table id="TabelTampilData" style="table-layout: auto; width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px;">
	<thead align="center">
		<tr style="text-align: center; font-size: 15px;">
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=10px;">No</th>
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=250px;">Tindakan</th>
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=100px;">PIC</th>
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=185px;">Target</th>
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=200px;">Aktual</th>
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=100px;">Status</th>
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=100px;">TTD</th>
		</tr>
	</thead>
	<tbody style="font-size:10px;">
	<?php $Nomor	= 1;?>
	<?php foreach($daftarTindakan as $tindakan) : ?>
		<?php if($tindakan["status"] == 200) : ?>
				<tr>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=10px;"><?=$Nomor++;?></td>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=250px;"><?= $tindakan['uraian_tindakan']; ?></td>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; width=100px;"><?= $tindakan["role"]; ?></td>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=185px;"><?= date('d-m-Y', strtotime($tindakan["tgl_target"]));?></td>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=180px;"><?= date('d-m-Y', strtotime($tindakan["tgl_aktual"]));?></td>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; width=100px;">ditindak</td>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; width=100px;"><div style="width: 200px"></div></td> 
				</tr>;
		<?php else :?>
					<tr>
						<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=10px;"><?=$Nomor++;?></td>
						<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=100px;">-</td>
						<td style="padding: 5px; border-bottom: 1px solid #ddd; width=250px;"><?= $tindakan["role"]; ?></td>
						<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=185px;"><?= date('d-m-Y', strtotime($tindakan["tgl_target"]));?></td>
						<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=180px;">-</td>
						<td style="padding: 5px; border-bottom: 1px solid #ddd; width=100px;">-</td>
						<td style="padding: 5px; border-bottom: 1px solid #ddd; width=200px;"></td>
					</tr>;
		<?php endif;?>
	<?php endforeach;?>
	</tbody>
</table>
</div>

<hr>
<div style="text-align: center;">
	<h5 style="margin: 0px;">Dept. Penerbit & Mgt Dev.</h5>
</div>
<hr>

<table width="100%" style="font-size: 12px;">
  <tr>
	<th style="background-color: #F5F5F5; color: black; padding: 3px;"  align="left"><p>(4) Keterangan Verifikasi : Lampiran : Ada / Tidak, Tanggal : ______ /______ /_____________ </p></th>
  </tr>
</table>
<div>
<table class="TabelTandaTangan" style="text-align: center; font-size=15px;">
<?php
	echo '
		  <tr>
			<td>
				<p>
				<b>Uraian</b>
				_____________________________________________________________________________________<br>
				_____________________________________________________________________________________<br>
				_____________________________________________________________________________________<br>
				_____________________________________________________________________________________<br>
				_____________________________________________________________________________________<br>
				_____________________________________________________________________________________<br>
				_____________________________________________________________________________________<br>
				</p>
			</td>
		  	<td>
			  <p>Diketahui,</p>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
			  <p>_____________________________________</p>
			  <p><b>Dept. Penerbit</b></p>
			</td>
			<td><div style="margin: 20px;"></div></td>
		  	<td>
			  <p>Diketahui,</p>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
			  <p>_____________________________________</p>
			  <p><b>Mgt. Development</b></p>
			</td>
		</tr>';
	?>
</table>
</div>

</body>
</html>

<html>

<head>
	<title><?= $title ?></title>
</head>

<body>
	<style>
		.text-size-30 {
			font-size: 30px;
		}

		.users-label {
			padding: 5px;
			height: 30px;
			width: 200px;
			font-size: 25px;
		}

		.users-data {
			padding: 5px;
			height: 30px;
			width: 400px;
			font-size: 25px;
		}

		.users-data-head {
			padding: 5px;
			height: 30px;
			width: 300px;
			font-size: 25px;
			text-align: center;
		}

		table,
		th,
		td {
			border: 1px solid black;
			border-collapse: collapse;
		}
	</style>
	<div style="text-align: center;">
		<h2 style="margin: 0px;"><?= $title ?></h2>
	</div>
	<hr>

	<table width=100%; style="table-layout: auto; width: 100%; border-collapse: collapse; margin-top: 10px; margin-left: 10px;">
		<thead>
			<tr>
				<th style="font-size: 12px; text-align:center; paddding:5px">No</th>
				<th style="font-size: 12px; text-align:center; paddding:5px">No Isu</th>
				<th style="font-size: 12px; text-align:center; paddding:5px">Dept. Penerbit</th>
				<th style="font-size: 12px; text-align:center; paddding:5px">Tgl. Target</th>
				<th style="font-size: 12px; text-align:center; paddding:5px">Uraian Isu</th>
				<th style="font-size: 12px; text-align:center; paddding:5px">Bobot</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			<?php foreach ($daftar_isu as $isu) : ?>
				<tr style="font-size: 12px;">
					<td style="font-size: 12px; text-align:center; paddding:5px"><?= $i++ ?></td>
					<td style="font-size: 12px; text-align:center; paddding:5px"><?= $isu['no_isu'] ?></td>
					<td style="font-size: 12px; text-align:center; paddding:5px"><?= $isu['role'] ?></td>
					<td style="font-size: 12px; text-align:center; paddding:5px"><?= date('d-m-Y', strtotime($isu['tgl_target'])) ?></td>
					<td style="font-size: 12px; text-align:center; paddding:5px"><?= $isu['uraian_isu'] ?></td>
					<td style="font-size: 12px; text-align:center; paddding:5px">
						<?php if ($isu['bobot'] <= 7) : ?>
							<span class="text-success">Low</span>
						<?php elseif ($isu['bobot'] >= 8 && $isu['bobot'] <= 12) : ?>
							<span class="text-warning">Medium</span>
						<?php else : ?>
							<span class="text-danger">High</span>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<br>
	<br>
	<br>
	<br>
	<div>
<table class="TabelTandaTangan" style="text-align: center; font-size=15px; margin-left: 850px;">
	<?php
	echo '
		  <tr>
		  	<td>
			   <p>Mengetahui, </p>
				<br>
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

</body>

</html>

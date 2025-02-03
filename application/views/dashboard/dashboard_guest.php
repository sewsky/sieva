<?php
if (!empty($data_sertifikat)) {
	?>
	<div class="pt-2 pb-0">
		<div class="text-center">
			<h3>Hasil Verifikasi</h3>
		</div>
		<div class="card">
			<div class="card-body">
				<table cellpadding="5">
					<tr>
						<td class="text-dark">Kode Sertifikat</td>
						<td class="text-dark">:</td>
						<td class="text-dark"><?php echo $data_sertifikat->kode_sertifikat ?></td>
					</tr>
					<tr>
						<td class="text-dark">Nama Peserta</td>
						<td class="text-dark">:</td>
						<td class="text-dark"><?php echo $data_sertifikat->nama_peserta ?></td>
					</tr>
					<tr>
						<td class="text-dark">Kepesertaan</td>
						<td class="text-dark">:</td>
						<td class="text-dark"><?php echo $data_sertifikat->kepesertaan ?></td>
					</tr>
					<tr>
						<td class="text-dark">Nama Kegiatan</td>
						<td class="text-dark">:</td>
						<td class="text-dark"><?php echo $data_sertifikat->nama_kegiatan ?></td>
					</tr>
					<tr>
						<td class="text-dark">Tanggal Kegiatan</td>
						<td class="text-dark">:</td>
						<td class="text-dark"><?php echo $data_sertifikat->tgl_kegiatan ?></td>
					</tr>
					<tr>
						<td class="text-dark">Lembaga</td>
						<td class="text-dark">:</td>
						<td class="text-dark"><?php echo $data_sertifikat->lembaga ?></td>
					</tr>
					<tr>
						<td class="text-dark">Tanggal Sertifikat</td>
						<td class="text-dark">:</td>
						<td class="text-dark"><?php echo $data_sertifikat->tgl_sertifikat ?></td>
					</tr>
					<tr>
						<td class="text-dark">Masa Berlaku</td>
						<td class="text-dark">:</td>
						<td class="text-dark"><?php echo $data_sertifikat->masa_berlaku ?></td>
					</tr>
				</table>
			</div>
			<div class="card-footer">
				<a href="<?php echo base_url('logout') ?>" class="btn btn-danger">Kembali</a>
			</div>
		</div>
	</div>
<?php } else { ?>
	<div class="pt-2 pb-0">
		<div class="text-center">
			<h3>Hasil Verifikasi</h3>
		</div>
		<div class="text-center mt-5">
			<h5>Tidak ditemukan!</h5>
		</div>
		<div class="mt-5 text-center">
			<a href="<?php echo base_url('logout') ?>" class="btn btn-danger">Kembali</a>
		</div>
	</div>
<?php } ?>
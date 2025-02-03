<div class="page-heading">
	<h3>Upload Template</h3>
</div>
<div class="page-content">
	<section>
		<div class="card">
			<div class="card-body">
				<div class="loading-pan" style="display:none;">
					<div class="d-flex align-items-center">
						<strong>Mengimpor file...</strong>
						<div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
					</div>
				</div>
				<div class="upload-pan">
					<div class="d-flex">
						<form id="fUpload" action="<?php echo base_url('sertifikat/import_template') ?>" method="post" enctype="multipart/form-data">
							<div class="d-flex w-100" style="height:30px;">
								<input type="file" name="file" class="form-control form-control-sm me-2" required style="height:30px;">
								<button type="submit" class="btn btn-success btn-sm" style="width:200px;"><i class="bi bi-upload"></i> Proses</button>
							</div>
						</form>
					</div>
				</div>
				<div class="msg-import"></div>
			</div>
		</div>
	</section>

	<section class="mb-5">
		<div class="d-flex justify-content-between mb-3">
			<div class="d-flex">
				<button class="btn btn-success me-2 btn-save" disabled>Save</button>
				<button class="btn btn-danger me-2 btn-delete" disabled>Delete</button>
				<button class="btn btn-warning me-2 pt-2 pb-1 btn-refresh"><i class="bi bi-table"></i></button>
				<input type="text" class="form-control search-input" placeholder="Search" style="max-width:400px;">
			</div>
			<a onclick="return confirm(`Lanjut untuk Ekspor data?`)" href="<?php echo base_url('sertifikat/export_data') ?>" class="btn btn-info me-2">Ekspor</a>
		</div>
		<div class="msg"></div>
		<form id="fTable">
			<table class="table table-bordered table-condensed bg-white" id="mytable">
				<thead>
					<tr>
						<td></td>
						<td>Kode Sertifikat</td>
						<td>Nama Peserta</td>
						<td>Kepesertaan</td>
						<td>Nama Kegiatan</td>
						<td>Tanggal Kegiatan</td>
						<td>Lembaga</td>
						<td>Tanggal Sertifikat</td>
						<td>Masa Berlaku</td>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</form>
	</section>
</div>
<script src="<?php echo base_url('assets/vendors/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

		function showMsgImport(msg) {
			$('.msg-import').html(msg);
			setTimeout(function() {
				$('.msg-import').html('');
			}, 3000);
		}

		$('#fUpload').on('submit', function(e) {
			e.preventDefault();
			var formData = new FormData();
			formData.append('file', $('#fUpload input[name="file"]')[0].files[0]);
			$('.upload-pan').hide();
			$('.loading-pan').show();
			setTimeout(function() {
				$.ajax({
					url: $('#fUpload').attr('action'),
					type: 'POST',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					processData: false,
					success: function(response) {
						showMsgImport('<div class="text-success mt-3"><b>' + response['msg'] + '</b></div>');
						$('.upload-pan').show();
						$('.loading-pan').hide();
						$('#fUpload')[0].reset();
						genTable();
					},
					error: function() {
						showMsgImport('<div class="text-danger mt-3"><b>Kendala!</b></div>');
						$('.upload-pan').show();
						$('.loading-pan').hide();
					}
				});
			}, 1000);
		});

		var tableSearch = '';

		$('.search-input').on('change', function() {
			tableSearch = $(this).val();
			genTable();
		});

		function genTable() {
			$('.btn-refresh').attr('disabled', 'disabled');
			$.ajax({
				url: '<?php echo base_url('sertifikat/json') ?>',
				type: 'post',
				data: {
					'draw': 1,
					'start': 0,
					'length': 100,
					'columns': [{
						"data": "id",
						"orderable": false,
						"searchable": false,
					}, {
						"data": "kode_sertifikat",
						"searchable": true,
					}, {
						"data": "nama_peserta",
						"searchable": true,
					}, {
						"data": "kepesertaan",
						"searchable": true,
					}, {
						"data": "nama_kegiatan",
						"searchable": true,
					}, {
						"data": "tgl_kegiatan",
						"searchable": true,
					}, {
						"data": "lembaga",
						"searchable": true,
					}, {
						"data": "tgl_sertifikat",
						"searchable": true,
					}, {
						"data": "masa_berlaku",
						"searchable": true,
					}],
					'order': [{
						'column': 0,
						'dir': 'desc',
					}],
					'search': {
						'value': tableSearch,
						'regex': 'false',
					}
				},
				success: function(response) {
					// response['recordsFiltered'];
					var html = '';
					var no = 0;
					for (var i in response['data']) {
						var dt = response['data'][i];
						html += `<tr>
							<td class=""><input type="checkbox" name="checklist[${dt['id']}]" value="${dt['id']}" class="form-check-input input-checklist" /></td>
							<td class="p-0"><input type="text" name="kode_sertifikat[${dt['id']}]" value="${dt['kode_sertifikat']}" data-name="kode_sertifikat" data-id="${dt['id']}" class="form-control form-control-md input-cell-edit" /></td>
							<td class="p-0"><input type="text" name="nama_peserta[${dt['id']}]" value="${dt['nama_peserta']}" data-name="nama_peserta" data-id="${dt['id']}" class="form-control form-control-md input-cell-edit" /></td>
							<td class="p-0"><input type="text" name="kepesertaan[${dt['id']}]" value="${dt['kepesertaan']}" data-name="kepesertaan" data-id="${dt['id']}" class="form-control form-control-md input-cell-edit" /></td>
							<td class="p-0"><input type="text" name="nama_kegiatan[${dt['id']}]" value="${dt['nama_kegiatan']}" data-name="nama_kegiatan" data-id="${dt['id']}" class="form-control form-control-md input-cell-edit" /></td>
							<td class="p-0"><input type="text" name="tgl_kegiatan[${dt['id']}]" value="${dt['tgl_kegiatan']}" data-name="tgl_kegiatan" data-id="${dt['id']}" class="form-control form-control-md input-cell-edit" /></td>
							<td class="p-0"><input type="text" name="lembaga[${dt['id']}]" value="${dt['lembaga']}" data-name="lembaga" data-id="${dt['id']}" class="form-control form-control-md input-cell-edit" /></td>
							<td class="p-0"><input type="text" name="tgl_sertifikat[${dt['id']}]" value="${dt['tgl_sertifikat']}" data-name="tgl_sertifikat" data-id="${dt['id']}" class="form-control form-control-md input-cell-edit" /></td>
							<td class="p-0"><input type="text" name="masa_berlaku[${dt['id']}]" value="${dt['masa_berlaku']}" data-name="masa_berlaku" data-id="${dt['id']}" class="form-control form-control-md input-cell-edit" /></td>
						</tr>`;
						no++;
					}
					if (no == 0) {
						html = `<tr>
							<td colspan="10" class="text-center pt-4"><p>Tidak ada data</p></td>
						</tr>`;
					}
					$('#mytable tbody').html(html);
					actionTable();
					setTimeout(function() {
						$('.btn-refresh').removeAttr('disabled');
					}, 1000);
				},
				error: function() {
					setTimeout(function() {
						$('.btn-refresh').removeAttr('disabled');
					}, 1000);
					setTimeout(function() {
						genTable();
					}, 2000);
				}
			});
		}
		genTable();


		function actionTable() {
			getChecklist();
			$('.input-checklist').on('change', function(e) {
				e.stopImmediatePropagation();
				getChecklist();
			})
			getInputAllowUpdate();
			$('.input-cell-edit').on('keyup', function(e) {
				e.stopImmediatePropagation();
				if (!$(this).hasClass('input-allow-update')) {
					$(this).addClass('input-allow-update');
				}
				getInputAllowUpdate();
			});
		}

		$('.btn-refresh').on('click', function() {
			genTable();
		});

		function getChecklist() {
			var clist = [];
			$('.input-checklist').each(function() {
				if ($(this).is(':checked')) {
					clist.push({
						'value': $(this).val(),
					});
				}
			});
			if (clist.length > 0) {
				$('.btn-delete').html('Delete(' + clist.length + ')');
				$('.btn-delete').removeAttr('disabled');
			} else {
				$('.btn-delete').html('Delete');
				$('.btn-delete').attr('disabled', 'disabled');
			}
			return clist;
		}

		function getInputAllowUpdate() {
			var fInp = [];
			$('.input-cell-edit.input-allow-update').each(function() {
				var name = $(this).attr('data-name');
				var id = $(this).attr('data-id');
				var val = $(this).val();
				fInp.push({
					'key': name,
					'id': id,
					'value': val,
				});
			});
			if (fInp.length > 0) {
				$('.btn-save').removeAttr('disabled');
			} else {
				$('.btn-save').attr('disabled', 'disabled');
			}
			return fInp;
		}

		function updateBulk() {
			var fInp = getInputAllowUpdate();
			if (fInp.length > 0) {
				$.ajax({
					url: '<?php echo base_url('sertifikat/update_bulk') ?>',
					type: 'post',
					data: {
						'cell_update': fInp,
					},
					success: function(response) {
						showMsg('<p class="text-success">' + response['msg'] + '</p>');
						genTable();
					},
					error: function() {
						alert('Kendala!');
					}
				});
			}
		}

		$('.btn-save').on('click', function() {
			updateBulk();
		});

		function deleteBulk() {
			var clist = getChecklist();
			if (clist.length > 0) {
				if (confirm('Apakah anda yakin untuk menghapus ' + clist.length + ' data?')) {
					$.ajax({
						url: '<?php echo base_url('sertifikat/delete_bulk') ?>',
						type: 'post',
						data: {
							'rows_delete': clist,
						},
						success: function(response) {
							showMsg('<p class="text-danger">' + response['msg'] + '</p>');
							genTable();
						},
						error: function() {
							alert('Kendala!');
						}
					});
				}
			}
		}

		$('.btn-delete').on('click', function() {
			deleteBulk();
		});

		function showMsg(msg) {
			$('.msg').html(msg);
			setTimeout(function() {
				$('.msg').html('');
			}, 3000);
		}
	});
</script>
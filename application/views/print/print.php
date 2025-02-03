<style>
	@media print {

		body {
			position: relative;
			padding: 0;
			height: 1px;
			overflow: visible;
			width: 0;
			visibility: hidden;
		}

		#main {
			margin-left: 0px;
			padding: 0px;
		}

		.printarea {
			position: absolute;
			width: 100%;
			top: 0;
			padding: 0;
			margin: -1px;
			visibility: visible;
		}

		table {
			width: 100vw !important;
		}

		td.checklist {
			display: none;
		}

		.head-print {
			text-align: center;
			width: 100vw !important;
		}

		h3 {
			text-align: center;
		}
	}
</style>
<div class="page-heading">
	<h3>Print</h3>
</div>
<div class="page-content">
	<section class="mb-5">
		<div class="d-flex mb-3">
			<div class="d-flex me-2">
				<button class="btn btn-primary me-2 btn-print" disabled>Print</button>
				<button class="btn btn-warning me-2 pt-2 pb-1 btn-refresh"><i class="bi bi-table"></i></button>
				<input type="text" class="form-control search-input" placeholder="Search" style="max-width:400px;">
			</div>
			<button class="btn btn-primary me-2 btn-print-table">Print tabel</button>
		</div>
		<div class="msg"></div>
		<form id="fTable" target="_blank" action="<?php echo base_url('print_doc/docprint') ?>" method="post" class="printarea">
			<div class="text-center mb-3 mt-4 head-print">
				<h3 class="">Daftar sertifikat</h3>
			</div>
			<table class="table table-bordered table-condensed bg-white " id="mytable">
				<thead>
					<tr>
						<td class="checklist"></td>
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
							<td class="checklist"><input type="checkbox" name="checklist[]" value="${dt['id']}" class="form-check-input input-checklist" /></td>
							<td>${dt['kode_sertifikat']}</td>
							<td>${dt['nama_peserta']}</td>
							<td>${dt['kepesertaan']}</td>
							<td>${dt['nama_kegiatan']}</td>
							<td>${dt['tgl_kegiatan']}</td>
							<td>${dt['lembaga']}</td>
							<td>${dt['tgl_sertifikat']}</td>
							<td>${dt['masa_berlaku']}</td>
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
				$('.btn-print').html('Print(' + clist.length + ')');
				$('.btn-print').removeAttr('disabled');
			} else {
				$('.btn-print').html('Print');
				$('.btn-print').attr('disabled', 'disabled');
			}
			return clist;
		}

		$('.btn-print').on('click', function() {
			$('#fTable').submit();
		});

		$('.btn-print-table').on('click', function() {
			window.print();
		});
	});
</script>
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Sertifikat_model extends CI_Model
{

	public $table = 'sertifikat';
	public $id = 'id';
	public $order = 'DESC';

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->library('ion_auth');
	}

	function import_template($data_upload)
	{
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load('assets/excels/' . $data_upload['file_name']);
		$sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		$no = 0;
		$ar_no_sertf = [];
		foreach ($sheet as $row) :
			if ($no > 0) {
				$ar_no_sertf[] = trim($row['A']);
			}
			$no++;
		endforeach;

		$arr_existed = [];
		$arr_existed_db = $this->get_by_nomor_sertifikat_in($ar_no_sertf);
		foreach ($arr_existed_db as $frow) :
			$arr_existed[$frow->kode_sertifikat] = true;
		endforeach;

		$bulk_data = [];
		$no = 0;
		foreach ($sheet as $row) :
			if ($no > 0) {
				$kode_sertifikat = trim($row['A']);
				if (!empty($kode_sertifikat)) {
					if (empty($arr_existed[$kode_sertifikat])) {
						$bulk_data[] = [
							'kode_sertifikat' => $kode_sertifikat,
							'nama_peserta' => trim($row['B']),
							'kepesertaan' => trim($row['C']),
							'nama_kegiatan' => trim($row['D']),
							'tgl_kegiatan' => trim($row['E']),
							'lembaga' => trim($row['F']),
							'tgl_sertifikat' => trim($row['G']),
							'masa_berlaku' => trim($row['H']),
							'id_user' => $this->ion_auth->get_user_id(),
						];
					}
				}
			}
			$no++;
		endforeach;
		if (count($bulk_data) > 0) {
			$this->db->insert_batch($this->table, $bulk_data);
		}
		if (file_exists('assets/excels/' . $data_upload['file_name'])) {
			unlink('assets/excels/' . $data_upload['file_name']);
		}
		return $bulk_data;
	}

	function export_data($id_user)
	{
		$data = $this->get_all($id_user);
		$this->export_template('Ekspor_data_' . date('YmdHis'), $data);
	}

	function export_template($filename = 'format-template', $data = [])
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$style_col = [
			'font' => ['bold' => true],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
			],
			'borders' => [
				'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
			]
		];
		$sheet->setCellValue('A1', "KODE SERTIFIKAT");
		$sheet->setCellValue('B1', "NAMA PESERTA");
		$sheet->setCellValue('C1', "KEPESERTAAN");
		$sheet->setCellValue('D1', "NAMA KEGIATAN");
		$sheet->setCellValue('E1', "TANGGAL KEGIATAN");
		$sheet->setCellValue('F1', "LEMBAGA");
		$sheet->setCellValue('G1', "TANGGAL SERTIFIKAT");
		$sheet->setCellValue('H1', "MASA BERLAKU");

		$sheet->getStyle('A1')->applyFromArray($style_col);
		$sheet->getStyle('B1')->applyFromArray($style_col);
		$sheet->getStyle('C1')->applyFromArray($style_col);
		$sheet->getStyle('D1')->applyFromArray($style_col);
		$sheet->getStyle('E1')->applyFromArray($style_col);
		$sheet->getStyle('F1')->applyFromArray($style_col);
		$sheet->getStyle('G1')->applyFromArray($style_col);
		$sheet->getStyle('H1')->applyFromArray($style_col);

		$sheet->getColumnDimension('A')->setWidth(30);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(30);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->getColumnDimension('E')->setWidth(30);
		$sheet->getColumnDimension('F')->setWidth(30);
		$sheet->getColumnDimension('G')->setWidth(30);
		$sheet->getColumnDimension('H')->setWidth(30);

		if (count($data) > 0) {
			$no = 0;
			foreach ($data as $row) :
				$sheet->setCellValue('A' . ($no + 2), $row->kode_sertifikat);
				$sheet->setCellValue('B' . ($no + 2), $row->nama_peserta);
				$sheet->setCellValue('C' . ($no + 2), $row->kepesertaan);
				$sheet->setCellValue('D' . ($no + 2), $row->nama_kegiatan);
				$sheet->setCellValue('E' . ($no + 2), $row->tgl_kegiatan);
				$sheet->setCellValue('F' . ($no + 2), $row->lembaga);
				$sheet->setCellValue('G' . ($no + 2), $row->tgl_sertifikat);
				$sheet->setCellValue('H' . ($no + 2), $row->masa_berlaku);
				$no++;
			endforeach;
		}

		// Set height semua kolom menjadi auto
		$sheet->getDefaultRowDimension()->setRowHeight(-1);
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		$sheet->setTitle("Template");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}

	function get_by_nomor_sertifikat_in($arr_no = [])
	{
		if (!is_array($arr_no)) {
			return [];
		}
		if (count($arr_no) == 0) {
			return [];
		}
		$this->db->where_in('kode_sertifikat', $arr_no);
		return $this->db->get($this->table)->result();
	}

	function get_by_nomor_sertifikat($no)
	{
		$this->db->where('kode_sertifikat', $no);
		return $this->db->get($this->table)->row();
	}

	function get_by_id_in($arr_id)
	{
		if (!is_array($arr_id)) {
			return [];
		}
		if (count($arr_id) == 0) {
			return [];
		}
		$this->db->where_in('id', $arr_id);
		return $this->db->get($this->table)->result();
	}

	// datatables
	function json($id_user = null)
	{
		$this->datatables->select('id,kode_sertifikat,nama_peserta,kepesertaan,nama_kegiatan,tgl_kegiatan,lembaga,tgl_sertifikat,masa_berlaku,tgl_update,id_user');
		$this->datatables->from('sertifikat');
		if (!empty($id_user)) {
			$this->datatables->where('id_user', $id_user);
		}
		// $this->datatables->add_column('action', anchor(site_url('sertifikat/read/$1'), 'Read') . " | " . anchor(site_url('sertifikat/update/$1'), 'Update') . " | " . anchor(site_url('sertifikat/delete/$1'), 'Delete', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
		return $this->datatables->generate();
	}

	// get all
	function get_all($id_user = null)
	{
		if (!empty($id_user)) {
			$this->db->where('id_user', $id_user);
		}
		return $this->db->get($this->table)->result();
	}

	// insert data
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	// update data
	function update($id, $data)
	{
		$data['tgl_update'] = date('Y-m-d H:i:s');
		$this->db->where($this->id, $id);
		$this->db->update($this->table, $data);
	}

	// delete data
	function delete($id)
	{
		$this->db->where($this->id, $id);
		$this->db->delete($this->table);
	}
}

/* End of file Sertifikat_model.php */
/* Location: ./application/models/Sertifikat_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-08-22 09:42:21 */
/* http://harviacode.com */

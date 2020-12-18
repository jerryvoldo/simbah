<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
            parent::__construct();
            // Your own constructor code

            $this->load->model('home_model');
    }

	public function index()
	{
		$data['pok'] = $this->home_model->load_pok();
		$this->load->view('home_view', $data);
	}

	public function belanja($mak)
	{
		$data['akun'] = $this->home_model->load_akun($mak);
		$data['belanja_all'] = $this->home_model->load_belanja($mak);
		$data['subkomponen'] = $this->home_model->load_subkomponen($data['akun']->parent_id);

		$total_belanja = 0;
		foreach($data['belanja_all'] as $key=>$belanja)
		{
			$total_belanja = $total_belanja + $belanja['debet'];
		}

		$data['total_belanja'] = $total_belanja;
		$data['sisa_pagu'] = $data['akun']->total_harga - $total_belanja;
		$data['jumlah_data'] = count($data['belanja_all']);

		$this->load->view('belanja_view', $data);
	}

	public function simpan()
	{
		if (strlen(trim($this->input->post('tanggal_pakai_pagu')))>0 && 
			strlen(trim($this->input->post('jumlah_pakai_pagu')))>0 &&
			strlen(trim($this->input->post('nomor_kuitansi')))>0 &&
			strlen(trim($this->input->post('keterangan_pemakaian')))>0
			) 
			{
				$data = array(
								'mak'=>$this->db->escape($this->input->post('mak')),
								'pengguna'=>$this->input->post('pengguna'),
								'debet'=>$this->input->post('jumlah_pakai_pagu'),
								'kredit'=>0,
								'epoch_transaksi'=>time(),
								'nomor_kuitansi'=>$this->db->escape($this->input->post('nomor_kuitansi')),
								'epoch_kuitansi'=>strtotime($this->input->post('tanggal_pakai_pagu')),
								'keterangan_belanja'=>$this->db->escape($this->input->post('keterangan_pemakaian'))
				);

				$this->home_model->simpan_belanja($data);
				redirect('home/belanja/'.$this->input->post('mak'));
			}
			else
			{
				echo 'Error : data tidak diisi lengkap';
			}
		
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Home_model extends CI_Model {

	public function load_pok()
	{
		$subquery = "select mak, sum(debet) as debet, sum(kredit) as kredit from sb2020_pok_transaksi
					group by mak";
		$sql="select pok.mak, term.deskripsi,  pok.total_harga, pok.total_harga - transaksi.debet as sisa,  pok.depth from sb2020_pokd0p0 pok 
				left join sb2020_term_table term on pok.id = term.id 
				left join (".$subquery.") as transaksi on pok.mak = transaksi.mak
				where pok.depth between 4 and 6";
		return $this->db->query($sql)->result_array();
	}

	public function load_akun($mak)
	{
		$sql = "select pok.mak, term.deskripsi, pok.parent_id, pok.total_harga, pok.depth from sb2020_pokd0p0 pok left join sb2020_term_table term on pok.id = term.id where mak = '".$mak."'";
		return $this->db->query($sql)->row();
	}

	public function load_subkomponen($id)
	{
		$sql ="select deskripsi from sb2020_term_table where id = ".$id;
		return $this->db->query($sql)->row();
	}

	public function simpan_belanja($data)
	{
		$sql = "insert into sb2020_pok_transaksi (mak, debet, kredit, epoch_transaksi, nomor_kuitansi, epoch_kuitansi, keterangan_belanja, pengguna) values (".$data['mak'].", ".$data['debet'].",".$data['kredit']." , ".$data['epoch_transaksi'].",".$data['nomor_kuitansi'].",".$data['epoch_kuitansi'].",".$data['keterangan_belanja'].",".$data['pengguna'][0].")";
		$this->db->query($sql);
	}

	public function load_belanja($mak)
	{
		$sql = "select * from sb2020_pok_transaksi where mak = '".$mak."' order by epoch_transaksi desc";
		return $this->db->query($sql)->result_array();
	}
}


?>
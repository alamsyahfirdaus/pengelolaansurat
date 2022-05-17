<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_model extends CI_Model {

	private $table      = 'user_surat';

	private function _setJoin()
	{
		$this->db->join('user', 'user.id = user_surat.user_id', 'left');
		$this->db->join('program_studi', 'program_studi.id_program_studi = user.program_studi_id', 'left');
		$this->db->join('jenis_surat', 'jenis_surat.id_jenis_surat = user_surat.jenis_surat_id', 'left');
	}

	public function getRow($id_surat)
	{
		date_default_timezone_set('Asia/Jakarta');
		
		$this->_setJoin();
		$this->db->where('md5(id_surat)', $id_surat);
		$query = $this->db->get_where($this->table)->row();

		if (isset($query->id_surat)) {
			$semester = $query->smt_mhs % 2 == 0 ? 'Genap' : 'Ganjil';
			return array(
				'id_surat' 			=> $query->id_surat,
				'nomor_surat' 		=> $query->nomor_surat,
				'nama_lengkap' 		=> ucwords(strtolower($query->nama)),
				'nim' 				=> $query->nim,
				'program_studi' 	=> $query->program_studi,
				'tahun_masuk' 		=> $query->tahun_masuk,
				'smt_mhs' 			=> $query->smt_mhs . ' ('. $semester .')',
				'status_surat' 		=> $query->status_surat,
				'ttd_dekan'			=> '<img src="'. base_url('assets/img/ttd_dekan.png') .'" alt="" style="height: 135px;">',
				'tanggal'			=> $this->getTanggal(date('Y-m-d H:i:s')),
				'semester'			=> $query->smt_mhs % 2 == 0 ? 'genap' : 'ganjil',
				'tahun_akademik'	=> $this->_getTahunAkademik($query->tahun_masuk, $query->smt_mhs),
				'jenis_surat'		=> $query->jenis_surat,
				'paragraf1'			=> $query->paragraf1,
				'paragraf2'			=> $query->paragraf2,
				'paragraf3'			=> $query->paragraf3,
			);	
		} else {
			return false;
		}
	}

	public function getRomawi($bulan)
	{
		switch ($bulan) {
			case 1: 
		        return "I";
		        break;
		    case 2:
		        return "II";
		        break;
		    case 3:
		        return "III";
		        break;
		    case 4:
		        return "IV";
		        break;
		    case 5:
		        return "V";
		        break;
		    case 6:
		        return "VI";
		        break;
		    case 7:
		        return "VII";
		        break;
		    case 8:
		        return "VIII";
		        break;
		    case 9:
		        return "IX";
		        break;
		    case 10:
		        return "X";
		        break;
		    case 11:
		        return "XI";
		        break;
		    case 12:
		        return "XII";
		        break;
		  }
	}

	public function getTanggal($datetime)
	{
		if ($datetime) {
		    $date = $datetime;
		} else {
			return '-';
		}

	    $moths = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

	    $year 	= substr($date, 0, 4);
	    $moth 	= substr($date, 5, 2);
	    $date 	= substr($date, 8, 2);

	    $substr	= substr($date, 0, 1) == 0 ? substr($date, 1) : $date;

	    $result = $substr . " " . $moths[(int) $moth - 1] . " " . $year;
	    return ($result);
	}

	private function _getTahunAkademik($tahun_masuk, $smt_mhs)
	{
		if ($smt_mhs > 1) {
			$semester 		= $smt_mhs / 2;
			$tahun_mulai 	= $smt_mhs % 2 == 0 ? $tahun_masuk + intval($semester) - 1 : $tahun_masuk + intval($semester);
			$tahun_selesai  = $tahun_mulai + 1;
		} else {
			$tahun_mulai 	= $tahun_masuk;
			$tahun_selesai  = $tahun_mulai + 1;
		}

		$tahun_akademik = $tahun_mulai .'/'. $tahun_selesai;

		return $tahun_akademik;
	}

	private function _setDataTable()
	{
		$column_order 	= array('user_surat.id_surat', null);
		$column_search 	= array('user_surat.id_surat', 'user.nim', 'user.nama', 'program_studi.program_studi', 'user_surat.nomor_surat', 'user_surat.smt_mhs', 'jenis_surat.jenis_surat');
		$order_by 		= array('user_surat.id_surat' => 'desc');

		$this->_setJoin();
	    $this->db->from($this->table);
	
	    $i = 0;
	 
	    foreach ($column_search as $item) // loop column 
	    {
	        if(@$_POST['search']['value']) // if datatable send POST for search
	        {
	             
	            if($i===0) // first loop
	            {
	                $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
	                $this->db->like($item, @$_POST['search']['value']);
	            }
	            else
	            {
	                $this->db->or_like($item, @$_POST['search']['value']);
	            }
	
	            if(count($column_search) - 1 == $i) //last loop
	                $this->db->group_end(); //close bracket
	        }
	        $i++;
	    }
	     
	    if(isset($_POST['order'])) // here order processing
	    {
	        $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	    } 
	    else if(isset($order_by))
	    {
	        $this->db->order_by(key($order_by), $order_by[key($order_by)]);
	    }
	}

	public function getDataTable()
	{
		$this->_setDataTable();
        if($this->input->post('length') != -1)
        $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get()->result();

        return array(
        	'result' => $query,
        	'count'	 => $this->db->count_all_results($this->table),
        	'rows'	 => $this->db->get($this->_setDataTable())->num_rows(),
        );
	}

}

/* End of file Surat_model.php */
/* Location: ./application/models/Surat_model.php */
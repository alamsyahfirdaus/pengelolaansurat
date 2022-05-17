<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

  //usaha untuk login 
  public function __construct()
  {
    parent::__construct();
    is_logged_in();

    $this->load->model('Surat_model', 'surat');
  }


  public function index()
  {
    //tittle
    $data['title']  = 'Dashboard';
    $data['user']   = $this->db->get_where('user', ['nim' => $this->session->userdata('nim')])->row_array();

    //untuk load view template
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('templates/footer');
  }

  //Peran = ROLE
  public function role()
  {
    //tittle
    $data['title'] = 'Peran';
    $data['user'] = $this->db->get_where('user', ['nim' =>
    $this->session->userdata('nim')])->row_array();

    $data['role'] = $this->db->get('user_role')->result_array();

    //untuk load view template
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/role', $data);
    $this->load->view('templates/footer');
  }

  public function roleAccess($role_id)
  {
    //tittle
    $data['title'] = 'Akses Peran';
    $data['user'] = $this->db->get_where('user', ['nim' =>
    $this->session->userdata('nim')])->row_array();

    $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

    $this->db->where('id !=', 1);

    $data['menu'] = $this->db->get('user_menu')->result_array();

    //untuk load view template
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/role_access', $data);
    $this->load->view('templates/footer');
  }

  public function changeAccess()
  {
    $menu_id = $this->input->post('menuId');
    $role_id = $this->input->post('role_id');

    $data    = [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ];

    $result = $this->db->get_where('user_access_menu', $data);

    if ($result->num_rows() < 1) {
      $this->db->insert('user_access_menu', $data);
    } else {
      $this->db->delete('user_access_menu', $data);
    }

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akses Telah Diubah!</div>');
  }

  public function showDataTable()
  {

    $query = $this->surat->getDataTable();
    $data  = array();
    $start  = $this->input->post('start');
    $no   = $start > 0 ? $start + 1 : 1;
    foreach ($query['result'] as $field) {
        $start++;
        $row    = array();
        $row[]  = '<p style="text-align: center;">'. $no++ .'</p>';
        $row[]  = $this->_data_mahasiswa($field);
        $row[]  = $this->_pengajuan_surat($field);

        $data[] = $row;
    }

    $output = array(
      'draw'            => $this->input->post('draw'),
      'recordsTotal'    => $query['count'],
      'recordsFiltered' => $query['rows'],
      'data'            => $data,
    );
    
    echo json_encode($output);

  }

  private function _data_mahasiswa($field)
  {
    $data = array(
      'NIM' => $field->nim, 
      'Nama<span style="color: #FFFFFF;">_</span>Mahasiswa' => $field->nama, 
      'Program<span style="color: #FFFFFF;">_</span>Studi' => $field->program_studi, 
      'Tahun<span style="color: #FFFFFF;">_</span>Masuk' => $field->tahun_masuk, 
      'Semester' => $field->smt_mhs, 
    );

    $no = 1;

    $content = '<table class="table" style="width: 100%;">';
    foreach ($data as $key => $value) {
      $css = $no == 1 ? 'padding-top: 0px;' : '';

      $content .= '<tr>';
      $content .= '<th style="border: none; padding-left: 0px; '. $css .'">'. $key .'</th>';
      $content .= '<td style="border: none; '. $css .'">:</td>';
      $content .= '<td style="border: none; padding-right: 0px; '. $css .'">'. $value .'</td>';
      $content .= '</tr>';

      $no++;
    }
    $content .= '</table>';

    return $content;

  }

  private function _pengajuan_surat($field)
  {

    $nomor_surat = '<p style="text-align: left;">'. $field->nomor_surat .'</p>';

    // if ($field->status_surat == 1) {
    //   $nomor_surat = '<p style="text-align: left;">'. $field->nomor_surat .'</p>';
    // } else {

    //   $explode_nomor = explode('.', $field->nomor_surat);

    //   $nomor_surat = '<div class="form-group">';
    //   $nomor_surat .= '<div class="input-group">';
    //   $nomor_surat .= '<div class="input-group-prepend">';
    //   $nomor_surat .= '<span class="input-group-text">'. $explode_nomor[0] .'.</span>';
    //   $nomor_surat .= '</div>';
    //   $nomor_surat .= '<input type="text" class="form-control" name="format_nomor_'. md5($field->id_surat) .'" value="'. substr($field->nomor_surat, strpos($field->nomor_surat, ".") + 1) .'">';


    //   $nomor_surat .= '<div class="input-group-append">';
    //   $nomor_surat .= '<button type="button" class="btn btn-primary" onclick="status_surat(' . "'" . md5($field->id_surat) . "'" . ')">Setujui</button>';
    //   $nomor_surat .= '</div>';
    //   $nomor_surat .= '</div>';
    //   $nomor_surat .= '<span id="error-format_nomor_'. md5($field->id_surat) .'" class="error invalid-feedback" style="font-size: 12px; color: #E74A3B; display: none;"></span>';
    //   $nomor_surat .= '</div>';
    //   $nomor_surat .= '<input type="hidden" name="nomor_surat_'. md5($field->id_surat) .'" value="'. $explode_nomor[0] .'.">';
    // }

    $status_surat = $field->status_surat == 1 ? 'Sudah Disetujui' : 'Belum Disetujui';

    $print = '<a href="'. site_url('admin/print_surat/'. md5($field->id_surat)) .'" target="_blank" class="btn btn-info btn-sm" style="font-weight: bold; margin-right: 6px;"><i class="fas fa-print"></i></a>';
    $hapus = '<button type="button" class="btn btn-danger btn-sm" onclick="hapus_surat(' . "'" . md5($field->id_surat) . "'" . ')" style="font-weight: bold;  margin-right: 6px;"><i class="fas fa-trash"></i></button>';

    if ($field->status_surat == 1) {
      $setujui = '<a href="'. site_url('admin/setujui_surat/'. md5($field->id_surat)) .'" class="btn btn-primary btn-sm" style="font-weight: bold;">Batalkan Persetujuan</a>';
    } else {
      $setujui = '<button type="button" class="btn btn-primary btn-sm" onclick="status_surat(' . "'" . md5($field->id_surat) . "'" . ')" style="font-weight: bold;">Setujui</button>';
    }

    $data = array(
      'Nomor<span style="color: #FFFFFF;">_</span>Surat' => [$nomor_surat], 
      'Jenis<span style="color: #FFFFFF;">_</span>Surat' => [$field->jenis_surat], 
      'Status<span style="color: #FFFFFF;">_</span>Surat' => [$status_surat], 
      'Aksi' => [$print, $hapus, $setujui], 
    );

    $no = 1;

    $content = '<table class="table" style="width: 100%;">';
    foreach ($data as $key => $value) {
      $css = $no == 1 ? 'padding-top: 0px; padding-bottom: 0px;' : '';

      $content .= '<tr>';
      $content .= '<th style="border: none; padding-left: 0px; '. $css .'">'. $key .'</th>';
      $content .= '<td style="border: none; '. $css .'">:</td>';

      $keterangan = $no == count($data) ? $value[0] . $value[1] . $value[2] : $value[0];

      $content .= '<td style="border: none; padding-right: 0px; '. $css .'">'. $keterangan .'</td>';
      $content .= '</tr>';

      $no++;
    }
    $content .= '</table>';

    return $content;
  }

  public function setujui_surat($id_surat = null)
  {
    $query = $this->surat->getRow($id_surat);

    if (!$query) {
      redirect('admin/index');
    }

    // if (substr($this->input->post('format_nomor'), 0, 1) == '.') {
    //   $format_nomor = substr($this->input->post('format_nomor'), 1);
    // } else {
    //   $format_nomor = $this->input->post('format_nomor');
    // }

    // $nomor_surat = $this->input->post('nomor_surat') . $format_nomor;

    // if ($query['status_surat'] != $nomor_surat) {
    //    $data['nomor_surat'] = $nomor_surat;
    // }

    $data['status_surat'] = $query['status_surat'] == NULL ? 1 : NULL;

    $this->db->update('user_surat', $data, ['id_surat' => $query['id_surat']]);

    if ($this->input->is_ajax_request()) {
      echo json_encode(['status' => TRUE]);
    } else {
      redirect('admin/index');
    }

  }

  public function print_surat($id_surat = null)
  {
    // Print Surat Keterangan Mahasiswa Aktif
    
    $query = $this->surat->getRow($id_surat);

    if (!$query) {
      redirect('user/pengajuan_surat');
    }

    $this->load->library('Pdf');

    $data = array(
      'title'     => $query['jenis_surat'],
      'surat'     => $query,
    );

    $this->load->view('templates/print_surat', $data);

  }

  public function hapus_surat($id_surat = null)
  {
    $query = $this->surat->getRow($id_surat);

    if (!$query) {
      redirect('admin/index');
    }

    $this->db->delete('user_surat', ['id_surat' => $query['id_surat']]);

    echo json_encode(['status' => TRUE]);

  }

  public function jenissurat($id_jenis_surat = null)
  {

    $data = array(
      'title'       => 'Jenis Surat',
      'user'        => $this->db->get_where('user', ['nim' => $this->session->userdata('nim')])->row_array(),
      'jenis_surat' => $this->db->get('jenis_surat')->result(),
      'row'         => $this->db->get_where('jenis_surat', ['md5(id_jenis_surat)' => $id_jenis_surat])->row(),
      'bulan_tahun' => $this->surat->getRomawi(date('m')) .'/'. date('Y'),
    );

    $fields = array(
      'id_jenis_surat'  => 'Jenis Surat',
      'paragraf1'       => 'Paragraf 1',
      'paragraf2'       => 'Paragraf 2',
    );

    foreach ($fields as $key => $value) {
      $this->form_validation->set_rules($key, $value, 'required|trim');
    }

    if ($this->form_validation->run() == FALSE) {

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/jenis_surat', $data);
      $this->load->view('templates/footer');

    } else {

      $user_surat = $this->db->get_where('user_surat', [
        'tahun' => date('Y'),
        'jenis_surat_id' => $this->input->post('id_jenis_surat'),
      ])->num_rows();

      $nomor_ke = $user_surat > 0 ? $user_surat + 1 : 1;

      $this->db->update('jenis_surat', [
        'nomor_ke'        => $nomor_ke,
        'format_nomor'    => $this->input->post('format_nomor'),
        'paragraf1'       => $this->input->post('paragraf1'),
        'paragraf2'       => $this->input->post('paragraf2'),
        'paragraf3'       => $this->input->post('paragraf3'),
      ], ['id_jenis_surat' => $this->input->post('id_jenis_surat')]);

      if ($this->db->affected_rows()) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Mengubah Format Surat!</div>');
      }

      redirect('admin/jenissurat');

    }

  }
  
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */

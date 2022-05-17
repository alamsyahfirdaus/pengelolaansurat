<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
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
    $data['title'] = 'Profil Saya';
    $data['user'] = $this->db->join('program_studi', 'program_studi.id_program_studi = user.program_studi_id', 'left')->get_where('user', ['nim' => $this->session->userdata('nim')])->row_array();

    //untuk load view template
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/index', $data);
    $this->load->view('templates/footer');
  }

  public function edit_profile()
  {

    $user = $this->db->get_where('user', ['nim' => $this->session->userdata('nim')])->row_array();

    //tittle
    $data['title'] = 'Edit Profile';
    $data['user']  = $user;

    $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim', [
      'required' => 'Nama Lengkap harus diisi!'
    ]);

    if ($user['role_id'] == 2) {
      // Mahasiswa
      $this->form_validation->set_rules('program_studi_id', 'Program Studi', 'required|trim', [
        'required' => 'Program Studi harus diisi!'
      ]);

      $this->form_validation->set_rules('tahun_masuk', 'Tahun Masuk', 'required|trim', [
        'required' => 'Tahun Masuk harus diisi!'
      ]);
    }


    if ($this->form_validation->run() == false) {

      //untuk load view template
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('user/edit_profile', $data);
      $this->load->view('templates/footer');
    } else {
      $nama  = $this->input->post('nama');
      $email = $this->input->post('email');
      $nim   = $this->input->post('nim');

      //jika ada gambar yang akan di upload
      $upload_gambar = $_FILES['image'];
      if ($upload_gambar) {
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '10000';
        $config['upload_path'] = './assets/img/profile/';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
          $gambar_lama = $user['image'];
          if ($gambar_lama != 'default.jpg') {
            //tidak bisa pake base_url tapi pakainya FCPATH atau ke front controller
            unlink(FCPATH . 'assets/img/profile/' . $gambar_lama);
          }

          $gambar_baru = $this->upload->data('file_name');
          $this->db->set('image', $gambar_baru);
        } else {
          echo $this->upload->display_errors();
        }
      }

      $update['nama'] = $nama;
      if ($this->input->post('program_studi_id')) {
        $update['program_studi_id'] = $this->input->post('program_studi_id');
      }
      if ($this->input->post('tahun_masuk')) {
        $update['tahun_masuk'] = $this->input->post('tahun_masuk');
      }

      $this->db->update('user', $update, ['id' => $user['id']]);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profil kamu telah di ubah!</div>');
      redirect('user');
    }
  }

  public function ubah_password()
  {
    //tittle
    $data['title'] = 'Ubah Password';
    $data['user'] = $this->db->get_where('user', ['nim' => $this->session->userdata('nim')])->row_array();

    $this->form_validation->set_rules(
      'current_password',
      'Current Password',
      'required|trim',
      [
        'required' => 'Kata lama sandi harus diisi!'
      ]
    );
    $this->form_validation->set_rules(
      'new_password1',
      'New Password',
      'required|trim|min_length[3]|matches[new_password2]',
      [
        'required' => 'Kata sandi baru harus diisi!',
        'matches' => 'Kata sandi harus sama!',
        'min_length' => 'Kata sandi minimal 3 huruf'
      ]
    );
    $this->form_validation->set_rules(
      'new_password2',
      'Confirm New Password',
      'required|trim|min_length[3]|matches[new_password1]',
      [
        'required' => 'Kata sandi baru harus diisi!',
        'matches' => 'Kata sandi harus sama!',
        'min_length' => 'Kata sandi minimal 3 huruf'
      ]
    );

    if ($this->form_validation->run() == false) {
      //untuk load view template
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('user/ubah_password', $data);
      $this->load->view('templates/footer');
    } else {

      $current_password = $this->input->post('current_password');
      $new_password = $this->input->post('new_password1');

      if (!password_verify($current_password, $data['user']['password'])) {

        //pasword salah 
        $this->session->set_flashdata(
          'message',
          '<div class="alert alert-danger" role="alert">Password yang anda masukan salah!</div>'
        );
        redirect('user/ubah_password');

        //cek password sama tidak dengan password saat ini
      } else {
        if ($current_password == $new_password) {
          $this->session->set_flashdata(
            'message',
            '<div class="alert alert-danger" role="alert">Password baru tidak boleh sama dengan password saat ini!</div>'
          );
          redirect('user/ubah_password');
        } else {
          //password sudah oke
          $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

          $this->db->set('password', $password_hash);
          $this->db->where('nim', $this->session->userdata('nim'));
          $this->db->update('user');

          $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">Password telah diubah!</div>'
          );
          redirect('user/ubah_password');
        }
      }
    }
  }

  public function pengajuan_surat()
  {

    $data = array(
      'title'       => 'Pengajuan Surat',
      'user'        =>  $this->db->get_where('user', ['nim' => $this->session->userdata('nim')])->row_array(),
      'jenis_surat' => $this->db->get('jenis_surat')->result(),
    );

    //untuk load view template
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/pengajuan_surat', $data);
    $this->load->view('templates/footer');

  }

  public function surat_keterangan()
  {

    $user     = $this->db->get_where('user', ['nim' => $this->session->userdata('nim')])->row_array();
    $user_id  = isset($user['nim']) ? $user['id'] : 0;

    $data['title'] = 'Pengajuan Surat';
    $data['user']  = $user;
    $data['surat'] = $this->db->where([
        'user_id'         => $user_id,
        'jenis_surat_id'  => '1',
      ])->order_by('smt_mhs', 'asc')->get('user_surat')->result();

    //untuk load view template
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/surat_keterangan', $data);
    $this->load->view('templates/footer');

  }

  public function surat_aktif($id_user = null)
  {
    // Pengajuan Surat Keterangan Mahasiswa Aktif
    
    $user = $this->db->get_where('user', ['md5(id)' => $id_user])->row();

    if (!$user) {
      redirect('user/pengajuan_surat');
    }

    $user_surat = $this->db->get_where('user_surat', [
      'user_id' => $user->id,
      'smt_mhs' => $this->input->post('smt_mhs'),
    ])->row();


    if (!$user_surat || $this->input->post('jenis_surat_id') > 1) {

      $nomor_surat = $this->_getNoSurat($this->input->post('jenis_surat_id'));

      $data = array(
        'nomor_surat'     => $nomor_surat,
        'user_id '        => $user->id,
        'smt_mhs'         => $this->input->post('smt_mhs'),
        'jenis_surat_id'  => $this->input->post('jenis_surat_id'),
      );

      $this->db->insert('user_surat', $data);

      $jenis_surat = $this->db->get_where('jenis_surat', ['id_jenis_surat' => $this->input->post('jenis_surat_id')])->row();

      echo json_encode([
        'status'    => TRUE,
        'message'   => 'Berhasil Mengajukan '. $jenis_surat->jenis_surat,
      ]);

    } else {
      echo json_encode(['status' => FALSE]);
    }


  }

  public function _getNoSurat($id_jenis_surat)
  {
    $user_surat = $this->db->get_where('user_surat', [
      'tahun' => date('Y'),
      'jenis_surat_id' => $id_jenis_surat,
    ])->num_rows();

    $nomor_ke = $user_surat > 0 ? $user_surat + 1 : 1;

    $update = $this->db->update('jenis_surat', ['nomor_ke' => $nomor_ke], ['id_jenis_surat' => $id_jenis_surat]);
    if ($update > 0) {
        $jenis_surat = $this->db->get_where('jenis_surat', ['id_jenis_surat' => $id_jenis_surat])->row();
        if (isset($jenis_surat->id_jenis_surat)) {
          return $jenis_surat->nomor_ke .'.'. $jenis_surat->format_nomor .'/'. $this->surat->getRomawi(date('m')) .'/'. date('Y');
        } else {
          return '#';
        }
    } else {
      return '#';
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

  public function list_surat($id_jenis_surat = null)
  {

    $jenis_surat = $this->db->get_where('jenis_surat', ['md5(id_jenis_surat)' => $id_jenis_surat])->row();

    if (!$jenis_surat) {
      redirect('user/pengajuan_surat');
    }

    $user     = $this->db->get_where('user', ['nim' => $this->session->userdata('nim')])->row_array();
    $user_id  = isset($user['nim']) ? $user['id'] : 0;

    $data = array(
      'title' => $jenis_surat->jenis_surat,
      'user'  => $user,
      'surat' => $this->db->where([
        'user_id'         => $user_id,
        'jenis_surat_id'  => $jenis_surat->id_jenis_surat,
      ])->order_by('id_surat', 'desc')->get('user_surat')->result(),
      'jenis_surat_id' => $jenis_surat->id_jenis_surat,
    );

    //untuk load view template
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/tambah_surat', $data);
    $this->load->view('templates/footer');
  }

}

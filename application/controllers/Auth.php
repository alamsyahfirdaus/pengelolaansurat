<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }


  public function index()
  {
    if ($this->session->userdata('nim')) {
      redirect('user');
    }

    $this->form_validation->set_rules(
      'nim',
      'Nim',
      'trim|required',
      [
        'required' => 'NIM / Username harus diisi!'
      ]
    );
    $this->form_validation->set_rules(
      'password',
      'Password',
      'required|trim',
      [
        'required' => 'Password harus diisi!'
      ]
    );
    if ($this->form_validation->run() == false) {
      $data['title'] = 'Halaman Login';
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/login');
      $this->load->view('templates/auth_footer');
    } else {
      //validasi sukses
      $this->_login();
    }
  }

  private function _login()
  {
    $nim        = $this->input->post('nim');
    $password   = $this->input->post('password');
    $user       = $this->db->get_where('user', ['nim' => $nim])->row_array();
    //jika user ada
    if ($user) {
      //jika user aktif
      if ($user['is_active'] == 1) {
        //cek password
        if (password_verify($password, $user['password'])) {
          $data = [
            'nim'     => $user['nim'],
            'role_id' => $user['role_id']
          ];
          $this->session->set_userdata($data);
          if ($user['role_id'] == 1) {
            redirect('admin');
          } else {
            redirect('User');
          }
        } else {
          $this->session->set_flashdata(
            'message',
            '<div class="alert alert-danger" role="alert">
                  Anda salah memasukan Password!</div>'
          );
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata(
          'message',
          '<div class="alert alert-danger" role="alert">
                Email dengan NIM ini belum diaktivasi</div>'
        );
        redirect('auth');
      }
    } else {
      //Jika user tidak terdaftar
      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-danger" role="alert">
                NIM tidak terdaftar!</div>'
      );
      redirect('auth');
    }
  }

  public function registration()
  {
    if ($this->session->userdata('nim')) {
      redirect('user');
    }

    //validasi nama, nim, email, password
    //trim= jika ada space di awal atw di atas maka ilang
    //required = notifikasi merah
    $this->form_validation->set_rules(
      'nama',
      'Nama',
      'required|trim',
      ['required'    => 'Nama Lengkap harus Diisi!']
    );
    $this->form_validation->set_rules(
      'nim',
      'Nim',
      'required|trim|is_unique[user.nim]',
      [
        'required'    => 'NIM harus diisi!',
        'is_unique'   => 'NIM sudah terdaftar!'
      ]
    );
    $this->form_validation->set_rules(
      'email',
      'Email',
      'required|trim|valid_email|is_unique[user.email]',
      [
        'required'    => 'Email harus diisi!',
        'is_unique'   => 'Email sudah terdaftar!'
      ]
    );
    //password 1
    $this->form_validation->set_rules(
      'password1',
      'Password',
      'required|trim|min_length[3]|matches[password2]',
      [
        'required'    => 'Kata Sandi harus diisi!',
        'matches'     => 'Kata Sandi tidak sama!',
        'min_length'  => 'Kata Sandi terlalu pendek!'
      ]
    );
    //password2
    $this->form_validation->set_rules(
      'password2',
      'Password',
      'required|trim|matches[password1]',
      [
        'required'    => 'Kata Sandi harus diisi!',
      ]
    );
    if ($this->form_validation->run() == false) {
      $data['title'] = 'Pendaftaran Akun Baru';
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/registration');
      $this->load->view('templates/auth_footer');
    } else {
      $email = $this->input->post('email', true);
      $user =
        [
          'nama'          => htmlspecialchars($this->input->post('nama', true)),
          'nim'           => htmlspecialchars($this->input->post('nim', true)),
          'email'         => htmlspecialchars($email),
          'image'         => 'default.jpg',
          'password'      => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
          'role_id'       => 2,
          'is_active'     => '0',
          'date_created'  => time()
        ];

      //siapkan token
      $token = base64_encode(random_bytes(32));
      $user_token = [
        'email' => $email,
        'token' => $token,
        'date_created' => time()
      ];

      $this->db->insert('user', $user);
      $this->db->insert('user_token', $user_token);

      //email
      $this->_sendEmail($token, 'verify');

      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-success" role="alert">
        Selamat! Akun anda telah dibuat. Silahkan login
        </div>'
      );
      redirect('auth');
    }
  }

  private function _sendEmail($token, $type)
  {
    $config = [
      'protocol'  => 'smtp',
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_user' => 'surat.keluar.fkip.umtas@gmail.com',
      'smtp_pass' => 'dzaki123',
      'smtp_port' =>  465,
      'mailtype'  => 'html',
      'charset'   => 'utf-8',
      'newline'   => "\r\n"
    ];

    $this->email->initialize($config);

    $this->email->from('surat.keluar.fkip.umtas@gmail.com', 'FKIP UMTAS');
    $this->email->to($this->input->post('email'));

    if ($type == 'verify') {
        $this->email->subject('Account Verification');
        $this->email->message('Click this link to verify you account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktivasi Akun</a>');
    } else if ($type == 'forgot') {
        $this->email->subject('Reset Password');
        $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
    }

    if ($this->email->send()) {
      return true;
    } else {
      echo $this->email->print_debugger();
      die;
    }
  }

  public function verify()
  {
      $email = $this->input->get('email');
      $token = $this->input->get('token');

      $user = $this->db->get_where('user', ['email' => $email])->row_array();

      if ($user) {
          $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

          if ($user_token) {
              if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                  $this->db->set('is_active', 1);
                  $this->db->where('email', $email);
                  $this->db->update('user');

                  $this->db->delete('user_token', ['email' => $email]);

                  $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' Telah diverifikasi! Silakan login.</div>');
                  redirect('auth');
              } else {
                  $this->db->delete('user', ['email' => $email]);
                  $this->db->delete('user_token', ['email' => $email]);

                  $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi akun gagal! Token kedaluwarsa.</div>');
                  redirect('auth');
              }
          } else {
              $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi akun gagal! Token salah.</div>');
              redirect('auth');
          }
      } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi akun gagal! Email salah.</div>');
          redirect('auth');
      }
  }

  public function logout()
  {
    if ($this->session->userdata('nim')) {
      $message = '<div class="alert alert-success" role="alert" style="font-weight: bold;">Anda Telah Keluar Akun</div>';
    }
    $this->session->unset_userdata('nim');
    $this->session->unset_userdata('role_id');
    if (isset($message)) {
      $this->session->set_flashdata('message', $message);
    }
    redirect('auth');
  }

  public function blocked()
  {
    $this->load->view('auth/blocked');
  }

  public function forgotPassword()
  {
      $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

      if ($this->form_validation->run() == false) {
          $data['title'] = 'Lupa Password';
          $this->load->view('templates/auth_header', $data);
          $this->load->view('auth/forgot-password');
          $this->load->view('templates/auth_footer');
      } else {
          $email = $this->input->post('email');
          $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

          if ($user) {
              $token = base64_encode(random_bytes(32));
              $user_token = [
                  'email' => $email,
                  'token' => $token,
                  'date_created' => time()
              ];

              $this->db->insert('user_token', $user_token);
              $this->_sendEmail($token, 'forgot');

              $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Silakan periksa email Anda untuk mengatur ulang Password!</div>');
              redirect('auth/forgotpassword');
          } else {
              $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email tidak terdaftar atau diaktifkan!</div>');
              redirect('auth/forgotpassword');
          }
      }
  }


  public function resetPassword()
  {
      $email = $this->input->get('email');
      $token = $this->input->get('token');

      $user = $this->db->get_where('user', ['email' => $email])->row_array();

      if ($user) {
          $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

          if ($user_token) {
              $this->session->set_userdata('reset_email', $email);
              $this->changePassword();
          } else {
              $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password gagal! Token salah.</div>');
              redirect('auth');
          }
      } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password gagal! Email salah.</div>');
          redirect('auth');
      }
  }


  public function changePassword()
  {
      if (!$this->session->userdata('reset_email')) {
          redirect('auth');
      }

      $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
      $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[3]|matches[password1]');

      if ($this->form_validation->run() == false) {
          $data['title'] = 'Change Password';
          $this->load->view('templates/auth_header', $data);
          $this->load->view('auth/change-password');
          $this->load->view('templates/auth_footer');
      } else {
          $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
          $email = $this->session->userdata('reset_email');

          $this->db->set('password', $password);
          $this->db->where('email', $email);
          $this->db->update('user');

          $this->session->unset_userdata('reset_email');

          $this->db->delete('user_token', ['email' => $email]);

          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Berhasil diubah! Silakan Login.</div>');
          redirect('auth');
      }
  }
  
}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */

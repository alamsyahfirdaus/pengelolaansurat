<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    //usaha untuk login 
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        //tittle
        $data['title'] = 'Pengelolaan Menu';
        $data['user'] = $this->db->get_where('user', ['nim' =>
        $this->session->userdata('nim')])->row_array();

        //ambil data dari database menu
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules(
            'menu',
            'Menu',
            'required',
            [
                'required' => 'Gagal menambahkan! form harus diisi! '
            ]
        );
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert
            alert-success" role="alert"> Menu Baru Telah Ditambahkan</div>');
            redirect('menu');
        }
    }

    public function submenu()
    {
        //tittle
        $data['title'] = 'Pengelolaan Submenu';
        $data['user'] = $this->db->get_where('user', ['nim' =>
        $this->session->userdata('nim')])->row_array();
        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules(
            'title',
            'Title',
            'required',
            [
                'required' => 'Form Title harus diisi! '
            ]
        );
        $this->form_validation->set_rules(
            'menu_id',
            'Menu',
            'required',
            [
                'required' => 'Form Akses Menu harus diisi! '
            ]
        );
        $this->form_validation->set_rules(
            'url',
            'URL',
            'required',
            [
                'required' => 'Form Url harus diisi! '
            ]
        );
        $this->form_validation->set_rules(
            'icon',
            'icon',
            'required',
            [
                'required' => 'Form Icon harus diisi! '
            ]
        );

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title'      => $this->input->post('title'),
                'menu_id'    => $this->input->post('menu_id'),
                'url'        => $this->input->post('url'),
                'icon'       => $this->input->post('icon'),
                'is_active'  => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert
            alert-success" role="alert"> Submenu Baru Telah Ditambahkan</div>');
            redirect('menu/submenu');
        }
    }

    public function c_delete($id)
    {
        $this->Menu_model->m_delete($id);
        redirect('menu/submenu');
    }
}

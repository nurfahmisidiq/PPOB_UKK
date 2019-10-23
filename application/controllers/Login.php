<?php
defined('BASEPATH') OR exit('No direct script acess allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_login');
    }
    
    public function index()
    {
        $this->load->view('v_login');
    }
    
    public function proses_login()
    {
        if($this->session->userdata('logged')==false)
        {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $cek = $this->db->get_where('admin',['username' => $username])->row_array();
            if ($cek)
            {
                if($password == $cek['password'])
                {
                    $data = [
                        'username' => $cek['username'],
                        'nama_admin' => $cek['nama_admin'],
                        'id_level' => $cek['id_level'],
                        'logged' => true
                    ];
                    $this->session->set_userdata($data);
                    echo "berhasil login";
                }
                else
                {
                    $this->session->set_flashdata('pesan', 'Password Salah');
                    redirect('Login/index','refresh');
                }

            }
            else
            {
                $this->session->set_flashdata('pesan', 'Username tidak terdaftar');
                redirect('Login/index','refresh');
            }

        }
        else
        {
            $this->session->set_flashdata('pesan', 'session sebelumnya belum terlogout');
            redirect('Login/index','refresh');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('Login/index','refresh');
    }
}
?>
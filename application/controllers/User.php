<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    protected $menu = [];
    function pre($i)
    {
        echo "<pre>";
        print_r($i);
        echo "</pre>";
    }
    public function __construct()
    {
        parent::__construct();
        is_loggedin([2]);
        $this->load->model('Menu');

        $this->data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $this->data['role'] = ($this->data['user']['role_id'] == 1) ? 'admin' : 'user';
        $this->menu = $this->Menu->get_menu_by_role($this->data['user']['role_id']);
        // print_r($p);
        // die;
        $this->load->library(['chart']);
    }
    public function sidebar()
    {
        $data['menu'] = $this->menu;
        $data['submenus'] = [];
        // $num=0;
        foreach ($this->menu as $m) {
            $data['submenus'][$m['id']] = $this->Menu->get_submenu_by_menu($m['id']);
        }
        return $data;

    }
    public function index()
    {
        $data = $this->data;
        $data['title'] = 'User Page';

        // $this->pre($data['submenus']);



        // var_dump($data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function product()
    {
        $this->load->model('Product');

        $data = $this->data;

        $data['title'] = 'User Product Page';
        $data['product'] = $this->Product->getProduct();
        $data['menu'] = $this->menu;
        $data['submenus'] = [];
        // $num=0;
        foreach ($this->menu as $m) {
            $data['submenus'][$m['id']] = $this->Menu->get_submenu_by_menu($m['id']);
        }


        // var_dump($data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('user/product', $data);
        $this->load->view('templates/footer');
    }
    // public function chartlist()
    // {
    //     $data = $this->data;

    //     $data['title'] = 'User Chartlist Page';
    //     $data['menu'] = $this->menu;
    //     $data['submenus'] = [];
    //     // $num=0;
    //     foreach ($this->menu as $m) {
    //         $data['submenus'][$m['id']] = $this->Menu->get_submenu_by_menu($m['id']);
    //     }

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/navbar', $data);
    //     $this->load->view('user/chartlist', $data);
    //     $this->load->view('templates/footer');
    // }
    public function chartlist()
    {
        $data = $this->data;
        $data['title'] = 'User Chartlist Page';
        $data['menu'] = $this->menu;
        $data['submenus'] = [];
        // $num=0;
        foreach ($this->menu as $m) {
            $data['submenus'][$m['id']] = $this->Menu->get_submenu_by_menu($m['id']);
        }
        $data['chart'] = $this->chart->read($data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('user/chartlist', $data);
        $this->load->view('templates/footer');
    }
    public function deleteChart($id)
    {

        $data = $this->data;
        $data['id_chart'] = $id;

        // Ambil id user yang login
        $data['chart'] = ($this->chart->delete($data));

        // Pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-success">Produk berhasil dihapus dari chart</div>');

        // Kembali ke halaman chartlist
        redirect('user/chartlist');
    }
    public function addToChart($id_product)
    {
        $data = $this->data;
        $data['id_product'] = $id_product;

        $this->chart->addOrUpdate($data);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Produk berhasil ditambahkan ke chart</div>');
        redirect('user/product'); // ganti ke halaman produk kamu
    }
    public function plusQty($id_chart)
    {
        $data = $this->data;
        $data['id_chart'] = $id_chart;
        $this->chart->plusQty($data);
        redirect('user/chartlist');
    }

    public function minQty($id_chart)
    {
        $data = $this->data;
        $data['id_chart'] = $id_chart;
        $this->chart->minQty($data);
        redirect('user/chartlist');
    }
}

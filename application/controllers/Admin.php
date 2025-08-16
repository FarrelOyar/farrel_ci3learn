<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    protected $menu = [];

    public function __construct()
    {
        parent::__construct();
        is_loggedin([1]);

        $this->load->model('Product');
        $this->load->library('form_validation');
        $this->load->model('Menu');

        // Ambil user sekali saja
        $this->data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $this->data['role'] = ($this->data['user']['role_id'] == 1) ? 'admin' : 'user';
        $this->menu = $this->Menu->get_menu_by_role($this->data['user']['role_id']);
    }
    public function sidebar()
    {
        $data['menu'] = $this->menu;
        $data['submenus'] = [];

        foreach ($this->menu as $m) {
            $data['submenus'][$m['id']] = $this->Menu->get_submenu_by_menu($m['id']);
        }

        return $data;
    }




    public function index()
    {
        // $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo $data['user']['name'];
        $data = $this->data;
        // $num=0;
        $data['title'] = 'Admin Page';
        $data = array_merge($data, $this->sidebar());

        // $this->pre($data['submenus']);

        // var_dump($data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }
    public function product()
    {
        $data = $this->data;
        $data = array_merge($data, $this->sidebar());


        // $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo $data['user']['name'];
        $data['title'] = 'Admin Page';
        $data['product'] = $this->Product->getProduct();
        // var_dump($data['product']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('admin/product', $data);
        $this->load->view('templates/footer');
    }

    public function CreateProduct()
    {
        $data = $this->data;
        $data = array_merge($data, $this->sidebar());

        $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'required|trim|numeric');
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('image', 'Image', 'callback_validate_image');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Add Product';
        
            $data['categoryproduct'] = $this->db->get('product_category')->result();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/createproduct', $data);
            $this->load->view('templates/footer');
        } else {
            // Upload image
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2MB

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();

                $data = [
                    'product_name' => htmlspecialchars($this->input->post('product_name')),
                    'price' => htmlspecialchars($this->input->post('price')),
                    'image' => $uploadData['file_name'], // hasil upload
                    'category_id' => htmlspecialchars($this->input->post('category')),
                ];

                // var_dump($data);
                $this->db->insert('product', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Product Berhasil Ditambahkan</div>');
                redirect('admin/product');
            } else {
                echo $this->upload->display_errors();
            }
        }
    }

    // Callback untuk validasi image
    public function validate_image()
    {
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed_ext)) {
                $this->form_validation->set_message('validate_image', 'File format must be JPG, JPEG, PNG, or GIF.');
                return FALSE;
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('validate_image', 'Image must be uploaded.');
            return FALSE;
        }
    }

    public function deleteProduct($id)
    {
        // Ambil data produk
        $product = $this->db->get_where('product', ['id' => $id])->row();
        var_dump($product);

        if ($product) {
            // Hapus file gambar jika ada
            $filePath = FCPATH . 'uploads/' . $product->image;
            if (file_exists($filePath) && !empty($product->image)) {
                unlink($filePath);
            }

            // Hapus data di database
            $this->db->delete('product', ['id' => $id]);

            // Flash message sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success">Produk berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Produk tidak ditemukan.</div>');
        }

        // Redirect kembali ke halaman produk
        redirect('admin/product');
    }

    public function editProduct($id)
    {
        $data = $this->data;

        // Ambil data user
        $data = array_merge($data, $this->sidebar());


        // Ambil data kategori
        $data['categoryproduct'] = $this->db->get('product_category')->result();

        // Ambil data produk berdasarkan ID
        $data['product'] = $this->db->get_where('product', ['id' => $id])->row();

        // Form validation
        $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'required|trim|numeric');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Product';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/editproduct', $data);
            $this->load->view('templates/footer');
        } else {
            $updateData = [
                'product_name' => htmlspecialchars($this->input->post('product_name')),
                'price' => htmlspecialchars($this->input->post('price')),
                'category_id' => htmlspecialchars($this->input->post('category')),
            ];

            // Cek apakah upload file baru
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    // Hapus gambar lama
                    $oldImage = $data['product']->image;
                    if ($oldImage && file_exists('./uploads/' . $oldImage)) {
                        unlink('./uploads/' . $oldImage);
                    }

                    $updateData['image'] = $this->upload->data('file_name');
                } else {
                    echo $this->upload->display_errors();
                    return;
                }
            }

            // Update ke database
            $this->db->where('id', $id);
            $this->db->update('product', $updateData);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Product berhasil diupdate!</div>');
            redirect('admin/product');
        }
    }
}

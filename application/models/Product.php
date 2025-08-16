<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Model
{
    public function getProduct()
    {
        // $query=$this->db->get('product');

        // return  $query->result();
        $this->db->select('product.id,product.product_name, product.price,product.image, product_category.category');
        $this->db->from('product');
        $this->db->join('product_category', 'product.category_id = product_category.id');
        return $this->db->get()->result();
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chart_models extends CI_Model
{
    public function getChart($data)
    {
        $this->db->select('
            chart.id,
            chart.id_user,
            chart.id_product,
            chart.qty,
            product.product_name,
            product.price,
            product.image,
            product_category.category
        ');
        $this->db->from('chart');
        $this->db->join('product', 'chart.id_product = product.id');
        $this->db->join('product_category', 'product.category_id = product_category.id', 'left');
        $this->db->where('chart.id_user', $data['user']['id']);
        return $this->db->get()->result();
    }
    public function deleteChart($data)
    {
        $this->db->where('id', $data['id_chart']);
        $this->db->where('id_user', $data['user']['id']);
        $this->db->delete('chart');
    }
    public function addOrUpdateChart($data)
    {
        $this->db->where('id_user', $data['user']['id']);
        $this->db->where('id_product', $data['id_product']);
        $query = $this->db->get('chart');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->db->where('id', $row->id);
            $this->db->update('chart', ['qty' => $row->qty + 1]);
        } else {
            $this->db->insert('chart', [
                'id_user'    => $data['user']['id'],
                'id_product' => $data['id_product'],
                'qty'        => 1
            ]);
        }
    }
    public function changeQty($data, $action)
    {
        $this->db->where('id', $data['id_chart']);
        $this->db->where('id_user', $data['user']['id']);
        $row = $this->db->get('chart')->row();

        if ($row) {
            if ($action === 'plus') {
                $this->db->where('id', $data['id_chart']);
                $this->db->update('chart', ['qty' => $row->qty + 1]);
            } elseif ($action === 'min') {
                if ($row->qty > 1) {
                    $this->db->where('id', $data['id_chart']);
                    $this->db->update('chart', ['qty' => $row->qty - 1]);
                }
            }
        }
    }
}

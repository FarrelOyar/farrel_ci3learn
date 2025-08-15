<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chart
{
    protected $CI;
    public  function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Chart_models');
    }
    public function read($data)
    {
        return  $this->CI->Chart_models->getChart($data);
    }
    public function delete($data)
    {
        return  $this->CI->Chart_models->deleteChart($data);
    }
    public function addOrUpdate($data)
    {

        return $this->CI->Chart_models->addOrUpdateChart($data);
    }

    public function plusQty($data)
    {

        return $this->CI->Chart_models->changeQty($data, 'plus');
    }

    public function minQty($data)
    {

        return $this->CI->Chart_models->changeQty($data, 'min');
    }
}

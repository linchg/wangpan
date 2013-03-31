<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload extends MY_Controller {

    public function __construct()
    {
        parent::__construct(false);
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1024';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $this->load->library('upload', $config);
    }

    public function do_upload(){
        if ( ! $this->upload->do_upload())
        {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
            exit;

        } 
        else
        {
            $data = array('upload_data' => $this->upload->data());
            var_dump($data);
            echo 'success';
            exit;
        }
    }
}


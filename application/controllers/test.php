<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($type)
	{
        var_dump($type);
        exit;
        $this->load->model('user','',true);
        $user = array('username'=>'a','password'=>'b');
        //$this->user->create($user);
        $a = $this->user->get('a','username');
        var_dump($a['points']);
        $up = array('points'=>'points+1');
        $this->user->set($up,array('username'=>'a'));
        $a = $this->user->get('a','username');
        var_dump($a['points']);
	}

    public function login () {
		$this->template->load_view('bare' , 'test/login');
    }

    public function register () {
        $this->title = '兴趣盘－注册用户';
        $this->template->set_static(array('static/js/register.js' , 'static/js/mail.tip.js'));
        $this->template->set_static(array('static/css/index.css') , SERVICE_NUMBER::CSSFILE , SERVICE_NUMBER::FILEHEADER);
        $this->template->set_menu();
        $this->template->load_view('bare' , 'register');			
    }

    public function upload(){
        $this->load->helper('form');
        $this->template->load_view('bare' , 'test/upload');			
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

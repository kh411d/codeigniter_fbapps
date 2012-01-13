<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	public function index()
	{
		//$this->load->view('welcome_message');
		$this->load->library('Auth');
		$this->load->library('authadapter',array('username'=>'admin','password'=>'admin'));
		
		/* echo "<pre>";
		print_r($this->auth);
		exit;
		 */
		//$adapter = new MyAuthAdapter('admin', 'admin');
         $result =   $this->auth->authenticate($this->authadapter);
		 print_r($result);
        if($this->auth->hasIdentity())
        {
            echo 'auth suceeeded foward to relavant page';
			print_r($this->auth->getIdentity());
			print_r($_SESSION);
        } 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
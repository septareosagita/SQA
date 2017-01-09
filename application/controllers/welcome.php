<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm', true);
        $this->dm->init('m_usr', 'user_id');
        $this->load->helper('download');
    }

    function index() {
        // cek user menu authorization
        // hardcode first
        $user_id = 'u001';

        // proses autentikasi tidak perlu dilakukan krn sudah dari SSO
        // SSO harus memberikan user_id yg ingin di loginkan dalam bentuk enkripsi base64

        // ambil detail user 
        $this->dm->init('V_USR', 'USER_ID');
        $c_user = "USER_ID = '" . $user_id . "'";
        $m_usr = $this->dm->select('','',$c_user);

        // jika user tidak ada di database, die
        if (count($m_usr)==0) die('User Not Found');
        //debug_array($m_usr);
                
        // ambil grpauth_id dan shop_id nya
        $grpauth_id = $m_usr[0]->GRPAUTH_ID;
        $shop_id = $m_usr[0]->SHOP_ID;
        $user_info = $user_id . ';;' .
                     $m_usr[0]->USER_NM . ';;' .
                     $grpauth_id . ';;' .
                     $shop_id . ';;' .
                     $m_usr[0]->EMAIL . ';;' .
                     $m_usr[0]->DESCRIPTION . ';;' .
                     $m_usr[0]->PLANT_CD . ';;' .
                     $m_usr[0]->PLANT_NM . ';;' .
                     $m_usr[0]->PLANT_DESC . ';;' .
                     $m_usr[0]->SHIFTGRP_ID . ';;' .
                     $m_usr[0]->SHIFTTGRP_NM . ';;'
                ;

        // cari menu sesuai grpauth_id dan shop_id
        $this->dm->init('V_SQA_GROUPAUTH_MENU', 'GRPAUTH_ID');
        $c_menu = "GRPAUTH_ID = '" . $grpauth_id . "' and SHOP_ID = '" . $shop_id . "' and IS_SHOW = '1'";
        $m_menu = $this->dm->select('','', $c_menu);

        // daftarin ke session
        $this->session->set_userdata('user_info', $user_info);
        //$this->session->set_userdata('m_menu', $m_menu);

        // redirect to the first menu
        redirect($m_menu[0]->MENU_CTRL);
    }
    
    function login_ajax() {
        $user_id = $_POST['user_id'];
        $pass = $_POST['pass'];
        
        $this->dm->init('V_USR','USER_ID');
        $m_usr = $this->dm->select('','',"USER_ID = '" . $user_id . "' and PASS = HASHBYTES('SHA1', '" . $pass . "')", '*');
        
        if (count($m_usr)>0) {
            
            $grpauth_id = $m_usr[0]->GRPAUTH_ID;
            $shop_id = $m_usr[0]->SHOP_ID;
            $user_info = $user_id . ';;' .
            $m_usr[0]->USER_NM . ';;' .
            $grpauth_id . ';;' .
            $shop_id . ';;' .
            $m_usr[0]->EMAIL . ';;' .
            $m_usr[0]->DESCRIPTION . ';;' .
            $m_usr[0]->PLANT_CD . ';;' .
            $m_usr[0]->PLANT_NM . ';;' .
            $m_usr[0]->PLANT_DESC . ';;' .
            $m_usr[0]->SHIFTGRP_ID . ';;' .
            $m_usr[0]->SHIFTTGRP_NM . ';;' .
            $m_usr[0]->GRPAUTH_NM . ';;';
            
            // buat menu nya
            $this->dm->init('V_SQA_GROUPAUTH_MENU', 'GRPAUTH_ID');
            $c_menu = "GRPAUTH_ID = '" . $grpauth_id . "' and SHOP_ID = '" . $shop_id . "' and IS_SHOW = '1'";
            $m_menu = $this->dm->select('','', $c_menu);
            
            $first_menu = $m_menu[0]->MENU_CTRL;
			
			if ($first_menu != '') {
				$this->session->set_userdata('user_info', $user_info);
				
                if ($this->session->userdata('request_path_info') != '') {
                    echo $this->session->userdata('request_path_info');
                } else {
                    echo $first_menu;    
                }
			} else {
				echo $first_menu;
			}
        } else {
            echo 0;
        }
    }

    function home() {
        $user_info = $this->session->userdata('user_info');
        debug_array($user_info);

        $m_menu = $this->session->userdata('m_menu');
        debug_array($m_menu);
    }

    function out () {
        $this->session->sess_destroy();
        
        //if ($this->uri->segment(3) != '') {
//            $path_info = base64_decode(HexToAscii($this->uri->segment(3)));
//            $this->session->set_userdata('request_path_info', $path_info);
//        } else {
//            $this->session->set_userdata('request_path_info', '');
//        }
        
        redirect('monitoring');        
    }

    function download_file() {
        $file_uri = $this->uri->segment(3);
        if (!$file_uri)
            exit;
        $file_uri = base64_decode(HexToAscii($file_uri));
        $file_uri = explode(';', $file_uri);

        $nama_file = $file_uri[0];
        $file_name = $file_uri[1];

        if (file_exists($file_name)) {
            //$data = base_url() . $file_name;
            $data = $file_name;
            $data = file_get_contents($data); // Read the file's contents
            force_download($nama_file, $data);
        } 
    }
    
    function check_old_pass() {        
        
        $old_pass = $_POST['old_pass'];
        $new_pass = $_POST['new_pass'];
        
        // cek password lama dgn session login id
        $user_id = get_user_info($this, 'USER_ID');
        $this->dm->init('V_USR','USER_ID');
        $m_usr = $this->dm->select('','',"USER_ID = '" . $user_id . "' and PASS = HASHBYTES('SHA1', '" . $old_pass . "')", '*');
        
        if (count($m_usr)>0) {
            $this->dm->sql_self_no_return("update M_USR set PASS = HASHBYTES('SHA1', '" . $new_pass . "') where USER_ID = '" . $user_id . "'");
            $ret = 1;
        } else {
            $ret = 0;
        }    
        echo $ret;
    }

	function send_mail_test()
	{
		$to = $this->uri->segment(3);
		$body= $this->uri->segment(4);
		$subject = $this->uri->segment(5);

		// by pass email lewat system SQA.
		// semoga boleh
		$this->dm->send_email($to, $body, $subject);
	}
    
    function ngemail() { //C820F290-FB5B-4F58-B3CF-F957A8E3D4D2/m
        $content = "
                <html>
                <head>
                    <title>Subject</title>
                </head>
                <body>
                <p>
                    Please Log In to Shipping Quality Audit System at ".htmlspecialchars(APP_URL .'t_sqa_dfct/report_sqa/C820F290-FB5B-4F58-B3CF-F957A8E3D4D2/m')." with your account
                </p>
                
                <p>
                    Regards,
                    <br/><br/>
                    <strong style='color: #4A4A4A'>SQA ADMIN MAIL SYSTEM</strong>
                    <br/>
                    <span style='font-size: 10px'>
                    * This email send automaticaly based on the SQA System. You dont have to reply this email. For Information &amp; Contact, please refer to ISTD TMMIN.
                    </span>
                </p>
                </body>
                </html>
        ";
        
        $cek = $this->dm->send_email('bogi@toyota.co.id', $content, 'IRFAN TEST ON ' . date('Y-m-d H:i:s'));
        //$cek = $this->dm->send_email('irfanroom@yahoo.co.id', $content, 'Test Charset');
        //if ($cek) {
            //echo 'email sukses';
            show_error($this->email->print_debugger());
        //} else {
            //echo 'email gagal';
//            show_error($this->email->print_debugger());

  //      }
        //$this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
//        $list_reply = $this->dm->select('','REPLY_TYPE ASC, COUNTERMEASURE_TYPE DESC',"PROBLEM_ID = 'B88F1F79-1103-4C50-88EE-61889832EA69'", '*',true);
//        debug_array($list_reply);
//        
//        $this->load->view('nganu');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
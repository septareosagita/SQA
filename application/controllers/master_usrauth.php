<?php

/*
 * @author: irfan@mediantarakreasindo.com
 * @created: March, 23 2011
 */

class master_usrauth extends CI_Controller {

    public $fieldseq = array();

    function __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm', true);
        $this->fieldseq = array(
            0 => 'USER_ID',
            1 => 'USER_NM',
            2 => 'GRPAUTH_ID',
            3 => 'SHIFTGRP_ID',
            4 => 'SHOP_ID',
            5 => 'DESCRIPTION',
            6 => 'BRANCH_ID',
            7 => 'Updateby',
            8 => 'Updatedt',
            9 => 'GRPAUTH_ID',
            10 => 'GRPAUTH_NM',
            11 => 'MENU_ID',
            12 => 'MENU_NM',
            13 => 'MENU_CTRL',
            14 => 'MENU_PARENT',
            15 => 'IS_SHOW',
            16 => 'IS_ACTIVE'
        );
        if ($this->session->userdata('user_info') == '')
            redirect('welcome/out');
    }

    function index() {
        redirect('master_usrauth/m_usr');
    }

    function m_usr() {
        $this->dm->init('V_USR', 'USER_ID');

        // inisialisasi variable
        $searchpaging = $condition = $searchkey = '';
        $page = 0;
        $using_search = false;
        $data['err'] = $this->session->flashdata('FLASH_MESSAGE');

        // deleting
        $cek = $this->input->post('cek');
        if ($cek) {
            $this->dm->init('M_USR', 'USER_ID');
            foreach ($cek as $v) {
                $delete_keys = array('USER_ID' => $v);
                $this->dm->delete($delete_keys);
            }
            redirect('master_usrauth/m_usr');
        }

        // searching
        if (isset($_POST['searchkey'])) {
            $searchkey = $this->input->post('searchkey', true);
            if ($searchkey != '')
                redirect('master_usrauth/m_usr/search/' . AsciiToHex(base64_encode($searchkey)) . '/2/desc/');
            else
                redirect('master_usrauth/m_usr');
        }

        // process searching
        $searchkey = ($this->uri->segment(3) == 'search') ? $this->uri->segment(4) : '';
        if ($searchkey != '') {
            $using_search = true;
            $searchkey = base64_decode(HexToAscii($searchkey));
            $condition .= ( $searchkey != '') ? "USER_ID LIKE '%" . $searchkey . "%' or USER_NM LIKE '%" . $searchkey . "%' or DESCRIPTION LIKE '%" . $searchkey . "%' or EMAIL LIKE '%" . $searchkey . "%'" : '';
        }
        $data['searchkey'] = $searchkey;

        // sorting & order
        $sf = sort_field($this, $using_search, 2, 'desc');
        $orderby = $sf[0];
        $data['sort'] = $sf[1];
        $data['sorttype'] = $sf[2];
        $sortseq = $sf[3];
        $sorttype = $sf[4];
        $page_segment = $sf[5];

        // setup site_url & browse_url for pagination & view
        $browse_url = 'master_usrauth/m_usr/';
        $pagination_base_url = site_url('master_usrauth/m_usr/' . $sortseq . '/' . $sorttype . '/page/');
        if ($using_search) {
            $ath_search = AsciiToHex(base64_encode($searchkey));
            $pagination_base_url = site_url('master_usrauth/m_usr/search/' . $ath_search . '/' . $sortseq . '/' . $sorttype . '/page/');
            $browse_url = 'master_usrauth/m_usr/search/' . $ath_search . '/';
        }
        $data['browse_url'] = $browse_url;

        //pagination
        $page = ($this->uri->segment($page_segment) != '') ? $this->uri->segment($page_segment) : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $total_rows = $this->dm->count($condition);
        $data['pagination'] = text_paging($this, $page_segment, $pagination_base_url, $total_rows, $page);

        //list m_usr
        $data['list_usr'] = $this->dm->select($limit, $orderby, $condition);

        $data['page_title'] = 'Master User Authorization';
        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $this->load->view('header', $data);
        $this->load->view('m_usr/browse', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function m_usr_change() {
        $this->dm->init('M_USR', 'USER_ID');
        $USER_ID = $USER_NM = $GRPAUTH_ID = $SHIFTGRP_ID = $SHOP_ID = $DESCRIPTION = $EMAIL = $Updateby = $Updatedt = '';
        $todo = 'ADD';
        $err = '';

        // cek jika ada Key untuk EDIT
        $USER_ID = $this->uri->segment(3);
        if ($USER_ID != '') {
            $ds = $this->dm->select('', '', "USER_ID = '" . $USER_ID . "'");
            $USER_ID = $ds[0]->USER_ID;
            $USER_NM = $ds[0]->USER_NM;
            $GRPAUTH_ID = $ds[0]->GRPAUTH_ID;
            $SHIFTGRP_ID = $ds[0]->SHIFTGRP_ID;
            $SHOP_ID = $ds[0]->SHOP_ID;
            $DESCRIPTION = $ds[0]->DESCRIPTION;
            $EMAIL = $ds[0]->EMAIL;
            $Updateby = $ds[0]->Updateby;
            $Updatedt = $ds[0]->Updatedt;
            $todo = 'EDIT';
        }

        // jika Form tersubmit
        if (isset($_POST['todo'])) {
            $USER_ID = $this->input->post('USER_ID');
            $USER_NM = $this->input->post('USER_NM');
            $GRPAUTH_ID = $this->input->post('GRPAUTH_ID');
            $SHIFTGRP_ID = $this->input->post('SHIFTGRP_ID');
            $SHOP_ID = $this->input->post('SHOP_ID');
            $DESCRIPTION = $this->input->post('DESCRIPTION');
            $EMAIL = $this->input->post('EMAIL');
            $PASS = $this->input->post('PASS');
            $Updateby = get_user_info($this, 'USER_ID');
            $Updatedt = $this->input->post('Updatedt');
            $todo = $this->input->post('todo');

            if ($todo == 'ADD') {
                // user_id check
                $cek = $this->dm->select('', '', "USER_ID = '" . $USER_ID . "'", 'USER_ID');
                if (count($cek) > 0) {
                    // user dah ada
                    $err = 'UserID <strong>' . $USER_ID . '</strong> already taken, please choose another one';
                } else {
                    // user belum ada
                    // cek jika user id tidak sama dengan kosong
                    if ($USER_ID != '') {
                        $data = array(
                            'USER_ID' => $USER_ID,
                            'USER_NM' => $USER_NM,
                            'GRPAUTH_ID' => $GRPAUTH_ID,
                            'SHIFTGRP_ID' => $SHIFTGRP_ID,
                            'SHOP_ID' => $SHOP_ID,
                            'DESCRIPTION' => $DESCRIPTION,
                            'EMAIL' => $EMAIL,
                            'Updateby' => $Updateby,
                            'Updatedt' => get_date(),
                        );
                        $this->dm->insert($data);
                        
                        // set password
                        $this->dm->sql_self_no_return("update M_USR set PASS = HASHBYTES('SHA1', '" . $PASS . "') where USER_ID = '" . $USER_ID . "'");
                        
                        redirect('master_usrauth/m_usr');
                    } else {
                        $err = 'Please input user ID for this user';
                    }
                }
            } else {

                $update_keys = "USER_ID = '" . $USER_ID . "'";
                $data = array(
                    'USER_NM' => $USER_NM,
                    'GRPAUTH_ID' => $GRPAUTH_ID,
                    'SHIFTGRP_ID' => $SHIFTGRP_ID,
                    'SHOP_ID' => $SHOP_ID,
                    'DESCRIPTION' => $DESCRIPTION,
                    'EMAIL' => $EMAIL,
                    'Updateby' => $Updateby,
                    'Updatedt' => get_date(),
                );
                
                // update password jika tidak kosong
                if ($PASS != '') {
                    $this->dm->sql_self_no_return("update M_USR set PASS = HASHBYTES('SHA1', '" . $PASS . "') where USER_ID = '" . $USER_ID . "'");
                }
                
                $this->dm->update($data, $update_keys);
                redirect('master_usrauth/m_usr');
            }
        }

        $data['USER_ID'] = $USER_ID;
        $data['USER_NM'] = $USER_NM;
        $data['GRPAUTH_ID'] = $GRPAUTH_ID;
        $data['SHIFTGRP_ID'] = $SHIFTGRP_ID;
        $data['SHOP_ID'] = $SHOP_ID;
        $data['DESCRIPTION'] = $DESCRIPTION;
        $data['EMAIL'] = $EMAIL;
        $data['Updateby'] = $Updateby;
        $data['todo'] = $todo;
        $data['err'] = $err;

        $data['page_title'] = 'Master User Authorization';
        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        // list group auth
        $this->dm->init('M_SQA_GROUPAUTH', 'GRPAUTH_ID');
        $data['list_grpauth'] = $this->dm->select();                

        // list shiftgroup
        $this->dm->init('M_SQA_SHIFTGRP', 'SHIFTGRP_ID');
        $data['list_shiftgrp'] = $this->dm->select();

        // list shop
        $this->dm->init('M_SQA_SHOP', 'SHOP_ID');
        $data['list_shop'] = $this->dm->select();

        $this->load->view('header', $data);
        $this->load->view('m_usr/change', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function m_usr_erase() {
        $this->dm->init('M_USR', 'USER_ID');
        $delete_keys = array('USER_ID' => $this->uri->segment(3));
        $this->dm->delete($delete_keys);
        redirect('master_usrauth/m_usr');
    }

    function grpauth() {
        $this->dm->init('M_SQA_GROUPAUTH', 'GRPAUTH_ID');

        // inisialisasi variable
        $searchpaging = $condition = $searchkey = '';
        $page = 0;
        $using_search = false;
        $data['err'] = $this->session->flashdata('FLASH_MESSAGE');

        // deleting
        $cek = $this->input->post('cek');
        if ($cek) {
            foreach ($cek as $v) {
                $delete_keys = array('GRPAUTH_ID' => $v);
                $this->dm->delete($delete_keys);
            }
            redirect('master_usrauth/grpauth');
        }

        // searching
        if (isset($_POST['searchkey'])) {
            $searchkey = $this->input->post('searchkey', true);
            if ($searchkey != '')
                redirect('master_usrauth/grpauth/search/' . AsciiToHex(base64_encode($searchkey)) . '/9/desc/');
            else
                redirect('master_usrauth/grpauth');
        }

        // process searching
        $searchkey = ($this->uri->segment(3) == 'search') ? $this->uri->segment(4) : '';
        if ($searchkey != '') {
            $using_search = true;
            $searchkey = base64_decode(HexToAscii($searchkey));
            $condition .= ( $searchkey != '') ? "GRPAUTH_ID LIKE '%" . $searchkey . "%' or GRPAUTH_NM LIKE '%" . $searchkey . "%'" : '';
        }
        $data['searchkey'] = $searchkey;

        // sorting & order
        $sf = sort_field($this, $using_search, 9);
        $orderby = $sf[0];
        $data['sort'] = $sf[1];
        $data['sorttype'] = $sf[2];
        $sortseq = $sf[3];
        $sorttype = $sf[4];
        $page_segment = $sf[5];

        // setup site_url & browse_url for pagination & view
        $browse_url = 'master_usrauth/grpauth/';
        $pagination_base_url = site_url('master_usrauth/grpauth/' . $sortseq . '/' . $sorttype . '/page/');
        if ($using_search) {
            $ath_search = AsciiToHex(base64_encode($searchkey));
            $pagination_base_url = site_url('master_usrauth/grpauth/search/' . $ath_search . '/' . $sortseq . '/' . $sorttype . '/page/');
            $browse_url = 'master_usrauth/grpauth/search/' . $ath_search . '/';
        }
        $data['browse_url'] = $browse_url;

        //pagination
        $page = ($this->uri->segment($page_segment) != '') ? $this->uri->segment($page_segment) : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $total_rows = $this->dm->count($condition);
        $data['pagination'] = text_paging($this, $page_segment, $pagination_base_url, $total_rows, $page);

        //list m_usr
        $data['list_usr'] = $this->dm->select($limit, $orderby, $condition);

        $data['page_title'] = 'Master User Authorization';
        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $this->load->view('header', $data);
        $this->load->view('m_usr/grpauth_browse', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function grpauth_change() {
        $this->dm->init('M_SQA_GROUPAUTH', 'GRPAUTH_ID');
        $GRPAUTH_ID = $GRPAUTH_NM = '';
        $GRPAUTH_IS_AUDITOR = '0';
        $todo = 'ADD';
        $err = '';

        // cek jika ada Key untuk EDIT
        $GRPAUTH_ID = $this->uri->segment(3);
        if ($GRPAUTH_ID != '') {
            $ds = $this->dm->select('', '', "GRPAUTH_ID = '" . $GRPAUTH_ID . "'");
            $GRPAUTH_ID = $ds[0]->GRPAUTH_ID;
            $GRPAUTH_NM = $ds[0]->GRPAUTH_NM;
            $GRPAUTH_IS_AUDITOR = $ds[0]->GRPAUTH_IS_AUDITOR; 
            $todo = 'EDIT';
        } else {
            $GRPAUTH_ID = $this->dm->generate_key('M_SQA_GROUPAUTH', 'GRPAUTH_ID', 2);
        }

        // jika Form tersubmit
        if (isset($_POST['todo'])) {
            $GRPAUTH_ID = $this->input->post('GRPAUTH_ID');
            $GRPAUTH_NM = $this->input->post('GRPAUTH_NM');
            $GRPAUTH_IS_AUDITOR = (isset($_POST['GRPAUTH_IS_AUDITOR'])) ? '1' : '0';
            $todo = $this->input->post('todo');

            if ($todo == 'ADD') {
                // cek jika user id tidak sama dengan kosong
                if ($GRPAUTH_NM != '') {
                    $data = array(
                        'GRPAUTH_ID' => $GRPAUTH_ID,
                        'GRPAUTH_NM' => $GRPAUTH_NM,
                        'GRPAUTH_IS_AUDITOR' => $GRPAUTH_IS_AUDITOR,
                        'Updateby' => get_user_info($this, 'USER_ID'),
                        'Updatedt' => get_date(),
                    );
                    $this->dm->insert($data);
                    redirect('master_usrauth/grpauth');
                } else {
                    $err = 'Please input the Name for this Group Auth';
                }
            } else {
                $update_keys = "GRPAUTH_ID = '" . $GRPAUTH_ID . "'";
                $data = array(
                    'GRPAUTH_NM' => $GRPAUTH_NM,
                    'GRPAUTH_IS_AUDITOR' => $GRPAUTH_IS_AUDITOR,
                    'Updateby' => get_user_info($this, 'GRPAUTH_ID'),
                    'Updatedt' => get_date(),
                );
                $this->dm->update($data, $update_keys);
                redirect('master_usrauth/grpauth');
            }
        }

        $data['GRPAUTH_ID'] = $GRPAUTH_ID;
        $data['GRPAUTH_NM'] = $GRPAUTH_NM;
        $data['GRPAUTH_IS_AUDITOR'] = $GRPAUTH_IS_AUDITOR;
        $data['todo'] = $todo;
        $data['err'] = $err;

        $data['page_title'] = 'Master User Authorization';
        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $this->load->view('header', $data);
        $this->load->view('m_usr/grpauth_change', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function grpauth_erase() {
        $this->dm->init('M_SQA_GROUPAUTH', 'GRPAUTH_ID');
        $delete_keys = array('GRPAUTH_ID' => $this->uri->segment(3));
        $this->dm->delete($delete_keys);
        redirect('master_usrauth/grpauth');
    }

    function menu() {
        $this->dm->init('M_SQA_MENU', 'MENU_ID');

        // inisialisasi variable
        $searchpaging = $condition = $searchkey = '';
        $page = 0;
        $using_search = false;
        $data['err'] = $this->session->flashdata('FLASH_MESSAGE');

        // deleting
        $cek = $this->input->post('cek');
        if ($cek) {
            foreach ($cek as $v) {
                $delete_keys = array('MENU_ID' => $v);
                $this->dm->delete($delete_keys);
            }
            redirect('master_usrauth/menu');
        }

        // searching
        if (isset($_POST['searchkey'])) {
            $searchkey = $this->input->post('searchkey', true);
            if ($searchkey != '')
                redirect('master_usrauth/menu/search/' . AsciiToHex(base64_encode($searchkey)) . '/11/desc/');
            else
                redirect('master_usrauth/menu');
        }

        // process searching
        $searchkey = ($this->uri->segment(3) == 'search') ? $this->uri->segment(4) : '';
        if ($searchkey != '') {
            $using_search = true;
            $searchkey = base64_decode(HexToAscii($searchkey));
            $condition .= ( $searchkey != '') ? "MENU_ID LIKE '%" . $searchkey . "%' or MENU_NM LIKE '%" . $searchkey . "%'" : '';
        }
        $data['searchkey'] = $searchkey;

        // sorting & order
        $sf = sort_field($this, $using_search, 11, 'asc');
        $orderby = $sf[0];
        $data['sort'] = $sf[1];
        $data['sorttype'] = $sf[2];
        $sortseq = $sf[3];
        $sorttype = $sf[4];
        $page_segment = $sf[5];

        // setup site_url & browse_url for pagination & view
        $browse_url = 'master_usrauth/menu/';
        $pagination_base_url = site_url('master_usrauth/menu/' . $sortseq . '/' . $sorttype . '/page/');
        if ($using_search) {
            $ath_search = AsciiToHex(base64_encode($searchkey));
            $pagination_base_url = site_url('master_usrauth/menu/search/' . $ath_search . '/' . $sortseq . '/' . $sorttype . '/page/');
            $browse_url = 'master_usrauth/menu/search/' . $ath_search . '/';
        }
        $data['browse_url'] = $browse_url;

        //pagination
        $page = ($this->uri->segment($page_segment) != '') ? $this->uri->segment($page_segment) : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $total_rows = $this->dm->count($condition);
        $data['pagination'] = text_paging($this, $page_segment, $pagination_base_url, $total_rows, $page);

        //list m_usr
        $data['list_menu'] = $this->dm->select($limit, $orderby, $condition);

        $data['page_title'] = 'Master User Authorization';
        // get sub menu        
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $this->load->view('header', $data);
        $this->load->view('m_usr/menu_browse', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function menu_change() {
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $MENU_ID = $MENU_NM = $MENU_CTRL = $MENU_PARENT = $IS_SHOW = $IS_ACTIVE = '';
        $todo = 'ADD';
        $err = '';

        // cek jika ada Key untuk EDIT
        $MENU_ID = $this->uri->segment(3);
        if ($MENU_ID != '') {
            $ds = $this->dm->select('', '', "MENU_ID = '" . $MENU_ID . "'");

            $MENU_ID = $ds[0]->MENU_ID;
            $MENU_NM = $ds[0]->MENU_NM;
            $MENU_CTRL = $ds[0]->MENU_CTRL;
            $MENU_PARENT = $ds[0]->MENU_PARENT;
            $IS_SHOW = $ds[0]->IS_SHOW;
            $IS_ACTIVE = $ds[0]->IS_ACTIVE;
            $todo = 'EDIT';
        } else {
            $MENU_ID = $this->dm->generate_key('M_SQA_MENU', 'MENU_ID', 3);
        }

        // jika Form tersubmit
        if (isset($_POST['todo'])) {

            $MENU_ID = $this->input->post('MENU_ID');
            $MENU_NM = $this->input->post('MENU_NM');
            $MENU_CTRL = $this->input->post('MENU_CTRL');
            $MENU_PARENT = $this->input->post('MENU_PARENT');
            $IS_SHOW = $this->input->post('IS_SHOW');
            $IS_ACTIVE = $this->input->post('IS_ACTIVE');
            $todo = $this->input->post('todo');

            if ($todo == 'ADD') {
                if ($MENU_NM != '') {
                    $data = array(
                        'MENU_ID' => $MENU_ID,
                        'MENU_NM' => $MENU_NM,
                        'MENU_CTRL' => $MENU_CTRL,
                        'MENU_PARENT' => ($MENU_PARENT == '') ? null : $MENU_PARENT,
                        'IS_SHOW' => $IS_SHOW,
                        'IS_ACTIVE' => $IS_ACTIVE,
                        'Updateby' => get_user_info($this, 'GRPAUTH_ID'),
                        'Updatedt' => get_date()
                    );
                    $this->dm->insert($data);
                    redirect('master_usrauth/menu');
                } else {
                    $err = 'Please input Menu name &amp; Controller';
                }
            } else {
                $update_keys = "MENU_ID = '" . $MENU_ID . "'";
                $data = array(
                    'MENU_NM' => $MENU_NM,
                    'MENU_CTRL' => $MENU_CTRL,
                    'MENU_PARENT' => ($MENU_PARENT == '') ? null : $MENU_PARENT,
                    'IS_SHOW' => $IS_SHOW,
                    'IS_ACTIVE' => $IS_ACTIVE,
                    'Updateby' => get_user_info($this, 'GRPAUTH_ID'),
                    'Updatedt' => get_date()
                );
                $this->dm->update($data, $update_keys);
                redirect('master_usrauth/menu');
            }
        }

        // list of menu parent
        $data['list_parent'] = $this->dm->select();

        $data['MENU_ID'] = $MENU_ID;
        $data['MENU_NM'] = $MENU_NM;
        $data['MENU_CTRL'] = $MENU_CTRL;
        $data['MENU_PARENT'] = $MENU_PARENT;
        $data['IS_SHOW'] = $IS_SHOW;
        $data['IS_ACTIVE'] = $IS_ACTIVE;
        $data['todo'] = $todo;
        $data['err'] = $err;

        // get sub menu
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $data['page_title'] = 'Master User Authorization';
        $this->load->view('header', $data);
        $this->load->view('m_usr/menu_change', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function menu_erase() {
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $delete_keys = array('MENU_ID' => $this->uri->segment(3));
        $this->dm->delete($delete_keys);
        redirect('master_usrauth/menu');
    }

    function grpmenu() {
        $this->dm->init('M_SQA_GROUPAUTH', 'GRPAUTH_ID');
        $grpauth_id = $this->uri->segment(3);

        // get detail group auth
        $grpauth = $this->dm->select('', '', "GRPAUTH_ID = '" . $grpauth_id . "'");
        $data['grpauth'] = $grpauth[0];

        // get distinct from group auth menu
        $this->dm->init('V_SQA_GROUPAUTH_MENU_DISC', 'GRPAUTH_ID');
        $w = "GRPAUTH_ID = '" . $grpauth_id . "'";
        $data['grpmenus'] = $this->dm->select('', '', $w);

        $this->load->view('header_plain');
        $this->load->view('m_usr/grpmenu_browse', $data);
        $this->load->view('footer_plain');
    }

    function grpmenu_change() {
        $this->dm->init('M_SQA_GROUPAUTH', 'GRPAUTH_ID');
        $grpauth_id = $this->uri->segment(3);
        $shop_id = $this->uri->segment(4);

        // get detail group auth
        $grpauth = $this->dm->select('', '', "GRPAUTH_ID = '" . $grpauth_id . "'");
        $data['grpauth'] = $grpauth[0];

        $todo = 'ADD';
        if ($shop_id != '') {
            $todo = 'EDIT';
        }
        $data['todo'] = $todo;

        // cek jika tersubmit
        $cek = $this->input->post('cek');
        if ($cek) {
            $this->dm->init('M_SQA_GROUPAUTH_MENU', 'GRPAUTH_ID');
            // delete semua dari M_SQA_GROUPAUTH_MENU where condition
            if ($shop_id != '') {
                // mau edit
                $delete_keys = array('GRPAUTH_ID' => $grpauth_id, 'SHOP_ID' => $shop_id);
                $this->dm->delete($delete_keys);
            } else {
                $shop_id = $_POST['SHOP_ID'];
            }

            foreach ($cek as $v) {
                $data = array(
                    'GRPAUTH_ID' => $grpauth_id,
                    'SHOP_ID' => $shop_id,
                    'MENU_ID' => $v,
                    'USR_AUTH' => $_POST['USR_AUTH' . $v]
                );
                $this->dm->insert($data);
            }
            redirect('master_usrauth/grpmenu/' . $grpauth_id);
        }

        // list shop
        $this->dm->init('M_SQA_SHOP', 'SHOP_ID');
        $w = ($shop_id == '') ? "SHOP_ID NOT IN (select distinct SHOP_ID FROM M_SQA_GROUPAUTH_MENU where GRPAUTH_ID = '" . $grpauth_id . "')" : '';
        $data['list_shop'] = $this->dm->select('', '', $w);

        // list menus
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['list_menu'] = $this->dm->select('', 'MENU_ID ASC, MENU_PARENT ASC');

        // list groupauth_menu
        $this->dm->init('M_SQA_GROUPAUTH_MENU', 'GRPAUTH_ID');
        $w = "GRPAUTH_ID = '" . $grpauth_id . "' and SHOP_ID = '" . $shop_id . "'";
        $list_grpmenu = $this->dm->select('', '', $w);
        $arr_menu = array();
        if (count($list_grpmenu) > 0) {
            foreach ($list_grpmenu as $l) {
                $arr_menu[$l->MENU_ID] = $l->USR_AUTH;
            }
        }
        $data['arr_menu'] = $arr_menu;

        $this->load->view('header_plain');
        $this->load->view('m_usr/grpmenu_change', $data);
        $this->load->view('footer_plain');
    }

    function grpmenu_erase() {
        $this->dm->init('M_SQA_GROUPAUTH_MENU', 'MENU_ID');
        $grpauth_id = $this->uri->segment(3);
        $shop_id = $this->uri->segment(4);

        $delete_keys = array('GRPAUTH_ID' => $grpauth_id, 'SHOP_ID' => $shop_id);
        $this->dm->delete($delete_keys);
        redirect('master_usrauth/grpmenu/' . $grpauth_id);
    }

	function cek_grp_shop() {
		$grpauth_id = $_POST['grpauth_id'];
		$shop_id = $_POST['shop_id'];
		$this->dm->init('M_SQA_GROUPAUTH_MENU', 'GRPAUTH_ID');
		echo $this->dm->count("GRPAUTH_ID = '" . $grpauth_id . "' AND SHOP_ID = '" . $shop_id . "'");
	}

}

?>

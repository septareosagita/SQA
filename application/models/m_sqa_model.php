<?php

/*
 * @author:
 * @created: March 24, 2011 - 09:01
 *
 * @modified by: -
 */

class m_sqa_model extends CI_Model {

    var $table_name = 'M_SQA_PLANT';
    var $table_pk = 'PLANT_CD';
    var $dbqis;
    var $dbrep;
	//achmad edit 2012.07.06
	var $debugs;

    function __construct() {
        parent::__construct();        
    }

    function init($table_name, $table_pk='') {
        $this->table_name = $table_name;
        $this->table_pk = $table_pk;
    }
    
    function init_dbqis($table_name, $table_pk = '') {
        $this->dbqis = $this->load->database('dbqis', true);
        $this->init($table_name, $table_pk);
    }
    
    function init_dbrep($table_name, $table_pk = '') {
        $this->dbrep = $this->load->database('dbrep', true);
        $this->init($table_name, $table_pk);
    }

    function select($limit='', $order='', $condition='', $fields = '*', $debug = false) {
        $sql = sql_select($this->table_name, $limit, $order, $condition, $fields, $this->table_pk);                
        
        if ($debug) {
            echo $sql . '<hr/>';
        }
        
        return $this->db->query($sql)->result();
    }
    
    function select_qis($limit='', $order='', $condition='', $fields = '*', $debug = false) {
        $sql = sql_select($this->table_name, $limit, $order, $condition, $fields, $this->table_pk);
        if ($debug) {
            echo $sql . '<hr/>';
        }
        //return $this->load->database('qis')->query($sql)->result();
        return $this->dbqis->query($sql)->result();
    }
    
    function select_rep($limit='', $order='', $condition='', $fields = '*', $debug = false) {
        $sql = sql_select($this->table_name, $limit, $order, $condition, $fields, $this->table_pk);
        if ($debug) {
            echo $sql . '<hr/>';
        }
        //return $this->load->database('qis')->query($sql)->result();
        return $this->dbrep->query($sql)->result();
    }

    function count($condition='', $debug = false) {
       $sql = sql_count($this->table_name, $condition, $this->table_pk);
	   if ($debug) {
			echo $sql . '</hr>';
	   }
       return $this->db->query($sql)->row()->num;
    }

    function insert($data) {
        return $this->db->insert($this->table_name, $data);
    }
    
    function insert_rep($data) {
        return $this->dbrep->insert($this->table_name, $data);
    }

    function update($data, $keys) {
        return $this->db->update($this->table_name, $data, $keys);
    }

    function delete($keys) {
        return $this->db->delete($this->table_name, $keys);
    }

    function select_last($limit='', $order='', $condition='', $fields = '*') {
        $sql = sql_select($this->table_name, $limit, $order, $condition, $fields, $this->table_pk);
        return $this->db->query($sql)->last_row();
    }

    function generate_key($table_name, $field_name, $field_size, $condition = '') {
        $this->table_name = $table_name;
        $cek = $this->select('0,1', $field_name . ' desc', $condition, $field_name);

        $ret = 0;
        if (count($cek) == 0) {
            $ret = 1;
        } else {
            $ret = $cek[0]->$field_name;
            $field_size = strlen($ret);
            $ret = $ret + 1;
        }        
        // strpad as field_size
        $ret = str_pad($ret, $field_size, "0", STR_PAD_LEFT);        
        return $ret;
    }

    function sql_self($sql) {
        return $this->db->query($sql)->result();         
    }
    
    function sql_self_no_return($sql) {
        return $this->db->query($sql);         
    }
    
    function sql_self_count($sql, $field_num) {
        return $this->db->query($sql)->row()->$field_num;
         
    }

    function prb_number() {
        $bulan = date("m");
        $tahun = date("Y");
        $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');
        $where = "PRB_SHEET_NUM LIKE '%/PS/SQA-QAD/$bulan/$tahun'";
        $dfct_sqpr = $this->dm->select('', '', $where);
        if (count($dfct_sqpr) < 1) {
            $new_sqpr = '001/PS/SQA-QAD/' . $bulan . '/' . $tahun;
            return $new_sqpr;
        } else {
            $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');
            $where = "PRB_SHEET_NUM LIKE '%/PS/SQA-QAD/$bulan/$tahun'";
            $dfct_last = $this->dm->select_last('', 'PRB_SHEET_NUM', $where);

            $sqpr_num = $dfct_last->PRB_SHEET_NUM;
            $nnn = intval(substr($sqpr_num, 0, 3));

            $new_sqpr = $nnn + 1;
            $new_sqpr = sprintf("%03d", $new_sqpr) . "/PS/SQA-QAD/" . $bulan . "/" . $tahun;
            return $new_sqpr;
        }
    }

    function sqpr_number() {
        $bulan = date("m");
        $tahun = date("Y");
        $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');
        $where = "SQPR_NUM LIKE '%/SQPR/SQA-QAD/$bulan/$tahun'";
        $dfct_sqpr = $this->dm->select('', '', $where);
        if (count($dfct_sqpr) < 1) {
            $new_sqpr = '001/SQPR/SQA-QAD/' . $bulan . '/' . $tahun;
            return $new_sqpr;
        } else {
            $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');
            $where = "SQPR_NUM LIKE '%/SQPR/SQA-QAD/$bulan/$tahun'";
            $dfct_last = $this->dm->select_last('', 'SQPR_NUM', $where);

            $sqpr_num = $dfct_last->SQPR_NUM;
            $nnn = intval(substr($sqpr_num, 0, 3));

            $new_sqpr = $nnn + 1;
            $new_sqpr = sprintf("%03d", $new_sqpr) . "/SQPR/SQA-QAD/" . $bulan . "/" . $tahun;
            return $new_sqpr;
        }
    }
    
    /*
     * @author: taufik@mediantarakreasindo.com
     * @created: Jun, 03 2011 - 10:44
     * fungsi : untuk mengirim email melalui applikasi
     */
    function send_email($to='', $content='', $subject='') {
    	/* Dalam CodeIgniter disediakan library pengiriman notifikasi ke user, dsb, yaitu library class Email.php
    	   diinisialisasi dulu dengan :*/
    	 $this->load->library('email');
    	 
    	/*setting secara manual,simpan di dalam satu variabel array $config */
    	 $configs['protocol']='smtp';
    	 $configs['smtp_host']='mail.toyota.co.id';
    	 $configs['smtp_port']='25';
    	 $configs['smtp_timeout']='30';
    	 $configs['smtp_user']='sqa.admin@toyota.co.id';
    	 $configs['smtp_pass']='toyota02';
    	 $configs['charset'] = "iso-8859-1";
    	 $configs['wordwrap'] = FALSE;
    	 $configs['mailtype'] = "html";
    	 $configs['newline']="\r\n";
    	 
    	/*panggil dengan perintah initialize dari objek email :*/
    	 $this->email->initialize($configs);
    	 
    	/*metode pengiriman email dari library */
    	 $this->email->from('sqa.admin@toyota.co.id','SQA KARAWANG');
    	 $this->email->to($to);
    	 $this->email->subject($subject);
    	 $this->email->message($content);
         $this->email->send();
    }        
}

?>

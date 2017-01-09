<?php

/*
 * @author:
 * @created: March 24, 2011 - 09:01
 *
 * @modified by: -
 */

class m_sqa_model extends CI_Model {

    var $table_name = 'M_SQA_COUNTRY';
    var $table_pk = 'COUNTRY_CD';

    function __construct() {
        parent::__construct();
    }

    function init($table_name, $table_pk='') {
        $this->table_name = $table_name;
        $this->table_pk = $table_pk;
    }

    function select($limit='', $order='', $condition='', $fields = '*') {
        $sql = sql_select($this->table_name, $limit, $order, $condition, $fields, $this->table_pk);        
        return $this->db->query($sql)->result();
    }

    function count($condition='') {
        $sql = sql_count($this->table_name, $condition, $this->table_pk);        
        return $this->db->query($sql)->row()->num;
    }

    function insert($data) {
        return $this->db->insert($this->table_name, $data);
    }

    function update($data, $keys) {
        return $this->db->update($this->table_name, $data, $keys);
    }

    function delete($keys) {
        return $this->db->delete($this->table_name, $keys);
    }

    function generate_key($table_name, $field_name, $field_size, $c='') {
        $this->table_name = $table_name;
        $cek = $this->select('0,1',$field_name . ' desc', $c, $field_name);

        $ret = 0;
        if (count($cek)==0) {
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

    // fungsi untuk generate key format untuk
    // PRB_SHEET_NUM & SQPR_NUM
    function generate_key_format() {
        
    }

    function sql_self($sql) {
        return $this->db->query($sql);
    }

    function last_id() {
        return $this->db->insert_id();
    }

}

?>

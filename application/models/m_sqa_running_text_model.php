<?php
/*
 * @author:
 * @created: March 24, 2011 - 09:30
 *
 * @modified by: -
 */

class m_sqa_running_text_model extends CI_Model {

    var $table_name = 'V_SQA_RUNNING_TEXT';
    var $table_model = 'M_SQA_RUNNING_TEXT';
    var $table_pk = 'PLANT_CD';

    function __construct() {
        parent::__construct();
    }

    /*
     * @param limit : String 0, 1 Exp: 'page, page_perview'
     * @param order : order by table Exp: 't1.country_name asc'
     * @param condition: condition filter table Exp: "t1.country_id='2'"
     * @param fields: field yg ingin diambil, defaultnya '*' (semua)
     */
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
        return $this->db->delete($this->table_model, $keys);
    }

}

?>
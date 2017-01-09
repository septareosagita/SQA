<?php
/*
 * @author:
 * @created: March 22, 2011 - 16:37
 *
 * @modified by: -
 */

class t_sqa_dfct_reply_model extends CI_Model {

    var $table_name = 'T_SQA_DFCT_REPLY';
    var $table_pk = 'SHOP_ID';

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
        return $this->db->delete($this->table_name, $keys);
    }
}

?>
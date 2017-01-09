<?php

/*
 * @author: Irfan Satriadarma
 * @copyright: 2011
 * @description: Helper untuk pembentukan SQL dari tiap - tiap Model
 */

// return sql query with paging as String

/*
 * Membuat SQL untuk di eksekusi ke SQL Server
 * @param table_name : nama table yang akan di query
 * @param limit : paging: klo kosong maka tidak di paging
 * @param order: order by table yg akan di query
 * @param condition: kondisi filter query
 * @param fields: field yang ingin di ambil, gunakan '*' untuk semua
 * @param default_order: MANDATORY, ini harus diisi untuk default order dari table tsb.
 *
 * @return SQL query as String
 */
function sql_select($table_name, $limit, $order, $condition, $fields, $default_order) {
    $strConditionTable = ($condition != '') ? ' where ' . $condition : '';
    $strConditionLimit = '';

    if ($limit != '') {
        $limit = explode(',', $limit);
        if (count($limit) == 2) {
            $limit1 = $limit[0];
            $limit2 = $limit[1];

            $limit1 = ($limit1 < 1) ? 1 : $limit1 + 1;
            $maxct = ($limit2 < 1) ? 1 : $limit2;
            $limit2 = $limit1 + $maxct;
            $strConditionLimit = " where (row >= " . $limit1 . " and row < " . $limit2 . ")";
        }
    }

    $orderBy = ($order != '') ? $order : $default_order;
    $sql = "select * from (select " . $fields . ", row_number() over (order by " . $orderBy . ") as row
                from " . $table_name . " " . $strConditionTable . ") as tbl" . $strConditionLimit;
    
    //echo $sql; 
    return $sql;
}

function sql_count($table_name, $condition, $field='') {
    $strConditionTable = ($condition != '') ? ' WHERE ' . $condition : '';
    $field = ($field == '') ? '*' : $field;
    $sql = "SELECT count(" . $field . ") AS num FROM " . $table_name . " " . $strConditionTable;
    return $sql;
}

function sort_field($ci_obj, $using_search, $default_sort = 0, $default_sortby = 'desc') {    
    // find key for segment, if search is exist, change it
    $sort_segment = (!$using_search) ? 3 : 5;
    $sorttype_segment = (!$using_search) ? 4 : 6;
    $page_segment = (!$using_search) ? 6 : 8;

    // sorting & order
    $sortseq = ($ci_obj->uri->segment($sort_segment) != '') ? $ci_obj->uri->segment($sort_segment) : $default_sort;
    $sortseq = (array_key_exists($sortseq, $ci_obj->fieldseq) ? $sortseq : $default_sort);
    $sort = $ci_obj->fieldseq[$sortseq];
    $sorttype = ($ci_obj->uri->segment($sorttype_segment) != '') ? $ci_obj->uri->segment($sorttype_segment) : $default_sortby;
    $sorttypev = ($sorttype == 'asc' ? 'desc' : 'asc');
    $orderby = ($sort != '') ? $sort . ' ' . $sorttype : '';

    return array($orderby, $sort, $sorttypev, $sortseq, $sorttype, $page_segment);
}

function sort_by($ci_obj) {
    echo $ci_obj->uri->segment(2);
}

function text_paging($ci_obj, $page_segment, $pagination_base_url, $total_rows, $page) {
    $config['uri_segment'] = $page_segment;
    $config['base_url'] = $pagination_base_url;
    $config['total_rows'] = $total_rows;
    $config['per_page'] = PAGE_PERVIEW;
    $config['cur_page'] = $page;
    $config['next_link'] = 'Next &rsaquo;';
    $config['last_link'] = 'Last &raquo;';
    $config['first_link'] = '&laquo; First';
    $config['prev_link'] = '&lsaquo; Prev';
    $ci_obj->pagination->initialize($config);
    return $ci_obj->pagination->create_links();
}

function text_paging_ajax($ci_obj, $pagination_base_url, $total_rows, $page, $url, $panel, $condition) {    
    $config['base_url'] = $pagination_base_url;
    $config['total_rows'] = $total_rows;
    $config['per_page'] = PAGE_PERVIEW;
    $config['next_link'] = 'Next &raquo;';
    $config['last_link'] = 'Last &raquo;&raquo;';
    $config['first_link'] = '&laquo;&laquo; First';
    $config['prev_link'] = '&laquo; Prev';
    $config['cur_page'] = $page;
    $config['prefix'] = '(';
    $config['suffix'] = ');';
    $ci_obj->pagination->initialize($config);
    return $ci_obj->pagination->create_links_ajax($url, $panel, $condition);
}

function get_date() {
    return date('Y-m-d H:i:s');
}

function get_date2() {
    return date('d-m-Y');
}

function get_date3(){
     $date = get_date2();

        // date parsing
        $date_x = explode('-', $date);
        $d = $date_x[0];
        $m = $date_x[1];
        $Y = $date_x[2];

        $yesterday_x = mktime(0, 0, 0, $m, $d - 1, $Y);
       return $yesterday = date("d-m-Y", $yesterday_x);

}

function get_user_info($ci_obj, $field = 'USER_NM') {
    $user_info = $ci_obj->session->userdata('user_info');
    $user_info = explode(';;', $user_info);

    if ($field == 'USER_ID') {
        return $user_info[0];
    } else if ($field == 'USER_NM') {
        return $user_info[1];
    } else if ($field == 'GRPAUTH_ID') {
        return (isset($user_info[2])) ? $user_info[2] : ''; // edited by irfan.satriadarma@gmail.com 20120418 -> supaya menghilangkan undefined offset.
    } else if ($field == 'SHOP_ID') {
        return (isset($user_info[3])) ? $user_info[3] : ''; // edited by irfan.satriadarma@gmail.com 20120418 -> supaya menghilangkan undefined offset.
    } else if ($field == 'EMAIL') {
        return $user_info[4];
    } else if ($field == 'DESCRIPTION') {
        return $user_info[5];
    } else if ($field == 'PLANT_CD') {
        return (isset($user_info[6])) ? $user_info[6] : ''; // edited by irfan.satriadarma@gmail.com 20120418 -> supaya menghilangkan undefined offset.
    } else if ($field == 'PLANT_NM') {
        return (isset($user_info[7])) ? $user_info[7] : ''; // edited by irfan.satriadarma@gmail.com 20120418 -> supaya menghilangkan undefined offset.
    } else if ($field == 'PLANT_DESC') {
        return $user_info[8];
    } else if ($field == 'SHIFTGRP_ID') {
        return $user_info[9];
    } else if ($field == 'SHIFTTGRP_NM') {
        return $user_info[10];
    } else if ($field == 'GRPAUTH_NM') {
        return $user_info[11];
    }
    return $user_info[1];
}

// convert date, f: [1|2]
function conv_date($f, $date, $sep = '/') {
    $fmt = '';
    if ($f == '1') { // normal to mysql
        $date = explode('/', $date);
        $fmt = (count($date) == 3) ? $date[2] . '-' . $date[1] . '-' . $date[0] : '';
    } else { // mysql to normal
        $date = explode(' ', $date);
        $date = explode('-', $date[0]);
        $fmt = (count($date) == 3) ? $date[2] . $sep . $date[1] . $sep . $date[0] : '';
    }
    return $fmt;
}


function createDateRangeArray($strDateFrom, $strDateTo) {
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.
    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange = array();

    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry

        while ($iDateFrom < $iDateTo) {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}

function get_user_email_approval($ci_obj) {
    $email = array();
    $sql_email = "select EMAIL from V_USR where 
                                (GRPAUTH_ID IN ('02','03','05','06','07')) OR 
                                (GRPAUTH_ID = '01' AND SHOP_ID = LEFT('".$dfct->SHOP_NM."',1));";
    $list_email = $ci_obj->dm->sql_self($sql_email) ;
    foreach ($list_email as $ii):
        $cek_ex = explode(';', $ii->EMAIL);
        if (count($cek_ex)>0) {
            foreach($cek_ex as $cek) {
                if ($cek != '') {
                    if (!in_array($cek, $email)) {
                        $email[] = $cek;    
                    }                                    
                }                            
            }
        } else {
            if ($ii->EMAIL != '') {
                if (!in_array($ii->EMAIL, $email)) {
                    $email[] = $ii->EMAIL;    
                }
            }
        }
    endforeach;
    return $email;
}

function get_content_email_approval($dfct, $PRB, $approve_sysdate, $dfct_confby_qcd, $dfct_confby_rel,$reply_text) {
    $msg = "
            <html>
            <body>
            <h3 style='color: #4A4A4A'>SHIPPING QUALITY AUDIT</h3>
                <p>
                    This Defect already approved By SQA Section Head.
                    <br/><br/>
                    <table border=\"0\">
                        <tr>
                            <td width=\"25%\">Problem Sheet Number</td>
                            <td width=\"1%\">:</td>
                            <td style=\"text-align: left\">".$PRB."</td>
                        </tr>
                        <tr>
                            <td>SQA Date</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$approve_sysdate."</td>
                        </tr>
                    </table><br/>
                    <strong>Vehicle Information:</strong> <br/>
                    <table border=\"0\">
                        <!--tr>
                            <td width=\"25%\">IDNO</td>
                            <td width=\"1%\">:</td>
                            <td style=\"text-align: left\">".$dfct->IDNO."</td>
                        </tr-->
                        <tr>
                            <td>Body No</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->BODYNO."</td>
                        </tr>
                        <tr>
                            <td>Frame No</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->VINNO."</td>
                        </tr>
                        <tr>
                            <td>Destination</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->DEST."</td>
                        </tr>
                        <tr>
                            <td>Model</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->DESCRIPTION."</td>
                        </tr>
                        <tr>
                            <td>Color</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->EXTCLR."</td>
                        </tr>
                    </table>
                    <strong>Defect Information: </strong> <br/>
                    <table border=\"0\">
                        <tr>
                            <td width=\"25%\">Defect Name</td>
                            <td width=\"1%\">:</td>
                            <td style=\"text-align: left\">".$dfct->DFCT."</td>
                        </tr>
                        <tr>
                            <td>Category Group</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->CTG_GRP_NM."</td>
                        </tr>
                        <tr>
                            <td>Category Name</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->CTG_NM."</td>
                        </tr>
                        <tr>
                            <td>Rank</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->RANK_NM2."</td>
                        </tr>
                        <tr>
                            <td>Responsible Shop</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->SHOP_NM."</td>
                        </tr>
                        <tr>
                            <td>Confirm By QCD</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct_confby_qcd."</td>
                        </tr>
                        <tr>
                            <td>Confirm By Related Div</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct_confby_rel."</td>
                        </tr>
                    </table>
                    <br />
                    <strong>Due Date per Defect Reply</strong>
                    <table border=\"0\" cellspacing=\"0\">
                        <tr>
                            <td style=\"border-bottom: 1px solid; border-top: 1px solid; font-weight: bold;\">Reply Type</td>
                            <td style=\"border-bottom: 1px solid; border-top: 1px solid; font-weight: bold\">Countermeasure</td>
                            <td style=\"border-bottom: 1px solid; border-top: 1px solid; font-weight: bold\">Due Date</td>
                        </tr>
                        ".$reply_text."
                    </table>
                    <br/>
                    Please Log In to Shipping Quality Audit System at <a href=ht".htmlspecialchars(APP_URL .'t_sqa_dfct/report_sqa/' . $dfct->PROBLEM_ID . '/m').">".htmlspecialchars(APP_URL .'t_sqa_dfct/report_sqa/' . $dfct->PROBLEM_ID . '/m')."</a> with your account
                </p>
                
                <p>
                    Regards,
                    <br/><br/>
                    <strong style='color: #4A4A4A'>SQA ADMIN MAIL SYSTEM</strong>
                    <br/>
                    <span style='font-size: 10px'>
                    * This email send automaticaly based on the SQA System. You dont have to reply this email. For Information & Contact, please refer to ISTD TMMIN.
                    </span>
                </p>
                </body>
                </html>
                ";
    return $msg;                
}

function get_content_email_unapproval($dfct, $dfct_confby_qcd, $dfct_confby_rel) {
    $msg = "<html>
            <body>
            <h3 style='color: #4A4A4A'>SHIPPING QUALITY AUDIT</h3>
                <p>
                    This Defect Approval already <strong>Cancelled</strong> By SQA Section Head.
                    <br/><br/>                    
                    <table border=\"0\">                        
                        <tr>
                            <td>Cancel Approval Date</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".date('d-m-Y')."</td>
                        </tr>
                    </table><br/>
                    <strong>Vehicle Information:</strong> <br/>
                    <table border=\"0\">
                        <!--tr>
                            <td width=\"25%\">IDNO</td>
                            <td width=\"1%\">:</td>
                            <td style=\"text-align: left\">".$dfct->IDNO."</td>
                        </tr-->
                        <tr>
                            <td>Body No</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->BODYNO."</td>
                        </tr>
                        <tr>
                            <td>Frame No</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->VINNO."</td>
                        </tr>
                        <tr>
                            <td>Destination</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->DEST."</td>
                        </tr>
                        <tr>
                            <td>Model</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->DESCRIPTION."</td>
                        </tr>
                        <tr>
                            <td>Color</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->EXTCLR."</td>
                        </tr>
                    </table>
                    <strong>Defect Information: </strong> <br/>
                    <table border=\"0\">
                        <tr>
                            <td width=\"25%\">Defect Name</td>
                            <td width=\"1%\">:</td>
                            <td style=\"text-align: left\">".$dfct->DFCT."</td>
                        </tr>
                        <tr>
                            <td>Category Group</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->CTG_GRP_NM."</td>
                        </tr>
                        <tr>
                            <td>Category Name</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->CTG_NM."</td>
                        </tr>
                        <tr>
                            <td>Rank</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->RANK_NM2."</td>
                        </tr>
                        <tr>
                            <td>Responsible Shop</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct->SHOP_NM."</td>
                        </tr>
                        <tr>
                            <td>Confirm By QCD</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct_confby_qcd."</td>
                        </tr>
                        <tr>
                            <td>Confirm By Related Div</td>
                            <td>:</td>
                            <td style=\"text-align: left\">".$dfct_confby_rel."</td>
                        </tr>
                    </table>                    
                    <br/>
                    Please Log In to Shipping Quality Audit System at <a href=ht".htmlspecialchars(APP_URL .'t_sqa_dfct/report_sqa/' . $dfct->PROBLEM_ID . '/m').">".htmlspecialchars(APP_URL .'t_sqa_dfct/report_sqa/' . $dfct->PROBLEM_ID . '/m')."</a> with your account                    
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
    return $msg;                
}

?>

<?php

class pdf_test extends CI_Controller {
function __construct()
{
parent::__construct();
$this->load->model('m_sqa_model', 'dm', true);
}
function achmad(){
        $email = $this->dm->send_email("achmad@arkamaya.co.id,eka@arkamaya.co.id", "Cobain...", "Tah... ");
        if($email){
            echo "email berhasil";
        }else{
            echo "email gagal";
        }
    }
function index()
{
$this->load->library('pdf_result');
// set informasi dokumen
        

        $this->load->library('pdf_ori');
        $this->pdf_result->SetSubject('Result search print - SQA');
        $this->pdf_result->SetFont('helvetica', '', 8);

        // set default header data
        $ht = 'PT. Toyota Motor Manufacturing Indonesia';
        $this->pdf_result->SetHeaderData('toyota.png', 17, $ht, "QAD - Customer Quality Audit\nAudit Section\n\n");
        $this->pdf_result->setPrintHeader(true);
        $this->pdf_result->setPrintFooter(true);
        $this->pdf_result->setTopMargin(65);
        $this->pdf_result->SetLeftMargin(10);
        $this->pdf_result->setPageOrientation('L');


        $data['something'] = 'hah';

        $this->pdf_result->AddPage();
        $html = $this->load->view('download_report/result_search_print', $data, true);
        $this->pdf_result->writeHTML($html, true, false, true, false, '');
        $this->pdf_result->Output('Result search print - Result_search.pdf', 'I');
}
}

?>
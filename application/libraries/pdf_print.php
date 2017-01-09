<?php

/*
  # override the default TCPDF config file
  if(!defined('K_TCPDF_EXTERNAL_CONFIG')) {
  define('K_TCPDF_EXTERNAL_CONFIG', TRUE);
  } */

# include TCPDF
require(APPPATH . 'config/tcpdf' . EXT);
require_once($tcpdf['base_directory'] . '/tcpdf.php');



/* * **********************************************************
 * TCPDF - CodeIgniter Integration
 * Library file
 * ----------------------------------------------------------
 * @author Jonathon Hill http://jonathonhill.net
 * @version 1.0
 * @package tcpdf_ci
 * ********************************************************* */

class pdf_print extends TCPDF {

    /**
     * TCPDF system constants that map to settings in our config file
     *
     * @var array
     * @access private
     */
    private $cfg_constant_map = array(
        'K_PATH_MAIN' => 'base_directory',
        'K_PATH_URL' => 'base_url',
        'K_PATH_FONTS' => 'fonts_directory',
        'K_PATH_CACHE' => 'cache_directory',
        'K_PATH_IMAGES' => 'image_directory',
        'K_BLANK_IMAGE' => 'blank_image',
        'K_SMALL_RATIO' => 'small_font_ratio',
    );
    /**
     * Settings from our APPPATH/config/tcpdf.php file
     *
     * @var array
     * @access private
     */
    private $_config = array();
    private $vinf = array();

    /**
     * Initialize and configure TCPDF with the settings in our config file
     *
     */
    function __construct() {

        # load the config file
        require(APPPATH . 'config/tcpdf' . EXT);
        $this->_config = $tcpdf;
        unset($tcpdf);



        # set the TCPDF system constants
        foreach ($this->cfg_constant_map as $const => $cfgkey) {
            if (!defined($const)) {
                define($const, $this->_config[$cfgkey]);
                #echo sprintf("Defining: %s = %s\n<br />", $const, $this->_config[$cfgkey]);
            }
        }

        # initialize TCPDF
        parent::__construct(
                        $this->_config['page_orientation'],
                        $this->_config['page_unit'],
                        $this->_config['page_format'],
                        $this->_config['unicode'],
                        $this->_config['encoding'],
                        $this->_config['enable_disk_cache']
        );


        # language settings
        if (is_file($this->_config['language_file'])) {
            include($this->_config['language_file']);
            $this->setLanguageArray($l);
            unset($l);
        }

        # margin settings
        $this->SetMargins($this->_config['margin_left'], $this->_config['margin_top'], $this->_config['margin_right']);

        # header settings
        $this->print_header = $this->_config['header_on'];
        #$this->print_header = FALSE;
        $this->setHeaderFont(array($this->_config['header_font'], '', $this->_config['header_font_size']));
        $this->setHeaderMargin($this->_config['header_margin']);
        $this->SetHeaderData(
                $this->_config['header_logo'],
                $this->_config['header_logo_width'],
                $this->_config['header_title'],
                $this->_config['header_string']
        );

        # footer settings
        $this->print_footer = $this->_config['footer_on'];
        $this->setFooterFont(array($this->_config['footer_font'], '', $this->_config['footer_font_size']));
        $this->setFooterMargin($this->_config['footer_margin']);

        # page break
        $this->SetAutoPageBreak($this->_config['page_break_auto'], $this->_config['footer_margin']);

        # cell settings
        $this->cMargin = $this->_config['cell_padding'];
        $this->setCellHeightRatio($this->_config['cell_height_ratio']);

        # document properties
        $this->author = $this->_config['author'];
        $this->creator = $this->_config['creator'];

        # font settings
        #$this->SetFont($this->_config['page_font'], '', $this->_config['page_font_size']);
        # image settings
        $this->imgscale = $this->_config['image_scale'];
    }

    public function Header() {
        $headerdata = $this->getHeaderData();
        if (($headerdata['logo']) AND ($headerdata['logo'] != K_BLANK_IMAGE)) {
            $imgtype = $this->getImageFileType(K_PATH_IMAGES . $headerdata['logo']);
            if (($imgtype == 'eps') OR ($imgtype == 'ai')) {
                $this->ImageEps(K_PATH_IMAGES . $headerdata['logo'], '', '', $headerdata['logo_width']);
            } elseif ($imgtype == 'svg') {
                $this->ImageSVG(K_PATH_IMAGES . $headerdata['logo'], '', '', $headerdata['logo_width']);
            } else {
                $this->Image(K_PATH_IMAGES . $headerdata['logo'], '', '', $headerdata['logo_width']);
            }
            $imgy = $this->getImageRBY();
        } else {
            $imgy = $this->y;
        }

        $this->SetFont('Helvetica', '', 9);
        $table = '<table cellpadding="3" width="100%">
                    <tr>
                        <td style="color: #ff0000">'.$headerdata['title'].'</td>
                        <td rowspan="2" align="right"><h3>SQA PROBLEM SHEET</h3></td>
                    </tr>
                    <tr>
                        <td>QAD - Customer Quality Audit <br/>Audit Section<br/></td>
                    </tr>                    
                    <tr>
                        <td></td>
                        <td style="text-align: right">Print Date : '. get_date() .'</td>
                    </tr>
                    <tr>
                        <td cols="2">
                            
                        </td>
                    </tr>                    
                </table>
                ';
        $this->writeHTMLCell($w = '', $h = '', $x = 30, $y = '',$html = $table, $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = 'L', $autopadding = true);       
        
    }

    function setVinf($v) {
        $this->vinf = $v;
    }

}
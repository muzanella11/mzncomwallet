<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class RestManager extends REST_Controller {
    private $headerData;
    private $statusRequest;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->library('enem_templates');
    }

    public function getHeaderData()
    {
        $this->headerData = getallheaders();
        return $this->headerData;
    }
}

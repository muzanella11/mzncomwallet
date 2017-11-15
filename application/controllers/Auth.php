<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/RestManager.php';
require APPPATH . '/libraries/TokenManagement.php';

class Auth extends RestManager {
    private $tokenManagement;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->load->model('enem_user_model');
        
        $this->tokenManagement = new TokenManagement();
    }

    public function index_get()
    {
        $data = [
            'status' => 'Ok',
            'messages' => 'Hello guys :)'
        ];
        return $this->set_response($data, REST_Controller::HTTP_OK);
    }

    public function token_get()
    {
        $length = 110811;
        $token = $this->tokenManagement->getNewToken();
        $setting_expired = array(
            'timeby' => 'hours',
            'value' => 1, // di set 1 jam expired nya
        );

        $configToken = array(
            'token' => $token,
            'setting_expired' => $setting_expired
        );

        $this->tokenManagement->initToken($configToken);

        $dataMasterToken = $this->tokenManagement->getTokenByTokenId($token);

        $data = [
            'status' => count($dataMasterToken) > 0 ? 'Ok' : 'Problem',
            'token' => $token
        ];
        return $this->response($data, REST_Controller::HTTP_OK);
    }

    public function check_token_get()
    {
        $dataHeader = $this->getHeaderData();
        $getTokenHeader = explode(' ', $dataHeader['Authorization'])[1];

        $checkToken = $this->enem_user_model->getDataTokenUserManagementByToken($getTokenHeader);
        $statusToken = $this->enem_templates->check_expired_time($checkToken[0]->token_expired);

        $data = [
            'status' => 'Ok',
            'messages' => 'Unauthorize'
        ];

        if ($statusToken === 0)
        {
            $data = [
                'status' => 'Ok',
                // 'token' => $getTokenHeader,
                'messages' => $statusToken === 0 ? 'active' : 'not active',
                'tokenStatus' => $statusToken === 0 ? true : false
            ];
        }

        return $this->set_response($data, $statusToken === 0 ? REST_Controller::HTTP_OK : REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function authorization_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');
        $status = '';
        $messages = '';

        $data = [
            'status' => $status,
            'message' => $messages
        ];

        return $this->response($data, REST_Controller::HTTP_OK);
    }

}

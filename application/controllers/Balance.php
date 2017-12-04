<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/RestManager.php';

class Balance extends RestManager {
    function __construct () 
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('enem_user_model');
        $this->load->model('BalanceModel');
    }

    public function index_get() 
    {
        $data = [
            'status' => 'Ok',
            'messages' => 'Hello guys :)'
        ];
        
        return $this->set_response($data, REST_Controller::HTTP_OK);
    }

    public function create_post()
    {
        $userId = $this->post('user_id');
        $amount = $this->post('amount');
        $dataPost = [
            'user_id' => $userId,
            'amount_balance' => $amount
        ];

        $dataUser = $this->enem_user_model->getEnemUserData('id', $dataPost['user_id']);
        $data = [
            'status' => '',
            'messages' => ''
        ];

        if (!$dataUser && !$amount)
        {
            $flag = 1;
            $data['status'] = 'Problem';
            $data['messages'] = 'Not found user id or amount';
        }
        else 
        {
            $flag = 0;
        }

        if ($flag === 0)
        {
            $db = array(
                ''
            );
        }

        var_dump($dataUser); exit;
    }
}
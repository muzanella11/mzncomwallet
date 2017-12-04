<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BalanceManagement {

    private $CI;

    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('enem_templates');
        $this->CI->load->model('enem_user_model');
        $this->CI->load->model('BalanceModel');
    }

    public function validateBalance($dataPost = [])
    {
        $dataUser = $this->CI->enem_user_model->getEnemUserData('id', $dataPost['user_id']);
        $dataBalance = $this->CI->BalanceModel->getDataUserBalance('id', $dataPost['user_id']);

        if (!$dataPost['user_id'])
        {
            $flag = 1;
            $data['status'] = 'Problem';
            $data['messages'] = 'Data user id is not found';
        }
        else if (!$dataUser)
        {
            $flag = 1;
            $data['status'] = 'Problem';
            $data['messages'] = 'Data user not found';
        }
        else if ($dataBalance)
        {
            $flag = 1;
            $data['status'] = 'Problem';
            $data['messages'] = 'Data balance already registered';
        }
        else if (!$dataPost['amount_balance'])
        {
            $flag = 1;
            $data['status'] = 'Problem';
            $data['messages'] = 'Data amount is not found';
        }
        else if (!is_numeric($dataPost['amount_balance']))
        {
            $flag = 1;
            $data['status'] = 'Problem';
            $data['messages'] = 'Wrong amount format';
        }
        else 
        {
            $flag = 0;
        }

        $data['flag'] = $flag;

        return $data;
    }

}

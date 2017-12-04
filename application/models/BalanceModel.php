<?php

/**
 * @author f1108k
 * @copyright 2015
 */



?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class BalanceModel extends MY_Model {
        function __construct(){
            parent::__construct();
        }

        function addUserBalance($data) {
            $sql    =   "INSERT INTO enem_balance (user_id, amount_balance, date_created)
                            VALUES('".$data['user_id']."', '".$data['amount_balance']."', now())";

            $this->db->query($sql);

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
            }
            else
            {
                $this->db->trans_commit();
            }
        }

        function updateUserBalance($data) {
            $amount_balance    =   "amount_balance='".$data['amount_balance']."'";

            $sql    =   "UPDATE enem_balance SET ".$amount_balance.", date_update=now() WHERE user_id ='".$data['user_id']."'";
            $this->db->query($sql);
        }

    }
?>
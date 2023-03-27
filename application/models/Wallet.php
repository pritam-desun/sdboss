<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Model {

    public function __construct () {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
    }

    /**
     * @Desc Get Balance
     */
    public function get_balance ($cust_code) {
        $conditions = array('cust_code' => $cust_code);
        $query = $this->db
            ->select('amount')
            ->where($conditions)
            ->get('wallet');
        
        $result = $query->row_array();
        return !empty($result) ? $result['amount'] : 0;
    }

    /**
     * @Desc: Add Balance to Wallet
     */
    public function add_balance ($cust_code, $amount) {
        $conditions = array('cust_code' => $cust_code);
        $query = $this->db
            ->select('amount')
            ->where($conditions)
            ->get('wallet');
        
        if ($query->num_rows() === 1) {
            $result = $query->row_array();
            $set = array(
                'amount' => floatval($amount) + floatval($result['amount'])
            );

            $this->db->where($conditions)->update('wallet', $set);
            return $this->db->affected_rows();
        }
        else {
            $insert_data = array(
                'cust_code' => $cust_code,
                'amount' => $amount
            );

            $this->db->insert('wallet', $insert_data);
            return $this->db->affected_rows();
        }
    }

    /**
     * @Desc: Deduct Balance from Wallet
     */
    public function deduct_balance ($cust_code, $amount) {
        ## Get available balance
        $current_balance = $this->get_balance($cust_code);
        $status = FALSE;

        if (intval($amount) <= intval($current_balance)) {
            $updated_balance = floatval($current_balance) - floatval($amount);
            $conditions = array('cust_code' => $cust_code);
            $set = array('amount' => $updated_balance);

            $this->db->where($conditions)->update('wallet', $set);
            $status = $this->db->affected_rows() > 0 ;
        }
        return $status;
    }

    /**
     * @Desc: Insert Wallet Transaction Record
     */
    public function add_transaction ($data) {
        if (empty($data['cust_code']) || empty($data['type'])) {
            return;
        }

        $txn_data = array(
            'cust_code' => $data['cust_code'],
            'trans_code' => !empty($data['trans_code']) ? $data['trans_code'] : get_transaction_code(),
            'amount' => !empty($data['amount']) ? $data['amount'] : 0,
            'purpose' => !empty($data['purpose']) ? $data['purpose'] : NULL,
            'type' => $data['type'],
            'txn_reference' => !empty($data['txn_reference']) ? $data['txn_reference'] : NULL,
            'source_type' => !empty($data['source_type']) ? $data['source_type'] : 'w',
            'created_on' => date('Y-m-d H:i:s')
        );

        $this->db->insert('wallet_trans', $txn_data);
        return $this->db->insert_id();
    }
}
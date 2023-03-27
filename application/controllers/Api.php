<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	## Response Check Types
    private $CHECK_TYPE_SUCCESS = 'success';
    private $CHECK_TYPE_FAILURE = 'failure';

    ## Purpose Opening Balanace
    private $PURPOSE_OPENING_BALANCE = 'Opening Balance';

    ## Wallet Transaction Types
    private $TYPE_CREDIT = 'CR';
    private $TYPE_DEBIT = 'DR';

    ## Bidding Type
    private $BID_TYPE_SINGLE = 'Single';
    private $BID_TYPE_PATTI = 'Patti';

    public function __construct () {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        header('Content-Type: application/json');
    }
    /**
     * @Desc: Return Sever Time
     */

     public function gettime(){
         $date = date('Y-m-d');
         $time = date('H:i:s');

         $response = [];
         $response['date'] = $date;
         $response['time'] = $time;
         echo json_encode($response);
     }

    /**
     * @Desc: Generate User Code
     */
    private function generate_customer_code () {
        $query = $this->db
            ->select('MAX(id) as last_id')
            ->get('customers');

        $result = $query->row_array();
        $lastid = $result['last_id'] + 1;
        $code = 'CUST' . str_pad($lastid, 6, "0", STR_PAD_LEFT);
        return $code;
    }

    public function generate_customer_codes () {
        $query = $this->db
            ->select('MAX(id) as last_id')
            ->get('customers');

        $result = $query->row_array();
        $lastid = $result['last_id'] + 1;
        $code = 'CUST' . str_pad($lastid, 6, "0", STR_PAD_LEFT);
        echo $code;
    }

    /**
     * @Desc: Send OTP
     */
    public function send_otp ($mobile, $msg, $mcode) {
        $query = $this->db
            ->select(['api AS api_key', 'sender_id', 'url', 'sms_qty'])
            ->where(['is_active' => 1])
            ->get('tbl_sms_settings');

        $data = $query->row_array();

        $message = rawurlencode($msg);
        $request_data = array(
            'apikey' => urlencode($data['api_key']),
            'numbers' => $mobile,
            "sender" => urlencode($data['sender_id']),
            "message" => $message
        );
        // if($data['sms_qty'] > 0){
            ## Send the POST request with cURL
            // $ch = curl_init($data['url']);
            // curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($ch);
            // print_r($response);exit;
            // curl_close($ch);


            $set = array(
                'sms_qty' => $data['sms_qty'] + 1
            );
            $this->db->where(['api' => $data['api_key']])->update('tbl_sms_settings', $set);
        // }
        

        $response = array(
            'check' => $this->CHECK_TYPE_SUCCESS,
            'data' => array(
                'mobile' => $mobile,
                'mcode' => (string) $mcode
            )
        );

        echo json_encode($response);
    }

    /**
     * @Desc: Verify Mobile Number, & send OTP if verification is success
     */
    public function verify_mobile () {
        $mobile = $this->input->post('mobile', TRUE);
        $pupose = $this->input->post('purpose', TRUE);

        $query = $this->db
            ->select('id')
            ->where(['mobile' => $mobile])
            ->get('customers');

        if ($pupose === "SignUp") {
              $mcode = rand(1111, 9999);
            $msg = "OTP for SignUp as a customer is ". $mcode . ". Don't share OTP with anyone for security reasons";

            ## Check for SignUp
            if ($query->num_rows() === 0) {
                $this->send_otp($mobile,$msg,$mcode);
            }
            else {
                $response = array(
                    'check' => $this->CHECK_TYPE_FAILURE,
                    'message' => 'Mobile No. is already exist'
                );
                echo json_encode($response);
            }
        }
        else {
            ## Check for Reset Password
            if ($query->num_rows() === 1) {
                 $mcode = rand(1111, 9999);
             $msg = "OTP for forgot password is $mcode. Don't share OTP with anyone for security reasons.";
                $this->send_otp($mobile,$msg,$mcode);
            }
            else {
                $response = array(
                    'check' => $this->CHECK_TYPE_FAILURE,
                    'message' => 'Account not exist'
                );
                echo json_encode($response);
            }
        }
    }

    /**
     * @Desc: Customer Sign Up
     */
    public function signup () {
        ## Load Wallet Model
        $this->load->model('wallet');

        $cutomer_code = $this->generate_customer_code();
        $datetime = date('Y-m-d H:i:s');
        $default_amount = 0;

        ## Insert into customers table
        $data = array(
            'cust_code' => $cutomer_code,
            'full_name' => ucwords(strtolower($this->input->post('full_name', TRUE))),
            'mobile' => $this->input->post('mobile', TRUE),
            'password' => md5($this->input->post('password', TRUE)),
            'm_verified' => 'Y',
            'mcode' => $this->input->post('mcode', TRUE),
            'created_on' => $datetime
        );

        $this->db->insert('customers', $data);
        $id = $this->db->insert_id();
        $data['id'] = $id;

        ## Insert into wallet table
        $this->wallet->add_balance($cutomer_code, $default_amount);
        $data['amount'] = $default_amount;

        ## Insert into wallet_trans table
        $wallet_transaction_data = array(
            'cust_code' => $cutomer_code,
            'amount' => $default_amount,
            'purpose' => $this->PURPOSE_OPENING_BALANCE,
            'type' => $this->TYPE_CREDIT,
        );
        $this->wallet->add_transaction($wallet_transaction_data);

        unset($data['password']);
        unset($data['m_verified']);
        unset($data['mcode']);
        unset($data['created_on']);

        $response = array(
            'check' => $this->CHECK_TYPE_SUCCESS,
            'data' => $data
        );

        echo json_encode($response);
    }

    /**
     * @Desc: User Sign In
     */
    public function signin () {
        $mobile = $this->input->post('mobile', TRUE);
       // print_r($_POST);
        $password = $this->input->post('password', TRUE);
        $response = array('check' => $this->CHECK_TYPE_SUCCESS);

        $query = $this->db
            ->select(['customers.id', 'customers.cust_code', 'full_name', 'mobile', 'password', 'amount'])
            ->where(['customers.mobile' => $mobile, 'customers.is_deleted'=>'0'])
            ->join('wallet', 'customers.cust_code = wallet.cust_code', 'inner')
            ->get('customers');
        $result = $query->row_array();
       // echo $this->db->last_query();exit;

        if (isset($result)) {
            if (md5($password) === $result['password']) {
                unset($result['password']);
                $response['data'] = $result;
            }
            else {
                $response['check'] = $this->CHECK_TYPE_FAILURE;
                $response['message'] = 'Wrong Password';
            }
        }
        else {
            $response['check'] = $this->CHECK_TYPE_FAILURE;
            $response['message'] = 'Account does not exist';
        }

        echo json_encode($response);
    }

    /**
     * @Reset Password
     */
    public function reset_password () {
        $mobile = $this->input->post('mobile', TRUE);
        $password = $this->input->post('password', TRUE);
        $mcode = $this->input->post('mcode', TRUE);

        $set = array(
            'password' => md5($password),
            'mcode' => $mcode
        );
        $this->db->where(['mobile' => $mobile])->update('customers', $set);

        $response = array(
            'check' => $this->CHECK_TYPE_SUCCESS,
            'message' => 'Password reset successfully'
        );
        echo json_encode($response);
    }

    /**
     * @Desc: Save Device Token for Push Notification
     */
    public function save_device_token () {
        $cust_code = $this->input->post('cust_code', TRUE);
        $token = $this->input->post('token', TRUE);

        $query = $this->db
            ->select(['token'])
            ->where(['cust_code' => $cust_code])
            ->get('device_token');

        if ($query->num_rows() === 1) {
            $set = array('token' => $token);
            $this->db->where(['cust_code' => $cust_code])->update('device_token', $set);
        }
        else {
            $insert_data = array(
                'cust_code' => $cust_code,
                'token' => $token
            );
            $this->db->insert('device_token', $insert_data);
        }

        $response = array(
            'check' => $this->CHECK_TYPE_SUCCESS,
            'message' => 'Device Token Saved'
        );
        echo json_encode($response);
    }

    /**
     * Remove Device Token
     */
    public function remove_device_token () {
        $cust_code = $this->input->post('cust_code', TRUE);
        $this->db->where(['cust_code' => $cust_code])->delete('device_token');

        $response = array(
            'check' => $this->CHECK_TYPE_SUCCESS,
            'message' => 'Device Token Removed'
        );
        echo json_encode($response);
    }

    /**
     * @Desc: Get Customer's Info
     */
    public function customer_info ($mobile) {
        $query = $this->db
            ->select(['customers.id', 'customers.cust_code', 'full_name', 'mobile', 'amount'])
            ->where(['mobile' => $mobile])
            ->join('wallet', 'customers.cust_code = wallet.cust_code', 'inner')
            ->get('customers');

        $response = $query->row_array();
        echo json_encode($response);
    }

    /**
     * @Desc: Get Wallet Balance
     */
    public function wallet_balance ($cust_code) {
        $this->load->model('wallet');
        $amount = $this->wallet->get_balance($cust_code);
        echo json_encode($amount);
    }

    /**
     * @Desc: Get News
     */
    public function news () {
        $query = $this->db
            ->select(['id', 'news'])
            ->where(['status' => 'Y'])
            ->get('news_update');

        $result = $query->result_array();
        echo json_encode($result);
    }

    /**
     * @Desc: Get Carousel Data
     */
    public function carousel () {
        $query = $this->db
            ->select(['id', 'attachment'])
            ->where(['status' => 'Y'])
            ->get('slider');

        $response = [];
        $result = $query->result_array();
        foreach ($result as $row) {
            $row['attachment'] = base_url() . 'uploads/carousel/' . $row['attachment'];
            $response[] = $row;
        }

        echo json_encode($response);
    }

    /**
     * @Desc: Game Category
     */
    public function categories () {
        $query = $this->db
            ->select(['id', 'label', 'cat_name', 'image'])
            ->where(['status' => 'Y'])
            ->order_by('id DESC')
            ->get('category');

        $response = [];
        $result = $query->result_array();
        foreach ($result as $row) {
            $row['image'] = base_url() . 'uploads/category/' . $row['image'];
            $response[] = $row;
        }

        echo json_encode($response);
    }

    /**
     * @Desc: Game
     */
    public function games () {
        $category_id = $this->input->post_get('category', TRUE);

        $sql = "
        SELECT
            game.id,
            game.gcode,
            game.name,
            game.image,
            game.minum_coin,
            game.play_day,
            category.cat_name,
            game.slot_id,
            slot.start_time,
            slot.end_time
        FROM
            game
        INNER JOIN category ON game.cat_id = category.id
        INNER JOIN slot ON game.slot_id = slot.id
        WHERE
            game.cat_id = " . $category_id . " AND game.status = 'Y'
        ORDER BY
            game.id ASC
        ";

        $query = $this->db->query($sql);
        $result = $query->result_array();

        $response = [];
        $current_day = date('l');
        foreach ($result as $row) {
            $row['minum_coin'] = !empty($row['minum_coin']) ? $row['minum_coin'] : "5";
            $row['image'] = base_url() . 'uploads/game/' . $row['image'];

            $play_days = json_decode(stripslashes($row['play_day']), TRUE);
            unset($row['play_day']);

            if (count($play_days) > 0) {
                if (in_array($current_day, $play_days)) {
                    $response[] = $row;
                }
            }
            else {
                $response[] = $row;
            }
        }

        echo json_encode($response);
    }

    /**
     * @Desc: Amount Deposit Request
     */
    public function deposit_request () {
        date_default_timezone_set('Asia/Kolkata');
        $response = array('check' => $this->CHECK_TYPE_FAILURE);
        $txn_modes = array('bank_account', 'gpay', 'paytm', 'phonepe', 'upi');

        $cust_code = $this->input->post('cust_code', TRUE);
        $amount = $this->input->post('amount', TRUE);
        $txn_ref_id = $this->input->post('txn_ref_id', TRUE);
        $txn_mode = $this->input->post('type', TRUE);

        
        $query = $this->db
            ->select('min_deposit_amount')
            ->where(['id' => 1])
            ->get('settings');
        $result = $query->row_array();
        $min_deposit_amount = intval($result['min_deposit_amount']);

        if (empty($cust_code)) {
            $response['message'] = 'Invalid customer id';
        }
        elseif (!filter_var($amount, FILTER_VALIDATE_INT)) {
            $response['message'] = 'Amount must be an integer';
        }
        elseif(intval($amount) < $min_deposit_amount) {
            $response['message'] = 'Minimum deposit amount is ' . $min_deposit_amount;
        }
        elseif (empty($txn_ref_id)) {
            $response['message'] = 'Invalid transaction reference id';
        }
        elseif (!in_array($txn_mode, $txn_modes)) {
            $response['message'] = 'Invalid transaction mode';
        }
        else {
            $data = array(
                'cust_code' => $cust_code,
                'txn_ref_id' => $txn_ref_id,
                'amount' => $amount,
                'type' => $txn_mode,
                'requested_on' => date('Y-m-d H:i:s'),
                'request_time' => date('Y-m-d H:i:s')
            );

            $this->db->insert('add_money', $data);
            $response['check'] = $this->CHECK_TYPE_SUCCESS;
            $response['message'] = 'Deposit Request sent.';
        }

        echo json_encode($response);
    }

    /**
     * @Desc: Amount Deposit History
     */
    public function deposit_history ($cust_code) {
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime($end . ' - 29 days'));

        $sql = "
        SELECT
            id,
            txn_ref_id,
            amount,
            requested_on,
            request_time,
            status
        FROM
            add_money
        WHERE
            cust_code = '$cust_code' AND DATE(requested_on) BETWEEN '$start' AND '$end'
        ORDER BY
            requested_on DESC
        ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        
        $response = array();
        foreach ($result as $row) {
            $requested_on = $row['request_time'];
            $date = date('Y-m-d', strtotime($requested_on));
            $timestamp = strtotime($date);
            $data = array(
                'id' => $row['id'],
                'txn_ref_id' => $row['txn_ref_id'],
                'amount' => $row['amount'],
                'requested_on' => $requested_on,
                'status' => $row['status']
            );

            $key = array_search($timestamp, array_column($response, 'id'));
            if (gettype($key) === "integer") {
                $response[$key]['data'][] = $data;
            }
            else {
                $response[] = array(
                    'id' => (string) $timestamp,
                    'date' => $date,
                    'data' => array($data)
                );
            }
        }

        echo json_encode($response);
    }

    /**
     * @Desc: Amount Withdraw Request
     */
    public function withdraw_request () {
        date_default_timezone_set('Asia/Kolkata');
        $cust_code = $this->input->post('cust_code', TRUE);
        $amount = $this->input->post('amount', TRUE);
        $response = array('check' => $this->CHECK_TYPE_FAILURE);

        ## Check if any pending request is present or not
        $query = $this->db
            ->select(['id'])
            ->where(['cust_code' => $cust_code, 'status' => 'P'])
            ->get('withdraw_money');

        if ($query->num_rows() > 0) {
            $response['check'] = $this->CHECK_TYPE_FAILURE;
            $response['message'] = 'Alerady have pending withdraw request.';
        }
        else {
            $this->load->model('wallet');
            $wallet_balance = $this->wallet->get_balance($cust_code);

            if (intval($amount) <= intval($wallet_balance)) {
                $data = array(
                    'cust_code' => $cust_code,
                    'amount' => $amount,
                    'requested_on' => date('Y-m-d H:i:s'),
                    'request_time' => date('Y-m-d H:i:s')
                );
                $this->db->insert('withdraw_money', $data);

                $response['check'] = $this->CHECK_TYPE_SUCCESS;
                $response['message'] = 'Request Sent.';
            }
            else {
                $response['check'] = $this->CHECK_TYPE_FAILURE;
                $response['message'] = 'Insufficient Wallet Balance';
            }
        }

        echo json_encode($response);
    }

    /**
     * @Desc: Amount Withdraw History
     */
    public function withdraw_history ($cust_code) {
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime($end . ' - 29 days'));

        $sql = "
        SELECT
            id,
            txn_ref_id,
            amount,
            requested_on,
            request_time,
            status
        FROM
            withdraw_money
        WHERE
            cust_code = '$cust_code' AND DATE(requested_on) BETWEEN '$start' AND '$end'
        ORDER BY
            requested_on DESC
        ";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        $response = array();
        foreach ($result as $row) {
            $requested_on = $row['request_time'];
            $txn_ref_id = !empty($row['txn_ref_id']) ? $row['txn_ref_id'] : strtotime($row['requested_on']);
            $date = date('Y-m-d', strtotime($requested_on));
            $timestamp = strtotime($date);
            $data = array(
                'id' => $row['id'],
                'txn_ref_id' => (string) $txn_ref_id,
                'amount' => $row['amount'],
                'requested_on' => $requested_on,
                'status' => $row['status']
            );

            $key = array_search($timestamp, array_column($response, 'id'));
            if (gettype($key) === "integer") {
                $response[$key]['data'][] = $data;
            }
            else {
                $response[] = array(
                    'id' => (string) $timestamp,
                    'date' => $date,
                    'data' => array($data)
                );
            }
        }

        echo json_encode($response);
    }

    /**
     * @Desc: Edit Profile
     */
    public function edit_account () {
        $cust_code = $_POST['cust_code'];
        $response = array('check' => $this->CHECK_TYPE_SUCCESS);
        $set = array();

        if (isset($_POST['full_name'])) {
            $set['full_name'] = $_POST['full_name'];
            $response['message'] = 'Changes made successfully';
        }

        if (isset($_POST['password'])) {
            $set['password'] = md5($_POST['password']);
            $response['message'] = 'Password changed';
        }

        if (isset($_POST['acc_number'])) {
            $set['acc_number'] = $_POST['acc_number'];
            $set['bank_name'] = ucwords(strtolower($_POST['bank_name']));
            $set['ifsc_code'] = strtoupper($_POST['ifsc_code']);
            $set['branch'] = ucwords(strtolower($_POST['branch']));
            $set['ac_holder'] = ucwords(strtolower($_POST['ac_holder']));
            $response['message'] = 'Bank details updated';
        }

        if (isset($_POST['paytm_number'])) {
            $set['paytm_number'] = $_POST['paytm_number'];
            $response['message'] = 'Paytm details updated';
        }

        if (isset($_POST['gpay_number'])) {
            $set['gpay_number'] = $_POST['gpay_number'];
            $response['message'] = 'Google Pay details updated';
        }

        if (isset($_POST['phonepay_number'])) {
            $set['phonepay_number'] = $_POST['phonepay_number'];
            $response['message'] = 'PhonePe details updated';
        }

        if (isset($_POST['upi'])) {
            $set['upi'] = $_POST['upi'];
            $response['message'] = 'UPI details updated';
        }

        $this->db->where(['cust_code' => $cust_code])->update('customers', $set);
        echo json_encode($response);
    }

    /**
     * @Desc: Get Account Details
     */
    public function account_info ($cust_code) {
        $query = $this->db
            ->select(['acc_number', 'bank_name', 'ifsc_code', 'branch', 'ac_holder', 'paytm_number', 'gpay_number', 'phonepay_number', 'upi', 'full_name','is_deleted'])
            ->where(['cust_code' => $cust_code])
            ->get('customers');

        $response = $query->row_array();
        echo json_encode($response);
    }

    /**
     * @Desc: Add Bidding
     */
    public function add_bidding () {
        ## Load Wallet Model
        $this->load->model('wallet');

        $cust_code = $this->input->post('cust_code');
        $game_code = $this->input->post('game_code');
        $type = $this->input->post('type');
        $bid_on = date('Y-m-d');
        $bid_time = date('H:i:s');
        $bid_data = json_decode(stripslashes($this->input->post('bid_data')), TRUE);
        // $numbers = array_column($bid_data, 'number');

        // $sql = "select c.status from game as g left join category as c on c.id = g.cat_id where c.status == 'Y' and g.gcode = '".$game_code."'";
        // $query = $this->db->query($SQL);
        // $result = $query->result_array();

        // if(empty($result)){
        //     $response['check'] = $this->CHECK_TYPE_FAILURE;
        //     $response['message'] = "Game is not available today";
        //     echo json_encode($response);exit;
        // }


        ## Get Total Bid Amount
        $total_bid_amount = 0;
        foreach ($bid_data as $value) {
            $total_bid_amount += intval($value['amount']);
        }

        ## Set Response
        $response = array(
            'check' => $this->CHECK_TYPE_SUCCESS,
            'message' => 'Thanks for bidding'
        );


        // If user try to pakami
        $sql = "SELECT s.* 
        FROM slot AS s 
        INNER JOIN game AS g ON g.slot_id = s.id
        WHERE g.gcode = ?";

        $slotInfo = $this->db->query($sql, [$game_code])->row();

        if($slotInfo) {
            $currentDate = date('Y-m-d');

            $startTimeSlot = $currentDate . ' ' .  $slotInfo->start_time;
            $startTime = new \DateTime($startTimeSlot);
    
            $now = time();
            // if( $now <  $startTime->getTimestamp() ) {
            //      deduct user wallet balance without any records
            //     $sql = "UPDATE wallet SET amount = amount - ? WHERE cust_code = ?";
            //     $this->db->query($sql, [$total_bid_amount, $cust_code]);
            //     echo json_encode($response); die;
            // }
    
            $endTimeSlot = $currentDate . ' ' . $slotInfo->end_time;
            $endTime = new \DateTime($endTimeSlot);
    
            if( $now > $endTime->getTimestamp() ) {
                // deduct user wallet balance without any records
                $sql = "UPDATE wallet SET amount = amount - ? WHERE cust_code = ?";
                $this->db->query($sql, [$total_bid_amount, $cust_code]);
                echo  json_encode($response); die;
            }
        }

        ## Get Wallet Balance
        $wallet_balance = $this->wallet->get_balance($cust_code);

        if (intval($total_bid_amount) <= intval($wallet_balance)) {
            /*$sql = "
            SELECT
                id,
                number,
                amount
            FROM
                bidding
            WHERE
                cust_code = '$cust_code' AND game_code = '$game_code' AND DATE(bid_on) = '$bid_on' AND number IN (" . implode(",", $numbers) .")
            ";
            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $batch_update_data = array();
                $result = $query->result_array();

                foreach ($result as $row) {
                    $key = array_search($row['number'], array_column($bid_data, 'number'));

                    $batch_update_data[] = array(
                        'id' => $row['id'],
                        'amount' => intval($row['amount']) + intval($bid_data[$key]['amount']),
                        'bid_on' => $bid_on . " " . $bid_time
                    );

                    ## remove element from array
                    unset($bid_data[$key]);

                    ## Rebase array
                    $bid_data = array_merge($bid_data);
                }

                $this->db->update_batch('bidding', $batch_update_data, 'id');
            }*/

            if (count($bid_data) > 0) {
                $insert_data = array();

                foreach ($bid_data as $value) {
                    $insert_data[] = array(
                        'cust_code' => $cust_code,
                        'game_code' => $game_code,
                        'type' => $type,
                        'number' => $value['number'],
                        'amount' => $value['amount'],
                        'bid_on' => $bid_on ." " . $bid_time,
                    );
                }

                $this->db->insert_batch('bidding', $insert_data);

                ## Update Wallet Balance
                $this->wallet->deduct_balance($cust_code, $total_bid_amount);

                ## Create Wallet Transaction
                $wallet_transaction_data = array(
                    'cust_code' => $cust_code,
                    'amount' => $total_bid_amount,
                    'purpose' => "Bidding",
                    'type' => $this->TYPE_DEBIT,
                    'txn_reference' => $game_code
                );
                $this->wallet->add_transaction($wallet_transaction_data);
            }
            else {
                $response['check'] = $this->CHECK_TYPE_FAILURE;
                $response['message'] = "Empty bid data";
            }
        }
        else {
            $response['check'] = $this->CHECK_TYPE_FAILURE;
            $response['message'] = "Insufficient Wallet Balance";
        }

        echo json_encode($response);
    }

    /**
     * @Desc: Bid History
     */
    public function bid_history () {
        $cust_code = $this->input->post_get('cust_code', TRUE);
        $type =$this->input->post_get('type', TRUE);
        $category_id = $this->input->post_get('category_id', TRUE);

        $end = date('Y-m-d');
        // $start = date('Y-m-d', strtotime($end . ' - 29 days'));
        $start = date('Y-m-d', strtotime($end . ' - 7 days'));

        if($type == 'Jodi'){
            //Get all active Game for posted cat
            $sql = "select name from game where status = 'Y' and cat_id = '".$category_id."'";
            $query = $this->db->query($sql);
            $all_game_result = array_column($query->result_array(), 'name');
        }

        $sql = "
        SELECT
            bidding.id,
            bidding.type,
            game.name AS game_title,
            bidding.number,
            bidding.amount,
            bidding.bid_on,
            bidding.status
        FROM
            bidding
        INNER JOIN game ON bidding.game_code = game.gcode
        WHERE
            bidding.cust_code = '$cust_code' AND bidding.type = '$type' AND DATE(bidding.bid_on) BETWEEN '$start' AND '$end' AND bidding.game_code IN(
            SELECT
                game.gcode
            FROM
                game
            WHERE
                game.cat_id = $category_id
        )
        ORDER BY
            bidding.bid_on DESC
        ";

        $query = $this->db->query($sql);
        $result = $query->result_array();

        $response = array();
        foreach ($result as $row) {
            $bid_on = $row['bid_on'];
            $date = date('Y-m-d', strtotime($bid_on));
            $timestamp = strtotime($date);



            if($type == 'Jodi'){
                $current_game_index = array_search($row['game_title'], $all_game_result);
                $row['game_title'] = $all_game_result[$current_game_index-1];
            }

            $data = array(
                'id' => $row['id'],
                'game_title' => $row['game_title'],
                'bid_on' => $bid_on,
                'number' => $row['number'],
                'amount' => $row['amount'],
                'status' => $row['status']
            );

            $key = array_search($timestamp, array_column($response, 'id'));
            if (gettype($key) === "integer") {
                $response[$key]['data'][] = $data;
            }
            else {
                $response[] = array(
                    'id' => (string) $timestamp,
                    'date' => $date,
                    'data' => array($data)
                );
            }
        }

        echo json_encode($response);
    }

    /**
     * @Desc: Game Result
     */
    public function game_result () {
        $category_id = $this->input->post_get('category_id', TRUE);
        $active_tab = $this->input->post_get('active_tab', TRUE);
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime($end . ' - 29 days'));

        $sql = "
        SELECT
            game_result.id,
            game_result.game_code,
            game.id AS game_id,
            game.name AS game_name,
            game_result.type,
            game_result.win_number,
            game_result.published_on
        FROM
            game_result
        INNER JOIN game ON game_result.game_code = game.gcode
        WHERE
            DATE(game_result.published_on) BETWEEN '$start' AND '$end' AND game_result.game_code IN(
            SELECT
                game.gcode
            FROM
                game
            WHERE
                game.cat_id = $category_id
        )
        ORDER BY
            game_result.published_on DESC
        ";

        $query = $this->db->query($sql);
        $result = $query->result_array();

        $response = array();
        foreach ($result as $row) {
            $date = date('Y-m-d', strtotime($row['published_on']));
            $timestamp = strtotime($date);
            $game_id = $row['game_id'];
            $game_name = ucwords(strtolower($row['game_name']));
            $type = $row['type'];
            $game_code = $row['game_code'];
            $win_number = $row['win_number'];
            $key = array_search($timestamp, array_column($response, 'id'));

            if (gettype($key) === "integer") {
                $data_array = $response[$key]['data'];
                $data_index = array_search($game_code, array_column($data_array, 'game_code'));

                if (gettype($data_index) === "integer") {
                    $data_array[$data_index][$type] = $win_number;
                }
                else {
                    $data_array[] = array(
                        'game_id' => $game_id,
                        'game_code' => $game_code,
                        'game_name' => $game_name,
                        $type => $win_number
                    );
                }

                ## Array Sort
                $game_ids_arr  = array_column($data_array, 'game_id');
                array_multisort($game_ids_arr, SORT_NUMERIC, $data_array);

                ## Set updated array
                $response[$key]['data'] = $data_array;
            }
            else {
                $response[] = array(
                    'id' => (string) $timestamp,
                    'date' => $date,
                    'data' => array(
                        array(
                            'game_id' => $game_id,
                            'game_code' => $game_code,
                            'game_name' => $game_name,
                            $type => $win_number
                        )
                    )
                );
            }
        }

        echo json_encode($response);
    }

    /**
     * @Desc: Get Support Details:
     */
    public function support_details () {
        $query = $this->db
            ->select(['phone_no', 'whatsapp_no', 'email'])
            ->where(['id' => 1])
            ->get('support');

        $response = $query->row_array();
        $response['phone_no'] = str_replace("+91", "", $response['phone_no']);
        $response['whatsapp_no'] = str_replace("+91", "", $response['whatsapp_no']);
        echo json_encode($response);
    }

    /**
     * @Desc: Get All Settings Data
     */
    public function settings () {

        $query = $this->db
            ->select(['email', 'whatsapp_number', 'mobile_number', 'min_deposit_amount', 'min_withdraw_amount', 'rules_page_url', 'share_msg', 'game_off', 'game_off_reason', 'game_off_image','withdraw_req_instruction','withdraw_req_start','withdraw_req_end'])
            ->where(['id' => 1])
            ->get('settings');

        $response = array();
        $result = $query->row_array();

        foreach ($result as $key => $value) {
            $response[$key] = $value != '' ? $value : NULL;
        }

        echo json_encode($response);
    }

    /**
     * @Desc: Get All Settings Data
     */
    public function trans () {
      $cust_code = 'CUST000001';
        $query = $this->db
            ->select('*')
            ->where(['cust_code' => $cust_code])
            ->where('txn_reference IS NOT ', NULL)
            ->get('wallet_trans');

        $response = array();
        $result = $query->result_array();

        foreach ($result as $key => $value) {
            $response[$key] = $value != '' ? $value : NULL;
        }

        echo json_encode($response);
    }

    /**
     * @Desc: Get All Transactions of a Customer
     */
    public function transactions () {
        $cust_code = $this->input->get('cust_code', TRUE);
        $page = !empty($this->input->get('page', TRUE)) ? intval($this->input->get('page', TRUE)) : 1;
        $records_per_page = !empty($this->input->get('limit', TRUE)) ? intval($this->input->get('limit', TRUE)) : 10;
        $start = ($page * $records_per_page) - $records_per_page;

        // $query = $this->db
        //     ->select(['id', 'trans_code', 'amount', 'type', 'purpose', 'created_on'])
        //     ->where(['cust_code' => $cust_code])
        //     ->order_by('created_on DESC')
        //     ->limit($records_per_page, $start)
        //     ->get('wallet_trans');

        //Right now returning all data need to place some limit but putting only limit will not work compare this
        //Query with above query and issue can be found
            $query = $this->db
            ->select(['id', 'trans_code', 'amount', 'type', 'purpose', 'created_on'])
            ->where(['cust_code' => $cust_code])
            ->get('wallet_trans');

        $result = $query->result_array();
        $response = array(
            'requested_records' => (string) $records_per_page,
            'records_in_response' => (string) count($result),
            'data' => array_reverse($result)
        );

        echo json_encode($response);
    }
    
    public function new_transactions () {
        $cust_code = $this->input->get('cust_code', TRUE);
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime($end . ' - 7 days'));
        if(is_null($cust_code)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'customer code is required'
            ]);
            die;
        }
         
        $sql = "SELECT g.name AS game_name, c.id AS cat_id, c.label, w_t.* 
        FROM wallet_trans AS w_t
        LEFT JOIN game AS g ON g.gcode = w_t.txn_reference
        LEFT JOIN category AS c ON g.cat_id = c.id
        WHERE w_t.cust_code = ? AND DATE(w_t.created_on) BETWEEN ? AND ?
        ORDER BY w_t.created_on ASC";
        
        $query = $this->db->query($sql, [$cust_code,$start,$end]);
        $customerWalletData = $query->result_array();
        $totalRecords = count($customerWalletData);
        
        $finalData = [];
        for($i = 0; $i <$totalRecords; $i++) {
            $tempData = $customerWalletData[$i];
            $cat_id = $tempData['cat_id'];
            $amount = $tempData['amount'];
            
            $gameCode = $tempData['txn_reference'];
            $bidOnDate = $tempData['created_on'];
            if($tempData['purpose'] == 'Bidding') {
                // find bidding data
                $sql = "SELECT type AS game_type, number, amount
                FROM bidding
                WHERE cust_code = ? AND game_code = ? AND bid_on = ?";
        
                $query = $this->db->query($sql, [$cust_code, $gameCode, $bidOnDate]);
                $customerBiddingData = $query->result_array();
              
                $tempData['trans_desp'] = 'Played ' . $tempData['label'] . ' ';
                $tempData['trans_desp'] .= $tempData['game_name'] . ' ';
    
                $totalAmount = 0;
                foreach($customerBiddingData as $biddingData) {
                    $totalAmount += $biddingData['amount'];
                    $tempData['trans_desp'] .= $biddingData['number'] . '(' . $biddingData['amount'] .')' . ' ';
                }
                $tempData['point'] = $totalAmount;
            } elseif($tempData['purpose'] == 'Winning Price') {
    
                $bidOnDate = (new \DateTime($bidOnDate))->format('Y-m-d');
                $sql = "SELECT type AS game_type, number, amount
                FROM bidding
                WHERE cust_code = ? AND game_code = ? AND  DATE(bid_on) = ? AND status='W'";
                
                $query = $this->db->query($sql, [$cust_code, $gameCode, $bidOnDate]);
                $customerWinningBids = $query->result_array();
           
    
                $tempData['trans_desp'] = 'Winning Price for ' . $tempData['label'] . ' ' . $tempData['game_name'];
                $types = array_column($customerWinningBids, 'game_type');
    
             
                if(!is_null($cat_id) && !empty($types) ) {
                    $sql = "SELECT * FROM wining_price WHERE cat_id = ? AND game_type IN ?";
                    $query = $this->db->query($sql, [$cat_id, $types ]);
                    $winingPriceConfigs = $query->result_array();
    
                    $tempBids = [];
                    foreach($winingPriceConfigs as $priceConfig) {
    
                        $key = array_search($priceConfig['game_type'], array_column($customerWinningBids, 'game_type'));
                        $getBidAmount = $customerWinningBids[$key]['amount'];
    
                        if($priceConfig['type'] == 'Percentage') {
                            // caluclate amount
                            $totalAmount = floatval($getBidAmount) + (floatval($getBidAmount) * floatval($priceConfig['value']) * 0.01);
                            if($totalAmount == $amount) {
                                $tempBids[] = $customerWinningBids[$key];
                            }
                        } else if($priceConfig['type'] == 'Multiply') {
                            $totalAmount = floatval($getBidAmount) * floatval($priceConfig['value']);
                            if($totalAmount == $amount) {
                                $tempBids[] = $customerWinningBids[$key];
                            }
                        }
                    }
                    
                    if(!empty($tempBids)) {
                        foreach($tempBids as $customerWinningBid) {
                            $tempData['trans_desp'] .= ' ' . $customerWinningBid['number'] . '('. number_format($customerWinningBid['amount'], 2) .')';
                        }
                    }
                } else {
                    foreach($customerWinningBids as $customerWinningBid) {
                        $tempData['trans_desp'] .= ' ' . $customerWinningBid['number'] . '('. number_format($customerWinningBid['amount'], 2) .')';
                    }  
                }
                
                $tempData['point'] = $customerWalletData[$i]['amount'];
            } else {
                $tempData['point'] = $customerWalletData[$i]['amount'];
                $tempData['trans_desp'] = $tempData['purpose'];
            }
        
            $customerWalletBalance = 0;
            // echo "<pre>";
            // print_r($customerWalletData);
            // echo $customerWalletData[$i]['amount'].$i.$customerWalletData[$i]['type']."<- <br>";
            if($customerWalletData[$i]['amount'] > 0){
                $customerWalletBalance = $customerWalletData[$i]['amount'];
            }else{
                $customerWalletBalance = -($customerWalletData[$i]['amount']);
            }
            if($i == 0) {
                $tempData['previous_amount'] =  $customerWalletData[0]['amount'];
                $tempData['current_amount'] = ($customerWalletData[$i]['type'] == 'CR') ? $tempData['previous_amount'] + $customerWalletBalance :  $tempData['previous_amount'] - $customerWalletBalance;
            
            } else {
                $tempData['previous_amount'] = $finalData[$i-1]['current_amount'];
                $tempData['current_amount'] = ($customerWalletData[$i]['type'] == 'CR') ? $tempData['previous_amount'] + $customerWalletBalance : $tempData['previous_amount'] - $customerWalletBalance;
            }
            
            $tempData['current_amount'] = floatval($tempData['current_amount']);
            
            $finalData[] = $tempData;
        }
        
        foreach($finalData as &$data){
            $data['current_amount'] = number_format($data['current_amount'], 2);
            $data['point'] = number_format($data['point'], 2);
        }
        
        echo json_encode(array_reverse($finalData)); die;
    }



    public function modified_transactions () {
        $cust_code = $this->input->get('cust_code', TRUE);
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime($end . ' - 2 days'));
        // $start = date('Y-m-d');
        // $end = date('Y-m-d', strtotime($start . ' + 1 days'));
        if(is_null($cust_code)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'customer code is required'
            ]);
            die;
        }
         
        $sql = "SELECT g.name AS game_name, c.id AS cat_id, c.label, w_t.* 
        FROM wallet_trans AS w_t
        LEFT JOIN game AS g ON g.gcode = w_t.txn_reference
        LEFT JOIN category AS c ON g.cat_id = c.id
        WHERE w_t.cust_code = ? AND DATE(w_t.created_on) BETWEEN ? AND ?
        ORDER BY w_t.created_on ASC";
        
        $query = $this->db->query($sql, [$cust_code,$start,$end]);
        $customerWalletData = $query->result_array();
        $totalRecords = count($customerWalletData);
        
        $finalData = [];
        for($i = 0; $i <$totalRecords; $i++) {
            $tempData = $customerWalletData[$i];
            $cat_id = $tempData['cat_id'];
            $amount = $tempData['amount'];
            
            $gameCode = $tempData['txn_reference'];
            $bidOnDate = $tempData['created_on'];
            if($tempData['purpose'] == 'Bidding') {
                // find bidding data
                $sql = "SELECT type AS game_type, number, amount
                FROM bidding
                WHERE cust_code = ? AND game_code = ? AND bid_on = ?";
        
                $query = $this->db->query($sql, [$cust_code, $gameCode, $bidOnDate]);
                $customerBiddingData = $query->result_array();
              
                $tempData['trans_desp'] = 'Played ' . $tempData['label'] . ' ';
                $tempData['trans_desp'] .= $tempData['game_name'] . ' ';
    
                $totalAmount = 0;
                foreach($customerBiddingData as $biddingData) {
                    $totalAmount += $biddingData['amount'];
                    $tempData['trans_desp'] .= $biddingData['number'] . '(' . $biddingData['amount'] .')' . ' ';
                }
                $tempData['point'] = $totalAmount;
            } elseif($tempData['purpose'] == 'Winning Price') {
    
                $bidOnDate = (new \DateTime($bidOnDate))->format('Y-m-d');
                $sql = "SELECT type AS game_type, number, amount
                FROM bidding
                WHERE cust_code = ? AND game_code = ? AND  DATE(bid_on) = ? AND status='W'";
                
                $query = $this->db->query($sql, [$cust_code, $gameCode, $bidOnDate]);
                $customerWinningBids = $query->result_array();
           
    
                $tempData['trans_desp'] = 'Winning Price for ' . $tempData['label'] . ' ' . $tempData['game_name'];
                $types = array_column($customerWinningBids, 'game_type');
    
             
                if(!is_null($cat_id) && !empty($types) ) {
                    $sql = "SELECT * FROM wining_price WHERE cat_id = ? AND game_type IN ?";
                    $query = $this->db->query($sql, [$cat_id, $types ]);
                    $winingPriceConfigs = $query->result_array();
    
                    $tempBids = [];
                    foreach($winingPriceConfigs as $priceConfig) {
    
                        $key = array_search($priceConfig['game_type'], array_column($customerWinningBids, 'game_type'));
                        $getBidAmount = $customerWinningBids[$key]['amount'];
    
                        if($priceConfig['type'] == 'Percentage') {
                            // caluclate amount
                            $totalAmount = floatval($getBidAmount) + (floatval($getBidAmount) * floatval($priceConfig['value']) * 0.01);
                            if($totalAmount == $amount) {
                                $tempBids[] = $customerWinningBids[$key];
                            }
                        } else if($priceConfig['type'] == 'Multiply') {
                            $totalAmount = floatval($getBidAmount) * floatval($priceConfig['value']);
                            if($totalAmount == $amount) {
                                $tempBids[] = $customerWinningBids[$key];
                            }
                        }
                    }
                    
                    if(!empty($tempBids)) {
                        foreach($tempBids as $customerWinningBid) {
                            $tempData['trans_desp'] .= ' ' . $customerWinningBid['number'] . '('. number_format($customerWinningBid['amount'], 2) .')';
                        }
                    }
                } else {
                    foreach($customerWinningBids as $customerWinningBid) {
                        $tempData['trans_desp'] .= ' ' . $customerWinningBid['number'] . '('. number_format($customerWinningBid['amount'], 2) .')';
                    }  
                }
                
                $tempData['point'] = $customerWalletData[$i]['amount'];
            } else {
                $tempData['point'] = $customerWalletData[$i]['amount'];
                $tempData['trans_desp'] = $tempData['purpose'];
            }
        
            $customerWalletBalance = 0;
            // echo "<pre>";
            // print_r($customerWalletData);
            // echo $customerWalletData[$i]['amount'].$i.$customerWalletData[$i]['type']."<- <br>";
            if($customerWalletData[$i]['amount'] > 0){
                $customerWalletBalance = $customerWalletData[$i]['amount'];
            }else{
                $customerWalletBalance = -($customerWalletData[$i]['amount']);
            }
            if($i == 0) {
                $tempData['previous_amount'] =  $customerWalletData[0]['prev_amount'];
                $tempData['current_amount'] = $customerWalletData[0]['current_amount'];
            
            } else {
                $tempData['previous_amount'] = $customerWalletData[$i]['prev_amount'];
                $tempData['current_amount'] = $customerWalletData[$i]['current_amount'];
            }
            
            $tempData['current_amount'] = floatval($tempData['current_amount']);
            
            $finalData[] = $tempData;
        }
        
        foreach($finalData as &$data){
            $data['current_amount'] = number_format($data['current_amount'], 2);
            $data['point'] = number_format($data['point'], 2);
        }
        
        echo json_encode(array_reverse($finalData)); die;
    }
    
    
    

    /**
     * @Desc:Push Test
     */
    public function test_push () {
        $token = $_REQUEST['token'];

        $req_data = array(
            'to' => $token,
            'title' => 'Test',
            'body' => 'test push notification'
        );

        $headers = array('Content-Type: application/json');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://exp.host/--/api/v2/push/send");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req_data));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec ($ch);
        curl_close ($ch);

        echo json_encode($response);
    }

    public function fetch_notifications(){
      $query = $this->db
          ->select(['id', 'title', 'body'])
          ->limit(30)
          ->order_by("id", "desc")
          ->get('tbl_notification');

      $response = array();
      $result = $query->result_array();

      echo json_encode($result); 
    }


}

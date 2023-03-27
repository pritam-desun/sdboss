<?php
class Report extends CI_Controller
{
    public $commonHelper;
    function __construct()
    {
        parent::__construct();
        check_authentic_user();
        $this->load->model('Report_model', 'report');
        $this->load->helper('commonfunction');
        $this->commonHelper = new CommonFunction;
    }

    public function index()
    {

        $main = array();

        $cat_id = '';
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $cat_id = $this->input->post('cat_id');
            if (isset($_POST['date']) && $_POST['date'] != '') {
                $search = " to ";
                if (preg_match("/{$search}/i", $_POST['date'])) {
                    $dates = explode(' to ', $_POST['date']);
                    $from_date = $dates[0];
                    $to_date = $dates[1];
                } else {
                    $from_date = $_POST['date'];
                    $to_date = $_POST['date'];
                }
            }
        }

        $cat = $this->report->getCategory($cat_id);

        foreach ($cat as $key => $cat_value) {

            //Getting win price details
            $win_price = $this->report->getWiningPrice($cat_value->id);
            $cat_value->win_price = $win_price;
            //Getting Games
            $games = $this->report->getGame($cat_value->id);

            //For total bid amount
            $single_bid_amount = 0;
            $patti_bid_amount = 0;
            $jodi_bid_amount = 0;
            $cp_bid_amount = 0;
            //For sum of win amount
            $single_sum_of_win_amount = 0;
            $patti_sum_of_win_amount = 0;
            $jodi_sum_of_win_amount = 0;
            $cp_sum_of_win_amount = 0;
            foreach ($games as $game) {
                //getting total bid amount for single,patti,jodi,cp
                $total_bid_result = $this->report->getTotalBidingAmount($game->gcode, $from_date, $to_date);
                // $game->total_bid_result = $total_bid_result;
                foreach ($total_bid_result as $bid_result) {
                    if ($bid_result->type == 'Single') {
                        $single_bid_amount += $bid_result->total_bid;
                    }
                    if ($bid_result->type == 'Patti') {
                        $patti_bid_amount += $bid_result->total_bid;
                    }
                    if ($bid_result->type == 'Jodi') {
                        $jodi_bid_amount += $bid_result->total_bid;
                    }
                    if ($bid_result->type == 'CP') {
                        $cp_bid_amount += $bid_result->total_bid;
                    }
                }

                //Getting sum of win amount not toal because total will be after multiplication or percentage
                $sum_win_amount = $this->report->getSumOfWinAmount($game->gcode, $from_date, $to_date);
                // $game->sum_win_amount = $sum_win_amount;
                foreach ($sum_win_amount as $win_result) {
                    if ($win_result->type == 'Single') {
                        $single_sum_of_win_amount += $win_result->total_win;
                    }
                    if ($win_result->type == 'Patti') {
                        $patti_sum_of_win_amount += $win_result->total_win;
                    }
                    if ($win_result->type == 'Jodi') {
                        $jodi_sum_of_win_amount += $win_result->total_win;
                    }
                    if ($win_result->type == 'CP') {
                        $cp_sum_of_win_amount += $win_result->total_win;
                    }
                }

                //Adding toal bid amount
                $cat_value->single_bid_amount = $single_bid_amount;
                $cat_value->patti_bid_amount = $patti_bid_amount;
                $cat_value->jodi_bid_amount = $jodi_bid_amount;
                $cat_value->cp_bid_amount = $cp_bid_amount;

                //Adding sum of win amount
                $cat_value->single_sum_of_win_amount = $single_sum_of_win_amount;
                $cat_value->patti_sum_of_win_amount = $patti_sum_of_win_amount;
                $cat_value->jodi_sum_of_win_amount = $jodi_sum_of_win_amount;
                $cat_value->cp_sum_of_win_amount = $cp_sum_of_win_amount;
            }
            $cat_value->game = $games;
            array_push($main, $cat_value);
        }

        // echo "<pre>";
        // print_r($main);
        // die();   
        $data['main'] = $main;
        $data['cats'] = $cat;
        $this->load->view('layout/header');
        $this->load->view('report/admin', $data);
        $this->load->view('layout/footer');
    }

    public function transaction()
    {
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d');

        $data['transactions'] = [];

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $mobile = $this->input->post('mobile');
            if (isset($_POST['date']) && $_POST['date'] != '') {
                $search = " to ";
                if (preg_match("/{$search}/i", $_POST['date'])) {
                    $dates = explode(' to ', $_POST['date']);
                    $from_date = $dates[0];
                    $to_date = $dates[1];
                } else {
                    $from_date = $_POST['date'];
                    $to_date = $_POST['date'];
                }
            }

            $result = $this->report->getWalletTransactions($mobile, $from_date, $to_date);
            // echo $this->db->last_query();
            $data['transactions'] = $result;
            // print_r($data);
        }

        // echo "here";exit;
        $this->load->view('layout/header');
        $this->load->view('report/transhistory', $data);
        $this->load->view('layout/footer');
    }

    public function commision()
    {
        $main = array();
        $cat_id = '';
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d');
        $cat = $this->report->getCategory($cat_id);
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $cat_id = $this->input->post('cat_id');
            // $cat = $this->report->getCategory($cat_id);
            if (isset($_POST['date']) && $_POST['date'] != '') {
                $search = " to ";
                if (preg_match("/{$search}/i", $_POST['date'])) {
                    $dates = explode(' to ', $_POST['date']);
                    $from_date = $dates[0];
                    $to_date = $dates[1];
                } else {
                    $from_date = $_POST['date'];
                    $to_date = $_POST['date'];
                }
            }

            $commision = $this->report->getCommision();
            $customers = $this->report->getCustomers();

            // print_r($commision['commision']);exit;

            foreach ($customers as $key => $customer) {
                //Getting Games
                $games = $this->report->getGame($cat_id, 'array');
                $game_codes = array_column($games, 'gcode');
                //getting total bid amount for single,patti,jodi,cp
                $total_bid_result = $this->report->getTotalAmount($game_codes, $from_date, $to_date, $customer['cust_code']);
                $customer['total_bid'] = $total_bid_result->total_bid;
                $customer['commision'] = ($total_bid_result->total_bid * $commision['commision']) / 100;
                array_push($main, $customer);
            }

            usort($main, function ($a, $b) {
                return $b['commision'] <=> $a['commision'];
            });
        }

        // echo "<pre>";
        // print_r($main);
        // die();   
        $data['main'] = $main;
        $data['cats'] = $cat;

        // print_r($data);exit;

        $this->load->view('layout/header');
        $this->load->view('report/commision', $data);
        $this->load->view('layout/footer');
    }

    public function distributorreport()
    {
        $data['results'] = NULL;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $distributor_id = $this->input->post('distributor_id');
            if (isset($_POST['date']) && $_POST['date'] != '') {
                $search = " to ";
                if (preg_match("/{$search}/i", $_POST['date'])) {
                    $dates = explode(' to ', $_POST['date']);
                    $from_date = $dates[0];
                    $to_date = $dates[1];
                } else {
                    $from_date = $_POST['date'];
                    $to_date = $_POST['date'];
                }
            }
            //ini_set('memory_limit', '128M');
            //$commision = $this->report->getDistributorReport();
            $this->db->select('SUM(bidding.amount) as amount, DATE_FORMAT(bidding.bid_on, "%d/%m/%Y") as bid_on,  
                                customers.full_name as counter_name, 
                                users.full_name as distributor_name, 
                                users.phone_no as distributor_mobile_no, wallet_trans.purpose, SUM(wallet_trans.amount) as win_amount');
            $this->db->where('users.user_id', $distributor_id);
            $this->db->where('DATE(bidding.bid_on) >=', $from_date);
            $this->db->where('DATE(bidding.bid_on) <=', $to_date);
            $this->db->where('wallet_trans.purpose', 'Winning Price');
            $this->db->join('users as dealer', 'users.user_id =dealer.assigned_by_id', 'left');
            $this->db->join('customers', 'dealer.user_id=customers.assigned_by_id', 'left');
            $this->db->join('bidding', 'customers.cust_code=bidding.cust_code', 'left');
            $this->db->join('wallet_trans', 'customers.cust_code=wallet_trans.cust_code', 'left');
            $this->db->group_by('DAY(bidding.bid_on)');
            $data['results'] = $this->db->get('users')->result();

            /* echo $this->db->last_query();
            die; */

            /* echo "<pre>";
            print_r($data['results']);
            die; */
        }
        $data['distributors'] =  $this->db->get_where('users', array('user_type' => 3, 'user_name' => 'distributor'))->result();
        $this->load->view('layout/header');
        $this->load->view('report/distributorreport', $data);
        $this->load->view('layout/footer');
    }

    public function dealerreport()
    {
        $data['results'] = NULL;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dealer_id = $this->input->post('dealer_id');
            if (isset($_POST['date']) && $_POST['date'] != '') {
                $search = " to ";
                if (preg_match("/{$search}/i", $_POST['date'])) {
                    $dates = explode(' to ', $_POST['date']);
                    $from_date = $dates[0];
                    $to_date = $dates[1];
                } else {
                    $from_date = $_POST['date'];
                    $to_date = $_POST['date'];
                }
            }
            //ini_set('memory_limit', '128M');
            //$commision = $this->report->getDistributorReport();
            $this->db->select('users.user_id as user_id, SUM(bidding.amount) as amount, DATE_FORMAT(bidding.bid_on, "%d-%m-%Y") as bid_on,  
                                customers.full_name as counter_name, 
                                users.full_name as dealer_name, 
                                users.phone_no as dealer_mobile_no, wallet_trans.purpose, SUM(wallet_trans.amount) as win_amount');
            $this->db->where('users.user_id', $dealer_id);
            $this->db->where('DATE(bidding.bid_on) >=', $from_date);
            $this->db->where('DATE(bidding.bid_on) <=', $to_date);
            $this->db->where('wallet_trans.purpose', 'Winning Price');
            $this->db->where('bidding.status', 'W');
            $this->db->join('customers', 'users.user_id=customers.assigned_by_id', 'left');
            $this->db->join('bidding', 'customers.cust_code=bidding.cust_code', 'left');
            $this->db->join('wallet_trans', 'customers.cust_code=wallet_trans.cust_code', 'left');
            $this->db->group_by('DAY(bidding.bid_on)');
            $data['results'] = $this->db->get('users')->result();
            /* echo $this->db->last_query();
            die; */
            /* echo "<pre>";
            print_r($data['results']);
            die; */
        }
        $data['dealers'] =  $this->db->get_where('users', array('user_type' => 4, 'user_name' => 'dealer'))->result();
        $this->load->view('layout/header');
        $this->load->view('report/dealerreport', $data);
        $this->load->view('layout/footer');
    }

    public function counterreport()
    {
        $data['results'] = NULL;
        $dealer_id =  $this->input->get('id');
        $date = new DateTime($this->input->get('date'));
        $date = $date->format('Y-m-d');
        //ini_set('memory_limit', '128M');
        //$commision = $this->report->getDistributorReport();
        $this->db->select('bidding.amount as bidding_amount, DATE_FORMAT(bidding.bid_on, "%d-%m-%Y-%h:%i%p") as bid_on,  
                                customers.full_name as counter_name, 
                                customers.mobile as counter_mobile_no, 
                                CASE WHEN `bidding`.`status` = "L" THEN "0  " ELSE `wallet_trans`.`amount` END AS win_amount', FALSE);
        $this->db->where('customers.assigned_by_id', $dealer_id);
        $this->db->where('DATE(bidding.bid_on)', $date);
        $this->db->where('DATE(wallet_trans.created_on)', $date);
        $this->db->where('wallet_trans.purpose', 'Winning Price');
        $this->db->where_in('bidding.status', ['W', 'L']);
        $this->db->join('customers', 'customers.cust_code=bidding.cust_code', 'left');
        $this->db->join('wallet_trans', 'bidding.cust_code=wallet_trans.cust_code', 'right');
        $this->db->group_by('bidding.id');
        $data['results'] = $this->db->get('bidding')->result();

        /*  $data['results'] = $this->db->query("SELECT
        `bidding`.`amount` AS `bidding_amount`,
        DATE_FORMAT(
            bidding.bid_on,
            '%d-%m-%Y-%h:%i%p'
        ) AS bid_on,
        `customers`.`full_name` AS `counter_name`,
        `customers`.`mobile` AS `counter_mobile_no`,
         CASE WHEN `bidding`.`status` = 'L' THEN '0' ELSE `wallet_trans`.`amount`
        
    END AS win_amount
    FROM
        `bidding`
    LEFT JOIN `customers` ON `customers`.`cust_code` = `bidding`.`cust_code`
    RIGHT JOIN `wallet_trans` ON `bidding`.`cust_code` = `wallet_trans`.`cust_code`
    WHERE
        `customers`.`assigned_by_id` = '16' AND DATE(bidding.bid_on) = $date AND DATE(wallet_trans.created_on) = $date AND `wallet_trans`.`purpose` = 'Winning Price' AND `bidding`.`status` IN('W', 'L')
    GROUP BY
        `bidding`.`id`")->result(); */

        /* echo $this->db->last_query();
        die; */
        /* echo "<pre>";
        print_r(array_merge($data['win'], $data['loss']));
        die; */
        // $data['results'] = array_merge($data['win'], $data['loss']);
        /* echo "<pre>";
        print_r($data['results']);
        die; */
        $this->load->view('layout/header');
        $this->load->view('report/counterreport', $data);
        $this->load->view('layout/footer');
    }
}

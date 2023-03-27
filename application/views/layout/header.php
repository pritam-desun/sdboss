<?php
defined('BASEPATH') or exit('No direct script access allowed');

$query = $this->db->query("select *  from settings where id=1");
$settings = $query->row();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?= $settings->app_name ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('backend/') ?>assets/img/favicon.ico" />
    <link href="<?= base_url('backend/') ?>assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="<?= base_url('backend/') ?>assets/js/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?= base_url('backend/') ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('backend/') ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('backend/') ?>assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('backend/') ?>plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
    <!-- END GLOBAL MANDATORY STYLES -->
    <script src="https://kit.fontawesome.com/b3311d77a8.js" crossorigin="anonymous"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="<?= base_url('backend/') ?>assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('backend/') ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('backend/') ?>assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('backend/') ?>assets/css/widgets/modules-widgets.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('backend/') ?>plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('backend/') ?>plugins/bootstrap-range-Slider/bootstrap-slider.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('backend/') ?>plugins/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('backend/') ?>assets/css/forms/switches.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('backend/') ?>plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('backend/') ?>plugins/table/datatable/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('backend/') ?>plugins/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('backend/') ?>plugins/editors/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('backend/') ?>plugins/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('backend/') ?>plugins/datepicker/bootstrap-datepicker.min.css">?>
    <!-- END PAGE LEVEL CUSTOM STYLES -->
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="<?= base_url('backend/') ?>assets/css/elements/miscellaneous.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('backend/') ?>assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('backend/') ?>assets/css/elements/alert.css">
    <script src="<?= base_url('backend/') ?>assets/js/libs/jquery-3.1.1.min.js"></script>
    <style>
        .btn-light {
            border-color: transparent;
        }

        .datepicker td,
        .datepicker th {
            height: auto;
            width: auto;
            padding: 5px;
            font-size: 14px;
        }
    </style>
    <!--  END CUSTOM STYLE FILE  -->


</head>

<body>
    <!--For Loader-->
    <?php $this->load->view('layout/loader') ?>
    <!--First Nav at top-->
    <?php $this->load->view('layout/topnavbar') ?>
    <!--Second Nav between -->
    <?php $this->load->view('layout/middlenav') ?>

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>
        <!--Side Nav-->
        <?php $this->load->view('layout/sidebar') ?>
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
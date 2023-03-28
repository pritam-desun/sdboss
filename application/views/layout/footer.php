<?php
$query = $this->db->query("select *  from settings where id=1");
$settings = $query->row();
?>

<div class="footer-wrapper">
    <div class="footer-section f-section-1">
        <p class="">Copyright © <?= date('Y') ?> <a target="_blank" href="#"> <?= $settings->app_name ?></a>, All rights
            reserved.</p>
    </div>
    <div class="footer-section f-section-2">
        <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                </path>
            </svg></p>
    </div>
</div>
</div>
<!--  END CONTENT AREA  -->

</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->

<script src="<?= base_url('backend/') ?>bootstrap/js/popper.min.js"></script>
<script src="<?= base_url('backend/') ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url('backend/') ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= base_url('backend/') ?>plugins/datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url('backend/') ?>assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="<?= base_url('backend/') ?>assets/js/custom.js"></script>
<script src="<?= base_url('backend/') ?>plugins/highlight/highlight.pack.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="<?= base_url('backend/') ?>plugins/apex/apexcharts.min.js"></script>
<script src="<?= base_url('backend/') ?>assets/js/widgets/modules-widgets.js"></script>
<script src="<?= base_url('backend/') ?>assets/js/dashboard/dash_1.js"></script>
<script src="<?= base_url('backend/') ?>plugins/editors/quill/quill.js"></script>
<script src="<?= base_url('backend/') ?>plugins/flatpickr/flatpickr.js"></script>
<script src="<?= base_url('backend/') ?>plugins/flatpickr/custom-flatpickr.js"></script>
<!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
<script src="<?= base_url('backend/') ?>plugins/table/datatable/datatables.js"></script>


<!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
<script src="<?= base_url('backend/') ?>plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
<script src="<?= base_url('backend/') ?>plugins/table/datatable/button-ext/jszip.min.js"></script>
<script src="<?= base_url('backend/') ?>plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
<script src="<?= base_url('backend/') ?>plugins/table/datatable/button-ext/buttons.print.min.js"></script>
<?php if ($this->router->class == 'settings' || $this->router->class == 'dashboard') { ?>
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<?php } ?>
<?php if ($this->router->class == 'game') { ?>
    <script src="<?= base_url('backend/') ?>plugins/select2/select2.min.js"></script>
    <script src="<?= base_url('backend/') ?>plugins/select2/custom-select2.js"></script>
<?php } ?>
<script>
    $(document).ready(function() {

        $('#customer_name_label').hide();
        $('#customer_name_div').hide();
        $('#amount_label').hide();
        $('#amount_div').hide();
        $('#danger_Alert').hide();
        $('#addition_submit').hide();

        $(document).on('click', '#newsEdit', function(event) {
            //alert('got');
            event.preventDefault();
            var id = $(this).data('id');
            var news = $(this).data('news');
            $('#id_modal').val(id);
            $('#news_modal').val(news);
            $('#newsEditModal').modal('show');
        });

        $(document).on('click', '#sliderEdit', function(event) {
            //alert('got');
            var url = "<?= base_url('uploads/carousel/') ?>";
            event.preventDefault();
            var id = $(this).data('id');
            var image = $(this).data('image');
            $('#id_modal').val(id);
            $('#prev_image').val(image);
            $("#img").attr("src", url + image);
            $('#sliderEditModal').modal('show');
        });

        $(document).on('click', '#catEdit', function(event) {
            alert('got');
            var url = "<?= base_url('uploads/category/') ?>";
            event.preventDefault();
            var id = $(this).data('id');
            var catName = $(this).data('catname');
            var label = $(this).data('label');
            var image = $(this).data('image');
            $('#id_modal').val(id);
            $('#label_modal').val(label);
            $('#prev_image_modal').val(image);
            $('#cat_name_modal').val(catName);
            $("#prv_image").attr("src", url + image);
            $('#editCatModal').modal('show');
        });

        $(document).on('click', '#slotEdit', function(event) {
            //alert('got');
            event.preventDefault();
            var id = $(this).data('id');
            var starttime = $(this).data('starttime');
            var endtime = $(this).data('endtime');
            var cat_id = $(this).data('cat');
            selectElement('inputCatEdit', cat_id);
            $('#id_modal').val(id);
            $('#starttime').val(starttime);
            $('#endtime').val(endtime);
            $('#slotEditModal').modal('show');
        });

        function selectElement(id, valueToSelect) {
            let element = document.getElementById(id);
            element.value = valueToSelect;
        }

        $("#resultCategory").change(function() {
            var cat_id = $(this).val();
            if (cat_id) {
                $.ajax({
                    url: "<?= base_url('playhistory/getTimeSlot') ?>",
                    type: "POST",
                    cache: false,
                    data: {
                        cat_id: cat_id
                    },
                    success: function(data) {
                        $("#slots").html(data);
                    }
                });
            } else {
                $('#slots').html('<option value="">Select Game Category</option>');
            }
        });




        <?php if ($this->router->method == 'slot') { ?>
            var modalToTarget = document.querySelectorAll('.slotModal');
            var f4 = flatpickr(document.querySelectorAll('.starttime'), {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i:ss",
                onOpen: function(selectedDates, dateStr, instance) {
                    modalToTarget.removeAttribute('tabindex');
                },
                onClose: function(selectedDates, dateStr, instance) {
                    modalToTarget.setAttribute('tabindex', -1);
                }
            });
            var f3 = flatpickr(document.querySelectorAll('.endtime'), {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i:ss",
                onOpen: function(selectedDates, dateStr, instance) {
                    modalToTarget.removeAttribute('tabindex');
                },
                onClose: function(selectedDates, dateStr, instance) {
                    modalToTarget.setAttribute('tabindex', -1);
                }
            });
        <?php } ?>
        $('#dataTables').DataTable({
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [{
                        extend: 'copy',
                        className: 'btn'
                    },
                    {
                        extend: 'csv',
                        className: 'btn'
                    },
                    {
                        extend: 'excel',
                        className: 'btn'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn'
                    },
                    {
                        extend: 'print',
                        className: 'btn'
                    }
                ]
            },

            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 15
        });

        $('#account_trans').DataTable({
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [{
                        extend: 'copy',
                        className: 'btn'
                    },
                    {
                        extend: 'csv',
                        className: 'btn'
                    },
                    {
                        extend: 'excel',
                        className: 'btn'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn'
                    },
                    {
                        extend: 'print',
                        className: 'btn'
                    }
                ]
            },
            "columns": [{
                    "data": "cust_code"
                },
                {
                    "data": "dealer_name"
                },
                {
                    "data": "distributor_name"
                },
                {
                    "data": "full_name"
                },
                {
                    "data": "mobile"
                },
                {
                    "data": "amount"
                },
                {
                    "data": "created_on"
                }
            ],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 15
        });
        // Add event listener for opening and closing details
        $('#account_trans tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format_tran_dr(row.data())).show();
                tr.addClass('shown');
            }
        });

        /* dealer view datatable */
        $('#dealer_tbl').DataTable({
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [{
                        extend: 'copy',
                        className: 'btn'
                    },
                    {
                        extend: 'csv',
                        className: 'btn'
                    },
                    {
                        extend: 'excel',
                        className: 'btn'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn'
                    },
                    {
                        extend: 'print',
                        className: 'btn'
                    }
                ]
            },
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 15
        });
        /* -------------------- */

        /* dealer view datatable */
        $('#online_tbl').DataTable({
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12 online-pd0"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [{
                        extend: 'copy',
                        className: 'btn'
                    },
                    {
                        extend: 'csv',
                        className: 'btn'
                    },
                    {
                        extend: 'excel',
                        className: 'btn'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn'
                    },
                    {
                        extend: 'print',
                        className: 'btn'
                    }
                ]
            },
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 15
        });
        /* -------------------- */


        /* Counter Datatable view */
        var table = $('#counter_tbl').DataTable({
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [{
                        extend: 'copy',
                        className: 'btn'
                    },
                    {
                        extend: 'csv',
                        className: 'btn'
                    },
                    {
                        extend: 'excel',
                        className: 'btn'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn'
                    },
                    {
                        extend: 'print',
                        className: 'btn'
                    }
                ]
            },
            "order": [],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 15
        });
        /* --------------------- */


        //Active User Table 

        var table = $('#account_list_tbl').DataTable({
            <?php if ($this->router->method === 'inactivelist') { ?> "ajax": "<?= base_url('account/get_inactive') ?>",
            <?php } else { ?> "ajax": "<?= base_url('account/get/' . $this->uri->segment(3)) ?>",
            <?php } ?>

            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [{
                        extend: 'copy',
                        className: 'btn'
                    },
                    {
                        extend: 'csv',
                        className: 'btn'
                    },
                    {
                        extend: 'excel',
                        className: 'btn'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn'
                    },
                    {
                        extend: 'print',
                        className: 'btn'
                    }
                ]
            },

            "columns": [{
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                {
                    "data": "cust_code"
                },
                {
                    "data": "distributor_name"
                },
                {
                    "data": "dealer_name"
                },
                {
                    "data": "full_name"
                },
                {
                    "data": "mobile"
                },
                {
                    "data": "action"
                }
            ],
            "order": [],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 15
        });


        // Add event listener for opening and closing details
        $('#account_list_tbl tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });




        //Money Table

        $('#moneyTable').DataTable({
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "order": [
                [0, "desc"]
            ],
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 15,
            drawCallback: function() {
                $('.dataTables_paginate > .pagination').addClass(
                    ' pagination-style-13 pagination-bordered mb-5');
            }
        });
        <?php if ($this->router->class == 'dashboard') { ?>
            var expences = <?php echo $income; ?>;
            var income = <?php echo $expences; ?>;
            var date = <?php echo $date; ?>;
            var options1 = {

                chart: {

                    fontFamily: 'Nunito, sans-serif',

                    height: 365,

                    type: 'area',

                    zoom: {

                        enabled: false

                    },

                    dropShadow: {

                        enabled: true,

                        opacity: 0.3,

                        blur: 5,

                        left: -7,

                        top: 22

                    },

                    toolbar: {

                        show: false

                    },

                    events: {

                        mounted: function(ctx, config) {

                            const highest1 = ctx.getHighestValueInSeries(0);

                            const highest2 = ctx.getHighestValueInSeries(1);



                            ctx.addPointAnnotation({

                                x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(
                                        highest1)])
                                    .getTime(),

                                y: highest1,

                                label: {

                                    style: {

                                        cssClass: 'd-none'

                                    }

                                },

                                customSVG: {

                                    SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1b55e2" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',

                                    cssClass: undefined,

                                    offsetX: -8,

                                    offsetY: 5

                                }

                            })



                            ctx.addPointAnnotation({
                                x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(
                                        highest2)])
                                    .getTime(),

                                y: highest2,

                                label: {

                                    style: {

                                        cssClass: 'd-none'

                                    }

                                },

                                customSVG: {

                                    SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#e7515a" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',

                                    cssClass: undefined,

                                    offsetX: -8,

                                    offsetY: 5

                                }

                            })

                        },

                    }

                },

                colors: ['#1b55e2', '#e7515a'],

                dataLabels: {

                    enabled: false

                },

                markers: {

                    discrete: [{

                        seriesIndex: 0,

                        dataPointIndex: 7,

                        fillColor: '#000',

                        strokeColor: '#000',

                        size: 5

                    }, {

                        seriesIndex: 2,

                        dataPointIndex: 11,

                        fillColor: '#000',

                        strokeColor: '#000',

                        size: 4

                    }]

                },

                subtitle: {

                    text: 'Total Profit',

                    align: 'left',

                    margin: 0,

                    offsetX: -10,

                    offsetY: 35,

                    floating: false,

                    style: {

                        fontSize: '14px',

                        color: '#888ea8'

                    }

                },

                title: {

                    text: '$10,840',

                    align: 'left',

                    margin: 0,

                    offsetX: -10,

                    offsetY: 0,

                    floating: false,

                    style: {

                        fontSize: '25px',

                        color: '#bfc9d4'

                    },

                },

                stroke: {

                    show: true,

                    curve: 'smooth',

                    width: 2,

                    lineCap: 'square'

                },

                series: [{

                    name: 'Income',

                    data: income

                }, {

                    name: 'Expenses',

                    data: expences

                }],

                labels: date,

                xaxis: {

                    axisBorder: {

                        show: false

                    },

                    axisTicks: {

                        show: false

                    },

                    crosshairs: {

                        show: true

                    },

                    labels: {

                        offsetX: 0,

                        offsetY: 5,

                        style: {

                            fontSize: '12px',

                            fontFamily: 'Nunito, sans-serif',

                            cssClass: 'apexcharts-xaxis-title',

                        },

                    }

                },

                yaxis: {

                    labels: {

                        formatter: function(value, index) {

                            return (value / 1000) + 'K'

                        },

                        offsetX: -22,

                        offsetY: 0,

                        style: {

                            fontSize: '12px',

                            fontFamily: 'Nunito, sans-serif',

                            cssClass: 'apexcharts-yaxis-title',

                        },

                    }

                },

                grid: {

                    borderColor: '#191e3a',

                    strokeDashArray: 5,

                    xaxis: {

                        lines: {

                            show: true

                        }

                    },

                    yaxis: {

                        lines: {

                            show: false,

                        }

                    },

                    padding: {

                        top: 0,

                        right: 0,

                        bottom: 0,

                        left: -10

                    },

                },

                legend: {

                    position: 'top',

                    horizontalAlign: 'right',

                    offsetY: -50,

                    fontSize: '16px',

                    fontFamily: 'Nunito, sans-serif',

                    markers: {

                        width: 10,

                        height: 10,

                        strokeWidth: 0,

                        strokeColor: '#fff',

                        fillColors: undefined,

                        radius: 12,

                        onClick: undefined,

                        offsetX: 0,

                        offsetY: 0

                    },

                    itemMargin: {

                        horizontal: 0,

                        vertical: 20

                    }

                },

                tooltip: {

                    theme: 'dark',

                    marker: {

                        show: true,

                    },

                    x: {

                        show: false,

                    }

                },

                fill: {

                    type: "gradient",

                    gradient: {

                        type: "vertical",

                        shadeIntensity: 1,

                        inverseColors: !1,

                        opacityFrom: .28,

                        opacityTo: .05,

                        stops: [45, 100]

                    }

                },

                responsive: [{

                    breakpoint: 575,

                    options: {

                        legend: {

                            offsetY: -30,

                        },

                    },

                }]

            }
            var chart1 = new ApexCharts(

                document.querySelector("#revenueMonthly1"),

                options1

            );
            chart1.render();
        <?php } ?>
    });

    /* Formatting function for row details - modify as you need */
    function format(d) {
        // console.log(d)
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
            '<tr>' +
            '<td>Wallet:</td>' +
            '<td>' + d.wallet_balance + '</td>' +
            '</tr>' +
            '</table>';
    }

    function format_tran_dr(d) {
        // console.log(d)
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
            '<tr>' +
            '<td>Amount:</td>' +
            '<td>' + d.amount + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Date:</td>' +
            '<td>' + d.created_on + '</td>' +
            '</tr>' +
            '</table>';
    }

    function getCustomerDetails(value) {
        if (value.length > 0) {
            if (value.length == 10) {
                $.ajax({
                    url: "<?= base_url('account/getAccount') ?>",
                    type: "post",
                    data: {
                        'mobile': value
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        const obj_response = JSON.parse(response);
                        if (obj_response.status == '1') {
                            $('#customer_name_label').show();
                            $('#customer_name_div').show();
                            $('#amount_label').show();
                            $('#amount_div').show();
                            $('#addition_submit').show();
                            $('#customer_name').val(obj_response.data.full_name);
                            $('#customer_id').val(obj_response.data.id);
                            $('#current_amount').val(obj_response.data.current_amount);
                        } else {
                            $('#danger_Alert').show();
                        }


                        // You will get response from your PHP page (what you echo or print)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            } else {
                $('#customer_name_label').hide();
                $('#customer_name_div').hide();
                $('#amount_label').hide();
                $('#amount_div').hide();
                $('#danger_Alert').hide();
                $('#addition_submit').hide();
            }
        }
    }
    <?php if ($this->session->user['user_type'] == 3) { ?>
        $(document).ready(function() {

            get_user($('#user_type').val());
        });
    <?php } ?>

    function get_user(user_type) {
        $('#user_id').html('<option> Loading... </option>');
        // $('#user_id').empty();
        $.ajax({
            url: "<?= base_url('money/getUserListByType') ?>",
            type: "post",
            data: {
                'user_type': user_type
            },
            beforeSend: function() {},
            success: function(option) {
                $('#user_id').html(option);
                // You will get response from your PHP page (what you echo or print)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    }

    function get_wallet_balance(user_id) {
        if (user_id != '') {
            $.ajax({
                url: "<?= base_url('money/getUserWalletBalance') ?>",
                type: "post",
                data: {
                    'user_id': user_id
                },
                beforeSend: function() {},
                success: function(response) {
                    $('#wallet_balance').val(response);
                    $('.hide_div').removeClass("d-none");
                    // You will get response from your PHP page (what you echo or print)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        } else {
            $('.hide_div').addClass("d-none");
        }

    }

    <?php if ($this->session->user['user_type'] == 4) { ?>

        function get_counter_wallet_balance(counter_id) {
            if (counter_id != '') {
                $.ajax({
                    url: "<?= base_url('money/getCounterWalletBalance') ?>",
                    type: "post",
                    data: {
                        'counter_id': counter_id
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        $('#wallet_balance').val(response);
                        $('.hide_div').removeClass("d-none");
                        // You will get response from your PHP page (what you echo or print)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            } else {
                $('.hide_div').addClass("d-none");
            }

        }
    <?php } ?>
    <?php if ($this->router->class == 'dashboard') { ?>
        CKEDITOR.replace('editor1');
        CKEDITOR.replace('editor2');
    <?php } ?>


    <?php if ($this->router->class == 'settings') { ?>
        CKEDITOR.replace('editor1');
    <?php } ?>

    <?php if ($this->router->class == 'report') { ?>
        var f3 = flatpickr(document.getElementById('rangeCalendarFlatpickr'), {
            mode: "range",
            allowInput: false,
        });
    <?php } ?>

    function get_dealer(distributor_id) {


        $('#dealer_id').append('<option>Loading...</option>');
        $('#dealer_id').empty();
        $.ajax({
            url: "<?= base_url('counter/get_dealer') ?>",
            type: "post",
            data: {
                'distributor_id': distributor_id
            },
            beforeSend: function() {},
            success: function(response) {
                $('#dealer_id').append(response);

                // You will get response from your PHP page (what you echo or print)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }



    function get_assign_category(counter_id) {
        $('.chkfalse').prop('checked', false);
        $('#updateBtn').html('Loading...').prop("disabled", true);


        $.ajax({
            url: "<?= base_url('master/get_assign_category') ?>",
            type: "post",
            data: {
                'counter_id': counter_id
            },
            beforeSend: function() {},
            success: function(response) {
                console.log(response);
                if (response.length) {
                    const obj_response = JSON.parse(response);
                    console.log(obj_response);
                    $.each(obj_response, function(key, value) {
                        $('#category_id' + value).prop('checked', true);
                    });
                }
                $('#updateBtn').html('Update').prop("disabled", false);

                // You will get response from your PHP page (what you echo or print)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script>

</body>

</html>
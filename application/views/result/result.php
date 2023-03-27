
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">



            <?php if($this->session->flashdata('msg')){ ?>

            <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">

                <button type="button" class="close" data-dismiss="alert">×</button>

                <p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>

            </div>

            <?php } ?>

            <div class="widget-content widget-content-area br-6">

                <h4> <?= $category->cat_name ?> Play Result - <?= date('d-m-Y',strtotime('-1 day')) ?></h4>

                <div class="table-responsive mb-4 mt-4">

                    <table id="" class="table table-hover non-hover" style="width:100%">

                        <thead>

                            <tr>

                                <?php $i=1;

                                foreach($result as $r){ 

                                    // echo "<pre>";

                                    // print_r($r);

                                    // echo "<pre>";

                                    ?>

                                <th>Time<?= $i; ?>(<?= $r->start_time ?>)</th>

                                <?php $i++;  } ?>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <?php $i=1;

                                foreach($result as $key => $r){ 
                                    $query = $this->db->query("select *  from game_result where game_code='".$r->gcode."' and DATE(published_on) IN ('".date('Y-m-d',strtotime('-1 day'))."')");
                                    $game_result=$query->result();

                                    if(empty($game_result)){ ?>
                                <td><button class="btn btn-success mb-2 add_result" id="add_result" data-id="<?= $r->cat_id ?>"
                                data-prev="<?= $key ?>"        
                                data-gcode=<?=$r->gcode ?> data-published_on = <?= date('d/m/Y',strtotime('-1 day')) ?>>Click Result</button></td> 
                                <?php }else{
                                    ?>
                                <td><button class="btn btn-danger mb-2 edit_result" id="edit_result" data-id="<?= $r->cat_id ?>"
                                data-prev="<?= $key ?>"       
                                data-gcode=<?=$r->gcode ?> 
                                data-single=<?=$game_result[0]->win_number ?>
                                data-patti=<?=$game_result[1]->win_number ?> 
                                <?php if($key == 0){ ?>
                                    data-cp="<?=$game_result[2]->win_number ?>" 
                                    data-jodi="";
                                <?php }else{ ?>
                                    data-jodi=<?= $game_result[2]->win_number ?> 
                                    data-cp="<?= $game_result[3]->win_number ?> "
                                <?php } ?>
                                data-published_on="<?=date('d/m/Y', strtotime($game_result[0]->published_on))?>" >Click
                                        Result</button></td>

                                <?php }

                                    ?>



                                <?php $i++;  } ?>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <div class="widget-content widget-content-area br-6">

                <h4> <?= $category->cat_name ?> Single & Patti Result - <?= date('d-m-Y',strtotime('-1 day')) ?> </h4>

                <div class="table-responsive mb-4 mt-4">

                    <table id="" class="table table-hover non-hover" style="width:100%">

                        <thead>

                            <tr>

                                <?php $i=1;

                                foreach($result as $r){ 

                                    // echo "<pre>";

                                    // print_r($r);

                                    // echo "<pre>";

                                    ?>

                                <th>Time<?= $i; ?>(<?= $r->start_time ?>)</th>

                                <?php $i++;  } ?>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <?php $i=1;

                                foreach($result as $r){ 

                                    // echo "<pre>";

                                    // print_r($r);

                                    // echo "<pre>";

                                    $query = $this->db->query("select gr.*  from game_result as gr left join game as g on g.gcode=gr.game_code left join slot as s on s.id=g.slot_id where gr.game_code='".$r->gcode."' and DATE(gr.published_on) IN ('".date('Y-m-d',strtotime('-1 day'))."') and type='Single'");
                                    
                                    $game_result=$query->row();
                                    if(!empty($game_result)){  ?>
                                <td><button class="btn btn-info mb-2"><?= $game_result->win_number ?></button></td>

                                <?php  }else{ ?>

                                <td></td>

                                <?php  } ?>

                                <?php $i++;  } ?>

                            </tr>

                            <tr>

                                <?php $i=1;

                                foreach($result as $r){ 

                                    // echo "<pre>";

                                    // print_r($r);

                                    // echo "<pre>";

                                    $query = $this->db->query("select *  from game_result where game_code='".$r->gcode."' and DATE(published_on) IN ('".date('Y-m-d',strtotime('-1 day'))."') and type='Patti'");

                                    $game_result=$query->row();

                                   //print_r($game_result);

                                   if(!empty($game_result)){ ?>

                                <td><button class="btn btn-info mb-2"><?= $game_result->win_number ?></button></td>

                                <?php   }else{

                                   echo "<td></td>";

                                } ?>



                                <?php $i++;  } ?>

                            </tr>

                            <tr>

                                <?php $i=1;

                                foreach($result as $r){ 

                                    // echo "<pre>";

                                    // print_r($r);

                                    // echo "<pre>";

                                    $query = $this->db->query("select *  from game_result where game_code='".$r->gcode."' and DATE(published_on) IN ('".date('Y-m-d',strtotime('-1 day'))."') and type='Jodi'");

                                    $game_result=$query->row();

                                   //print_r($game_result);

                                   if(!empty($game_result)){ ?>

                                <td><button class="btn btn-info mb-2"><?= $game_result->win_number ?></button></td>

                                <?php   }else{

                                   echo "<td></td>";

                                } ?>



                                <?php $i++;  } ?>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>



        <!-- //Start Today -->

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <div class="widget-content widget-content-area br-6">

                <h4> <?= $category->cat_name ?> Play Result - <?= date('d-m-Y') ?></h4>

                <div class="table-responsive mb-4 mt-4">

                    <table id="" class="table table-hover non-hover" style="width:100%">

                        <thead>

                            <tr>

                                <?php $i=1;
                                      
                                foreach($result as $r){ 

                                    // echo "<pre>";

                                    // print_r($r);

                                    // echo "<pre>";

                                    ?>

                                <th>Time<?= $i; ?>(<?= $r->start_time ?>)</th>

                                <?php $i++;  } ?>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <?php $i=1;    
                                foreach($result as $key => $r){ 
                                    $query = $this->db->query("select *  from game_result where game_code='".$r->gcode."' and DATE(published_on) IN ('".date("Y-m-d")."')");
                                    $game_result=$query->result();

                                    if(empty($game_result)){ ?>
                                <td><button class="btn btn-success mb-2 add_result" id="add_result" data-id="<?= $r->cat_id ?>" 
                                        data-prev=<?= $key ?>
                                        data-gcode=<?=$r->gcode ?> data-published_on = <?=date('d/m/Y', strtotime(str_replace('/', '-', date('Y-m-d'))))?>>Click Result</button></td>
                                <?php }else{
                                   
                                   ?>
                                <td><button class="btn btn-danger mb-2 edit_result" id="edit_result" data-id="<?= $r->cat_id ?>"
                                        data-prev=<?= $key ?>
                                        data-gcode=<?=$r->gcode ?> data-single=<?=$game_result[0]->win_number ?>
                                        data-patti=<?=$game_result[1]->win_number ?> 
                                        <?php if($key == 0){ ?>
                                            data-cp="<?=$game_result[2]->win_number ?>" 
                                            data-jodi="";
                                        <?php }else{ ?>
                                            data-jodi=<?= $game_result[2]->win_number ?> 
                                            data-cp="<?= $game_result[3]->win_number ?> "
                                        <?php } ?>
                                            
                                        data-published_on="<?=date('d/m/Y', strtotime($game_result[0]->published_on))?>" >Click
                                        Result</button></td>

                                <?php }

                                    ?>



                                <?php $i++;  } ?>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- //End Of Today -->

        
        
        <!-- //Today Result Start -->

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <div class="widget-content widget-content-area br-6">

                <h4> <?= $category->cat_name ?> Single & Patti Result - <?= date('d-m-Y') ?></h4>

                <div class="table-responsive mb-4 mt-4">

                    <table id="" class="table table-hover non-hover" style="width:100%">

                        <thead>

                            <tr>

                                <?php $i=1;

                                foreach($result as $r){ 

                                    // echo "<pre>";

                                    // print_r($r);

                                    // echo "<pre>";

                                    ?>

                                <th>Time<?= $i; ?>(<?= $r->start_time ?>)</th>

                                <?php $i++;  } ?>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <?php $i=1;

                                foreach($result as $r){ 

                                    // echo "<pre>";

                                    // print_r($r);

                                    // echo "<pre>";

                                    $query = $this->db->query("select gr.*  from game_result as gr left join game as g on g.gcode=gr.game_code left join slot as s on s.id=g.slot_id where gr.game_code='".$r->gcode."' and DATE(gr.published_on) IN ('".date("Y-m-d")."') and type='Single'");
                                    
                                    $game_result=$query->row();
                                    if(!empty($game_result)){  ?>
                                <td><button class="btn btn-info mb-2"><?= $game_result->win_number ?></button></td>

                                <?php  }else{ ?>

                                <td></td>

                                <?php  } ?>

                                <?php $i++;  } ?>

                            </tr>

                            <tr>

                                <?php $i=1;

                                foreach($result as $r){ 

                                    // echo "<pre>";

                                    // print_r($r);

                                    // echo "<pre>";

                                    $query = $this->db->query("select *  from game_result where game_code='".$r->gcode."' and DATE(published_on) IN ('".date("Y-m-d")."') and type='Patti'");

                                    $game_result=$query->row();

                                   //print_r($game_result);

                                   if(!empty($game_result)){ ?>

                                <td><button class="btn btn-info mb-2"><?= $game_result->win_number ?></button></td>

                                <?php   }else{

                                   echo "<td></td>";

                                } ?>



                                <?php $i++;  } ?>

                            </tr>

                            <tr>

                                <?php $i=1;

                                foreach($result as $r){ 

                                    // echo "<pre>";

                                    // print_r($r);

                                    // echo "<pre>";

                                    $query = $this->db->query("select *  from game_result where game_code='".$r->gcode."' and DATE(published_on) IN ('".date("Y-m-d")."') and type='Jodi'");

                                    $game_result=$query->row();

                                   //print_r($game_result);

                                   if(!empty($game_result)){ ?>

                                <td><button class="btn btn-info mb-2"><?= $game_result->win_number ?></button></td>

                                <?php   }else{

                                   echo "<td></td>";

                                } ?>



                                <?php $i++;  } ?>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- //Today Result End -->



    </div>

</div>

<div class="modal fade login-modal" id="addResultModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModal"
    aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="loginModalLabel">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <svg aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line> 
                    </svg>
                </button>
            </div>

            <div class="modal-body">
                <form class="mt-0" method="post" action="<?= base_url('result/add') ?>" autocomplete="off">
                    <input type="hidden" class="form-control mb-2" name="cat_id" id="cat_id">
                    <input type="hidden" class="form-control mb-2" name="g_code" id="g_code">
                    <input type="hidden" id="prev_code_add" class="form-control mb-2" name="prev_code">
                    <div class="form-group">
                        <input type="hidden" class="form-control mb-4" id="result_date" name="result_date" required placeholder="Enter Result Date">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control mb-4" pattern="\d*" required name="type[Single]" maxlength="1"  placeholder="Enter Single">
                        <!-- <input type="number" class="form-control mb-4" required name="type[Single]" max="1"
                            placeholder="Enter Single"> -->
                    </div>
                    <div class="form-group">
                    <input type="text" class="form-control mb-4" id="patti_field" onkeyup="handleCPInput(this.value)" pattern="\d*" required name="type[Patti]" maxlength="3"  placeholder="Enter Patti">
                        <!-- <input type="number" max="3" class="form-control mb-4" required name="type[Patti]"
                            placeholder="Enter Patti"> -->
                    </div>
                    <div class="form-group">
                    <input type="text" id="jodi_add" class="form-control mb-4" pattern="\d*" required name="type[Jodi]" maxlength="2"  placeholder="Enter Jodi">
                    </div>
                    <div class="form-group">
                    <input type="hidden" class="form-control mb-4" id="cp_field" pattern="\d*" required name="type[CP]">
                    </div>

                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-block">Submit</button>
                </form>

            </div>

        </div>

    </div>

</div>

<div class="modal fade login-modal" id="editResultModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModal"
    aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="loginModalLabel">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></button>
            </div>

            <div class="modal-body">
                <form class="mt-0" method="post" action="<?= base_url('result/edit') ?>" autocomplete="off">
                    <input type="hidden" class="form-control mb-2" name="cat_id" id="cat_id_edit">
                    <input type="hidden" class="form-control mb-2" name="g_code" id="g_code_edit">
                    <input type="hidden" id="prev_code_edit" class="form-control mb-2" name="prev_code_edit">           
                    <div class="form-group">
                        <input type="hidden" class="form-control mb-4" id="edit_result_date" name="edit_result_date" required placeholder="Enter Result Date">
                    </div>

                    <div class="form-group">
                        <!-- <input type="number" id="single_win" class="form-control mb-4" required name="type[Single]"
                            maxlength="1" placeholder="Enter Single"> -->
                        <input type="text" id="single_win" class="form-control mb-4" pattern="\d*" required name="type[Single]" maxlength="1"  placeholder="Enter Single">   
                    </div>

                    <div class="form-group">
                    <input type="text" id="patti_win" class="form-control mb-4" pattern="\d*" onkeyup="handleWinCPInput(this.value)" required name="type[Patti]" maxlength="3"  placeholder="Enter Patti">   

                        <!-- <input type="number" id="patti_win" maxlength="3" class="form-control mb-4" required
                            name="type[Patti]" placeholder="Enter Patti"> -->
                    </div>
                    <div class="form-group">
                    <input type="text" id="jodi_win" class="form-control mb-4" pattern="\d*" required name="type[Jodi]" maxlength="2"  placeholder="Enter Jodi">
                    </div>
                    <div class="form-group">
                    <input type="hidden" class="form-control mb-4" id="cp_field_edit" pattern="\d*" required name="type[CP]">
                    </div>                
                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-block">Submit</button>

                </form>

            </div>

        </div>

    </div>

</div>
<!-- 
    If My prev_Code is 0 then it means this is my first game 
    And if it is my first game then there is no need to show the jodi field and calculate winning 
    Only needed to check winning and everything if it is not first game result 
    Why?? Because first game jodi value is getting inserted into the next game don't temper with it
 -->
<script>
$(document).ready(function() {
    $('#result_date').datepicker({
		format: "dd/mm/yyyy",
		todayHighlight:true,
		autoclose: true,
		endDate: '0d'
	});

    $('#edit_result_date').datepicker({
		format: "dd/mm/yyyy",
		todayHighlight:true,
		autoclose: true,
		endDate: '0d'
	});
});

$(document).on('click', '.add_result', function(event) {
    var id = $(this).data('id');
    var gcode = $(this).data('gcode');
    var prevcode = $(this).data('prev');
    var published_on = $(this).data('published_on');

    if(prevcode == 0){
        $('#jodi_add').attr("type","hidden");
    }else{
        $('#jodi_add').attr("type","text");
    }
        
    $('#addResultModal').modal('show');
    $('#prev_code_add').val(prevcode);
    $('#cat_id').val(id);
    $('#g_code').val(gcode);
    $('#result_date').val(published_on);
});

$(document).on('click', '.edit_result', function(event) {
    var id = $(this).data('id');
    var gcode = $(this).data('gcode');
    var prevcode = $(this).data('prev');
    var single = $(this).data('single');
    var patti = $(this).data('patti');
    var jodi = $(this).data('jodi');
    var cp = $(this).data('cp');
    var published_on = $(this).data('published_on');

    if(prevcode == 0){
        $('#jodi_win').attr("type","hidden");
    }else{
        $('#jodi_win').attr("type","text");
    }

    $('#cat_id_edit').val(id);
    $('#g_code_edit').val(gcode);
    $('#single_win').val(single);
    $('#patti_win').val(patti);
    $('#jodi_win').val(jodi);
    $('#cp_field_edit').val(cp);
    $('#prev_code_edit').val(prevcode);
    $('#edit_result_date').val(published_on);
    $('#editResultModal').modal('show'); 
});

function handleCPInput(val){
    var cp_field = document.querySelector('#cp_field');
    cp_field.value = val;
}

function handleWinCPInput(val){
    var cp_field = document.querySelector('#cp_field_edit');
    cp_field.value = val;
}

</script>
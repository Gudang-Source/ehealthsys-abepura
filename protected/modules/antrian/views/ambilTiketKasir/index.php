<style>
    body{
        background-image:url("<?php echo Yii::app()->request->baseUrl; ?>/images/antrian/bg_kiosk_antrian_kasir.jpg"); //default
        background-repeat:no-repeat;
        background-size:cover;
    }
    button.disabled{
        background:url("images/process-working.gif") no-repeat !important;
        background-position: top center !important;
    }
    button.btn-tiket {
        width:340px;
        height:140px;
        background:	url("images/antrian/button a tanpa text.png") no-repeat;
        background-size: 100% 100%;
        border:none;
        margin: 256px -25px 0px 128px;
        vertical-align: top;
        font-family: Arial, Helvetica, sans-serif;
        color:white;
        font-size:38px;
        letter-spacing:0px;
        font-weight: bold;
        text-shadow: 2px 2px 6px #000000;
    }
    button.btn-tiket:hover{
        background:	url("images/antrian/button a tanpa text (hover).png") no-repeat;
        background-size: 100% 100%;
    }

    .keterangan{
        /*color:#000000;*/
        width:100%;
        height:275px;
        border:none;
        margin: 32px 0px 0px 32px;
        padding: 0px 0px 0px 420px;
        vertical-align: top;
        font-size:20px;
        /*text-indent: 10px;*/
        text-align: left;
        font-weight: bold;
        color: #D7970B;
        text-shadow: 1px 1px 1px #000;
    }
    
    #btn-kasir-2{
        margin-right: 25px;
        margin-left: 80px;
    }
</style>

<div id="container" style="height:100%;width:98%;background-size:cover;background-color: transparent;">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'antrian-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
)); ?> 
    <div id="headerAntrian">
        <div id="refresh" style="float:right;">
            <?php echo CHtml::link(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                "javascript:void(0);", 
                array('class'=>'btn btn-danger',
                      'onclick'=>"window.location.href = window.location.href"));  ?>
        </div>
    </div>    
    <div id="contentAntrian" style="height:500px;width:99%;background-size:cover;">
        <div class="content">
            <?php echo $form->hiddenField($model,'ruangan_id', array('readonly'=>true)); ?>
            <?php echo $form->hiddenField($model,'carabayar_id', array('readonly'=>true)); ?>
            <?php echo $form->hiddenField($model,'statuspasien', array('readonly'=>true)); ?>
            <?php echo $form->hiddenField($model,'carabayar_loket', array('readonly'=>true)); ?>
            <?php echo $form->hiddenField($model,'loket_id', array('readonly'=>true)); ?>
            <?php echo $form->hiddenField($model,'noantrian', array('readonly'=>true)); ?>


            <?php
            if(count($modLokets) > 0){
                foreach ($modLokets as $key => $loket) {
                    echo CHtml::htmlButton(strtoupper($loket->loket_nama),
                                             array('onclick'=>'simpan(this,'.$loket->loket_id.','.$loket->carabayar_id.')',
                                            'id'=>'btn-'.strtolower(str_replace(" ","-",$loket->loket_nama)) ,
                                            'class'=>'btn-tiket',
                    ));
                }
            }

            ?>
            <div class="keterangan">
                <div class = "row-fluid">
                    <?php 
                         if(count($modLokets)){
                             foreach ($modLokets as $i => $loket){
                                 echo "<div class='span6'>";
                                 echo $loket->loket_fungsi;
                                 echo "</div>";
                             }
                         } 

                    ?>
                </div>
            </div>
            <iframe id="print_win" src="" style="display: none;"></iframe>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<div class="block-footer-antrian">
    <div id="footerAntrian">
        <marquee direction="left" scrollamount="10" id="textrunning">
            <?php echo Yii::app()->user->getState('running_text_kiosk'); ?>
        </marquee>
    </div> 
    <div id="footerClock">
        <div id="clock"></div>
    </div>
</div>

<script type="text/javascript">
    function simpan(obj,loket_id, carabayar_id){
        //salin ke form
        if(!$(obj).hasClass("disabled")){
            $("#<?php echo CHtml::activeId($model, "loket_id") ?>").val(loket_id);
            $("#<?php echo CHtml::activeId($model, "carabayar_id") ?>").val(carabayar_id);
            //post form
            $("button").attr("disabled");
            $("button").addClass("disabled");
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('SimpanTiket'); ?>',
                data: {data:$("#antrian-form").serialize()},//
                dataType: "json",
                success:function(data){
                    var delaytombol = parseInt(data.delaytombol) * parseInt(1000);
                    print(data.model.antrian_id);
                    setTimeout(function(){
                        $("button").removeAttr("disabled");
                        $("button").removeClass("disabled");
                    },delaytombol);
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }
    }
    function print(antrian_id){
        $("#print_win").attr('src',"<?php echo $this->createUrl('Print') ?>&antrian_id="+antrian_id);
    }
    function tampilkanRunningText(){
        $.post('<?php echo $this->createUrl('getRunningText') ?>',{},function(data){
            $('#textrunning').html(data);
        },'json');
    }
    tampilkanRunningText();
    setInterval(   // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
        function(){
            tampilkanRunningText()
            return false;
        }, 
        50000  // fungsi di eksekusi setiap 50 detik sekali
    );
</script>


<?php /*
<div class="white-container">
    <legend class="rim2">Informasi <b>Kamar</b></legend>
    <fieldset class="box">
        <legend class="rim">Pencarian Kamar</legend>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'informasiKamar-t-form',
            'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array(
                    'onKeyPress'=>'return disableKeyPress(event)',
//				RSN-1299	
//                  'onsubmit'=>'if(requiredCheck(this)){getInfoKamar(this);} return false;'
		            'onSubmit'=>'return getInfoKamar(this);'
                ),
                'focus'=>'#',
        )); ?>

        <table width="100%">
            <tr>
                <td width="35%">
                    <div class="control-group ">
                        <label class="control-label required">
                            Ruangan
                            <span class="required">
                                *
                            </span>
                        </label>
                        <div class="controls">
                            <?php
                                echo $form->dropDownList($modKamarRuangan,'ruangan_id',
                                    CHtml::listData($modKamarRuangan->RuanganItems, 'ruangan_id', 'ruangan_nama'),
                                    array(
                                        'class'=>'span3','empty'=>'-- Pilih --',
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'ajax'=>array(
                                            'type'=>'POST',
                                            'url'=>$this->createUrl('GetRuanganKamarRuangan',array('encode'=>false,'namaModel'=>'PPKamarruanganM')),
                                            'update'=>'#PPKamarruanganM_kelaspelayanan_id',
                                        ),
                                    )
                                );
                            ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <label class="control-label required">
                            Kelas Pelayanan
                            <span class="required">
                                *
                            </span>
                        </label>
                        <div class="controls">
                            <?php echo $form->dropDownList($modKamarRuangan,'kelaspelayanan_id',  array(),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',
                                'ajax'=>array('type'=>'POST',
                                'url'=>$this->createUrl('GetRuanganNoKamarRuangan',array('encode'=>false,'namaModel'=>'PPKamarruanganM')),
                                'update'=>'#PPKamarruanganM_kamarruangan_nokamar',),
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <label class="control-label ">
                            No. Kamar
                        </label>
                        <div class="controls">
                            <?php echo $form->dropDownList($modKamarRuangan,'kamarruangan_nokamar',  array(),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                        </div>
                    </div>
                    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                          array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));?>
                                    <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl($this->id.'/index'), 
                                    array('class'=>'btn btn-danger',
                                        'onclick'=>'return refreshForm(this);'));  ?>
               </td>
               <td width="25%">
                    <table width="100%" id="infoRuangan">
                        <tr>
                            <td>
                                <fieldset class="box2">
                                    <legend class="rim" id="photo">Foto Ruangan <?php echo PPRuanganM::model()->findByPk($idRuangan)->ruangan_nama;?></legend>
                                         <?php 
                                             if(empty($modRuangan->ruangan_image)){
                                         ?>  
                                             <img src="<?php echo Params::urlRuanganTumbsDirectory().'no_photo.jpeg' ?>" />
                                         <?php }else{ ?>
                                             <img src="<?php echo Params::urlRuanganTumbsDirectory().'kecil_'.$modRuangan->ruangan_image ?>" />
                                         <?php } ?>
                                </fieldset>
                            </td>
                        </tr>
                    </table>
               </td>
               <td width="40%">
                    <fieldset class="box2">
                        <legend class="rim">Fasilitas</legend>
                        <div id="fasilitasRuangan"><?php echo $modRuangan->ruangan_fasilitas ?></div>
                    </fieldset>
               </td>
            </tr>
            <tr>
                <td>
                </td> 
            </tr>
        </table>
    </fieldset>
    <fieldset class="box">
        <legend class="rim">Data Tempat Tidur</legend>
            <div id="form_kasur"></div>
    </fieldset>
<?php $this->endWidget(); ?>

<?php

$idRuangan=CHtml::activeId($modKamarRuangan,'ruangan_id');
$idKelasPelayanan=  CHtml::activeId($modKamarRuangan,'kelaspelayanan_id');
$idNoKamar=  CHtml::activeId($modKamarRuangan,'kamarruangan_nokamar');
$jscript = <<< JS
function cekValidasi()
{
    idKelas=$('#${idKelasPelayanan}').val();
    idKamar=$('#${idNoKamar}').val();
    idRuangan=$('#${idRuangan}').val();
    
    if(idRuangan==''){
        myAlert('Anda Belum Memilih Ruangan');
    }
    else if(idKelas==''){
        myAlert('Anda Belum Memilih Kelas Pelayanan');
    }else if(idKamar==''){
        myAlert('Anda Belum Memilih Kamar');
    }else{
        $('#btn_simpan').click();
    }
}
JS;
Yii::app()->clientScript->registerScript('faktur',$jscript, CClientScript::POS_HEAD);
?>
</div>
*/
?>
<script>
    $(document).ready(
        function()
        {
            var idRuangan = 207;
            getDataKamar(idRuangan);
            /*
            $.post('<?php echo Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInfoKamar');?>', {idRuangan:idRuangan},
                function(data)
                {
                    $("#infoRuangan").find('legend[id="photo"]').text('Foto Ruangan ' + data.data_ruangan.nama);
                    $("#infoRuangan").find('img').attr('src', data.data_ruangan.foto);
                    $("#infoRuangan").find('div[id="fasilitasRuangan"]').text(data.data_ruangan.fasilitas);
                },
            'json');
            */
        }
    );
    
    function getKelasPelayanan(obj)
    {
        $.post('<?php echo $this->createUrl('GetRuanganKamarRuangan');?>', {idRuangan:idRuangan},
            function(data)
            {
                $("#infoRuangan").find('legend[id="photo"]').text('Foto Ruangan ' + data.data_ruangan.nama);
                $("#infoRuangan").find('img').attr('src', data.data_ruangan.foto);
                $("#infoRuangan").find('div[id="fasilitasRuangan"]').text(data.data_ruangan.fasilitas);
            },
        'json');        
    }
    
    function getDataKamar(obj)
    {
        var idRuangan = null;
        if(typeof obj == 'obj')
        {
            idRuangan = $(obj).val();
        }else{
            idRuangan = obj;
        }
        
        $.post('<?php echo Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInfoKamar');?>', {idRuangan:idRuangan},
            function(data)
            {
                $("#infoRuangan").find('legend[id="photo"]').text('Foto Ruangan ' + data.data_ruangan.nama);
                $("#infoRuangan").find('img').attr('src', data.data_ruangan.foto);
                $("#infoRuangan").find('div[id="fasilitasRuangan"]').text(data.data_ruangan.fasilitas);
            },
        'json');
    }
    
    function getInfoKamar(obj)
    {
        // var is_kosong = 0;
        // $(obj).find('label.required').each(
        //     function()
        //     {
        //         if($(this).parent('.control-group').find().val('select') == "")
        //         {
        //             is_kosong++;
        //         }
        //     }
        // );
        // if(is_kosong > 0)
        // {
        //     myAlert('pilihan belum lengkap, coba cek lagi');
        // }else{
            var idRuangan = 207;
            var data = {
                ruangan_id:$(obj).find('select[name$="[ruangan_id]"]').val(),
                kelaspelayanan_id:$(obj).find('select[name$="[kelaspelayanan_id]"]').val(),
                kamarruangan_nokamar:$(obj).find('select[name$="[kamarruangan_nokamar]"]').val()
            };
            $("#form_kasur").empty();
            $.post('<?php echo Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getDetailKamar');?>', data,
                function(data)
                {
                    if(data.form != "")
                    {
                        $("#form_kasur").append(data.form);
                    }
                    $(obj).find("button[type='submit']").removeAttr("disabled");
                },
            'json');
        // }
        return false;

    }
    
    
    
</script>

<style>
    .contentKamar, .bed{
        -moz-box-shadow: 0px 5px 10px rgba(0,0,0,.6);
        -webkit-box-shadow: 0px 5px 10px rgba(0,0,0,.6);
        -o-box-shadow: 0px 5px 10px rgba(0,0,0,.6);
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        -o-border-radius:3px;
    }
    .contentKamar{
        border:1px solid black;
        margin:10px;
		
    }
    .bed{
        display:inline-block;
        width:13%;
        border-color:#ccc;
        margin:10px;
    }
   
    .popover-inner{
        width:100%;        
    }
    .image_ruangan{
        height:100px;
        width:100px;
    }
	.pintu{
		background-image:url(images/pintu.png);
		width:16px;
		height:75px;
		margin-top:80px;
		float:right;
		margin-right:-2px;
		}
</style>

<div class="white-container">
    <legend class="rim2">Informasi <b>Kamar Rawat</b></legend> 
    <div class = "control-group">
        <?php echo CHtml::label('Ruangan', 'ruangan_nama',array('class'=>'control-label')) ?>
        <div class = "controls">            
            <?php 
            echo CHtml::dropDownList('ruangan', '', CHtml::listData(
                RuanganM::model()->findAll(" ruangan_aktif = TRUE AND instalasi_id IN ('".Params::INSTALASI_ID_RI."','".Params::INSTALASI_ID_ICU."','".Params::INSTALASI_ID_IBS."') ORDER BY ruangan_nama ")
                , 'ruangan_id', 'ruangan_nama'),
                array('empty'=>'-- Pilih --', 'onchange'=>'getListRuangan();')
            ); 
            ?>
        </div>
    </div>
    <div class="isi">
        <?php echo $row; ?>
    </div>
</div>

<?php 
$url = Yii::app()->createUrl($this->route);
Yii::app()->clientScript->registerScript('list', '
    function getListRuangan(){
        ruangan = $("#ruangan").val();
        $(".contentKamar").addClass("animation-loading");
        $.post("'.$url.'", {ajax:true,ruangan:ruangan},function(data){
            $(".isi").html(data);
            $(".contentKamar").removeClass("animation-loading");
            jQuery(\'a[rel="popover"]\').popover();
            jQuery(\'.poping\').popover({placement:"bottom"});
        },"json");
    }
',  CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScript('readyFunction','
    jQuery(\'.poping\').popover({placement:"bottom"});
//    $(".bed").mousemove(function(e){
//        $(".popover").show();
//        tinggi = $(".popover").height()/2;
//        $(".popover").css("left",e.clientX);        
//        $(".popover").css("top",($(document).scrollTop())+e.clientY-tinggi);   
//    });
//    
   $(".bed").click(function(e){
        $(".popover").slideToggle();
    });
    
    ',  CClientScript::POS_READY); ?>
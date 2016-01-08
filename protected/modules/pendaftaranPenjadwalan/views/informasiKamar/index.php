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
<fieldset class="box2">
    <legend class="rim">
        <?php echo CHtml::checkBox('pakeAnastesi', $modAnastesi->pakeAnastesi, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
        Pasien Anastesi
    </legend>
    <div id="divAnastesi" class="control-group <?php echo ($modAnastesi->pakeAnastesi) ? '':''; ?>">
        
       <?php echo $form->dropDownListRow($modAnastesi,'jenisanastesi_id', CHtml::listData(JenisAnastesiM::model()->findAll('jenisanastesi_aktif = true order by jenisanastesi_id '), 'jenisanastesi_id', 'jenisanastesi_nama') ,
                            array('disabled'=>true,
                                   'empty'=>'-- Pilih --',
                                   'onkeypress'=>"return $(this).focusNextInputField(event)",
                                   'ajax'=>array(
                                        'type'=>'POST',
                                        'url'=>Yii::app()->createUrl('ActionDynamic/GetAnastesi',array('encode'=>false,'namaModel'=>'PasienanastesiT','attr'=>'')),
                                        'update'=>'#PasienanastesiT_anastesi_id',),
                                    'onchange'=>'$("#PasienanastesiT_typeanastesi_id").html("")',
                                )); ?>
        
        <?php 
//        echo $form->dropDownListRow($modAnastesi,'anastesi_id', array() ,
//                            array('disabled'=>true,
//                                   'empty'=>'-- Pilih --',
//                                   'onkeypress'=>"return $(this).focusNextInputField(event)",
//                                   'ajax'=>array(
//                                        'type'=>'POST',
//                                        'url'=>Yii::app()->createUrl('ActionDynamic/GetTypeAnastesi',array('encode'=>false,'namaModel'=>'PasienanastesiT','attr'=>'')),
//                                        'update'=>'#PasienanastesiT_typeanastesi_id',)
//                                )); ?>
        <?php 
        echo $form->dropDownListRow($modAnastesi,'anastesi_id', array() ,
                            array('disabled'=>true,
                                    'empty'=>'-- Pilih --',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                    'onchange'=>'js:getRowsTypeAnastesiDropdown()'
                                   )); ?>
        
        <?php 
//        DIPINDAHKAN KE TABEL GRID BAWAH
//        echo $form->dropDownListRow($modAnastesi,'typeanastesi_id', array() ,array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
        
        <?php echo $form->dropDownListRow($modAnastesi,'dokteranastesi_id', CHtml::listData($modPenunjang->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'value'=>$modRencanaOperasiAttrib->dokteranastesi_id)); ?>
        
        <?php echo $form->dropDownListRow($modAnastesi,'perawatanastesi_id', CHtml::listData($modPenunjang->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'value'=>$modRencanaOperasiAttrib->perawat_id)); ?>
        
    
    </div>
</fieldset>

<?php
$enableInputAnastesi = ($modAnastesi->pakeAnastesi) ? 1 : 0;
$js = <<< JS
if(${enableInputAnastesi}) {
    $('#divAnastesi input').removeAttr('disabled');
    $('#divAnastesi select').removeAttr('disabled');
}
else {
    $('#divAnastesi input').attr('disabled','true');
    $('#divAnastesi select').attr('disabled','true');
}

$('#pakeAnastesi').change(function(){
        if ($(this).is(':checked')){
                $('#divAnastesi input').removeAttr('disabled');
                $('#divAnastesi select').removeAttr('disabled');
                $('#PasienanastesiT_dokteranastesi_id').val($('#BSRencanaOperasiT_dokteranastesi_id').val());
        }else{
                $('#divAnastesi input').attr('disabled','true');
                $('#divAnastesi select').attr('disabled','true');
                $('#divAnastesi input').attr('value','');
                $('#divAnastesi select').attr('value','');
        }
//        $('#divAnastesi').slideToggle(500);
    });
JS;
Yii::app()->clientScript->registerScript('anastesi',$js,CClientScript::POS_READY);
?>
<script type="text/javascript">
function getRowsTypeAnastesiDropdown(){
    $.ajax({
        url:"<?php echo $this->createUrl('GetTypeAnastesi', array('encode'=>false,'namaModel'=>'PasienanastesiT','attr'=>'' ))?>",
        type:'POST',
        data: {
            "PasienanastesiT[anastesi_id]":$("#PasienanastesiT_anastesi_id").val(),
        },
    }).done(
        function(data){
            $("#tblFormRencanaOperasi tbody").find("tr").each(function(){
                $(this).find(".typeanastesi").empty();
                $(this).find(".typeanastesi").append(data);
            });
        }
    );
}
</script>

<?php 
//KHUSUS UNTUK JENIS ANASTESINYA ADA
if (isset($modAnastesi->jenisanastesi_id)){ ?>
<script type="text/javascript">
function getAnastesiDropdown()
{
    $.ajax({
        url:"<?php echo Yii::app()->createUrl('ActionDynamic/GetAnastesi', array('encode'=>false,'namaModel'=>'PasienanastesiT','attr'=>'' ))?>",
        type:'POST',
        data: {
            "PasienanastesiT[jenisanastesi_id]":<?php echo $modAnastesi->jenisanastesi_id?>,
        },
    }).done(
        function(data){
            $("#PasienanastesiT_anastesi_id").empty();
            $("#PasienanastesiT_anastesi_id").append(data);
        }
    );
}
getAnastesiDropdown();


</script>
<?php }?>

<?php 
//KHUSUS UNTUK ANASTESINYA ADA
if(!empty($modAnastesi->pasienanastesi_id) && !empty($modAnastesi->anastesi_id)){
    ?>
<script type="text/javascript">
function getTypeAnastesiDropdown(){
    $.ajax({
        url:"<?php echo $this->createUrl('GetTypeAnastesi', array('encode'=>false,'namaModel'=>'PasienanastesiT','attr'=>'' ))?>",
        type:'POST',
        data: {
            "PasienanastesiT[anastesi_id]":<?php echo $modAnastesi->anastesi_id?>,
        },
    }).done(
        function(data){
            $("#PasienanastesiT_typeanastesi_id").empty();
            $("#PasienanastesiT_typeanastesi_id").append(data);
        }
    );
}
 
function getRowsTypeAnastesiDropdownDefault(){
    $.ajax({
        url:"<?php echo $this->createUrl('GetTypeAnastesi', array('encode'=>false,'namaModel'=>'PasienanastesiT','attr'=>'' ))?>",
        type:'POST',
        data: {
            "PasienanastesiT[anastesi_id]":<?php echo $modAnastesi->anastesi_id?>,
        },
    }).done(
        function(data){
            $("#tblFormRencanaOperasi tbody").find("tr").each(function(){
                $(this).find(".typeanastesi").empty();
                $(this).find(".typeanastesi").append(data);
            });
        }
    );
}
 

setTimeout(function(){
    $("#PasienanastesiT_anastesi_id").val(<?php echo $modAnastesi->anastesi_id ?>);
    getTypeAnastesiDropdown();
    getRowsTypeAnastesiDropdownDefault();
},2500);
//setTimeout(function(){$("#PasienanastesiT_typeanastesi_id").val(<?php // echo $modAnastesi->typeanastesi_id ?>)},2000);
setTimeout(function(){
        $("#tblFormRencanaOperasi tbody").find("tr").each(function(){
            var typeAnastesiSebelum = $(this).find("input[name$='[typeanastesi_id_sebelum]']").val();
            $(this).find(".typeanastesi").val(typeAnastesiSebelum);
        });
},3000);

</script>
<?php } ?>
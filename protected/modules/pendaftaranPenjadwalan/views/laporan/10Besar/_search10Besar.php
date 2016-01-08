<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchInfoKunjungan',
        'focus'=>'#'.CHtml::activeId($modPPInfoKunjunganV,'instalasi_id'),
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        table{
            margin-bottom: 0px;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
    </style>
	 
    <fieldset class='box'>
	 <legend class="rim"><i class="icon-search icon-white"></i> Pencarian berdasarkan : </legend>
         <div class="row-fluid">
             <div class="span4">
                 <?php echo CHtml::hiddenField('type', ''); ?>
                    <div class='control-group'>
                        <div class = 'control-label'>Tanggal Pemeriksaan</div>
                        <div class="controls">  
                            <?php $modPPInfoKunjunganV->tgl_awal = $format->formatDateTimeForUser($modPPInfoKunjunganV->tgl_awal); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPPInfoKunjunganV,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                //                                          'maxDate'=>'d',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
				    'maxDate'=>'d',
                                ),
                                'htmlOptions' => array('readonly' => true,
                                'class'=>'span2',
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $modPPInfoKunjunganV->tgl_awal = $format->formatDateTimeForDb($modPPInfoKunjunganV->tgl_awal); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <div class = 'control-label'>Sampai Dengan</div>
                        <div class="controls">
                            <?php $modPPInfoKunjunganV->tgl_akhir = $format->formatDateTimeForUser($modPPInfoKunjunganV->tgl_akhir); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPPInfoKunjunganV,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                //                                         'maxdate'=>'d',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate'=>'d',
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'class'=>'span2',
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $modPPInfoKunjunganV->tgl_akhir = $format->formatDateTimeForDb($modPPInfoKunjunganV->tgl_akhir); ?>
                        </div>
                    </div>
             </div>
             <div class="span4">
                <?php
                                       echo $form->dropDownListRow($modPPInfoKunjunganV, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'style'=>'width:200px;',
                                               'ajax' => array('type' => 'POST',
                                                       'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modPPInfoKunjunganV))),
                                                       'update' => '#' . CHtml::activeId($modPPInfoKunjunganV, 'ruangan_id') . ''),));
                               ?>

                               <?php
                                  echo $form->textFieldRow($modPPInfoKunjunganV, 'jumlahTampil', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly')); 
                                  ?>
             </div>
             <div class="span4">
                 <?php echo $form->dropDownListRow($modPPInfoKunjunganV, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id' => $modPPInfoKunjunganV->instalasi_id, 'ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2','style'=>'width:200px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
             </div>
         </div>
         <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
            ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                        Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                        array('class'=>'btn btn-danger',
                                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
        </div>
    </fieldset>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php 
$urlAjax = $this->createUrl('GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => $modPPInfoKunjunganV->getNamaModel()));
        Yii::app()->clientScript->registerScript('numbers','
    $(".numbersOnly").keydown(function(event) {
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
        if ($(this).val() == 0){
            $(this).val(1);
        }
    });
    $(".numbersOnly").keyup(function(event){
        if ($(this).val() == 0){
            $(this).val(1);
        }
    });
//    $("#'.CHtml::activeId($modPPInfoKunjunganV, 'instalasi_id').'").change(function(){
//        $.ajax({
//            type:"POST",
//            data:$("#searchInfoKunjungan").serialize(),
//            url:"'.$urlAjax.'",
//            success:function(data){
//                $("#'.CHtml::activeId($modPPInfoKunjunganV, 'ruangan_id').'").html("<option value>-- Pilih --</pilih>"+data)
//            }
//        });
//    })
',  CClientScript::POS_READY
);?>



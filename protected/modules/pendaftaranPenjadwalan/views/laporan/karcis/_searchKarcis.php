<legend class="rim"><i class="icon-search icon-white"></i> Pencarian berdasarkan :</legend>
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
     <!--   <legend>Kunjungan</legend> -->
       


    <div class="row-fluid">
        <div class="span6">
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

                 <?php
                    echo $form->dropDownListRow($modPPInfoKunjunganV, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    ));
                    ?>
        
        </div>


        <div class="span6">
            <div class="control-group ">
                <?php $modPPInfoKunjunganV->tgl_akhir = $format->formatDateTimeForUser($modPPInfoKunjunganV->tgl_akhir); ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPPInfoKunjunganV,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
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

            <?php echo $form->dropDownList($modPPInfoKunjunganV, 'ruangan_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                   

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
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php 
$urlAjax = $this->createUrl('GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($modPPInfoKunjunganV)));
        Yii::app()->clientScript->registerScript('numbers','
    $("#'.CHtml::activeId($modPPInfoKunjunganV, 'instalasi_id').'").change(function(){
        $.ajax({
            type:"POST",
            data:$("#searchInfoKunjungan").serialize(),
            url:"'.$urlAjax.'",
            success:function(data){
                $("#'.CHtml::activeId($modPPInfoKunjunganV, 'ruangan_id').'").html("<option value>-- Pilih --</pilih>"+data)
            }
        });
    })
',  CClientScript::POS_READY
);?>



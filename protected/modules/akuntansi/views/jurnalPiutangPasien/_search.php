<legend class="rim">Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jurnalpiutangpasien-search',
        'type'=>'horizontal',
        'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event)'
        ),
        'focus'=>'#',
)); ?>

<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'tgl_pendaftaran',array('class'=>'control-label'));?>
                <div class="controls">
                    <?php   
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglAwal',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array(
                                'class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>true
                            ),
                        ));
                    ?>

                </div>
            </div>
            <div class="control-group ">
                <label class="control-label" for="AKRincianpiutangrekeningpasienV_tglAkhir">Sampai Dengan</label>
                <div class="controls">
                    <?php   
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglAkhir',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array(
                                'class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>true
                            ),
                        ));
                    ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php
            echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(array('order'=>'instalasi_nama'),'instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                'ajax' => array('type' => 'POST',
                    'url' => $this->createUrl('GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => 'AKRincianpiutangrekeningpasienV')),
                    'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''),));
            ?>
            <?php echo $form->dropDownListRow($model, 'ruangan_id', array(), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'clearDetail()')); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData(CarabayarM::model()->findAll(array('order'=>'carabayar_nama'),'carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                                                            'ajax' => array('type'=>'POST',
                                                                'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>'AKRincianpiutangrekeningpasienV')), 
                                                                'update'=>'#' . CHtml::activeId($model, 'penjamin_id') . ''  //selector to update
                                                            ),
                                                            'class' => 'span3',
                                    )); ?>

            <?php echo $form->dropDownListRow($model,'penjamin_id', array() ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class' => 'span3')); ?>
            <?php // echo $form->textFieldRow($model,'carabayar_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php // echo $form->textFieldRow($model,'penjamin_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('id'=>'btn_submit','class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'addDetail()')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('id'=>'btn_resset','class'=>'btn btn-danger', 'type'=>'reset','onclick'=>'konfirmasi();')); ?>
    
</div>
<?php $this->endWidget();  
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
	
	Yii::app()->clientScript->registerScript('reloadPage', '
		function konfirmasi(){
			window.location.href="'.Yii::app()->createUrl($module.'/'.$controller.'/Index', array('modul_id'=>Yii::app()->session['modul_id'])).'";
		}', CClientScript::POS_HEAD);
?>
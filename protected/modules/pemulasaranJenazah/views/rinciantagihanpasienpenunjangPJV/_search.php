<legend class='rim'>Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rjrinciantagihanpasien-v-search',
        'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
	<div class="control-group ">
                <?php echo $form->labelEx($model,'tgl_pendaftaran', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                        $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); 
                        $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                        ?>
                </div>
            </div>
	<div class="control-group ">
                <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php 
                        $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                        $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); 
                        $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                        ?>    
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3', 'maxlength'=>20)); ?>
            
</td>
<td>
    <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3', 'maxlength'=>50)); ?>
    <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3', 'maxlength'=>50)); ?>
    <?php echo $form->dropDownListRow($model,'statusBayar', LookupM::getItems('statusbayar'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>20)); ?>
    </td>
</tr>
</table>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('autofocus'=>true, 'class'=>'btn btn-primary', 'type'=>'submit' , 'onKeyUp'=>'return formSubmit(this,event)' )); ?>
          <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>   <?php 
            $content = $this->renderPartial('laboratorium.views.tips.informasi_rincian',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
	</div>

<?php $this->endWidget(); ?>

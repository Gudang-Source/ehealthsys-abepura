<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'info-pemusnahanoa-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nopemusnahan'),
)); ?> 
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Pemusnahan','tglpemusnahan', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                                    $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tgl_awal',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
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
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                                    )); 
                                    $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                                ?>
                            </div>
                    </div> 
                <?php echo $form->textFieldRow($model,'nopemusnahan',array('placeholder'=>'Ketik No. Pemusnahan','class'=>'span3')); ?>
            </td>
	    <td>
		<?php echo $form->dropDownListRow($model,'instalasi_id', $instalasiTujuan, 
                        array('class'=>'span3','empty'=>'-- Pilih --','ajax'=>array('type'=>'POST',
				'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
				'update'=>"#".CHtml::activeId($model, 'ruangan_id'),
                            )));?>
		<?php echo $form->dropDownListRow($model,'ruangan_id',$ruanganAsal,array('empty'=>'-- Pilih --','class'=>'span3')); ?> 
		
	    </td>
            <td>
                <?php echo $form->textFieldRow($model,'pegawaimengetahui_nama',array('placeholder'=>'Ketik Nama Pegawai Mengetahui','class'=>'span3')); ?>
		<?php echo $form->textFieldRow($model,'pegawaimenyetujui_nama',array('placeholder'=>'Ketik Nama Pegawai Menyetujui','class'=>'span3')); ?>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	<?php
           $content = $this->renderPartial('../tips/informasi_gudangfarmasi',array(),true);
           $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
</div>


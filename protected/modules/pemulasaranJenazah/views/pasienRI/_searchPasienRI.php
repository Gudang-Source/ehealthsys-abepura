<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'daftarPasien-form',
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        'focus'=>'#'.CHtml::activeId($model,'no_rekam_medik'),
)); ?>
<fieldset class='box'>
    <legend class="rim">Pencarian</legend>
    <table width='100%' class="table-condensed">
        <tr>
            <td>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                        <?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'onClick'=>'cekTanggal();','rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                        Tanggal Masuk 
                    </label>
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
                        ?> </div></div>
                    <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
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
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                        No. Rekam Medik
                    </label>
                    <div class="controls">
                        <?php echo $form->textField($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3',
                                'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                        Nama Pasien
                    </label>
                    <div class="controls">
                        <?php echo $form->textField($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3',
                                'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    </div></div>
                 
                <?php echo $form->textFieldRow($model,'nama_bin',array('placeholder'=>'Ketik Nama Panggilan','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
            </td>
            <td>     
                <?php echo $form->dropDownListRow($model,'caramasuk_id', CHtml::listData($model->getCaraMasukItems(), 'caramasuk_id', 'caramasuk_nama') ,array('class'=>'span3','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                 <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                        'ajax' => array('type'=>'POST',
                            'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>'AMPasienrawatinapV')), 
                            'update'=>'#'.CHtml::activeId($model,'penjamin_id').''  //selector to update
                        ),)); ?>
                 <?php echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
            </td>
        </tr>
    </table>
    
        <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
			<?php 
$content = $this->renderPartial('../tips/informasi2',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
	</div>
<?php 
echo CHtml::hiddenField('pendaftaran_id');
echo CHtml::hiddenField('pasien_id');
?>
<?php $this->endWidget();?>
</fieldset>  
<legend class="rim"><i class="icon-search icon-white"></i> Pencarian berdasarkan : </legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppbooking-kamar-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model, 'no_pendaftaran'),
)); ?>
<div class="row-fluid">
    <div class="span4">
        <div class="control-group ">
            <?php echo CHtml::label('Tanggal Awal','tgl_awal', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                <?php   
                    $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tgl_awal',
                                'mode'=>'date',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,

                                ),
                                'htmlOptions'=>array('readonly'=>true,
                                'class'=>'dtPicker2', 
                                'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
            )); ?> 
                <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
            </div>
        </div>
        <div class="control-group ">
            <label for="namaPasien" class="control-label">
               Sampai Dengan
            </label>
            <div class="controls">
                <?php $model->tgl_akhir= $format->formatDateTimeForUser($model->tgl_akhir); ?>
                <?php
                    $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tgl_akhir',
                                'mode'=>'date',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                ),
                                'htmlOptions'=>array('readonly'=>true,
                                'class'=>'dtPicker2', 
                                'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                )); ?>
                <?php $model->tgl_akhir= $format->formatDateTimeForDb($model->tgl_akhir); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::activeLabel($model,'no_pendaftaran',array('class'=>'control-label')); ?>
            <div class="controls">
               <?php echo $form->textField($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3')); ?>
            </div>
        </div> 
        <div class="control-group ">
            <?php echo CHtml::activeLabel($model,'statusbooking',array('class'=>'control-label')); ?>
            <div class="controls">
               <?php echo $form->dropDownList($model,'statusbooking', LookupM::getItems('statusbooking'),array('class'=>'span3','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>               
            </div>
        </div> 
    </div>
    <div class="span4">
        <div class="control-group ">
            <?php echo CHtml::activeLabel($model,'statuskonfirmasi',array('class'=>'control-label')); ?>
            <div class="controls">
               <?php echo $form->dropDownList($model,'statuskonfirmasi', CustomFunction::getStatusKonfirmasiBooking(),array('class'=>'span3','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>             
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::activeLabel($model,'ruangan_id',array('class'=>'control-label')); ?>
            <div class="controls">
               <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData(KamarruanganM::model()->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --',
                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'ajax'=>array(
                            'type'=>'POST',
                            'url'=>$this->createUrl('GetKamarRuangan',array('encode'=>false,'namaModel'=>'PPBookingKamarT')),
                            'update'=>'#PPBookingKamarT_kamarruangan_id',),
                        'ajax'=>array(
                            'type'=>'POST',
                            'url'=>$this->createUrl('SetDropdownKelasPelayanan',array('encode'=>false,'namaModel'=>get_class($model))),
                            'update'=>'#'.CHtml::activeId($model, 'kelaspelayanan_id')),
                        )); 
                ?>
            </div>
        </div>         
        <div class="control-group ">
            <?php echo CHtml::activeLabel($model,'kamarruangan_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'kamarruangan_id', array(),array('class'=>'span3','empty'=>'-- Pilih --',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            )); 
                ?>  
            </div>
        </div>
    </div>
    <div class="span4">                                    
        <div class="control-group ">
            <?php echo CHtml::activeLabel($model,'kelaspelayanan_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'kelaspelayanan_id', array() ,array('class'=>'span3','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
        </div> 
        <div class="control-group ">
            <?php echo CHtml::activeLabel($model,'bookingkamar_no',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'bookingkamar_no',array('placeholder'=>'Ketik No. Pemesanan','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::activeLabel($model,'noRekamMedik',array('class'=>'control-label')); ?>
            <div class="controls">
               <?php echo $form->textField($model,'noRekamMedik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
    </div>
</div>




	<?php //echo $form->textFieldRow($model,'bookingkamar_id',array('class'=>'span3')); ?>




	<?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span3')); ?>


	<?php //echo $form->textFieldRow($model,'pasienadmisi_id',array('class'=>'span3')); ?>




	<?php //echo $form->textAreaRow($model,'keteranganbooking',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3')); ?>

	<div class="form-actions">
        <?php $controller = Yii::app()->controller->id; ?>
		    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl($this->id.'/Admin'), 
                                array('class'=>'btn btn-danger',
                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Admin').'";} ); return false;'));  ?>
        <?php  
            $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
        ?>	
	
	</div>

<?php $this->endWidget(); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'search',
	'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model, 'tglrekammedis', array('class' => 'span3')); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglrekammedis', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php $model->tgl_rekam_medik = $format->formatDateTimeForUser($model->tgl_rekam_medik); ?>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_rekam_medik',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3',
						'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                    <?php $model->tgl_rekam_medik = $format->formatDateTimeForDb($model->tgl_rekam_medik); ?>
                </div>
            </div>
                
            <div class="control-group ">
				<label class="control-label">Sampai dengan</label>
                <?php // echo $form->labelEx($model, 'tgl_rekam_medik_akhir', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php $model->tgl_rekam_medik_akhir = $format->formatDateTimeForUser($model->tgl_rekam_medik_akhir); ?>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_rekam_medik_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                    ));
                    ?>
                    <?php $model->tgl_rekam_medik_akhir = $format->formatDateTimeForDb($model->tgl_rekam_medik_akhir); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'maxlength' => 10,'placeholder'=>'Ketik No. Rekam Medik Awal')); ?>
            <div class="control-group ">    
				<label class="control-label">Sampai dengan</label>
				<div class="controls">
				<?php echo $form->textField($model, 'no_rekam_medik_akhir', array('class' => 'span3', 'maxlength' => 10,'placeholder'=>'Ketik No. Rekam Medik Akhir')); ?>
				</div>
            </div>
            <?php //echo $form->textFieldRow($model, 'instalasi_nama', array('class' => 'span3', 'maxlength' => 50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'maxlength' => 50,'placeholder'=>'Ketik Nama Pasien')); ?>
            <?php echo $form->dropDownListRow($model, 'statusrekammedis', LookupM::getItems('statusrekammedis')
                    , array('empty'=>'-- Pilih --', 'class' => 'span3', 'maxlength' => 10)); ?>
            <?php echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama"), 'instalasi_id', 'instalasi_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'onchange'=>'getRuangan();')); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama"), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span3', 'maxlength' => 20,'placeholder'=>'Ketik No. Pendaftaran')); ?>
            
        </td>
    </tr>
</table>

<?php //echo $form->textFieldRow($model,'warnadokrm_id',array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model,'warnadokrm_namawarna',array('class'=>'span5','maxlength'=>20)); ?>

    <?php //echo $form->textFieldRow($model,'warnadokrm_kodewarna',array('class'=>'span5','maxlength'=>20)); ?>

    <?php //echo $form->textFieldRow($model,'lokasirak_id',array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model,'lokasirak_nama',array('class'=>'span5','maxlength'=>100)); ?>

    <?php //echo $form->textFieldRow($model,'nodokumenrm',array('class'=>'span5','maxlength'=>20)); ?>
    <?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span5')); ?>
    <?php //echo $form->textFieldRow($model,'tgl_rekam_medik',array('class'=>'span5')); ?>
<?php //echo $form->textFieldRow($model,'nama_bin',array('class'=>'span5','maxlength'=>30)); ?>

    <?php // echo $form->textFieldRow($model,'jeniskelamin',array('class'=>'span5','maxlength'=>20)); ?>

    <?php //echo $form->textFieldRow($model,'tanggal_lahir',array('class'=>'span5')); ?>

    <?php //echo $form->textAreaRow($model,'alamat_pasien',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

    <?php //echo $form->textFieldRow($model,'tempat_lahir',array('class'=>'span5','maxlength'=>25)); ?>

    <?php //echo $form->textFieldRow($model,'tglmasukrak',array('class'=>'span5')); ?>
<?php //echo $form->textFieldRow($model,'nomortertier',array('class'=>'span5','maxlength'=>2)); ?>

    <?php //echo $form->textFieldRow($model,'nomorsekunder',array('class'=>'span5','maxlength'=>2)); ?>

    <?php //echo $form->textFieldRow($model,'nomorprimer',array('class'=>'span5','maxlength'=>2)); ?>

    <?php //echo $form->textFieldRow($model,'warnanorm_i',array('class'=>'span5','maxlength'=>50)); ?>

    <?php //echo $form->textFieldRow($model,'warnanorm_ii',array('class'=>'span5','maxlength'=>50)); ?>

    <?php //echo $form->textFieldRow($model,'tglkeluarakhir',array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model,'tglmasukakhir',array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model,'dokrekammedis_id',array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span5')); ?>
<?php //echo $form->textFieldRow($model,'pendaftaran_id',array('class'=>'span5')); ?>

    <div class="form-actions">
                        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    </div>

<?php $this->endWidget(); ?>


<script>
    function getRuangan(){
        var value = $('#<?php echo CHtml::activeId($model, 'instalasi_id'); ?>').val();
        if (jQuery.isNumeric(value)){
            $.post('<?php echo $this->createUrl('getRuanganPasien'); ?>', {instalasi_id:value}, function(data){
                $('#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>').html('<option value="">-- Pilih --</option>'+data.dropDown);
            }, 'json');
        }
        else{
            
        }
    }
</script>
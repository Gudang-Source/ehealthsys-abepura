<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<div class="search-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'pesanambulans-t-search',
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'pesanambulans_t'),
)); ?>
    <div class="row-fluid">
        <div class="span4">
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Pemakaian','tglPemakaian', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
					$model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
					$model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                    $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'date',
                                            'options'=> array(
												'dateFormat'=>Params::DATE_FORMAT,
												'maxDate' => 'd',
                                                'showOn' => false,
                                                'yearRange'=> "-150:+0",
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker2', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
					
                    <?php echo $form->error($model, 'tgl_awal'); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Sampai dengan</label>
                <div class="controls">
                    <?php   
                    $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
												'dateFormat'=>Params::DATE_FORMAT,
												'maxDate' => 'd',
                                                'showOn' => false,
                                                'yearRange'=> "-150:+0",
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php echo $form->error($model, 'tgl_akhir'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'pesanambulans_no',array('placeholder'=>'No. Pemesanan','class'=>'span3','maxlength'=>20)); ?>
        </div>
        <div class="span4">
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'No. Pendaftaran','class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'pasien_norekammedis',array('placeholder'=>'No. Rekam Medik','class'=>'span3','maxlength'=>10)); ?>
            <?php echo $form->textFieldRow($model,'pasien_nama',array('placeholder'=>'Nama Pasien','class'=>'span3','maxlength'=>100)); ?>
        </div>
        <div class="span4">
            <?php echo $form->textFieldRow($model,'pemesan_nama',array('placeholder'=>'Nama Pemesan','class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textField($model,'inisial_modul',array('readonly'=>true,'placeholder'=>'Nama Pemesan','class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')).'&nbsp;';  ?>
<?php  
$content = $this->renderPartial('ambulans.views.tips.informasiPemesananAmbulans',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
    </div>

<?php $this->endWidget(); ?>
</div>
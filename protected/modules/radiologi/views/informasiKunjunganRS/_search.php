<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'no_rekam_medik'),
        'htmlOptions'=>array(),

)); ?>
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <div class="row-fluid">
        <div class="span4">
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Kunjungan','Tanggal Awal',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php   $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                           $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tgl_awal',
                                'mode'=>'date',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',

                                ),
                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                ),
                   )); ?>

               </div>
            </div>
            <div class="control-group ">
                 <?php echo CHtml::label('sampai dengan','Tanggal Akhir',array('class'=>'control-label')); ?>
                <div class="controls">
                   <?php   $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                           $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tgl_akhir',
                                'mode'=>'date',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
//                                                    'minDate' => 'd',
                                     'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                ),
                   )); ?>

               </div>
            </div>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3 alphanumeric-only all-caps','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Ketik no. pendaftaran','maxlength' => 12)); ?>
        </div>
        <div class="span4">
            
			<?php echo $form->textFieldRow($model,'no_rekam_medik',array('autofocus'=>true, 'class'=>'span3 numbers-only','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Ketik no. rekam medik', 'maxlength' => 6)); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3 hurufs-only','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Ketik nama pasien')); ?>
            <?php //echo $form->textFieldRow($model,'alias',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Alias')); ?>
			<div class="control-group ">
                <?php echo CHtml::label('Dokter Penanggung Jawab','Dokter Penanggung Jawab', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php   
                        echo $form->dropDownList($model,'nama_pegawai',CHtml::listData(PegawaiM::model()->findAll("pegawai_aktif = TRUE ORDER BY nama_pegawai ASC"), 'nama_pegawai', 'nama_pegawai'),array('empty'=>'--Pilih--','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                    ?>

                </div>
            </div>
        </div>
        <div class="span4">
            
             <?php
                $instalasi = InstalasiM::model()->findAllByAttributes(array(
                    'instalasi_id' => array(2,3,4),
                ));
                $ruangan = RuanganM::model()->findAllByAttributes(array(
                    'instalasi_id' => array(2,3,4),
                    'ruangan_aktif' => true,
                ), array(
                    'order'=>'instalasi_id, ruangan_nama',
                ));
                echo $form->dropDownListRow($model,'instalasi_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
                    'empty'=>'-- Pilih --',
                    'class'=>'span3',                     
                    'ajax' => array('type'=>'POST',
                        'url'=> $this->createUrl('/ActionDynamic/getRuanganDariInstalasi',array('encode'=>false,'namaModel'=>get_class($model))), 
                        'success'=>'function(data){$("#'.CHtml::activeId($model, "ruangan_id").'").html(data); }',
                    ),
                 ));
                echo $form->dropDownListRow($model,'ruangan_id', array(), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));
				?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
        <?php $content = $this->renderPartial('tips/tipsInformasiKunjunganRS',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));    ?>
    </div>
    
<?php $this->endWidget();?>
</fieldset>  
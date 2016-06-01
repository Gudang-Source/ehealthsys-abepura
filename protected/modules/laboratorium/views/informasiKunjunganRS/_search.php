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
    <legend class="rim">Pencarian</legend>
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
                 <?php echo CHtml::label('Sampai Dengan','Tanggal Akhir',array('class'=>'control-label')); ?>
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
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('autofocus'=>true, 'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Ketik no. rekam medik')); ?>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Ketik no. pendaftaran')); ?>
        </div>
        <div class="span4">
            
            <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Ketik nama pasien')); ?>
            <?php //echo $form->textFieldRow($model,'alias',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Alias')); ?>
            <?php 
                $carabayar = CarabayarM::model()->findAll(array(
                    'condition'=>'carabayar_aktif = true',
                    'order'=>'carabayar_nourut',
                ));
                foreach ($carabayar as $idx=>$item) {
                    $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                        'carabayar_id'=>$item->carabayar_id,
                        'penjamin_aktif'=>true,
                   ));
                   if (empty($penjamins)) unset($carabayar[$idx]);
                }
                $penjamin = PenjaminpasienM::model()->findAll(array(
                    'condition'=>'penjamin_aktif = true',
                    'order'=>'penjamin_nama',
                ));
                echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                    'empty'=>'-- Pilih --',
                    'class'=>'span3', 
                    'ajax' => array('type'=>'POST',
                        'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                        'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
                    ),
                 ));
                echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));

            ?>
            <div class="control-group ">
                <?php echo CHtml::label('Dokter Penanggung Jawab','Dokter Penanggung Jawab', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php   
                        echo $form->dropDownList($model,'nama_pegawai',CHtml::listData(DokterV::model()->findAll(" pegawai_aktif = true ORDER BY nama_pegawai ASC "), 'nama_pegawai', 'namaLengkap'),array('empty'=>'--Pilih--','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); 
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
                        'url'=> $this->createUrl('/actionDynamic/getRuanganDariInstalasi',array('encode'=>false,'namaModel'=>get_class($model))), 
                        'success'=>'function(data){$("#'.CHtml::activeId($model, "ruangan_id").'").html(data); }',
                    ),
                 ));
                echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));

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
        <?php $content = $this->renderPartial('laboratorium.views.informasiKunjunganRS.tips.tipsInformasiKunjunganRS',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));    ?>			
    </div>
    
<?php $this->endWidget();?>
</fieldset>  
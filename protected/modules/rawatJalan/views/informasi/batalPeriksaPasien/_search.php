<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
)); ?>
<table width="100%" class="table-condensed">
    <tr>
        <td>
            <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'tglbatal', array('class'=>'control-label')) ?>
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
                <label class='control-label'>Sampai dengan</label>
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
        </td>
        <td>
            <?php // echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','style'=>'width:204px;', 'maxlength'=>20)); ?>
            <div class = "control-group">
                    <?php echo Chtml::label("No Pendaftaran",'no_pendaftaran', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php 
                        $prefix = array(
                           0 => Params::PREFIX_RAWAT_JALAN
                        );
                        echo $form->dropDownList($model,'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix),array('class'=>'numbers-only', 'style'=>'width:75px;')); 
                    ?>
                    <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10,'placeholder'=>'Ketik No. Pendaftaran')); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3', 'maxlength'=>10)); ?>
            <?php echo $form->dropDownListRow($model, 'nama_pegawai', 
                        CHtml::listData(DokterV::model()->findAllByAttributes(array(
                            'instalasi_id'=>Params::INSTALASI_ID_RJ,
                            'pegawai_aktif'=>true,
                        ), array(
                            'order'=>'nama_pegawai asc'
                        )), 'nama_pegawai', 'namaLengkap'), array('empty'=>'-- Pilih --', 'class'=>'span3')); 
                    ?>
        </td>
        <td>
            
        </td>
        <td><?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','maxlength'=>50)); ?>            
                    <?php 
                    $carabayar = CarabayarM::model()->findAll(array(
                        'condition'=>'carabayar_aktif = true',
                        'order'=>'carabayar_nama ASC',
                    ));
                    foreach ($carabayar as $idx=>$item) {
                        $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                            'carabayar_id'=>$item->carabayar_id,
                            'penjamin_aktif'=>true,
                       ),
                            array('order' => 'penjamin_nama ASC')    
                                );
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
                    echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
                    ?>
            <?php echo $form->textFieldRow($model,'nama_pemakai',array('placeholder'=>'Ketik Nama Pembatal','class'=>'span3','maxlength'=>20)); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));  ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
		Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
		array('class'=>'btn btn-danger',
			  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	<?php
		$content = $this->renderPartial('rawatJalan.views.informasi.batalPeriksaPasien.tips.informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
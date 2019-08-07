<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'monitoring-search-form',
                'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'peminjamanrm_id',array('class'=>'span5')); ?>
<table style="width:100%;">
    <tr>
        <td style="width:30%">
            <div class="control-group ">                                   
                <div class="control-label">
                    <?php echo CHtml::label('Tanggal Pendaftaran','tgl_awal'); ?>
                </div>
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
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); 
                            ?>
                </div>
            <?php echo CHtml::label('Sampai dengan','tgl_akhir',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>
                </div>
                <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)')); ?>
                <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)')); ?>
            </div>    
        </td>
        <td>
                <?php echo $form->textFieldRow($model,'nama_pasien'); ?>
                <?php echo $form->dropDownListRow($model,'jeniskasuspenyakit_id',CHtml::listData($model->getJeniskasuspenyakitItems(),'jeniskasuspenyakit_id','jeniskasuspenyakit_nama'),array('empty'=>'-- Pilih --','onkeypress'=>'$(this).focusNextInputField(event)')); ?>               
                <?php echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = true AND instalasi_id In ('".Params::INSTALASI_ID_RAD."','".Params::INSTALASI_ID_REHAB."','".Params::INSTALASI_ID_LAB."','".Params::INSTALASI_ID_IBS."') ORDER BY ruangan_nama ASC"),'ruangan_id','ruangan_nama'),
                        array('empty'=>'-- Pilih --','class'=>'','onkeypress'=>'$(this).focusNextInputField(event)',
                            'ajax' => array('type'=>'POST',
                                'url'=> $this->createUrl('/actionDynamic/getDokterRuangan',array('encode'=>false,'namaModel'=>'RKMonitoringpenunjangV')), 
                                'update'=>'#RKMonitoringpenunjangV_pegawai_id'  //selector to update
                            ),
                            )); ?>
            <?php echo $form->dropDownListRow($model, 'pegawai_id', array(''=>'-- Pilih --')); ?>
                                
                <?php //echo $form->dropDownListRow($model,'carabayar_id',CHtml::listData($model->getCaraBayarItems(),'carabayar_id','carabayar_nama'),array('empty'=>'-- Pilih --','class'=>'','onkeypress'=>'$(this).focusNextInputField(event)')); ?>
                <?php //echo $form->dropDownListRow($model,'penjamin_id',CHtml::listData($model->getPenjaminItems(),'penjamin_id','penjamin_nama'),array('empty'=>'-- Pilih --','class'=>'','onkeypress'=>'$(this).focusNextInputField(event)')); ?>				                           
                
        </td>
        <td>
                 <?php echo $form->dropDownListRow($model,'statusperiksa',LookupM::getItems('statusperiksa'),array('empty'=>'-- Pilih --','class'=>'','onkeypress'=>'$(this).focusNextInputField(event)')); ?>
                <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData(CarabayarM::model()->CarabayarItems, 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                            'ajax' => array('type'=>'POST',
                                'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>'RKMonitoringpenunjangV')), 
                                'update'=>'#RKMonitoringpenunjangV_penjamin_id'  //selector to update
                            ),
                )); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Penjamin',' Penjamin', array('class'=>'control-label')) ?>&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'penjamin_id', PenjaminrekM::model()->getPenjaminItems() ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                    </div>
     
                    </div>
  </td>
    </tr>
</table>
	<div class="form-actions">
                    <?php
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
                        echo '&nbsp;';
                        echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                Yii::app()->createUrl($this->module->id.'/Monitoring/Penunjang'), 
                                                array('class'=>'btn btn-danger',
                                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); 
                        $content = $this->renderPartial('../tips/informasi',array(),true);
                        echo "&nbsp;";
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                    ?>
	</div>
           
      
<?php $this->endWidget(); ?>
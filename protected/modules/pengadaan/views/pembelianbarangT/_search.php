<legend class="rim""><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gupembelianbarang-t-search',
        'type'=>'horizontal',
)); ?>
  
<table width="100%" class="table-condensed">
    <tr>
        <td>
        <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>

            <div class='control-group'>
        <?php $format= new MyFormatter; ?>
         <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
         <div class="controls">  
             <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
            <?php
             $this->widget('MyDateTimePicker', array(
                 'model' => $model,
                 'attribute' => 'tgl_awal',
                 'mode' => 'date',
                 'options' => array(
                     'dateFormat' => Params::DATE_FORMAT,
                     'maxDate'=>'d',
                 ),
                 'htmlOptions' => array('readonly' => true, 'class' => "dtPicker3",
                     'onkeypress' => "return $(this).focusNextInputField(event)"),
             ));
             ?>
             <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
         </div> 
            </div>
        <div class="control-group ">
             <?php $format= new MyFormatter; ?>
            <label for="namaPasien" class="control-label">
               Sampai dengan
              </label>
            <div class="controls">
          <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?> 
                      <?php      $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>
                 <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'nopembelian',array('class'=>'span3', 'maxlength'=>20)); ?>
</td>
        <td>
			 <div class="control-group ">
				<?php echo CHtml::label('Sumber Dana','sumberdana_id', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'sumberdana_id', CHtml::listData(SumberdanaM::model()->findAll('sumberdana_aktif = true ORDER BY sumberdana_nama'), 'sumberdana_id', 'sumberdana_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
				</div>
			</div>
			
			
			
			<div class="control-group ">
				<?php echo CHtml::label('Supplier','supplier_id', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'supplier_id', CHtml::listData(SupplierM::model()->findAll('supplier_aktif = true ORDER BY supplier_nama'), 'supplier_id', 'supplier_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
				</div>
			</div>
                  
			 <div class="control-group ">
				<?php echo CHtml::label('Pegawai Pemesanan','peg_pemesanan_id', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'peg_pemesanan_id', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif = true ORDER BY nama_pegawai'), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
				</div>
			</div>            
            <?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); ?>
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
        $content = $this->renderPartial('pengadaan.views.tips/informasi_pembelian_barang',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>

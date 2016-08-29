<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'gzpengajuanbahanmkn-search',
                 'type'=>'horizontal',
)); ?>
<table width="100%" class="table-condensed">
    <tr>
        <td>
            <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'tglpengajuanbahan', array('class'=>'control-label')) ?>
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
                    )); ?> </div></div>
		<div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
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
                </div>
            
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Tanggal Minta Dikirim
                      </label>
                    <div class="controls">
                            <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tglmintadikirim',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                               // 'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>
                    </div>
                </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nopengajuan',array('class'=>'span3 angkahuruf-only', 'maxlength'=>20, 'placeholder'=>'Ketik no. pengajuan')); ?>
            <?php //echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
            <?php echo $form->dropDownListRow($model,'status_persetujuan', Params::statusPersetujuan(),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'idpegawai_mengajukan', Chtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id  = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"), 'pegawai_id', 'namaLengkap'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
            <?php echo $form->dropDownListRow($model,'idpegawai_mengetahui', Chtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id  = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"), 'pegawai_id', 'namaLengkap'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
            
            
        </td>
    </tr>
</table>

	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	<?php 
$content = $this->renderPartial('../tips/informasiPengajuanBM',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
	</div>

<?php $this->endWidget(); ?>
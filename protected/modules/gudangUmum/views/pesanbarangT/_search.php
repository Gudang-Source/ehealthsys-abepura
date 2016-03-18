<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
  'focus'=>'#'. CHtml::activeId($model,'nopemesanan'),
	'id'=>'gupesanbarang-t-search',
        'type'=>'horizontal',
)); ?>
	<table width="100%" class="table-condensed">
            <tr>
                <td>
                    <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
                    <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Pesan Barang','tglPesanBarang', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                            <?php   
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
                            <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                        </div></div>
						<div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
                    <div class="controls">
                            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
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
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                        </div>
                    </div>                   
                </td>
                <td>
                    <div class="control-group ">
                        <label class="control-label">
                            <?php echo CHtml::activeLabel($model, 'nopemesanan', array('class'=>'control-label')); ?>
                        </label>
                        <div class="controls">
                           <?php echo $form->textField($model,'nopemesanan',array('placeholder'=>'Ketik No. Pemesanan', 'class'=>'span3', 'maxlength'=>20)); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <label class="control-label">
                            <?php echo CHtml::activeLabel($model, 'ruanganpemesan_id', array('class'=>'control-label')); ?>
                        </label>
                        <div class="controls">
                               <?php echo $form->dropDownList($model,'ruanganpemesan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$model->ruanganpemesan->instalasi_id,'ruangan_aktif'=>true), array('order'=>'ruangan_nama ')), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <label class="control-label">
                           <?php echo CHtml::activeLabel($model, 'pegpemesan_id', array('class'=>'control-label')); ?>
                        </label>
                        <div class="controls">
                              <?php echo $form->dropDownList($model,'pegpemesan_id', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif = true ORDER BY nama_pegawai ASC'), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
                        </div>
                    </div>
                    <?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); ?>
                </td>
            </tr>
        </table>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl('informasi'), 
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'refreshForm(this); return false;')); ?>
            <?php  
                $content = $this->renderPartial('gudangUmum.views.pesanbarangT.tips.informasi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>  
    </div>
<?php $this->endWidget(); ?>



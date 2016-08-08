<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'guterimapersediaan-t-search',
        'type'=>'horizontal',
)); ?>

	<table width="100%" class="table-condensed">
            <tr>
                <td>
                    <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
                    <div class="control-group ">
                        <?php echo Chtml::label('Tanggal Terima','tglterima', array('class'=>'control-label')) ?>
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
                            )); ?>
                                 </div></div>
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
                </td>
                <td>
                    <div class = "control-group">
                        <?php echo Chtml::label('No Penerimaan','nopenerimaan',array('class'=>'control-label')); ?>
                        <div class = "controls">
                            <?php echo $form->textField($model,'nopenerimaan',array('class'=>'span3', 'maxlength'=>20, 'placeholder'=>'Ketik no. penerimaan', 'autofocus'=>true)); ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label('Sumber Dana','sumberdana_id',array('class'=>'control-label')); ?>
                        <div class = "controls">
                            <?php echo $form->dropDownList($model,'sumberdana_id', CHtml::listData(SumberdanaM::model()->findAll('sumberdana_aktif = true ORDER BY sumberdana_nama ASC'), 'sumberdana_id', 'sumberdana_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
                        </div>
                    </div>                    
                </td>
                <td>
                    <?php echo $form->dropDownListRow($model,'peg_penerima_id', CHtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = true AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
                    <div class = "control-group">
                        <?php echo Chtml::label('Ruangan Penerima','ruanganpenerima_id',array('class'=>'control-label')); ?>
                        <div class = "controls">
                            <?php echo $form->dropDownList($model,'ruanganpenerima_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
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
                $content = $this->renderPartial('tips/informasi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
        </div>

<?php $this->endWidget(); ?>

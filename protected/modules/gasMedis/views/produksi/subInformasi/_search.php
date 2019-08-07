<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'informasi-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'noterima'),
)); ?> 
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Produksi','tglterima', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                                    $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tgl_awal',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                                    )); 
                                    $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                                ?>
                            </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                                    )); 
                                    $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                                ?>
                            </div>
                    </div> 
                
            </td>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Petugas Gas Medis','petugas', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php  echo $form->dropDownList($model, 'petugasgasmedis_id', CHtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"), 'pegawai_id', 'namaLengkap') ,array('class'=>'span3','empty'=>'-- Pilih --')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Mengetahui','mengetahui_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php  echo $form->dropDownList($model, 'mengetahui_id', CHtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"), 'pegawai_id', 'namaLengkap') ,array('class'=>'span3','empty'=>'-- Pilih --')); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); echo "&nbsp;"; ?>
        <?php
           $content = $this->renderPartial('tips/informasi',array(),true);
           $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
</div>
<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'aspembklaimpiutang-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nokaskeluar'),
)); ?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                <?php echo CHtml::label('Tgl. Pembayaran','tglPembayaran', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php   
                        $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tgl_awal',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                        )); 
                    ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php   
                        $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tgl_akhir',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'minDate' => 'd',
                                        ),
                                        'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                        )); 
                    ?>
                </div>
            </div>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('PenggajianpegT/Informasi'), array('class'=>'btn btn-danger')); ?>
    <?php
        $content = $this->renderPartial('../tips/informasi_penggajianKaryawan',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>

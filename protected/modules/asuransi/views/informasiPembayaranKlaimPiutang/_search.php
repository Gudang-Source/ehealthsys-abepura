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
            <?php echo $form->textFieldRow($model, 'nopembayaranklaim', array('class'=>'angkahuruf-only', 'placeholder' => 'No. Pembayaran Klaim')); ?>
        </td>
        <td>
            
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/barangM/admin'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    echo "&nbsp;";
    ?>
    <?php
       $tips = array(
    '0' => 'tanggal',    
    '1' => 'detail',
    '2' => 'batal',
    '3' => 'cari',
    '4' => 'ulang2'
);
$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>

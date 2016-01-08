<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rencana-lembur-t-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php
                $format = new myFormatter();
                $modRencanaLembur->tgl_awal  = $format->formatDateTimeForUser($modRencanaLembur->tgl_awal);
                $modRencanaLembur->tgl_akhir = $format->formatDateTimeForUser($modRencanaLembur->tgl_akhir);
            ?>
            <div class="control-group ">
                <?php echo $form->labelEx($modRencanaLembur,'tgl_awal', array('class'=>'control-label','style'=>'width:180px;')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$modRencanaLembur,
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'date',
                                            'options'=> array(
												'maxDate'=>'d',
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <?php echo $form->labelEx($modRencanaLembur,'tgl_akhir', array('class'=>'control-label','style'=>'width:180px;')) ?>
                <div class="controls">
                    <?php   
                        $this->widget('MyDateTimePicker',array(
                                        'model'=>$modRencanaLembur,
                                        'attribute'=>'tgl_akhir',
                                        'mode'=>'date',
                                        'options'=> array(
											'maxDate'=>'d',
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                    )); ?>
                </div>
            </div>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('RencanaLemburT/Informasi'), array('class'=>'btn btn-danger','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
        $content = $this->renderPartial('../tips/informasi_rencanaLembur',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>

<?php 
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'realisasi-lembur-t-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
			<?php
                $format = new myFormatter();
                $modRealisasiLembur->tgl_awal  = $format->formatDateTimeForUser($modRealisasiLembur->tgl_awal);
                $modRealisasiLembur->tgl_akhir = $format->formatDateTimeForUser($modRealisasiLembur->tgl_akhir);
            ?>
            <div class="control-group ">
                <?php //echo $form->labelEx($modRealisasiLembur,'tgl_awal', array('class'=>'control-label')) ?>
                <div class='control-label'>Tgl. Awal Realisasi</div>
                    <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$modRealisasiLembur,
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'date',
                                            'options'=> array(
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
                <?php //echo $form->labelEx($modRealisasiLembur,'tgl_akhir', array('class'=>'control-label')) ?>
                <div class='control-label'>Tgl. Akhir Realisasi</div>    
                <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modRealisasiLembur,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
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
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('RealisasiLemburT/Informasi'), array('class'=>'btn btn-danger','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
        $content = $this->renderPartial('../tips/informasi_realisasiLembur',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>

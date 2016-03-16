<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pemesananobatalkeskeluar-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nopemesanan'),
)); ?> 
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Pemesanan','tglpemesanan', array('class'=>'control-label')) ?>
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
                <?php echo $form->textFieldRow($model,'nopemesanan',array('placeholder'=>'Ketik No. Pemesanan','class'=>'numberOnly')); ?>
                <?php echo $form->dropDownListRow($model,'instalasipemesan_id', $instalasiPemesanans, 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                                            'update'=>"#".CHtml::activeId($model, 'ruanganpemesan_id'),
                                )));?>
            </td>
            <td>
                <?php // echo $form->dropDownListRow($model,'ruanganpemesan_id',$ruanganPemesanans,array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model,'statuspesan', LookupM::getItems('statuspesan'),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($model,'statusmutasi', array(1=>'SUDAH DIMUTASi', 2=>'BELUM DIMUTASI'), array('class'=>'span3','empty'=>'-- Pilih --')); ?>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); echo "&nbsp;"; ?><?php
           $content = $this->renderPartial($this->path_view.'/tips/tipsInformasi',array(),true);
           $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</fieldset>
    <?php $this->endWidget(); ?>
</div>

<div id="divSearch-form">
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'rencana-t-search',
            'type'=>'horizontal',
            'focus'=>'#'.CHtml::activeId($model,'noformulir'),
    )); ?> 
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Formulir Opname','tglformulir', array('class'=>'control-label')) ?>
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
            </div>
            <div class="span4">
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
            </div>
            <div class="span4">
                <?php echo $form->textFieldRow($model,'noformulir',array('placeholder'=>'Ketik No. Formulir Opname','class'=>'numberOnly')); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); echo "&nbsp;"; ?><?php
               $content = $this->renderPartial($this->path_view.'tips/tipsInformasi',array(),true);
               $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </fieldset>
</div>
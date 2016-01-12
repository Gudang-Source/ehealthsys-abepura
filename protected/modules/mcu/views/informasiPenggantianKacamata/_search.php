<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'caridata-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'no_pengajuan'),
    'htmlOptions'=>array(),
)); ?>

<fieldset class="box row-fluid"> 
    <legend class="rim"><i clas="icon-white icon-search"></i> Pencarian</legend>
    <table width="100%" class="table-condensed">
            <tr>
                    <td>
                            <div class="control-group ">
                                    <?php $model->tgl_awal = isset($model->tgl_awal) ? MyFormatter::formatDateTimeForUser($model->tgl_awal) : date('d M Y'); ?>
                                    <label class='control-label'>Tanggal Pengajuan</label>
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
                                                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                            )); 
                                                    ?>
                                    </div>
                            </div>
                            <div class="control-group ">
                                    <label class='control-label'>Sampai Dengan</label>
                                    <div class="controls">
                                            <?php $model->tgl_akhir = isset($model->tgl_akhir) ? MyFormatter::formatDateTimeForUser($model->tgl_akhir) : date('d M Y'); ?>
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
                            <?php echo $form->textFieldRow($model,'no_pengajuan',array('placeholder'=>'Ketik No. Memo', 'class'=>'span3', 'maxlength'=>10)); ?>

                            <?php echo $form->dropDownListRow($model,'status', $model->statusGanti(),array('empty'=>'-- Pilih --','style'=>'width:120px;')); ?>  
                    </td>
            </tr>
    </table>
    <div class="form-actions">
            <?php 
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
            ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger',
                            'onclick'=>'return refreshForm(this);'));  ?>
            <?php  
                    $content = $this->renderPartial('tips/informasi',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
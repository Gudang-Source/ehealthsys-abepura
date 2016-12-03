<legend class='rim'><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rjrinciantagihanpasien-v-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
)); ?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Pendaftaran','tgl_pendaftaran', array('class'=>'control-label')) ?>
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
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Akhir','tgl_akhir', array('class'=>'control-label')) ?>
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
            <div class="control-group">
                <?php echo CHtml::label('No. Pendaftaran','no_pendaftaran', array('class'=>'control-label')) ?>                        
                    <div class="controls">

                        <?php 

                                $prefix = array(
                                    0 => Params::PREFIX_RAWAT_DARURAT,
                                    1 => Params::PREFIX_RAWAT_INAP,
                                    2 => Params::PREFIX_RAWAT_JALAN
                                );

                            echo $form->dropDownList($model,'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix),array('class'=>'numbers-only', 'style'=>'width:75px;')); 
                        ?>
                        <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10,'placeholder'=>'Ketik No. Pendaftaran')); ?>                                                                
                    </div>                        
            </div>
            <?php //echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3', 'maxlength'=>20)); ?>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbers-only', 'maxlength'=>6)); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3 hurufs-only', 'maxlength'=>50)); ?>
        </td>
        <td>
            
            <?php echo $form->dropDownListRow($model,'statusBayar', LookupM::getItems('statusbayar'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>20)); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
    echo '&nbsp;';?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php 
        $content = $this->renderPartial('../tips/informasi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>

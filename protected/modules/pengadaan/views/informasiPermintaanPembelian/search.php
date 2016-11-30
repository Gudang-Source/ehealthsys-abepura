<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rencana-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nopermintaan'),
)); ?> 
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Permintaan','tglpermintaanpembelian', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                                    $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tgl_awal',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd'
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
                                                        'maxDate' => 'd'
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                                    )); 
                                    $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                                ?>
                            </div>
                    </div> 
                <?php echo $form->textFieldRow($model,'nopermintaan',array('placeholder'=>'Ketik No. Permintaan','class'=>'angkahuruf-only')); ?>
            </td>
            <td>                               
                <div class = "span5">
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'statuspembelian', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'statuspembelian',LookupM::getItems('statuspembelian'),array('empty'=>'--Pilih--','style'=>'width:130px;')); ?>
                            </div>
                    </div>
                </div>
                
                <?php echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData(RuanganM::model()->getRuanganByInstalasi(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
                        array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
                
                <?php echo $form->dropDownListRow($model,'supplier_id',
                        CHtml::listData(SupplierM::model()->SupplierItems, 'supplier_id', 'supplier_nama'),
                        array('class'=>'span3 isRequired', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'empty'=>'-- Pilih --')); ?>
                
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'index',array('modul_id'=>Yii::app()->session['modul_id'])), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
        ?>
        <?php
           $tips = array(
               '0' => 'tanggal',
               '1' => 'ubah',
               '2' => 'terima',
               '3' => 'detail',
               '4' => 'cari',
               '5' => 'ulang2'
           );
           $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
           $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
</div>
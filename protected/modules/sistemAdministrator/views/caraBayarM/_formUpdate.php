<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sacara-bayar-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'carabayar_nama'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <table>
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model,'carabayar_nama',array('class'=>'span2', 'onkeypress'=>"return nextFocus(this,event,'SACaraBayarM_carabayar_namalainnya','')", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'carabayar_namalainnya',array('class'=>'span2', 'onkeypress'=>"return nextFocus(this,event,'SACaraBayarM_metode_pembayaran','SACaraBayarM_carabayar_nama')", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'metode_pembayaran',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'btn_simpan','SACaraBayarM_carabayar_namalainnya')", 'maxlength'=>50)); ?>
                    <div>
                        <?php echo $form->checkBoxRow($model,'carabayar_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'carabayar_loket',array('class'=>'span1', 'onkeypress'=>"return nextFocus(this,event,'SACaraBayarM_metode_pembayaran','SACaraBayarM_carabayar_nama')", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'carabayar_singkatan',array('class'=>'span1', 'onkeypress'=>"return nextFocus(this,event,'btn_simpan','SACaraBayarM_carabayar_namalainnya')", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'carabayar_nourut',array('class'=>'span1 numbers-only', 'onkeypress'=>"return nextFocus(this,event,'btn_simpan','SACaraBayarM_carabayar_namalainnya')", 'maxlength'=>50)); ?>
                </td>
            </tr>
        </table>

        <div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/caraBayarM/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php
                    $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Cara Bayar', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/sistemAdministrator/CaraBayarM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
        </div>

<?php $this->endWidget(); ?>



<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppruangan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#SAKelasruanganM_ruangan_id',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->dropDownListRow($model,'ruangan_id',  CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); ?>
        
	<div class="control-group">
		<div class="controls">

			 <?php
					$arrKelasPelayanan = KelasruanganM::model()->findAllByAttributes(array('ruangan_id'=>$model->ruangan_id));
//					$arrKelasPelayanan = array();
//					foreach($modRuangan as $Ruangan){
//					   $arrKelasPelayanan[] = $Ruangan['kelaspelayanan_id'];
//					}
					
				   $this->widget('application.extensions.emultiselect.EMultiSelect', array('sortable' => true, 'searchable' => true));
					echo CHtml::dropDownList('kelaspelayanan_id[]',$arrKelasPelayanan,
						CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama"), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
						array('multiple'=>'multiple','key'=>'kelaspelayanan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
					);
			  ?>

		 </div>  
	</div>   
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/'.$this->id.'/admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
						
                         <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelas Ruangan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                        Yii::app()->createUrl($this->module->id.'/'.$this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    
                        <?php
                            $content = $this->renderPartial($this->path_view.'tips/tipsCreateUpdate',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
    
	</div>

<?php $this->endWidget(); ?>

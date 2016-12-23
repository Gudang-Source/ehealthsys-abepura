<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'informasi-penangguhanangsuran-form',
	//'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);',
	'enctype' => 'multipart/form-data'),
)); 
$format = new MyFormatter();
?>
<table width="100%">
    <tr>
        <td>
                        <div class="control-group">	
                                <label class="control-label" >				
                                    Tanggal Penangguhan
                                </label>
				<div class="controls">					
                                    <?php   
                                        $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
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
                                        $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                                        ?>					
    				</div>    				
			</div>
			
            
                        <div class="control-group">				
				<?php echo Chtml::label('Sampai Dengan', 'tgl_akhir', array('class' => 'control-label')); ?>
				<div class="controls">					
                                    <?php   
                                        $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                                        $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tgl_akhir',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                    ));
                                        $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                                        ?>					
    				</div>    				
			</div>
                                    
        </td>
        <td>
                <?php echo $form->textFieldRow($model,'nokeanggotaan',array('class'=>'span3 numbers-only','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nokeanggotaan'),)); ?>	
		
                <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3 hurufs-only','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nama_anggota'),)); ?>	
            
               	
        </td>
    </tr>		
</table>
<div class="span12">
			<?php //echo CHtml::submitButton('Cari', array('class'=>'btn btn-blue', 'id'=>'btn-cari')); ?>
			<?php //echo CHtml::link('Pengajuan Pemotongan', $this->createUrl('pengajuanPemotongan/index'), array('class'=>'btn btn-green', 'id'=>'btn-cari', 'target'=>'_blank')); ?>
                    <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
            ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                        $this->createUrl($this->id.'/index'), 
                                        array('class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>
		
             <?php
                    $tips = array(
                        '0' => 'tanggal',                                           
                        '1' => 'cari',
                        '2' => 'ulang2',
                        
                    );
                    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
		</div> 
<?php $this->endWidget(); ?>

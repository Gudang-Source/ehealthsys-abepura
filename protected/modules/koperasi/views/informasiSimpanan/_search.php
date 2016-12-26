<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
        'id'=>'informasi-anggota-form',
	'method'=>'get',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'form-groups-bordered'),
)); 
$format = new MyFormatter();
?>
<table width="100%">
    <tr>
        <td>
                        <div class="control-group">	
                                <label class="control-label" >				
                                    Tanggal Simpanan
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
                                    ));?>					
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
                                    ));?>					
    				</div>    				
			</div>
                            <?php echo $form->textFieldRow($model,'nosimpanan',array('class'=>'span3 numbers-only','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nosimpanan'),)); ?>	
        </td>
        <td>
                <?php echo $form->textFieldRow($model,'nokeanggotaan',array('class'=>'span3 numbers-only','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nokeanggotaan'),)); ?>	
		
                <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3 hurufs-only','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nama_anggota'),)); ?>	
            
                <div class="control-group">
				<?php echo Chtml::label('Golongan', 'golonganpegawai_id', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('condition'=>'golonganpegawai_aktif = true', 'order'=>'golonganpegawai_nama asc')), 'golonganpegawai_id', 'golonganpegawai_nama'), array('empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
				</div>
			</div>		
		
		
		
		
        </td>
        <td>
            <?php echo $form->dropDownListRow($model, 'jenissimpanan', Chtml::listData(JenissimpananM::model()->findAll("jenissimpanan_aktif = TRUE ORDER BY jenissimpanan ASC"), 'jenissimpanan', 'jenissimpanan'), array('empty' => '-- Pilih --')); ?>
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
		

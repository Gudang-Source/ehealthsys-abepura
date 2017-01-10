<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'informasi-kartuangsuran-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);',
	'enctype' => 'multipart/form-data'),
        )); ?>
<?php 

$format = new MyFormatter();
?>
<table width="100%">
    <tr>
        <td>
                        <div class="control-group">	
                                <label class="control-label" >
				<?php echo $form->checkBox($angsuran,'filterTanggal'); ?>
                                    Tanggal Angsuran
                                </label>
				<div class="controls">					
                                    <?php   
                                        $angsuran->tgl_awal = $format->formatDateTimeForUser($angsuran->tgl_awal);
                                        $this->widget('MyDateTimePicker',array(
                                        'model'=>$angsuran,
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
                                        $angsuran->tgl_akhir = $format->formatDateTimeForUser($angsuran->tgl_akhir);
                                        $this->widget('MyDateTimePicker',array(
                                        'model'=>$angsuran,
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
            
                        <?php echo $form->textFieldRow($angsuran,'no_pinjaman',array('class'=>'span3 angkahuruf-only','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$angsuran->getAttributeLabel('no_pinjaman'),)); ?>	
        </td>
        <td>
                <?php echo $form->textFieldRow($angsuran,'nokeanggotaan',array('class'=>'span3 numbers-only','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$angsuran->getAttributeLabel('nokeanggotaan'),)); ?>	
		
                <?php echo $form->textFieldRow($angsuran,'nama_pegawai',array('class'=>'span3 hurufs-only','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$angsuran->getAttributeLabel('nama_anggota'),)); ?>	
            
                <div class="control-group">
				<?php echo $form->label($angsuran, 'golonganpegawai_id', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($angsuran, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('condition'=>'golonganpegawai_aktif = true', 'order'=>'golonganpegawai_nama asc')), 'golonganpegawai_id', 'golonganpegawai_nama'), array('empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
				</div>
			</div>
		</div>
		
		
		
		<?php echo $form->dropDownListRow($angsuran,'statuspinjaman',Params::statusPinjaman(),array('empty'=>'-- Pilih --', 'class'=>'form-control')); ?>		
		
        </td>
    </tr>
		
			
			
</table>
		<div class="span12">
			<?php //echo CHtml::submitButton('Cari', array('class'=>'btn btn-blue', 'id'=>'btn-cari')); ?>
			<?php //echo CHtml::link('Pengajuan Pemotongan', $this->createUrl('pengajuanPemotongan/index'), array('class'=>'btn btn-green', 'id'=>'btn-cari', 'target'=>'_blank')); ?>
                    <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
            ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                        $this->createUrl($this->id.'/index'), 
                                        array('class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>
		
             <?php
                    $tips = array(
                        '0' => 'tanggal',
                        '1' => 'ubah',
                        '2' => 'printKartu',
                        '3' => 'batal',
                        '4' => 'cari',
                        '5' => 'ulang2',
                        
                    );
                    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
		</div> 
	

  <?php $this->endWidget(); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'informasi-pengajuanpemotongan-form',
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
                                    Tanggal Pengajuan
                                </label>
				<div class="controls">					
                                    <?php   
                                        $pengajuanPemotongan->tgl_awal = $format->formatDateTimeForUser($pengajuanPemotongan->tgl_awal);
                                        $this->widget('MyDateTimePicker',array(
                                        'model'=>$pengajuanPemotongan,
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
                                        $pengajuanPemotongan->tgl_akhir = $format->formatDateTimeForUser($pengajuanPemotongan->tgl_akhir);
                                        $this->widget('MyDateTimePicker',array(
                                        'model'=>$pengajuanPemotongan,
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
            
                        <?php echo $form->textFieldRow($pengajuanPemotongan,'nopengajuan',array('class'=>'span3 angkahuruf-only','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$pengajuanPemotongan->getAttributeLabel('no_pinjaman'),)); ?>	
        </td>
        <td>
                <?php echo $form->textFieldRow($pengajuanPemotongan,'nokeanggotaan',array('class'=>'span3 numbers-only','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$pengajuanPemotongan->getAttributeLabel('nokeanggotaan'),)); ?>	
		
                <?php echo $form->textFieldRow($pengajuanPemotongan,'nama_pegawai',array('class'=>'span3 hurufs-only','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$pengajuanPemotongan->getAttributeLabel('nama_anggota'),)); ?>	
            
                <div class="control-group">
				<?php echo Chtml::label('Sumber Potongan', 'golonganpegawai_id', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($pengajuanPemotongan, 'potongansumber_id', CHtml::listData(PotongansumberM::model()->findAll(array('condition'=>'potongansumber_aktif = true', 'order'=>'namapotongan asc')), 'potongansumber_id', 'namapotongan'), array('empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
				</div>
			</div>
		</div>
		
		
		
		
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

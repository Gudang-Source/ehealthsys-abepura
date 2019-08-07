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
                

            <div class="control-group ">
                    <label for="namaPasien" class="control-label">                        
                        Tanggal Keanggotaan
                    </label>
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
                        ));?>
                    </div>
                </div>

                <div class="control-group ">
                    <label for="namaPasien" class="control-label">                        
                        Sampai Dengan
                    </label>
                    <div class="controls">
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                        <?php   $format = new MyFormatter;
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

		
		<div class="control-group">
                        <?php echo Chtml::label('No Keanggotaan','nokeanggotaan',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'nokeanggotaan',array('class'=>'form-control numbers-only', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nokeanggotaan'),)); ?>
			</div>
		</div>
            </td>
       
            <td>
                  <div class="control-group">
            <?php echo $form->labelEx($model, 'Golongan',array('class'=>'control-label col-sm-3')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('condition'=>'golonganpegawai_aktif = true','order'=>'golonganpegawai_nama')), 'golonganpegawai_id', 'golonganpegawai_nama'), array("class"=>"form-control", "empty" => "-- Pilih --")); ?>
            </div>
      </div>
      <div class="control-group">
            <?php echo $form->labelEx($model, 'Jabatan',array('class'=>'control-label col-sm-3')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(array('condition'=>'jabatan_aktif = true','order'=>'jabatan_nama')), 'jabatan_id', 'jabatan_nama'), array("class"=>"form-control", "empty" => "-- Pilih --")); ?>
            </div>
      </div>
            </td>
        
    </table>
		<?php //echo $form->textAreaRow($model,'alamat_pegawai',array('rows'=>2, 'cols'=>50, 'class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('alamat_pegawai'),)); ?>

            <?php /*
            <div class="form-group">
            <?php echo $form->labelEx($model, 'Unit',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-5">
                <?php echo $form->dropDownList($model, 'unit_id', CHtml::listData(UnitM::model()->findAll(array('condition'=>'unit_aktif = true','order'=>'namaunit')), 'unit_id', 'namaunit'), array("class"=>"form-control", "empty" => "-- Pilih --")); ?>
            </div>
      </div> */ ?>
      
		
	
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
<?php $this->endWidget(); ?>

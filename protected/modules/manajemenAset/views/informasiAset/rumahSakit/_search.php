<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'invtanah-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nama_pegawai'),
)); 
$format = new MyFormatter();
?>

	<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>

<div class="row-fluid">
	<table style = "width:100%">
            <tr>
                <td>
                   <div class='control-group hari'>
                    <?php /*echo CHtml::label('Tanggal Penjualan', 'dari_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => "dtPicker3",
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                                               
                        ?>
                        <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
                    </div> 

                </div>
                <div class='control-group hari'>
                    <?php echo CHtml::label('Sampai Dengan', 'dari_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>                     
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => "dtPicker3",
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); */?>                     
                    </div>
                    
               <!-- </div>-->
                    <div class = "control-group">
                       <?php echo Chtml::label("Kode Inventaris",'inventarisasi_kode', array('class'=>'control-label')) ?>
                       <div class = "controls">
                           <?php echo $form->textField($model,'inventarisasi_kode',array('class'=>'angkahuruf-only')) ?>
                       </div>
                   </div>
               
                   <div class = "control-group">
                       <?php echo Chtml::label("Nama Barang",'barang_nama', array('class'=>'control-label')) ?>
                       <div class = "controls">
                           <?php echo $form->textField($model,'barang_nama',array('class'=>'custom-only')) ?>
                       </div>
                   </div>
               
                   <div class = "control-group">
                       <?php echo Chtml::label("Kode Barang",'barang_kode', array('class'=>'control-label')) ?>
                       <div class = "controls">
                           <?php echo $form->textField($model,'barang_kode',array('class'=>'')) ?>
                       </div>
                   </div>
                </td>
                <td>
                   
                    
                    <div class = "control-group">
                       <?php echo Chtml::label("Tahun Beli",'barang_thnbeli', array('class'=>'control-label')) ?>
                       <div class = "controls">
                           <?php echo $form->dropDownList($model,'barang_thnbeli', CustomFunction::getTahun(null, null),array('empty'=>'-- Pilih --')) ?>
                       </div>
                   </div>
                    
                   <div class = "control-group">
                       <?php echo Chtml::label("Ruangan",'ruangan_id', array('class'=>'control-label')) ?>
                       <div class = "controls">
                           <?php echo $form->dropDownList($model,'ruangan_id', Chtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --')) ?>
                       </div>
                   </div>
                    
                    <div class = "control-group">
                       <?php echo Chtml::label("Keadaan",'inventarisasi_keadaan', array('class'=>'control-label')) ?>
                       <div class = "controls">
                           <?php echo $form->dropDownList($model,'inventarisasi_keadaan', LookupM::getItems('inventariskeadaan'),array('empty'=>'-- Pilih --')) ?>
                       </div>
                   </div>
                   
                </td>                
                <td>                    
                    <div class = "control-group">
                       &nbsp;
                       <div class = "controls">
                           &nbsp;
                       </div>
                   </div>
                   
                </td>                
            </tr>
        </table>
		

</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
						$this->createUrl($this->id.'/index'), 
						array('class'=>'btn btn-danger',
							  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
          $tips = array(
              '0' => 'tanggal',
              '1' => 'cari',
              '2' => 'ulang'
          );
          $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
          $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>

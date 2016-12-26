<legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
<div class="search-form" style="">
	<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
		'type' => 'horizontal',
		'id' => 'searchLaporan',
		'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
			));
	?>
	 <style>

            label.checkbox, label.radio{
                width:150px;
                display:inline-block;
            }
        

    </style>
		<div class="row-fluid">
		 <div class="span4">
			 <?php echo CHtml::label('Periode Laporan', 'tglmasukpenunjang', array('class' => 'control-label')) ?>
			 <?php echo CHtml::hiddenField('type',''); ?>
			 <div class="controls">
				 <?php echo $form->dropDownList($model,'jns_periode', array('hari'=>'Hari','bulan'=>'Bulan','tahun'=>'Tahun'), array('class'=>'span2', 'onchange'=>'ubahJnsPeriode();')); ?>
			 </div><br /><br />
                   
		 </div>
		 <div class="span4">
			 <div class='control-group hari'>
				 <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
				 <div class="controls">  
					 <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
					<?php
					 $this->widget('MyDateTimePicker', array(
						 'model' => $model,
						 'attribute' => 'tgl_awal',
						 'mode' => 'date',
						 'options' => array(
							 'dateFormat' => Params::DATE_FORMAT,
							 'maxDate'=>'d',
						 ),
						 'htmlOptions' => array('readonly' => true, 'class' => "span2",
							 'onkeypress' => "return $(this).focusNextInputField(event)"),
					 ));
					 ?>
					 <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
				 </div> 

			 </div>
			 <div class='control-group bulan'>
				 <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
				 <div class="controls">
					 <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
					 <?php 
						 $this->widget('MyMonthPicker', array(
							 'model' => $model,
							 'attribute' => 'bln_awal', 
							 'options'=>array(
								 'dateFormat' => Params::MONTH_FORMAT,
							 ),
							 'htmlOptions' => array('readonly' => true,
								 'class' => "span2",
								 'onkeypress' => "return $(this).focusNextInputField(event)"),
						 ));  
					 ?>
					 <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
				 </div> 
			 </div>
			 <div class='control-group tahun'>
				 <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
				 <div class="controls">
					 <?php 
					 echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
					 ?>
				 </div>
			 </div>
		 </div>
		 <div class="span4">
			 <div class='control-group hari'>
				 <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
				 <div class="controls">  
					 <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
					 <?php
					 $this->widget('MyDateTimePicker', array(
						 'model' => $model,
						 'attribute' => 'tgl_akhir',
						 'mode' => 'date',
						 'options' => array(
							 'dateFormat' => Params::DATE_FORMAT,
							 'maxDate'=>'d',
						 ),
						 'htmlOptions' => array('readonly' => true,'class' => "span2",
							 'onkeypress' => "return $(this).focusNextInputField(event)"),
					 ));
					 ?>
					 <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
				 </div> 
			 </div>
			 <div class='control-group bulan'>
				 <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
				 <div class="controls"> 
					 <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
					 <?php 
						 $this->widget('MyMonthPicker', array(
							 'model' => $model,
							 'attribute' => 'bln_akhir', 
							 'options'=>array(
								 'dateFormat' => Params::MONTH_FORMAT,
							 ),
							 'htmlOptions' => array('readonly' => true,'class' => "span2",
								 'onkeypress' => "return $(this).focusNextInputField(event)"),
						 ));  
					 ?>
					 <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
				 </div> 
			 </div>
			 <div class='control-group tahun'>
				 <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
				 <div class="controls">
					 <?php 
					 echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
					 ?>
				 </div>
			 </div>
		 </div> 
	 </div>
        
	<div class="form-actions">
		<?php
		echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
		?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
							Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
							array('class'=>'btn btn-danger',
								  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;'));  ?>
	</div>
	<?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>
<script>
    function checkAll() {
        if($('#checkAllGolongan').is(':checked')){
           $('#searchLaporan input[name*="golonganpegawai_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#searchLaporan input[name*="golonganpegawai_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }
        
        if($('#checkAllJabatan').is(':checked')){
           $('#searchLaporan input[name*="jabatan_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#searchLaporan input[name*="jabatan_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }

       if($('#checkAllPangkat').is(':checked')){
           $('#searchLaporan input[name*="pangkat_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#searchLaporan input[name*="pangkat_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }
        
        if($('#checkAllJenisKelamin').is(':checked')){
           $('#searchLaporan input[name*="jeniskelamin"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#searchLaporan input[name*="jeniskelamin"]').each(function(){
                $(this).removeAttr('checked');
           });
        }
    }
    
    $(document).ready(function(){
        checkAll();
    });
</script>

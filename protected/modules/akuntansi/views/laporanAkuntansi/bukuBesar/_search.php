<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
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

label.checkbox{
        width:150px;
        display:inline-block;
}
</style>
<fieldset class='box'>
    <legend class="rim"><i class='icon-white icon-search'></i> Pencarian</legend>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group ">
				<?php echo $form->labelEx($modelLaporan, 'periodeposting_id', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php 
						echo $form->dropDownList($modelLaporan, 'periodeposting_id', CHtml::listData(AKPeriodepostingM::model()->findAll("periodeposting_aktif = TRUE ORDER BY deskripsiperiodeposting ASC"),'periodeposting_id','deskripsiperiodeposting'), array('empty' => '-- Pilih --',
						'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm'));
					?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Unit Kerja', 'Unit Kerja', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                        echo $form->dropDownList($modelLaporan,'ruangan_id',CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"),
							'ruangan_id','ruangan_nama'),array('class'=>'span2','style'=>'width:140px','empty'=>'-- Pilih --')); 
                    ?>
                </div>
			</div>
		</div>
		<div class="span6">
			<div class='control-group'>
				<?php echo CHtml::label('Kode Rekening','koderekening', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php 
						$this->widget('MyJuiAutoComplete', array(
							'model' => $modelLaporan,
							'attribute' => 'koderekening',
							'sourceUrl' => $this->createUrl('rekeningKodeAkuntansi'),
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => 2,
								'focus' => 'js:function( event, ui ) {
									if(ui.item.kdrincianobyek ){
										$(this).val(ui.item.kdrincianobyek);
									}else{
										if(ui.item.kdobyek){
											$(this).val(ui.item.kdobyek);
										}else if(ui.item.kdjenis){
											$(this).val(ui.item.kdjenis)
										}
									}
									return false;
								}',
								'select' => 'js:function( event, ui ) {
									   $(this).val(ui.item.value);                                            
									   return false;
								}'
							),
							'htmlOptions' => array(
								'onkeypress' => "return $(this).focusNextInputField(event)",
								'placeholder'=>'Ketikan Kode Rekening',
								'class'=>'span3',
								'style'=>'width:150px;',
							),
						));
					?>
				</div>
			</div>
			
			<div class='control-group'>
				<?php echo CHtml::label('Nama Rekening','namarekening', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php
						$this->widget('MyJuiAutoComplete', array(
							'model' => $modelLaporan,
							'attribute' => 'namarekening',
							'name'=>'namarekening',
							'sourceUrl' => $this->createUrl('rekeningAkuntansi'),
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => 2,
								'focus' => 'js:function( event, ui ) {
									 if(ui.item.nmrincianobyek){
										$(this).val(ui.item.nmrincianobyek);
									 }else{
										if(ui.item.nmobyek){
											$(this).val(ui.item.nmobyek);
										}else if(ui.item.nmjenis){
											$(this).val(ui.item.nmjenis)
										}
									 }
									 return false;
								}',
								'select' => 'js:function( event, ui ) {
									$(this).val(ui.item.value);
									  return false;
								}'
							),
							'htmlOptions' => array(
								'onkeypress' => "return $(this).focusNextInputField(event)",
								'placeholder'=>'Ketikan Nama Rekening',
								'class'=>'span3',
								'style'=>'width:150px;',
							),
						));
					?>
				</div>
			</div>
		</div>
	</div>
	
    <div class="form-actions">
        <?php
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), 
				array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));?>
        
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				$this->createUrl($this->id.'/LaporanBukuBesar'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);')); ?>
    </div>
</div>  
<?php
    $this->endWidget();
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
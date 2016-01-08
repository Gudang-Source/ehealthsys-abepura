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
	<div class="row-fluid">
		<div class="span12">
			<?php echo CHtml::hiddenField('type', ''); ?>
			<?php //echo CHtml::hiddenField('src', ''); ?>
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Tanggal</legend>
				<div class="span6">
					<div class="control-group">
						<div class = 'control-label'>Tanggal Pemakaian</div>
						<div class="controls">  
							<?php
								$this->widget('MyDateTimePicker',array(
											'model' => $model,
											'attribute' => 'tgl_awal',
											'mode' => 'date',
	//                                        'maxDate'=>'d',
											'options' => array(
												'dateFormat' => Params::DATE_FORMAT,
											),
											'htmlOptions' => array('readonly' => true,
												'onkeypress' => "return $(this).focusNextInputField(event)"),
								));
							?>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<?php echo CHtml::label(' Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
						<div class="controls">  
							<?php
								$this->widget('MyDateTimePicker', array(
										'model' => $model,
										'attribute' => 'tgl_akhir',
										'mode' => 'date',
	//                                            'maxdate'=>'d',
										'options' => array(
											'dateFormat' => Params::DATE_FORMAT,
										),
										'htmlOptions' => array('readonly' => true,
											'onkeypress' => "return $(this).focusNextInputField(event)"),
								));
							?>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="span12">
			<div id='searching'>
				<fieldset class="box2">
					<legend class="rim">Berdasarkan Jenis Obat</legend>
					<div>
						<input id="checkAll" class="checkbox-column" type="checkbox" name="checkAll" value="1" checked="checked" onclick="checkAllJO()" onkeypress="return $(this).focusNextInputField(event)">
						Pilih Semua
					</div><br/>
					<?php
						echo $form->CheckBoxList($model,'jenisobatalkes_id',CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_nama'));
					?>
				</fieldset>
			</div>
		</div>
	</div>
    
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan',
        'ajax' => array(
				'type' => 'GET', 
				'url' => array("/".$this->route), 
				'update' => '#tableLaporan',
				'beforeSend' => 'function(){
					$("#tableLaporan").addClass("animation-loading");
				}',
				'complete' => 'function(){
					$("#tableLaporan").removeClass("animation-loading");
				}',
             )
            )); ?>
	<?php
 //echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
 //                                                                       array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));?> 
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
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
<script>

        function checkAllJO() {
            if ($("#checkAll").is(":checked")) {
                $('.checkbox input[name*="RDLaporanpemakaiobatalkesV"]').each(function(){
                   $(this).attr('checked',true);
                })
            } else {
               $('.checkbox input[name*="RDLaporanpemakaiobatalkesV"]').each(function(){
                   $(this).removeAttr('checked');
                })
            }
            //setAll();
        }
</script>
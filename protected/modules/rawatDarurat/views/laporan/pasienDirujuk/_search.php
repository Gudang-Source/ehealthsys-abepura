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
        #rujukankeluar tr td label.checkbox{
            width: 100px;
            display:inline-block;
        }
        table{
            margin-bottom: 0px;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
    </style>
	<div class="row-fluid">
		<div class="span12">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Kunjungan</legend>
				<table width="100%">
					<tr>
						<td width="50%">
							<?php echo CHtml::hiddenField('type', ''); ?>
							<div class='control-group'>
								<div class = 'control-label'>Tanggal Pemeriksaan</div>
								<div class="controls">  
									<?php
									$this->widget('MyDateTimePicker', array(
										'model' => $model,
										'attribute' => 'tgl_awal',
										'mode' => 'date',
										'options' => array(
											'dateFormat' => Params::DATE_FORMAT,
											'maxDate'=>'d'
										),
										'htmlOptions' => array('readonly' => true,
											'onkeypress' => "return $(this).focusNextInputField(event)"),
									));
									?>
								</div>
							</div>
						</td>
						<td> 
							<div class="control-group ">
								<div class = 'control-label'>Sampai Dengan</div>
								<div class="controls">
									<?php
									$this->widget('MyDateTimePicker', array(
										'model' => $model,
										'attribute' => 'tgl_akhir',
										'mode' => 'date',
										'options' => array(
											'dateFormat' => Params::DATE_FORMAT,
											'maxDate'=>'d'
										),
										'htmlOptions' => array('readonly' => true,
										'onkeypress' => "return $(this).focusNextInputField(event)"),
									));
									?>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div class="span12">
			<fieldset class="box2">
			<legend class="rim">
				Berdasarkan Tujuan Rujukan &nbsp; <?php echo CHtml::checkBox('cek_all', true, array('value'=>'cek', 'onchange'=>'cek_all_tindakan(this)'));?>
			</legend>
				<?php echo '<table width="100%" id="rujukankeluar">
						<tr>
							<td>'.

								$form->checkBoxList($model, 'rujukankeluar_id', CHtml::listData(RujukankeluarM::model()->findAll(), 'rujukankeluar_id', 'rumahsakitrujukan'),
										array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",'checked'=>'checked','template'=>'<div style="width:298px; float:left; padding:2.5px;">{input} {label}</div>')).'

							</td>
						</tr>
					 </table>'; ?>
		</fieldset>
		</div>
	</div>
        
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan',
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
             ))); 
        ?>
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
//$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<script type="text/javascript">
    function cek_all_tindakan(obj){
        if($(obj).is(':checked')){
            $("#rujukankeluar").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#rujukankeluar").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    $(document).ready(function(){
        $('.checkbox').addClass();
    });
</script>


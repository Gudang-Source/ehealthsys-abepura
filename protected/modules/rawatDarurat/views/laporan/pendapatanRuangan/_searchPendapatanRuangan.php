<div class="search-form" style="">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
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

        #penjamin label.checkbox{
            width: 120px;
            display:inline-block;
        }

    </style>
	<div class="row-fluid">
		<div class="span12">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Tanggal Kunjungan</legend>
				<table width="100%">
					<tr>
						<td width="50%">
							<?php echo CHtml::hiddenField('type', ''); ?>
							<?php //echo CHtml::hiddenField('src', ''); ?>
							<div class = 'control-label'>Tanggal Pelayanan</div>
							<div class="controls">  
								<?php
								$this->widget('MyDateTimePicker', array(
									'model' => $model,
									'attribute' => 'tgl_awal',
									'mode' => 'date',
									'options' => array(
										'dateFormat' => Params::DATE_FORMAT,
										'maxDate'=>'d',
									),
									'htmlOptions' => array('readonly' => true,
										'onkeypress' => "return $(this).focusNextInputField(event)"),
								));
								?>
							</div>
						</td>
						<td>
							<?php echo CHtml::label('Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
								<div class="controls">  
									<?php
									$this->widget('MyDateTimePicker', array(
										'model' => $model,
										'attribute' => 'tgl_akhir',
										'mode' => 'date',
										'options' => array(
											'dateFormat' => Params::DATE_FORMAT,
											'maxDate'=>'d',
										),
										'htmlOptions' => array('readonly' => true,
											'onkeypress' => "return $(this).focusNextInputField(event)"),
									));
									?>
								</div>
						</td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div class="span4">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Kelas Pelayanan </legend>
				<?php echo'<table>
					<tr>
						<td>
							<div>'.CHtml::checkBox("checkAllR",true, array("onkeypress"=>"return $(this).focusNextInputField(event)",
								"class"=>"checkbox-column","onclick"=>"checkAllRuangan()","checked"=>"checked")).' Pilih Semua </div><br/>
							<div id="Ruangan">'.
							$form->checkBoxList($model, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('value'=>'pengunjung', 'inline'=>true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'
							</div>
						</td>
					 </tr>
				</table>'; ?>
			</fieldset>
		</div>
		<div class="span4">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Dokter </legend>
				<?php //echo $form->textFieldRow($model,'nama_pegawai',array()); ?>
				<div class="control-group ">
					<?php echo $form->labelEx($model, 'Nama Dokter', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php 
						//echo CHtml::activeHiddenField($model, 'pegawai_id');
						$this->widget('MyJuiAutoComplete', array(
							'name'=>CHtml::activeId($model, 'nama_pegawai'),
							 'model'=>$model,
							 'source'=>'js: function(request, response) {
											$.ajax({
												url: "'.Yii::app()->createUrl('ActionAutoComplete/Pegawai').'",
												dataType: "json",
												data: {
													term: request.term,
												},
												success: function (data) {
														response(data);
												}
											})
										 }',
							  'options'=>array(
									'showAnim'=>'fold',
									'minLength' => 2,
									'focus'=> 'js:function( event, ui ) {
										 $(this).val(ui.item.value);
										 return false;
									 }',
									'select'=>'js:function( event, ui ) {
										 $("#'.CHtml::activeId($model, 'nama_pegawai').'").val(ui.item.nama_pegawai);
										 return false;
									 }',
							 ),
							 'htmlOptions'=>array(
								 'readonly'=>false,
								 'placeholder'=>'Nama Dokter',
								 'class'=>'span3',
								 'onkeypress'=>"return $(this).focusNextInputField(event);",
							 ),
							 'tombolDialog'=>array('idDialog'=>'dialogPegawai'),
						)); ?>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="span4">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Cara Bayar </legend>
				<?php echo '<table>
					<tr>
						<td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Cara&nbsp;Bayar</label></td>
						<td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
							'ajax' => array('type' => 'POST',
								'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
								'update' => '#penjamin',  //selector to update
							),
						)).'
						</td>
					</tr>
					<tr>
						<td>
							<label>Penjamin</label>
						</td>
						<td>
							<div id="penjamin">'.
								//$form->checkBoxList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('value'=>'pengunjung', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'
							'<label>Data Tidak Ditemukan</label></div>
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
             )
            )); 
        ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<?php 
//$urlGetPenjamin = Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().''));
//Yii::app()->clientScript->registerScript('ajax','
//    $("#'.CHtml::activeId($model, 'carabayar_id').'").change(function(){
//        id = $(this).val();
//        $.post("'.$urlGetPenjamin.'", {id:id},function(data){
//            
//        });
//    });
//',CClientScript::POS_READY); ?>

<?php //Yii::app()->clientScript->registerScript('onclickButton','
//  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
//  $(".accordion-heading a.accordion-toggle").click(function(){
//            $(this).parents(".accordion").find("div.tampilGrafik").remove();
//            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
//            
//            
//  });
//',  CClientScript::POS_READY);
?>
<?php 
    // Dialog buat nambah data pegawai =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogPegawai',
        'options'=>array(
            'title'=>'Pencarian Dokter',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>800,
            'minHeight'=>500,
            'resizable'=>false,
        ),
));

    $modPegawai =new PegawaiM();
    $modPegawai->unsetAttributes();
    if(isset($_GET['PegawaiM'])) {
        $modPegawai->attributes = $_GET['PegawaiM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array( 
        'id'=>'sapegawai-m-grid', 
        'dataProvider'=>$modPegawai->search(), 
        'filter'=>$modPegawai, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                                              "onClick"=>"
                                                $(\"#'.CHtml::activeId($model, 'nama_pegawai').'\").val(\"$data->nama_pegawai\");
                                                $(\"#dialogPegawai\").dialog(\"close\");    
                                                "
                                         ))',
            ),
            'nomorindukpegawai',
            'nama_pegawai',
            'jeniskelamin',
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>

        <?php $this->endWidget(); ?>
<script>
        function checkAll() {
            if ($("#checkAllCaraBayar").is(":checked")) {
                $('#penjamin input[name*="RDLaporanpendapatanruangan"]').each(function(){
                   $(this).attr('checked',true);
                })
            } else {
               $('#penjamin input[name*="RDLaporanpendapatanruangan"]').each(function(){
                   $(this).removeAttr('checked');
                })
            }
            //setAll();
        }

        function checkAllRuangan() {
            if ($("#checkAllR").is(":checked")) {
                $('#Ruangan input[name*="RDLaporanpendapatanruangan"]').each(function(){
                   $(this).attr('checked',true);
                })
            } else {
               $('#Ruangan input[name*="RDLaporanpendapatanruangan"]').each(function(){
                   $(this).removeAttr('checked');
                })
            }
            //setAll();
        }
        
        function setAll(obj){
            $('.cekList').each(function(){
               if ($(this).is(':checked')){

                    $(this).parents('tr').find('.cekList').val(1);
                    }else{
                        $(this).parents('tr').find('.cekList').val(0);
                    }
            });
        }
</script>
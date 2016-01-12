<div class="white-container">
<legend class="rim2">Rencana Pelatihan</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rencanapelatihan-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event); '),//dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
		'focus' => '#KPRencanadiklatT_0_pegawai_nama',
)); ?>
<?php 
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success', "Data Rencana Pelatihan berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>
<fieldset class="box">   
<legend class="rim"><span class='judul'>Data Rencana Pelatihan </span></legend>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group">
			<?php echo $form->labelEx($model,'tglrencanadiklat', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php 
				$this->widget('MyDateTimePicker', array(
				'model'=>$model,
				'attribute'=>'tglrencanadiklat',
				'mode' => 'date',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,
				'class'=>'span2',
				'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>
			</div>
		</div>
		<?php echo $form->textFieldRow($model,'norencanadiklat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
		<?php echo $form->hiddenField($model,'jmlRow',array('class'=>'span2','style'=>'width:90px;','readonly'=>true))?>
	</div>
</div>
</fieldset>
	<div class="block-tabel">
        <h6>Tabel <b>Rencana Pelatihan</b></h6>
        <table class="items table table-striped table-condensed" id="table-rencanapelatihan">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Induk Pegawai</th>
                    <th>Nama Pegawai</th>
                    <th>Jenis Pelatihan</th>
                    <th>Nama Pelatihan</th>
                    <th>Tanggal Pelatihan</th>
                    <th>Lama Pelatihan</th>
                    <th>Tempat Pelatihan</th>
                    <th>Alamat Pelatihan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $trRencanaPelatihan = $this->renderPartial('_rowRencanaPelatihan',array('format'=>$format,'model'=>$model),true); 
                echo $trRencanaPelatihan;
                ?>
            </tbody>
        </table>
    </div>  
	<div class="row-fluid box">
		<div class="span4">
			<div class="control-group ">
			<?php echo $form->labelEx($model, 'keterangan_diklat', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textArea($model,'keterangan_diklat',array('placeholder'=>'Keterangan Rencana','rows'=>3, 'cols'=>30, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:175px;')); ?>
				</div>
			</div>
			<div class="control-group ">
			<?php echo $form->labelEx($model, 'pemberitugas_id', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->hiddenField($model, 'pemberitugas_id',array('readonly'=>true)); ?>
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'model'=>$model,
						'attribute' => 'pemberitugas_nama',
						'source' => 'js: function(request, response) {
										   $.ajax({
											   url: "' . $this->createUrl('AutocompletePemberiTugas') . '",
											   dataType: "json",
											   data: {
												   term: request.term,
											   },
											   success: function (data) {
													   response(data);
											   }
										   })
										}',
						'options' => array(
							'showAnim' => 'fold',
							'minLength' => 3,
							'focus' => 'js:function( event, ui ) {
								$(this).val( ui.item.label);
								return false;
							}',
							'select' => 'js:function( event, ui ) {
								$("#'.Chtml::activeId($model, 'pemberitugas_id') . '").val(ui.item.pegawai_id); 
								return false;
							}',
						),
						'htmlOptions' => array(
							'class'=>'pemberitugas_nama',
							'onkeypress'=>"return $(this).focusNextInputField(event)",
							'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pemberitugas_id') . '").val(""); '
						),
						'tombolDialog' => array('idDialog' => 'dialogPemberiTugas'),
					));
					?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group ">
			<?php echo $form->labelEx($model, 'mengetahui_id', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->hiddenField($model, 'mengetahui_id',array('readonly'=>true)); ?>
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'model'=>$model,
						'attribute' => 'pegawaimengetahui_nama',
						'source' => 'js: function(request, response) {
										   $.ajax({
											   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
											   dataType: "json",
											   data: {
												   term: request.term,
											   },
											   success: function (data) {
													   response(data);
											   }
										   })
										}',
						'options' => array(
							'showAnim' => 'fold',
							'minLength' => 3,
							'focus' => 'js:function( event, ui ) {
								$(this).val( ui.item.label);
								return false;
							}',
							'select' => 'js:function( event, ui ) {
								$("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(ui.item.pegawai_id); 
								return false;
							}',
						),
						'htmlOptions' => array(
							'class'=>'pegawaimengetahui_nama',
							'onkeypress'=>"return $(this).focusNextInputField(event)",
							'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(""); '
						),
						'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
					));
					?>
				</div>
			</div>
			<div class="control-group">
			<?php echo $form->labelEx($model,'tglmengetahui', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php 
				$this->widget('MyDateTimePicker', array(
				'model'=>$model,
				'attribute'=>'tglmengetahui',
				'mode' => 'date',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,
				'class'=>'span2',
				'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>
			</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group ">
			<?php echo $form->labelEx($model, 'menyetujui_id', array('class' => 'control-label')); ?>
				<div class="controls">
				<?php echo $form->hiddenField($model, 'menyetujui_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'pegawaimenyetujui_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'menyetujui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'pegawaimenyetujui_nama',
						'onkeypress'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'menyetujui_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
				));
				?>
				</div>
			</div>
			<div class="control-group">
			<?php echo $form->labelEx($model,'tglmenyetujui', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php 
				$this->widget('MyDateTimePicker', array(
				'model'=>$model,
				'attribute'=>'tglmenyetujui',
				'mode' => 'date',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,
				'class'=>'span2',
				'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>
			</div>
			</div>
		</div>
	</div>
    <div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'verifikasiRencanaPelatihan();', 'onkeypress'=>'verifikasiRencanaPelatihan();')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('index'),array('class'=>'btn btn-danger','onclick'=>'if(!confirm("'.Yii::t('mds','Apakah anda akan mengulang input data ?').'")) return false;')); ?>
		<?php	$content = $this->renderPartial('../tips/transaksi_rencanapelatihan',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<div style='display:none;'>
<?php
    $this->widget('MyDateTimePicker', array(
		'model'=>$model,
		'attribute'=>'rencanadiklat_periode',
        'mode' => 'date',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
        ),
        'htmlOptions' => array('readonly' => true,
		'onkeypress' => "return $(this).focusNextInputField(event)"),
    ));
?>	
<?php
    $this->widget('MyDateTimePicker', array(
		'model'=>$model,
		'attribute'=>'rencanadiklat_sampaidgn',
        'mode' => 'date',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
        ),
        'htmlOptions' => array('readonly' => true,
		'onkeypress' => "return $(this).focusNextInputField(event)"),
    ));
?>	
</div>

<?php 
//========= Dialog buat cari data Pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Pencarian Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo '<div id="tablePencarianPegawai"></div>';
$this->renderPartial('_dialogPegawai');
$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end Pegawai dialog =============================
?> 
<?php 
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPemberiTugas',
    'options'=>array(
        'title'=>'Pencarian Pemberi Tugas',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPemberiTugas = new KPPegawaiV('searchPegawaiMengetahui');
$modPemberiTugas->unsetAttributes();
if(isset($_GET['KPPegawaiV'])) {
    $modPemberiTugas->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaipemberitugas-grid',
	'dataProvider'=>$modPemberiTugas->searchPegawaiMengetahui(),
	'filter'=>$modPemberiTugas,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'pemberitugas_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pemberitugas_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPemberiTugas\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPemberiTugas, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPemberiTugas, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPemberiTugas, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPemberiTugas, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new KPPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['KPPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->searchPegawaiMengetahui(),
	'filter'=>$modPegawaiMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'mengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menyetujui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
		'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui = new KPPegawairuanganV('search');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['KPPegawairuanganV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['KPPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimenyetujui-grid',
	'dataProvider'=>$modPegawaiMenyetujui->searchPegawaiMenyetujui(),
	'filter'=>$modPegawaiMenyetujui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'menyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimenyetujui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>
<script type="text/javascript">
	
function setDialog(obj){
    parent = $(obj).parents(".input-append").find("input").attr("id");
    dialog = "#dialogPegawai";
    $(dialog).attr("parent-dialog",parent);
    $(dialog).dialog("open");
}

function setPegawaiAuto(pegawai_id){
	
    dialog = "#dialogPegawai";
    parent = $(dialog).attr("parent-dialog");
    obj = $("#"+parent);
    $.get('<?php echo $this->createUrl('AutocompletePegawai'); ?>',{pegawai_id:pegawai_id},function(data){
        $(obj).val(data[0].nama_pegawai);
        $(obj).val(data[0].nomorindukpegawai);
        setPegawai(obj,data[0]);
    },"json");
    $(dialog).dialog("close");
    
}

function setPegawai(obj,item)
{
    $(obj).parents('tr').find('input[name$="[pegawai_nama]"]').val(item.nama_pegawai);
    $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val(item.pegawai_id);
    $(obj).parents('tr').find('input[name$="[nomorindukpegawai]"]').val(item.nomorindukpegawai);
}

function addRowPelatihan(obj)
{
	var trRencanaPelatihan = new String(<?php echo CJSON::encode($this->renderPartial('_rowRencanaPelatihan',array('model'=>$model,'format'=>$format,'removeButton'=>true),true));?>);

	$("#table-rencanapelatihan > tbody > tr:last .tambahRow").attr('style','display:none;');
	$("#table-rencanapelatihan > tbody > tr:last .hapusRow").attr('style','display:true;');
    $(obj).parents('table').children('tbody').append(trRencanaPelatihan.replace());
	renameInput('#table-rencanapelatihan');
    $('#table-rencanapelatihan tbody').each(function(){
        jQuery('input[name$="[rencanadiklat_periode]"]').datepicker(
			jQuery.extend(
				{showMonthAfterYear:true},
				jQuery.datepicker.regional['id'],
				{
					'dateFormat':'dd M yy',
					'changeYear':true,
					'changeMonth':true,
					'showAnim':'fold',
					'yearRange':'-0y:+10y'
				}
			)
		);
        jQuery('input[name$="[rencanadiklat_sampaidgn]"]').datepicker(
			jQuery.extend(
				{showMonthAfterYear:true},
				jQuery.datepicker.regional['id'],
				{
					'dateFormat':'dd M yy',
					'changeYear':true,
					'changeMonth':true,
					'showAnim':'fold',
					'yearRange':'-0y:+10y'
				}
			)
		);
		jQuery('input[name$="[pegawai_nama]"]').autocomplete(
			{
				'showAnim':'fold',
				'minLength':2,
				'focus':function( event, ui )
				{
					$(this).val( ui.item.label);
					return false;
				},
				'select':function( event, ui )
				{
					setPegawai(this, ui.item);
					return false;
				},
				'source':function(request, response)
				{
					$.ajax({
						url: "<?php echo $this->createUrl('AutocompletePegawai');?>",
						dataType: "json",
						data: {
							term: request.term,
						},
						success: function (data) {
							response(data);
						}
					})
				}
			}
		); 
    });  
}

function hapusPelatihan(obj){
	myConfirm('Apakah anda akan membatalkan rencana pelatihan ini?','Perhatian!',
	function(r){
		if(r){
			$(obj).parents('tr').detach();	
			renameInput('#table-rencanapelatihan');
		}
	});
}

function renameInput(obj_table){
    var row = 0;
	var jmlRow = $('#table-rencanapelatihan tbody tr').length;
	if (jmlRow == 1){
		$("#table-rencanapelatihan > tbody > tr:last .tambahRow").attr('style','display:true;');
		$("#table-rencanapelatihan > tbody > tr:last .hapusRow").attr('style','display:none;');
	}else{
		$("#table-rencanapelatihan > tbody > tr:last .tambahRow").attr('style','display:true;');
		$("#table-rencanapelatihan > tbody > tr:last .hapusRow").attr('style','display:true;');
	}
	$(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    
}

function verifikasiRencanaPelatihan(){
	$("#table-rencanapelatihan").addClass("animation-loading");
    if(requiredCheck($("rencanapelatihan-form"))){  
	var jml_row	= $('#table-rencanapelatihan tbody tr').length;
	$('#<?php echo CHtml::activeId($model,"jmlRow"); ?>').val(jml_row);  
		 if(validasiDetail()){
			$('#rencanapelatihan-form').submit();
        }else{
			formatNumberSemua();
			$("#table-rencanapelatihan").removeClass("animation-loading");
            return false;
        }
		
		$("#table-rencanapelatihan").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
}

function validasiDetail(){
    if(validasiDetailPegawai() && validasiDetailJenisDiklat() && validasiDetailNamaDiklat() && validasiDetailTanggalPelatihanDari() && validasiDetailTanggalPelatihanSD() && validasiDetailSatuanLamaDiklat() && validasiDetailLamaDiklat() && validasiDetailTempatDiklat() && validasiDetailAlamatDiklat()){
		return true;
	}else{
		return false;
	}
}

function validasiDetailPegawai(){
    var detailpegawai_id = document.getElementsByClassName("pegawai_id");
    var jml = detailpegawai_id.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detailpegawai_id[i].value === ''){
            myAlert('Silahkan lengkapi semua Nama Pegawai !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}

function validasiDetailJenisDiklat(){
    var detailjenisdiklat_id = document.getElementsByClassName("jenisdiklat_id");
    var jml = detailjenisdiklat_id.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detailjenisdiklat_id[i].value === ''){
            myAlert('Silahkan lengkapi semua Jenis Pelatihan !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}

function validasiDetailNamaDiklat(){
    var detailnamadiklat = document.getElementsByClassName("namadiklat");
    var jml = detailnamadiklat.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detailnamadiklat[i].value === ''){
            myAlert('Silahkan lengkapi semua Nama Pelatihan !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}

function validasiDetailTanggalPelatihanDari(){
    var detailrencanadiklat_periode = document.getElementsByClassName("rencanadiklat_periode");
    var jml = detailrencanadiklat_periode.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detailrencanadiklat_periode[i].value === ''){
            myAlert('Silahkan lengkapi semua Tanggal Pelatihan !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}

function validasiDetailTanggalPelatihanSD(){
    var detailrencanadiklat_sampaidgn = document.getElementsByClassName("rencanadiklat_sampaidgn");
    var jml = detailrencanadiklat_sampaidgn.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detailrencanadiklat_sampaidgn[i].value === ''){
            myAlert('Silahkan lengkapi semua Tanggal Pelatihan !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}

function validasiDetailSatuanLamaDiklat(){
    var detailsatuan_lama = document.getElementsByClassName("satuan_lama");
    var jml = detailsatuan_lama.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detailsatuan_lama[i].value === '0'){
            myAlert('Silahkan lengkapi semua Satuan Lama Pelatihan !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}

function validasiDetailLamaDiklat(){
    var detaillamadiklat = document.getElementsByClassName("lamadiklat");
    var jml = detaillamadiklat.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detaillamadiklat[i].value === ''){
            myAlert('Silahkan lengkapi semua Lama Pelatihan !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}

function validasiDetailTempatDiklat(){
    var detailtempat_diklat = document.getElementsByClassName("tempat_diklat");
    var jml = detailtempat_diklat.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detailtempat_diklat[i].value === ''){
            myAlert('Silahkan lengkapi semua Tempat Pelatihan !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}

function validasiDetailAlamatDiklat(){
    var detailalamat_diklat = document.getElementsByClassName("alamat_diklat");
    var jml = detailalamat_diklat.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detailalamat_diklat[i].value === ''){
            myAlert('Silahkan lengkapi semua Alamat Pelatihan !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}

function tombolTambahHapus(){
	var jmlRow = parseInt($('#table-rencanapelatihan tbody tr').length);
	if (jmlRow === 1){
        $("#table-rencanapelatihan > tbody > tr:last .tambahRow").attr('style','display:true;');
	}else{
        $("#table-rencanapelatihan > tbody > tr:last .tambahRow").attr('style','display:true;');
        $("#table-rencanapelatihan > tbody > tr:last .hapusRow").attr('style','display:true;');
	}
}

$(document).ready(function(){
	$("#table-rencanapelatihan > tbody > tr:last .tambahRow").attr('style','display:true;');
});
</script>
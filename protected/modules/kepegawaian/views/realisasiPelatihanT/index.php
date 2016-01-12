<div class="white-container">
	<legend class="rim2">Transaksi <b>Realisasi Pelatihan</b></legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'realisasipelatihan-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event); '),//dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
		'focus' => '#'.CHtml::activeId($model, 'tglrencanadiklat'),
)); ?>
<?php 
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success', "Data Realisasi Pelatihan berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>
<fieldset class="box">   
<legend class="rim"><span class='judul'>Data Realisasi Pelatihan </span></legend>
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
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'norencanadiklat', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'model'=>$model,
						'attribute' => 'norencanadiklat',
						'source' => 'js: function(request, response) {
										   $.ajax({
											   url: "' . $this->createUrl('AutocompleteNoRencanaDiklat') . '",
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
								$("#'.Chtml::activeId($model, 'norencanadiklat') . '").val(ui.item.norencanadiklat); 
								setRowRencana(ui.item.norencanadiklat);
								return false;
							}',
						),
						'htmlOptions' => array(
							'class'=>'norencanadiklat',
							'onkeypress'=>"return $(this).focusNextInputField(event)",
							'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'norencanadiklat') . '").val(""); '
						),
						'tombolDialog' => array('idDialog' => 'dialogRencanaDiklat'),
					));
					?>
				</div>
		</div>
		<?php echo $form->hiddenField($model,'jmlRow',array('class'=>'span2','style'=>'width:90px;','readonly'=>true))?>
	</div>
</div>
</fieldset>
<div class="block-tabel">
        <h6>Tabel <b>Realisasi Pelatihan</b></h6>
		<div style="overflow-x: scroll;">
        <table class="items table table-striped table-condensed" id="table-realisasipelatihan">
            <thead>
                <tr>
                    <th>Pilih</th>
                    <th>No.</th>
                    <th>No. Induk Pegawai</th>
                    <th>Nama Pegawai</th>
                    <th>Jenis Pelatihan</th>
                    <th>Nama Pelatihan</th>
                    <th>Tanggal <br>Mulai Diklat</th>
                    <th>Lama Pelatihan</th>
                    <th>Tempat Pelatihan</th>
                    <th>No. Keputusan</th>
                    <th>Tanggal Penetapan</th>
                    <th>Pimpinan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
		</div>
    </div> 
    <div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'verifikasiRealisasiPelatihan();', 'onkeypress'=>'verifikasiRealisasiPelatihan();')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('index'),array('class'=>'btn btn-danger','onclick'=>'if(!confirm("'.Yii::t('mds','Apakah anda akan mengulang input data ?').'")) return false;')); ?>
		<?php 
    echo (!isset($_GET['norencanadiklat']) ? 
		CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'disabled'=>true))."&nbsp&nbsp" : 
		CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'disabled'=>false, 'onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"); 
   $urlPrint= $this->createUrl('print',array('norencanadiklat'=>isset($_GET['norencanadiklat'])?$_GET['norencanadiklat'] : null));
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+"&caraPrint="+caraPrint,"",'location=_new, width=1200px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>
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
</div>

<?php 
//========= Dialog buat cari data No Rencana Diklat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRencanaDiklat',
    'options'=>array(
        'title'=>'Pencarian Rencana Pelatihan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modRencanaDiklat = new KPRencanadiklatT('searchRencanaDiklat');
$modRencanaDiklat->unsetAttributes();
if(isset($_GET['KPPegawaiV'])) {
    $modRencanaDiklat->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
	'id'=>'rencanadiklat-grid',
	'dataProvider'=>$modRencanaDiklat->searchRencanaDiklat(),
	'filter'=>$modRencanaDiklat,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'mergeColumns'=>'norencanadiklat',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectRencanaDiklat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'norencanadiklat').'\").val(\"$data->norencanadiklat\");
												  setRowRencana(\"$data->norencanadiklat\");
												  $(\"#dialogRencanaDiklat\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'name'=>'norencanadiklat',
                    'value'=>'$data->norencanadiklat',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'value'=>'$data->pegawai->nama_pegawai',
                ),
                array(
                    'header'=>'Mulai Periode Diklat',
					'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->rencanadiklat_periode)',
                ),
                array(
                    'header'=>'Sampai Periode Diklat',
					'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->rencanadiklat_sampaidgn)',
                ),
                array(
                    'header'=>'Sampai Periode Diklat',
					'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->rencanadiklat_sampaidgn)',
                ),
                array(
                    'header'=>'Tempat Diklat',
                    'value'=>'$data->tempat_diklat',
                ),
                array(
                    'header'=>'Alamat Diklat',
                    'value'=>'$data->alamat_diklat',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end No Rencana Diklat dialog =============================
?>
<div style='display:none;'>
<?php
    $this->widget('MyDateTimePicker', array(
		'model'=>$modPegawaiDiklat,
		'attribute'=>'tglditetapkandiklat',
        'mode' => 'date',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
        ),
        'htmlOptions' => array('readonly' => true,
		'onkeypress' => "return $(this).focusNextInputField(event)"),
    ));
?>	
</div>
<script type="text/javascript">
function setRowRencana(norencanadiklat){
	setRow();
	$('#table-realisasipelatihan').addClass('animation-loading'); 
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('loadFormRencanaPelatihan'); ?>',
		data: {norencanadiklat:norencanadiklat},
		dataType: "json",
		success:function(data){
			$('#table-realisasipelatihan > tbody').append(data.form);
			$('#table-realisasipelatihan tbody').each(function(){
				jQuery('input[name$="[tglditetapkandiklat]"]').datepicker(
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
			});  
			$('#table-realisasipelatihan').removeClass('animation-loading');
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function setRow(){
	$('#table-realisasipelatihan tbody').each(function(){
		$('#table-realisasipelatihan tbody > tr').detach();	
	}); 
}

function verifikasiRealisasiPelatihan(){
	$("#table-realisasipelatihan").addClass("animation-loading");
    if(requiredCheck($("realisasipelatihan-form"))){  
		 if(validasiDetail()){
			$('#realisasipelatihan-form').submit();
        }else{
			formatNumberSemua();
			$("#table-realisasipelatihan").removeClass("animation-loading");
            return false;
        }
		
		$("#table-realisasipelatihan").removeClass("animation-loading");
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
    if(validasiNomorKeputusanDiklat() && validasiTanggalDitetapkan() && validasiDetailPemimpin() && validasiDetailKeterangan()){
		return true;
	}else{
		return false;
	}
}

function validasiNomorKeputusanDiklat(){
    var detailnomorkeputusandiklat = document.getElementsByClassName("nomorkeputusandiklat");
    var jml = detailnomorkeputusandiklat.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detailnomorkeputusandiklat[i].value === ''){
            myAlert('Silahkan lengkapi semua Nomor Keputusan Diklat !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}

function validasiTanggalDitetapkan(){
    var detailtglditetapkandiklat = document.getElementsByClassName("tglditetapkandiklat");
    var jml = detailtglditetapkandiklat.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detailtglditetapkandiklat[i].value === ''){
            myAlert('Silahkan lengkapi semua Tanggal Penetapan !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}

function validasiDetailPemimpin(){
    var detailpejabatygmemdiklat = document.getElementsByClassName("pejabatygmemdiklat");
    var jml = detailpejabatygmemdiklat.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detailpejabatygmemdiklat[i].value === ''){
            myAlert('Silahkan lengkapi semua Pemimpin !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}

function validasiDetailKeterangan(){
    var detailpegawaidiklat_keterangan = document.getElementsByClassName("pegawaidiklat_keterangan");
    var jml = detailpegawaidiklat_keterangan.length;
    var kosong = false;
    for(i=0;i<jml;i++){
        if(detailpegawaidiklat_keterangan[i].value === ''){
            myAlert('Silahkan lengkapi semua Keterangan !');
            kosong = true;
            break;
        }
    }
    if(kosong)
        return false;
    else
        return true;
}
</script>
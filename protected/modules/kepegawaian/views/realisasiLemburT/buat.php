<?php
$arrMenu = array();
//(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>'Realisasi Rencana Lembur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
$this->menu=$arrMenu;
?>
<?php
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0) 
    Yii::app()->user->setFlash('success',"Data Realisasi Rencana Lembur berhasil disimpan !");
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'buat-realisasi-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return check(this);'),
        'focus'=>'#',
)); ?>
<div class="white-container">
    <legend class="rim2">Realisasi <b>Rencana Lembur</b></legend>
    <?php echo $form->errorSummary($modRealisasiLembur); ?>
    <fieldset class="box">
        <legend class="rim">Realisasi Rencana Lembur</legend>
        <div class="row-fluid">
			<?php if(isset($_GET['norencana'])){ ?>
			<div class="span6">
                <div class="control-group">
                    <label class="control-label">Tanggal</label>
                    <div class="controls">
                        <?php echo $form->textField($modRencanaLembur,'tglrencana', array('class'=>'span3', 'readonly'=>true)); ?>
					</div>
                </div>
                <div class="control-group">
                    <label class="control-label">No. Rencana</label>
                    <div class="controls">
                        <?php echo $form->textField($modRencanaLembur,'norencana', array('class'=>'span3', 'readonly'=>true)); ?>
                    </div>
                </div>
			</div>
			<?php } ?>
            <div class="span6">
				<div class="control-group">
                    <?php echo $form->labelEx($modRealisasiLembur,'tglrealisasi', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php   
                        $modRealisasiLembur->tglrealisasi = (!empty($modRealisasiLembur->tglrealisasi) ? date("d/m/Y",strtotime($modRealisasiLembur->tglrealisasi)) : null);
                        $this->widget('MyDateTimePicker',array(
                                                'model'=>$modRealisasiLembur,
                                                'attribute'=>'tglrealisasi',
                                                'mode'=>'date',
                                                'options'=> array(
            //                                            'dateFormat'=>Params::DATE_FORMAT,
                                                    'showOn' => false,
//                                                    'maxDate' => 'd',
                                                    'yearRange'=> "-150:+0",
                                                ),
                                                'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        <?php echo $form->error($modRealisasiLembur, 'tglrealisasi'); ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRealisasiLembur,'norealisasi', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modRealisasiLembur,'norealisasi',array('class'=>'span3 isRequiredNoRea','readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20, 'autofocus'=>true)); ?>

                    </div>
                </div>
            </div>
            <div class="span4">
                
			</div>
            <div class="span4">
                
            </div>
        </div>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel Realisasi <b>Rencana Lembur</b></h6>
        <table class="items table table-striped table-condensed" id="table-pegawai">
            <thead>
                <tr>
                    <th style="text-align: center;">No.</th>
                    <th style="text-align: center;">No. Induk Pegawai</th>
                    <th style="text-align: center;">Nama Pegawai</th>
                    <!--<th style="text-align: center;">Departemen</th>-->
                    <th style="text-align: center;">Jam Mulai</th>
                    <th style="text-align: center;">Jam Selesai</th>
                    <th style="text-align: center;">Alasan Lembur</th>
                    <th style="text-align: center;">Pilih</th>
                </tr>
            </thead>
            <tbody>
                <?php                    
                $tr = '';
                $no = 1;
                $index = 0;
                $format = new MyFormatter;

                if (!empty($modDetail)){
                    foreach ($modDetail as $key => $detail) {                    
                        if($modDetail[$key]->tglmulai != null){
                            $modRealisasiLemburDetail->jamMulai = date('H:i',strtotime($modDetail[$key]->tglmulai));
                        }
                        if($modDetail[$key]->tglselesai != null){
                            $modRealisasiLemburDetail->jamSelesai = date('H:i',strtotime($modDetail[$key]->tglselesai));
                        }
                        $modRealisasiLemburDetail->rencanalembur_id = $detail->rencanalembur_id;
                        $modRealisasiLemburDetail->pegawai_id = $detail->pegawai_id;
                        $modRealisasiLemburDetail->alasanlembur = $detail->alasanlembur;
                        $modRealisasiLemburDetail->nourut = $no;
                        $tr.="<tr>
                           <td>".CHtml::activeTextField($modRealisasiLemburDetail,'['.$index.']nourut',array('class'=>'span1 no_urut','readonly'=>TRUE))
                                .CHtml::activeHiddenField($modRealisasiLemburDetail, '['.$index.']rencanalembur_id')
                                .CHtml::activeHiddenField($modRealisasiLemburDetail, '['.$index.']pegawai_id')
                                ."</td>
                           <td>".$modDetail[$key]->pegawai->nomorindukpegawai."</td>
                           <td>".$modDetail[$key]->pegawai->nama_pegawai."</td>
                           <td>".CHtml::activetextField($modRealisasiLemburDetail,'['.$index.']jamMulai',array('placeholder'=>'00:00','class'=>'span1 detailRequired','readonly'=>false, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)", 'onblur'=>'checkTime(this);'))."</td>
                           <td>".CHtml::activetextField($modRealisasiLemburDetail,'['.$index.']jamSelesai',array('placeholder'=>'00:00','class'=>'span1 detailRequired','readonly'=>false, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)", 'onblur'=>'checkTime(this);'))."</td>
                           <td>".CHtml::activetextField($modRealisasiLemburDetail,'['.$index.']alasanlembur',array('class'=>'span3 detailRequired','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)"))."</td>
                           <td></td>
                           </tr>   
                       "; // <td>".$modDetail[$key]->pegawai->departement->departement_nama."</td>
                       $no++;
                       $index++;
                    }
                    echo $tr;
                }else if ($modRencanaLemburDetail > 0){
					$this->renderPartial('_rowRealisasiRencana',array('modRealisasiLemburDetail'=>$modRealisasiLemburDetail,'modRencanaLemburDetail'=>$modRencanaLemburDetail,'modPegawai'=>$modPegawai));
				}else{
					$trTindakan = $this->renderPartial('_rowDetail',array('modRealisasiLemburDetail'=>$modRealisasiLemburDetail,'modPegawai'=>$modPegawai),true); 
					echo $trTindakan;
				}
            ?>
            </tbody>
        </table>
    </div>    
	<fieldset class="box">
        <div class="row-fluid">
			<div class="span4">
				<div class="control-group">
					<?php echo CHtml::label('Lembur Pada Hari Libur', 'isharilembur', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo CHtml::checkBox('isharilembur','isharilembur', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					</div>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($modRencanaLembur, 'keterangan', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textArea($modRencanaLembur, 'keterangan',array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="control-group">
					<?php $modRencanaLembur->pemberitugas_nama = $modRencanaLembur->getPegawaiAttributes($modRencanaLembur->pemberitugas_id,'nama_pegawai'); ?>
					<label class="control-label required" >
						Pemberi Tugas
						<span class="required">*</span>
					</label>
					<div class="controls">
						<?php echo CHtml::activeHiddenField($modRencanaLembur,'pemberitugas_id', array('class'=>'isRequiredPemb'));?>
									<div style="float:left;">
									<?php $this->widget('MyJuiAutoComplete',array(
												'model'=>$modRencanaLembur,
												'attribute'=>'pemberitugas_nama',
												'sourceUrl'=> Yii::app()->createUrl('kepegawaian/ActionAutoCompleteKP/PemberiTugas'),
												'options'=>array(
												   'showAnim'=>'fold',
												   'minLength' => 2,
												   'select'=>'js:function( event, ui ) {
															  $("#KPRencanaLemburT_pemberitugas_id").val(ui.item.pegawai_id);
													}',
												),
												'tombolDialog'=>array('idDialog'=>'dialogPemberiTugas'),
												'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','style'=>'float:left;'),
									)); ?>
									</div>
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="control-group">
					<?php $modRencanaLembur->mengetahui_nama = $modRencanaLembur->getPegawaiAttributes($modRencanaLembur->mengetahui_id,'nama_pegawai'); ?>
					<?php //echo $form->uneditableRow($modRencanaLembur,  'mengetahui_nama',array('class'=>'span3')); ?>
					<?php //echo $form->labelEx($modRencanaLembur,'mengetahui_id', array('class'=>'control-label')) ?>
					<label class="control-label required" >
						Mengetahui
						<span class="required">*</span>
					</label>
					<div class="controls">
						<?php echo CHtml::activeHiddenField($modRencanaLembur,'mengetahui_id', array('class'=>'isRequiredMeng'));?>
						<!--<div style="float:left;">-->
						<?php $this->widget('MyJuiAutoComplete',array(
									'model'=>$modRencanaLembur,
									'attribute'=>'mengetahui_nama',
									'sourceUrl'=> Yii::app()->createUrl('kepegawaian/ActionAutoCompleteKP/Mengetahui'),
									'options'=>array(
									   'showAnim'=>'fold',
									   'minLength' => 2,
									   'select'=>'js:function( event, ui ) {
												  $("#KPRencanaLemburT_mengetahui_id").val(ui.item.pegawai_id);
										}',
									),
									'tombolDialog'=>array('idDialog'=>'dialogMengetahui'),
									'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','style'=>'float:left;'),
						)); ?>
						<!--</div>-->
					</div>
				</div>
				<div class="control-group">
					<?php $modRencanaLembur->menyetujui_nama = $modRencanaLembur->getPegawaiAttributes($modRencanaLembur->menyetujui_id,'nama_pegawai'); ?>
					<?php //echo $form->uneditableRow($modRencanaLembur,  'menyetujui_nama',array('class'=>'span3')); ?>
					<?php //echo $form->labelEx($modRencanaLembur,'menyetujui_id', array('class'=>'control-label')) ?>
					<label class="control-label required" >
						Menyetujui
						<span class="required">*</span>
					</label>
					<div class="controls">
						<?php echo CHtml::activeHiddenField($modRencanaLembur, 'menyetujui_id', array('class'=>'isRequiredMeny'));?>
							<!--<div style="float:left;">-->
							<?php $this->widget('MyJuiAutoComplete',array(
										'model'=>$modRencanaLembur,
										'attribute'=>'menyetujui_nama',
										'sourceUrl'=> Yii::app()->createUrl('kepegawaian/ActionAutoCompleteKP/Menyetujui'),
										'options'=>array(
										   'showAnim'=>'fold',
										   'minLength' => 2,
										   'select'=>'js:function( event, ui ) {
													  $("#KPRencanaLemburT_menyetujui_id").val(ui.item.pegawai_id);
											}',
										),
										'tombolDialog'=>array('idDialog'=>'dialogMenyetujui'),
										'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','style'=>'float:left;'),
							)); ?>
							<!--</div>-->
					</div>
				</div>
			</div> 
		</div>
	</fieldset>
    <div class="form-actions">
        <?php 
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['norealisasi'])) ? true : ($sukses > 0) ? true : false;; 
        ?>
        <?php $disablePrint = ($disableSave) ? false : true; ?>
        <?php 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
            //  jika dengan cek obat
            /**
             echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekObat();', 'onkeypress'=>'cekObat();','disabled'=>$disableSave)); //formSubmit(this,event)        
             * 
             * 
             */
             ?>
        <?php if(!isset($_GET['frame'])){
            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/buat'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'return refreshForm(this);'));
        } ?>								
        <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
        ?>
        <?php
            $content = $this->renderPartial('kepegawaian.views.tips.transaksi_penggajian',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
        ?>
    </div>           
    <?php $this->endWidget(); ?>
</div>
<?php
/**
 * Java Script untuk Cek Validasi jam mulai dan jam selesai tidak boleh kosong
 */

$jscript = <<<JS
function cekValidasi(event)
{ 
  kosong = ' ';
  pilih = true;
  detailRequired = $("#tabelPegawaiLembur tbody").find(".detailRequired[value="+kosong+"]");
  karlemburPilih = $("#tabelPegawaiLembur tbody").find(".pilih[value="+pilih+"]");
  jumlah =  detailRequired.length;      
  jumPilih =  karlemburPilih.length;      
  if ($('.isRequiredNoRea').val()==''){
    alert ('Silahkan Isi No. Realisasi');
    return false;
  }else 
  if ($('.isRequiredMeng').val()==''){
    alert ('Silahkan Isi Mengetahui');
    return false;
  }else 
  if ($('.isRequiredMeny').val()==''){
    alert ('Silahkan Isi Menyetujui');
    return false;
  }else
  if ($('.isRequiredPemb').val()==''){
    alert ('Silahkan Isi Pemberi Tugas');
    return false;
  }
//  else{
//    $('#btn_simpan').click();
//    return true; 
//  }
      else 
  if (jumlah==0){        
    $('#btn_simpan').click();
    return true;        
  }else{
    alert ('Jam Mulai, Jam Selesai dan Alasan Lembur Tidak Boleh Kosong!');
    return false;
  }
}
// Original JavaScript code by Chirp Internet: www.chirp.com.au 
// Please acknowledge use of this code by including this header. 
    function checkTime(field) { 
        var errorMsg = ""; 
        // regular expression to match required time format 
        re = /^(\d{1,2}):(\d{2})(:00)?([ap]m)?$/; 
        if(field.value != '') { 
            if(regs = field.value.match(re)) { 
                 
                // 24-hour time format 
                if(regs[1] > 23) { 
                    errorMsg = "Kesalahan format jam : " + regs[1] + ". Masukan jam antara 00 s.d 23 !"; 
                } 
                 
                if(!errorMsg && regs[2] > 59) { 
                    errorMsg = "Kesalahan format menit: " + regs[2] + ". Masukan menit antara 00 s.d 59 !"; 
                } 
            } else { 
                errorMsg = "Kesalahan format waktu: " + field.value + ". Masukan jam dan waktu antara 00:00 s.d 23:59 !"; 
            } 
       } 
       if(errorMsg != "") { 
           myAlert(errorMsg);
           field.value = "";
           field.focus();
           return false; 
       } 
       return true; 
}
JS;
Yii::app()->clientScript->registerScript('inputPegawai',$jscript, CClientScript::POS_HEAD);
?>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogMengetahui',
    'options'=>array(
        'title'=>'Pencarian Mengetahui Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>450,
        'resizable'=>false,
    ),
));

$modMengetahui = new PegawaiM('search');
$modMengetahui -> unsetAttributes();
if(isset($_GET['PegawaiM'])) {
    $modMengetahui->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'mengetahui-m-grid',
	'dataProvider'=>$modMengetahui->search(),
	'filter'=>$modMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectMengetahui",
                                            "onClick" => "$(\"#KPRencanaLemburT_mengetahui_id\").val(\"$data->pegawai_id\");
                                                          $(\"#'.CHtml::activeId($modRencanaLembur,'mengetahui_nama').'\").val(\"$data->nama_pegawai\");
                                                          $(\"#dialogMengetahui\").dialog(\"close\");    
                                                          return false;
                                                "))',
                        ),
                        array(
                            'header'=>'No.',
                            'type'=>'raw',
                            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'filter'=>false,
                        ),
                        'nomorindukpegawai',                
                        'nama_pegawai',
//                        array(
//                            'header'=>'Departement',
//                            'value'=>'$data->departement->departement_nama',
//                            'filter'=>false,
//                        ),       
                

	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Menyetujui Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>450,
        'resizable'=>false,
    ),
));

$modMenyetujui = new PegawaiM('search');
$modMenyetujui -> unsetAttributes();
if(isset($_GET['PegawaiM'])) {
    $modMenyetujui->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'menyetujui-m-grid',
	'dataProvider'=>$modMenyetujui->search(),
	'filter'=>$modMenyetujui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectMenyetujui",
                                            "onClick" => "$(\"#KPRencanaLemburT_menyetujui_id\").val(\"$data->pegawai_id\");
                                                          $(\"#'.CHtml::activeId($modRencanaLembur,'menyetujui_nama').'\").val(\"$data->nama_pegawai\");
                                                          $(\"#dialogMenyetujui\").dialog(\"close\");    
                                                          return false;
                                                "))',
                        ),
                        array(
                            'header'=>'No.',
                            'type'=>'raw',
                            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'filter'=>false,
                        ),
                        'nomorindukpegawai',                
                        'nama_pegawai',
//                        array(
//                            'header'=>'Departement',
//                            'value'=>'$data->departement->departement_nama',
//                            'filter'=>false,
//                        ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Lembur =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiLembur',
    'options'=>array(
        'title'=>'Pencarian Pegawai Lembur',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>450,
        'resizable'=>false,
    ),
));

$modPegawaiLembur = new PegawaiM('search');
$modPegawaiLembur -> unsetAttributes();
if(isset($_GET['PegawaiM'])) {
    $modPegawaiLembur->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'karlembur-m-grid',
	'dataProvider'=>$modPegawaiLembur->search(),
	'filter'=>$modPegawaiLembur,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPegawaiLembur",
                                            "onClick" => "$(\"#pegawailembur_id\").val(\"$data->pegawai_id\");
                                                          $(\"#'.CHtml::activeId($modRencanaLembur,'karlembur_nama').'\").val(\"$data->nama_pegawai\");
                                                          submitPegawaiLembur(this);
                                                          $(\"#dialogPegawaiLembur\").dialog(\"close\");    
                                                          return false;
                                                "))',
                        ),
                        array(
                            'header'=>'No.',
                            'type'=>'raw',
                            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'filter'=>false,
                        ),
                        'nomorindukpegawai',                
                        'nama_pegawai',
//                        array(
//                            'header'=>'Departement',
//                            'value'=>'$data->departement->departement_nama',
//                            'filter'=>false,
//                        ),
                

	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Pegawai Lembur dialog =============================
?>

<?php 
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPemberiTugas',
    'options'=>array(
        'title'=>'Pencarian Pemberi Tugas',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>450,
        'resizable'=>false,
    ),
));

$modPemberiTugas = new PegawaiM('search');
$modPemberiTugas -> unsetAttributes();
if(isset($_GET['PegawaiM'])) {
    $modPemberiTugas->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pemberitugas-m-grid',
	'dataProvider'=>$modPemberiTugas->search(),
	'filter'=>$modPemberiTugas,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPemberiTugas",
                                            "onClick" => "$(\"#KPRencanaLemburT_pemberitugas_id\").val(\"$data->pegawai_id\");
                                                          $(\"#'.CHtml::activeId($modRencanaLembur,'pemberitugas_nama').'\").val(\"$data->nama_pegawai\");
                                                          $(\"#dialogPemberiTugas\").dialog(\"close\");    
                                                          return false;
                                                "))',
                        ),
                        array(
                            'header'=>'No.',
                            'type'=>'raw',
                            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'filter'=>false,
                        ),
                        'nomorindukpegawai',                
                        'nama_pegawai',
//                        array(
//                            'header'=>'Departement',
//                            'value'=>'$data->departement->departement_nama',
//                            'filter'=>false,
//                        ),

	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>


<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogPegawaiBadak',
        'options'=>array(
            'title'=>'Pencarian Data Pegawai',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
	echo CHtml::hiddenField('tindakan_untuk',0,array('readonly'=>true));
	$modPegawaiLembur = new PegawaiM('search');
	$modPegawaiLembur->unsetAttributes();
	if(isset($_GET['PegawaiM'])) {
		$modPegawaiLembur->attributes = $_GET['PegawaiM'];
	}
	
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pegawaibadak-m-grid',
            'dataProvider'=>$modPegawaiLembur->search(),
            'filter'=>$modPegawaiLembur,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
											setPegawaiAuto(\"$data->pegawai_id\",0);
                                            $(\"#dialogPegawaiBadak\").dialog(\"close\");
                                        "))',
                    ),
					array(
						'header'=>'No.',
						'type'=>'raw',
						'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
						'filter'=>false,
					),
                    array(
                        'header'=>'NIP',
						'name'=> 'nomorindukpegawai',
                        'type'=>'raw',
                        'value'=>'$data->nomorindukpegawai',
                    ),          
					'nama_pegawai',
            ),
            'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
                
            
            }',
    ));
    $this->endWidget();
    ?>


<?php $this->renderPartial('_jsFunctions', array('modRencanaLembur'=>$modRencanaLembur,'modDetail'=>$modDetail,'modRealisasiLembur'=>$modRealisasiLembur)); ?>

<script type="text/javascript">
    function hapusBaris(obj){
        myConfirm("Apakah anda ingin membatalkan ini?","Perhatian!",function(r){if(r){
            $(obj).parents('tr').detach();
        }});
    }

    function check(obj){
        var kosongJamMulai = 0;
        var kosongJamSelesai = 0;
        var kosongAlasan = 0;
        $("#table-pegawai").find('[name*="[jamMulai]"]').each(function(){
            if($(this).val()==""){
                kosongJamMulai++;
            }
        });
        $("#table-pegawai").find('[name*="[jamSelesai]"]').each(function(){
            if($(this).val()==""){
                kosongJamSelesai++;
            }
        });
        $("#table-pegawai").find('[name*="[alasanlembur]"]').each(function(){
            if($(this).val()==""){
                kosongAlasan++;
            }
        });

        if(kosongJamMulai>0){
            myAlert('Jam Mulai harus di isi!');
            return false;
        }else if(kosongJamSelesai>0){
            myAlert('Jam Selesai harus di isi!');
            return false;
        }else if(kosongAlasan>0){
            myAlert('Alasan lembur harus di isi!');
            return false;
        }

        return requiredCheck(obj);
    }
	
function setDialogPegawai(obj){
    var tindakan_untuk = $(obj).parent().parent().find('input').attr('id');
    $("#tindakan_untuk").val(tindakan_untuk);
    $("#dialogPegawaiBadak").dialog("open");
	var nomorindukpegawai = '';
    $.fn.yiiGridView.update('pegawaibadak-m-grid', {
        data:{
            "PegawaiM[nomorindukpegawai]":nomorindukpegawai,
        }
    });
}
	
function setPegawaiAuto(pegawai_id,is_auto,tr){
	if(is_auto != '1'){
		var tindakan_untuk = $("#tindakan_untuk").val();
		var tr = $('#'+tindakan_untuk).parents('tr');	
	}
	var pegawaisama = $("#table-pegawai input[name$='[pegawai_id]'][value='"+pegawai_id+"']");
	if(pegawaisama.val()){ //jika ada pegawai sudah ada di list
		myAlert('Pegawai sudah ada dalam list');
	}else{
		$(tr).addClass("animation-loading-1");
		$.get('<?php echo $this->createUrl('GetPegawai'); ?>',{pegawai_id: pegawai_id},function(data){
			$(tr).find('input[name$="[pegawai_id]"]').val(data[0].pegawai_id);
			$(tr).find('input[name$="[nomorindukpegawai]"]').val(data[0].nomorindukpegawai);
			$(tr).find('input[name$="[nama_pegawai]"]').val(data[0].nama_pegawai);
			$(tr).removeClass("animation-loading-1");
		},"json");
		$("#dialogPegawaiBadak").dialog("close");
	}
}

function addRow(obj){
    var table = $('#table-pegawai');
	var nourut = $(obj).parents('tr').find('input[name$="[nourut]"]').val();
	var row_tindakan = new String(<?php echo CJSON::encode($this->renderPartial('_rowDetail',array('modRealisasiLemburDetail'=>$modRealisasiLemburDetail,'modPegawai'=>$modPegawai,'removeButton'=>true),true));?>);
	var tr = $(obj).parents('tr');
	$("'"+row_tindakan+"'").insertAfter( tr );
	renameInputRow($(table));
    $(table).find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
}
function cancelRow(obj){
	var tr = $(obj).parents('tr');
	var pegawai_id = $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val();
	if(pegawai_id != ''){
		myConfirm("Apakah anda akan membatalkan pegawai ini?",
		"Perhatian!",
		function(r){
			if(r){
				$(tr).addClass("animation-loading-1");
				setTimeout(function(){
					$(obj).parents('tr').detach();
					renameInputRow($("#table-pegawai"));
					$(tr).removeClass("animation-loading-1");
				},400);
			}
		}); 
	}else{
		$(obj).parents('tr').detach();
		renameInputRow($("#table-pegawai"));
	}
}

function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find('input[name*="nourut"]').val(row+1);
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

$(document).ready(function(){
    renameInputRow($("#table-pegawai")); 
});

</script>
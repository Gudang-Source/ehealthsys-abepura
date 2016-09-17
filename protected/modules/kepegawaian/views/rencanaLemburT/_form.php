<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rencana-lembur-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>
<?php echo $form->errorSummary($modRencanaLembur); ?>
<?php if (isset($modRealisasiLembur)) echo $form->errorSummary($modRealisasiLembur); ?>
<fieldset class="box">
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    <legend class="rim">Data Rencana Lembur</legend>
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <?php echo $form->labelEx($modRencanaLembur,'tglrencana', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php   
                    $modRencanaLembur->tglrencana = (!empty($modRencanaLembur->tglrencana) ? date("d/m/Y",strtotime($modRencanaLembur->tglrencana)) : null);
                    $this->widget('MyDateTimePicker',array(
						'model'=>$modRencanaLembur,
						'attribute'=>'tglrencana',
						'mode'=>'date',
						'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
							'showOn' => false,
							'maxDate' => 'd',
							'yearRange'=> "-150:+0",
						),
						'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
						),
                    )); ?>
                    <?php echo $form->error($modRencanaLembur, 'tglrencana'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modRencanaLembur,'norencana', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modRencanaLembur,'norencana',array('class'=>'span3 isRequired', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>20)); ?>

                </div>
            </div>
        </div>
        <div class="span4">
            <div "control-group">
                <?php echo $form->labelEx($modRencanaLembur,'mengetahui_id', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::activeHiddenField($modRencanaLembur,'mengetahui_id');?>
                                <div style="float:left;">
                                <?php $this->widget('MyJuiAutoComplete',array(
                                            'model'=>$modRencanaLembur,
                                            'attribute'=>'mengetahui_nama',
                                            'sourceUrl'=> $this->createUrl('Mengetahui'),
                                            'options'=>array(
                                               'showAnim'=>'fold',
                                               'minLength' => 2,
                                               'select'=>'js:function( event, ui ) {
                                                          $("#KPRencanaLemburT_mengetahui_id").val(ui.item.pegawai_id);
                                                }',
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogMengetahui'),
                                            'htmlOptions'=>array(
                                                'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaLembur, 'mengetahui_id') . '").val(""); ',
                                                'class'=>'span3','style'=>'float:left;'),
                                )); ?>
                                </div>
                </div>
            </div>

            <div class="control-group">
                <?php //echo $form->textFieldRow($modRencanaLembur,'menyetujui_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php //echo $form->labelEx($modRencanaLembur,'menyetujui_id', array('class'=>'control-label')) ?>
                <?php echo $form->labelEx($modRencanaLembur,'menyetujui_id', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::activeHiddenField($modRencanaLembur, 'menyetujui_id');?>
					<div style="float:left;">
						<?php $this->widget('MyJuiAutoComplete',array(
							'model'=>$modRencanaLembur,
							'attribute'=>'menyetujui_nama',
							'sourceUrl'=> $this->createUrl('Menyetujui'),
							'options'=>array(
							   'showAnim'=>'fold',
							   'minLength' => 2,
							   'select'=>'js:function( event, ui ) {
										  $("#KPRencanaLemburT_menyetujui_id").val(ui.item.pegawai_id);
								}',
							),
							'tombolDialog'=>array('idDialog'=>'dialogMenyetujui'),
							'htmlOptions'=>array('onkeyup'=>"return $(this).focusNextInputField(event)",
							'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaLembur, 'menyetujui_id') . '").val(""); ',
							'class'=>'span3','style'=>'float:left;'),
						)); ?>
					</div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
<fieldset class="box">
    <legend class="rim">Data Pegawai</legend>
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <?php echo $form->labelEx($modRencanaLembur,'nama_pegawai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::hiddenField('pegawailembur_id');?>
					<div style="float:left;">
						<?php $this->widget('MyJuiAutoComplete',array(
							'model'=>$modRencanaLembur,
							'attribute'=>'karlembur_nama',
							'sourceUrl'=> $this->createUrl('PegawaiLembur'),
							'options'=>array(
							   'showAnim'=>'fold',
							   'minLength' => 2,
							   'select'=>'js:function( event, ui ) {
										  $("#pegawailembur_id").val(ui.item.pegawai_id);
										  $("#'.CHtml::activeId($modRencanaLembur,'karlembur_nama').'").val(ui.item.nama_pegawai);
										  $("#'.CHtml::activeId($modRencanaLembur,'rencana_nip').'").val(ui.item.nomorindukpegawai);
								}',
							),
							'tombolDialog'=>array('idDialog'=>'dialogPegawaiLembur'),
							'htmlOptions'=>array(
							'onkeypress'=>"return $(this).focusNextInputField(event)",
							'onblur' => 'if(this.value === "") $("#pegawailembur_id").val(""); ',
							'class'=>'span3','style'=>'float:left;'),
						)); ?>
					</div>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
				<?php echo $form->labelEx($modRencanaLembur,'rencana_nip', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($modRencanaLembur, 'rencana_nip', array('class'=>'span3','onkeypress'=>"if(event.keyCode == 13){submitPegawaiLembur();} return $(this).focusNextInputField(event);" )); ?>
					<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
						array('onclick'=>'submitPegawaiLembur();return false;',
							  'class'=>'btn btn-primary',
							  'onkeypress'=>"if(event.keyCode == 13){submitPegawaiLembur();} return $(this).focusNextInputField(event);",
							  'rel'=>"tooltip",
							  'title'=>"Klik Untuk Menambahkan Pegawai Lembur",

							)); ?>
				</div>
			</div>
        </div>
    </div>
</fieldset>
<div class="block-tabel">
    <h6>Tabel <b>Rencana Lembur</b></h6>
    <?php if (isset($modDetails)){
    echo $form->errorSummary($modDetails); }?>
    <table id="tabelPegawaiLembur" class="table table-striped table-condensed">
        <thead>
        <tr>
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">No. Induk Pegawai</th>
            <th style="text-align: center;">Nama Pegawai</th>
            <!--<th style="text-align: center;">Jabatan</th>-->
            <th style="text-align: center;">Jam Mulai</th>
            <th style="text-align: center;">Jam Selesai</th>
            <th style="text-align: center;">Alasan Lembur</th>
            <th style="text-align: center;">Batal</th>

        </tr>
        </thead>
        <tbody>
            <?php
                $tr = '';
                $no = 1;
                $format = new MyFormatter;
               if(count($rencana) > 0){
                    foreach($rencana AS $key=> $modDetail){
						$rencana[$key]->jamMulai = date('H:i:s', strtotime($rencana[$key]->tglmulai));
						$rencana[$key]->jamSelesai = date('H:i:s', strtotime($rencana[$key]->tglselesai));
						$tr.="<tr>
						   <td>". CHtml::TextField('noUrut',$no++,array('class'=>'span1 noUrut','readonly'=>TRUE))."</td>
						   <td>".$rencana[$key]->pegawai->nomorindukpegawai."</td>
						   <td>".$rencana[$key]->pegawai->nama_pegawai."</td>
						   <td style='text-align:center;'>".$rencana[$key]->jamMulai."</td>
						   <td style='text-align:center;'>".$rencana[$key]->jamSelesai."</td>
						   <td>".$rencana[$key]->alasanlembur."</td>
						   </tr>   
					   "; // <td>".$modDetail[$key]->pegawai->departement->departement_nama."</td>

					}
				echo $tr;

			}
			?>
        </tbody>
    </table>
    <table class="table-condensed">
        <tr>
            <td width="50%">
                <div class="control-group">
                    <?php echo $form->labelEx($modRencanaLembur, 'keterangan', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modRencanaLembur, 'keterangan', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </td>
            <td width="50%">
                <div class="control-group">
                    <?php echo $form->labelEx($modRencanaLembur, 'pemberitugas_id', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($modRencanaLembur,'pemberitugas_id');?>
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
								'htmlOptions'=>array(
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaLembur, 'pemberitugas_id') . '").val(""); ',
								'class'=>'span2','style'=>'float:left;'),
                            )); ?>
                        </div>
                    </div>
                </div>
            </td>
        </tr>    
    </table>
</div>
<div class="form-actions">
        <?php 
			$disableSave = false;
			$disableSave = (!empty($_GET['norencana'])) ? true : ($sukses > 0) ? true : false;
			$disablePrint = ($disableSave) ? false : true;
        ?>
    <?php 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'validasiLembur();', 'onkeypress'=>'validasiLembur();','disabled'=>$disableSave)); //formSubmit(this,event)        
                //  jika tanpa validasiLembur 
                /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
                 * 
                 */
         ?>
        
    <?php if(!isset($_GET['frame'])){
        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
            $this->createUrl($this->id.'/buat'), 
            array('class'=>'btn btn-danger',
                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    } ?>
        <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));
        ?>
    <?php
        $tips = array(
            '0' => 'tanggal',
            '1' => 'autocomplete-search',
            '2' => 'time',
            '3' => 'tambah2',
            '4' => 'simpan',
            '5' => 'ulang',
            '6' => 'print',
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('_jsFunctions',array('modRencanaLembur'=>$modRencanaLembur)); ?>
<?php
$karlembur_nama=CHtml::activeId($modRencanaLembur,'karlembur_nama');
$karlembur_nomorindukpegawai=CHtml::activeId($modRencanaLembur,'rencana_nip');
$jscript = <<< JS
var nomorindukpegawaiPegawaiLembur;


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
								  $(\"#'.CHtml::activeId($modRencanaLembur,'rencana_nip').'\").val(\"$data->nomorindukpegawai\");
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
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->textFieldRow($modRencanaKebBarang,'renkebbarang_no',array('readonly'=>true,'class'=>'span3 isRequired', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
		</div>
	</div>
	<div class="span2"></div>		
	<div class="span4">
		<div class="control-group ">
            <?php echo $form->labelEx($modRencanaKebBarang,'renkebbarang_tgl', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                        $modRencanaKebBarang->renkebbarang_tgl = (!empty($modRencanaKebBarang->renkebbarang_tgl) ? date("d/m/Y H:i:s",strtotime($modRencanaKebBarang->renkebbarang_tgl)) : null);
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$modRencanaKebBarang,
                            'attribute'=>'renkebbarang_tgl',
                            'mode'=>'datetime',
                            'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                'maxDate' => 'd',
                                'yearRange'=> "-150:+0",
                            ),
                            'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                            ),
                    )); ?>
                </div>
        </div>
	</div>
</div>
<!--<div class = "span5">
    <div class="control-group ">
        <?php // echo $form->labelEx($modRencanaKebBarang,'statusrencana', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php // echo $form->dropDownList($modRencanaKebBarang,'statusrencana',LookupM::getItems('statusrencana'),array('empty'=>'--Pilih--','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
    </div>
</div>-->

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

$modPegawaiMengetahui = new PegawairuanganV('search');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->search(),
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
                                                  $(\"#'.CHtml::activeId($modRencanaKebBarang,'pegmengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modRencanaKebBarang,'pegmengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
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

$modPegawaiMenyetujui = new PegawairuanganV('search');
$modPegawaiMenyetujui->unsetAttributes();
$modPegawaiMenyetujui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimenyetujui-grid',
	'dataProvider'=>$modPegawaiMenyetujui->search(),
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
                                                  $(\"#'.CHtml::activeId($modRencanaKebBarang,'pegmenyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modRencanaKebBarang,'pegmenyetujui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
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
<div class = "span4">
    <?php echo CHtml::hiddenField('supplier_id',"", array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo CHtml::hiddenField('permintaanpembelian_id',$modPermintaanPembelian->permintaanpembelian_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    
    <?php if(isset($_GET['sukses'])){ ?> 
    <?php if(!empty($modPermintaanPembelian->rencanakebfarmasi_id)){ ?>
    <?php echo $form->hiddenField($modPermintaanPembelian,'rencanakebfarmasi_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modRencanaKebFarmasi,'noperencnaan',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->labelEx($modRencanaKebFarmasi,'tglperencanaan', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                        'model'=>$modRencanaKebFarmasi,
                        'attribute'=>'tglperencanaan',
                        'mode'=>'datetime',
                        'options'=> array(
                            'dateFormat'=>PARAMS::DATE_FORMAT,
                            'maxDate'=>'d',
                        ),
                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 isRequired', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                        ),
            )); ?>
        </div>
    
    <?php } ?>
    
    <?php }else if(isset($_GET['rencana_id'])){ ?>
    <?php echo $form->textFieldRow($modRencanaKebFarmasi,'noperencnaan',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->hiddenField($modPermintaanPembelian,'rencanakebfarmasi_id',array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->labelEx($modRencanaKebFarmasi,'tglperencanaan', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                        'model'=>$modRencanaKebFarmasi,
                        'attribute'=>'tglperencanaan',
                        'mode'=>'datetime',
                        'options'=> array(
                            'dateFormat'=>PARAMS::DATE_FORMAT,
                            'maxDate'=>'d',
                        ),
                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 isRequired', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                        ),
            )); ?>
        </div>
    <?php } ?>
    <?php if(isset($_GET['penawaran_id'])){ ?>
    <?php echo $form->hiddenField($modPermintaanPembelian,'permintaanpenawaran_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPermintaanPenawaran,'nosuratpenawaran',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPermintaanPenawaran,'tglpenawaran', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                    $modPermintaanPenawaran->tglpenawaran = (!empty($modPermintaanPenawaran->tglpenawaran) ? date("d/m/Y H:i:s",strtotime($modPermintaanPenawaran->tglpenawaran)) : null);
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$modPermintaanPenawaran,
                        'attribute'=>'tglpenawaran',
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
    <?php } ?>  
	<?php echo $form->textFieldRow($modPermintaanPembelian,'nopermintaan',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPermintaanPembelian,'tglpermintaanpembelian', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                    $modPermintaanPembelian->tglpermintaanpembelian = (!empty($modPermintaanPembelian->tglpermintaanpembelian) ? date("d/m/Y H:i:s",strtotime($modPermintaanPembelian->tglpermintaanpembelian)) : null);
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$modPermintaanPembelian,
                        'attribute'=>'tglpermintaanpembelian',
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
    
    <?php echo $form->dropDownListRow($modPermintaanPembelian,'supplier_id',
             CHtml::listData(SupplierM::model()->SupplierItems, 'supplier_id', 'supplier_nama'),
             array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
             'empty'=>'-- Pilih --')); ?>
</div>
<div class = "span4">
    <?php echo $form->dropDownListRow($modPermintaanPembelian,'syaratbayar_id',
                CHtml::listData($modPermintaanPembelian->SyaratBayarItems, 'syaratbayar_id', 'syaratbayar_nama'),
                array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                'empty'=>'-- Pilih --',)); ?>
    <?php echo $form->textAreaRow($modPermintaanPembelian,'keteranganpermintaan',array('placeholder'=>'Ket. Permintaan','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
</div>
<div class = "span4">
    <?php echo $form->textAreaRow($modPermintaanPembelian,'alamatpengiriman',array('placeholder'=>'Alamat Pengirim','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<!--    <div class="control-group ">
        <?php // echo $form->labelEx($modPermintaanPembelian,'statuspembelian', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php // echo $form->dropDownList($modPermintaanPembelian,'statuspembelian',LookupM::getItems('statuspembelian'),array('empty'=>'--Pilih--','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
    </div>-->
</div>

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
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new GFPegawaiV('search');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['GFPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['GFPegawaiV'];
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
                                                  $(\"#'.CHtml::activeId($modPermintaanPembelian,'pegawaimengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPermintaanPembelian,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
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
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui = new GFPegawaiV('search');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['GFPegawaiV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['GFPegawaiV'];
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
                                                  $(\"#'.CHtml::activeId($modPermintaanPembelian,'pegawaimenyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPermintaanPembelian,'pegawaimenyetujui_nama').'\").val(\"$data->NamaLengkap\");
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
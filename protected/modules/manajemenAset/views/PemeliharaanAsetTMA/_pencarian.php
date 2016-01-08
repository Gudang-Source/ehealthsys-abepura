<div class="search-form">
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pencarian-form',
    'type' => 'horizontal',
    //'focus'=>'#'.CHtml::activeId($modSterilisasiDetail,'sterilisasi_no'),
        ));
?>
<div class="row-fluid">
    <div class="span4">
        <div class="control-group">
                <?php echo CHtml::label('Kategori Aset', 'kategori_aset', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php echo $form->dropDownList($modPemeliharaanDetail,'kategori_aset',$kategoriaset,array('empty'=>'--Kategori Aset--', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>           
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label('Asal Aset', 'asal_aset', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php echo $form->dropDownList($modPemeliharaanDetail,'asal_aset',$asalaset,array('empty'=>'--Asal Aset--','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>           
                </div>
        </div>			
    </div>
    <div class="span4">
        <div class="control-group ">
                <?php echo CHtml::label('Kode Invetarisasi','kode_inventaris',array('class'=>'control-label')) ?>
                        <div class="controls">
                                <?php echo $form->textField($modPemeliharaanDetail,'kode_inventaris',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>false)); ?>
                        </div> 
        </div>
        <div class="control-group ">
                <?php echo CHtml::label('Kode Aset','',array('class'=>'control-label')) ?>
                        <div class="controls">
                                <?php echo $form->textField($modPemeliharaanDetail,'kode_aset',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>false)); ?>
                        </div> 
        </div>
    </div>
    <div class="span4">
        <div class="control-group">
                <?//php echo CHtml::hiddenField('barang_id'); ?>
                <?//php echo CHtml::hiddenField('barang_kode'); ?>
                <label class="control-label" for="namaObat">Nama Aset</label>
                <div class="controls">
                <?php echo CHtml::hiddenField('barang_id','',array('readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('inv_id','',array('readonly'=>true)); ?>
                <?php 
                        $this->widget('MyJuiAutoComplete', array(
                                'name'=>'namaBarang',
                                'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                                   url: "'.$this->createUrl('AutocompleteBarang').'",
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
                                                        $(this).val("");
                                                        return false;
                                                }',
                                           'select'=>'js:function( event, ui ) {
                                                        $(this).val(ui.item.value);
                                                        $("#barang_id").val(ui.item.barang_id);
                                                        $("#namaBarang").val(ui.item.barang_nama);
                                                        return false;
                                                }',
                                ),
                                'htmlOptions'=>array(
                                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                                        'onblur' => 'if(this.value === "") $("#barang_id").val(""); '
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogBarangAset'),
                        )); 
                        ?>
                </div>
        </div>			
    </div>
</div>
<div class="form-actions">
        <?php 
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onkeypress'=>'searchPenerimaan();','onclick'=>'searchPenerimaan()')); 
        ?>
        <?php 
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                $this->createUrl($this->id.'/index'), 
                array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));  
        ?>
</div>
<?php $this->endWidget(); ?>
</div>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarangAset',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 570,
        'resizable' => false,
    ),
));

$modBarang = new MABarangV('search');
$modBarang->unsetAttributes();
if (isset($_GET['MABarangV'])){
    $modBarang->attributes = $_GET['MABarangV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barangsusut-t-grid',
    'dataProvider'=>$modBarang->searchDialog(),
    'filter'=>$modBarang,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectBarang",
				"onClick" => "
					$(\'#barang_id\').val(\'$data->barang_id\');
					$(\'#namaBarang\').val(\'$data->barang_nama\');
					$(\"#'.CHtml::activeId($modPemeliharaanDetail,'kode_inventaris').'\").val(\"$data->barang_id\");
					$(\'#dialogBarangAset\').dialog(\'close\');
					return false;"))',
        ),
		'barang_nama',
		'barang_kode',
		'barang_ekonomis_thn',
		'barang_harganetto',
		
		'invasetlain_namabrg',
		'invasetlain_kode',
		'invasetlain_noregister',
		array(
			'header'=>'Inv. Aset Lain Tanggal Guna',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invasetlain_tglguna)'
		),
		
		'invgedung_namabrg',
		'invgedung_kode',
		'invgedung_noregister',
		array(
			'header'=>'Inv. Gedung Tanggal Guna',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invgedung_tglguna)'
		),
		
		'invperalatan_namabrg',
		'invperalatan_kode',
		'invperalatan_noregister',
		array(
			'header'=>'Inv. Peralatan Tanggal Guna',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invperalatan_tglguna)'
		),
		'invperalatan_umurekonomis',
		
		'invjalan_kode',
		'invjalan_noregister',
		'invjalan_namabrg',
		array(
			'header'=>'Inv. Jalan Tanggal Guna',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invjalan_tglguna)'
		),
		
		'invtanah_namabrg',
		'invtanah_kode',
		'invtanah_noregister',
		array(
			'header'=>'Inv. Tanah Tanggal Guna',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invtanah_tglguna)'
		),
		'invtanah_umurekonomis',
		
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>
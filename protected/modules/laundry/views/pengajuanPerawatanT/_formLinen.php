<div class="row-fluid" id="formLinen">
    <div class="span4">
        <?php /*
        <div class="control-group ">
            <label class='control-label'>No. Register Linen</label>
            <div class="controls">
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'noregisterlinen',
                        'source'=>'js: function(request, response) {
                                       $.ajax({
                                           url: "'.$this->createUrl('AutocompleteRegisterLinen').'",
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
                                    $("#linen_id").val(ui.item.linen_id);
                                    $("#noregisterlinen").val(ui.item.noregisterlinen);
                                    return false;
                                }',
                        ),
                        'htmlOptions'=>array(
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#linen_id").val(""); '
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogRegister'),
                    )); 
                ?>
            </div>
        </div>
        */ ?>
        <div class="control-group">
            <label class='control-label'>Nama Linen</label>
            <div class="controls">
                <?php echo CHtml::hiddenField('linen_id'); ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                        'name'=>'namalinen',
                        'source'=>'js: function(request, response) {
                                       $.ajax({
                                           url: "'.$this->createUrl('AutocompleteLinen').'",
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
                                    $("#linen_id").val(ui.item.linen_id);
                                    $("#namalinen").val(ui.item.namalinen);
                                    return false;
                                }',
                        ),
                        'htmlOptions'=>array(
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#linen_id").val(""); '
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogLinen'),
                    )); 
                ?>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="control-group">
            <label class='control-label'>Jenis Perawatan</label>
            <div class="controls">
                <?php echo Chtml::dropDownList('jenisperawatan','', LookupM::getItems('jenisperawatan'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="control-group">
            <label class='control-label'>Keterangan</label>
            <div class="controls">
                    <?php echo Chtml::textField('keterangan_pengperawatan', '', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
                    &nbsp;&nbsp;&nbsp;
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                            array('onclick' => 'inputLinen();return false;',
                                    'class' => 'btn btn-primary',
                                    'onkeypress' => "inputLinen();return $(this).focusNextInputField(event)",
                                    'rel' => "tooltip",
                                    'title' => "Klik untuk menambahkan Linen",));
                    ?>	
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog buat cari Register Linen =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRegister',
    'options' => array(
        'title' => 'Daftar Register Linen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 700,
        'resizable' => false,
    ),
));

$modLinen = new LALinenM('searchDialog');
$modLinen->unsetAttributes();
if (isset($_GET['LALinenM'])){
    $modLinen->attributes = $_GET['LALinenM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modLinen->searchDialog(),
    'filter'=>$modLinen,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRegister",
				"onClick" => "
					$(\'#linen_id\').val(\'$data->linen_id\');
					$(\'#noregisterlinen\').val(\'$data->noregisterlinen\');
					$(\'#dialogRegister\').dialog(\'close\');
					return false;"))',
        ),
		
		array(
			'name'=>'namalinen',
			'type'=>'raw',
			'value'=>'$data->namalinen'
		),
		array(
			'name'=>'noregisterlinen',
			'type'=>'raw',
			'value'=>'$data->noregisterlinen'
		),	
		array(
			'header'=>'Tanggal Register',
			'type'=>'raw',
			'value'=>'$data->tglregisterlinen'
		),
		array(
			'header'=>'Barang',
			'type'=>'raw',
			'value'=>'isset($data->barang_id)?$data->barang->barang_nama:""'
		),
		array(
			'header'=>'Bahan',
			'type'=>'raw',
			'value'=>'isset($data->bahanlinen_id)?$data->bahan->bahanlinen_nama:""'
		),
		array(
			'header'=>'Jenis',
			'type'=>'raw',
			'value'=>'isset($data->jenislinen_id)?$data->jenis->jenislinen_nama:""'
		),
		
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>

<?php
//========= Dialog buat cari Nama Linen =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogLinen',
    'options' => array(
        'title' => 'Daftar Linen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 700,
        'resizable' => false,
    ),
));

$modLinen = new LALinenM('searchDialog');
$modLinen->unsetAttributes();
if (isset($_GET['LALinenM'])){
    $modLinen->attributes = $_GET['LALinenM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang2-m-grid',
    'dataProvider'=>$modLinen->searchDialog(),
    'filter'=>$modLinen,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectLinen",
				"onClick" => "
					$(\'#linen_id\').val(\'$data->linen_id\');
					$(\'#namalinen\').val(\'$data->namalinen\');
					$(\'#dialogLinen\').dialog(\'close\');
					return false;"))',
        ),
		
		array(
			'name'=>'namalinen',
			'type'=>'raw',
			'value'=>'$data->namalinen'
		),
		array(
			'name'=>'noregisterlinen',
			'type'=>'raw',
			'value'=>'$data->noregisterlinen'
		),	
		array(
			'header'=>'Tanggal Register',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglregisterlinen)',
		),
		array(
			'header'=>'Barang',
			'type'=>'raw',
			'value'=>'isset($data->barang_id)?$data->barang->barang_nama:""'
		),
		array(
			'header'=>'Bahan',
			'type'=>'raw',
			'value'=>'isset($data->bahanlinen_id)?$data->bahan->bahanlinen_nama:""'
		),
		array(
			'header'=>'Jenis',
			'type'=>'raw',
			'value'=>'isset($data->jenislinen_id)?$data->jenis->jenislinen_nama:""'
		),
		
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>
<div class="row-fluid" id="formDetailBarang">
    <div class="span4">
        <div class="control-group ">
                <label class='control-label'>Barang</label>
                <div class="controls">
                        <?php echo CHtml::hiddenField('barang_id'); ?>
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
                'tombolDialog'=>array('idDialog'=>'dialogBarang'),
            )); 
            ?>

                </div>
        </div>
    </div>
    <div class="span4">
        <div class="control-group">
                <label class='control-label'>Jumlah</label>
                <div class="controls">
                        <?php echo Chtml::textField('jumlah', 1, array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
                        <?php echo Chtml::hiddenField('ruangan_id', Yii::app()->user->getState('ruangan_id'), array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                        <?php echo Chtml::dropDownList('satuan', '', LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                                array('onclick' => 'inputBarang();return false;',
                                        'class' => 'btn btn-primary',
                                        'onkeypress' => "inputBarang();return $(this).focusNextInputField(event)",
                                        'rel' => "tooltip",
                                        'title' => "Klik untuk menambahkan Barang",));
                        ?>
                </div>
        </div>
    </div>
</div>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));

$modBarang = new GUInformasistokbarangV('searchBarangRuangan');//GUBarangM('searchDialog')
$modBarang->unsetAttributes();
$modBarang->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['GUInformasistokbarangV'])){
    $modBarang->attributes = $_GET['GUInformasistokbarangV'];
    $modBarang->ruangan_id = Yii::app()->user->getState('ruangan_id');
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modBarang->searchBarangRuangan(),
    'filter'=>$modBarang,
	'template'=>"{summary}\n{items}{pager}",
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
					$(\'#satuan\').val(\'$data->barang_satuan\');
					$(\'#dialogBarang\').dialog(\'close\');
					return false;"))',
        ),
       array(
            'header' => 'Tipe Barang',
            'name' => 'barang_type',
            'filter' => CHtml::dropDownList('GUBarangM[barang_type]',$modBarang->barang_type,LookupM::getItems('barangumumtype'),array('empty'=>'-- Pilih --')),    
            'value' => '$data->barang_type',
        ),
        'barang_kode',
        'barang_nama',
        'barang_merk',        
        array(
            'name'=>'barang_satuan',
            'filter'=> CHtml::dropDownList('GUBarangM[barang_satuan]',$modBarang->barang_satuan,LookupM::getItems('satuanbarang'),array('empty'=>'--Pilih--')),
            'value'=>'$data->barang_satuan',
        ),
        'barang_ukuran',
        'barang_ekonomis_thn',
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>
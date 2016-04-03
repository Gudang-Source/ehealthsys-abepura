<?php
    if(!empty($_GET['id'])){
?>
     <div class="alert alert-block alert-success">
        <a class="close" data-dismiss="alert">×</a>
        Data berhasil disimpan
    </div>
<?php } ?>
<div class="white-container">
    <legend class="rim2">Transaksi Pengajuan <b>Bahan Makanan</b></legend>

    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'gzpengajuanbahanmkn-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        'focus' => '#',
            ));
    ?>

    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

    <?php //echo $form->errorSummary($model, $modDetails, $modDetailPengajuan); ?>
	<fieldset class="box">
		<legend class="rim">Data Pengajuan</legend>
		<div class="row-fluid">
			<div class="span4">
				<?php echo $form->textFieldRow($model, 'nopengajuan', array('readonly'=>true,'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
				<div class="control-group ">
					<?php echo $form->labelEx($model, 'tglpengajuanbahan', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglpengajuanbahan',
							'mode' => 'datetime',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
						));
						?>
						<?php echo $form->error($model, 'tglpengajuanbahan'); ?>
					</div>
				</div>
				<?php echo $form->dropDownListRow($model, 'supplier_id', CHtml::listData($model->Supplier, 'supplier_id', 'supplier_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				<div class="control-group ">
					<?php echo $form->labelEx($model, 'tglmintadikirim', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglmintadikirim',
							'mode' => 'datetime',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								//'maxDate' => 'd',
							),
							'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
						));
						?>
						<?php echo $form->error($model, 'tglmintadikirim'); ?>
					</div>
				</div>
				<?php echo $form->dropDownListRow($model, 'sumberdanabhn', LookupM::getItems('sumberdanabahan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
			</div>
			<div class="span4">
                            <?php echo $form->textAreaRow($model, 'alamatpengiriman', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->dropDownListRow($model, 'idpegawai_mengetahui', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif = true'), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			</div>
			<div class="span4">
                            <?php echo $form->dropDownListRow($model, 'idpegawai_mengajukan', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif = true'), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->textAreaRow($model, 'keterangan_bahan', array('rows' => 6, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	</fieldset>
	<fieldset class="box">
		<legend class="rim">Pilih Bahan Makanan</legend>
        <div class="control-group ">
            <label class="control-label">Nama Bahan Makanan <font color="red"> * </font></label>
            <div class="controls">
                <?php echo CHtml::hiddenField('idBahan'); ?>
                <!--                <div class="input-append" style='display:inline'>-->
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namaBahan',
                    'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompleteBahanMakanan') . '",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                                   idSumberDana: $("#idSumberDana").val(),
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                        'select' => 'js:function( event, ui ) {
                                                        $("#idBahan").val(ui.item.bahanmakanan_id); 
                                                        $("#qty").val(1); 
                                                        $("#satuanbahan").val(ui.item.satuanbahan);
                                                        return false;
                                                    }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogBahanMakanan'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">Jumlah</label>
            <div class="controls">
                <?php echo CHtml::textField('qty', '', array('class' => 'span1 numbersOnly number', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                <?php echo CHtml::dropDownList('satuanbahan', '', LookupM::getItems('satuanbahanmakanan'), array('empty' => '-- Pilih --', 'class' => 'span1')); ?>
                <?php echo CHtml::textField('ukuran', '', array('class' => 'span2', 'placeholder' => 'Ukuran')); ?>
                <?php echo CHtml::textField('merk', '', array('class' => 'span2', 'placeholder' => 'Merk')); ?>
                <?php
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'inputBahanMakanan();return false;',
                    'class' => 'btn btn-primary numbersOnly',
                    'onkeypress' => "inputBahanMakanan();return $(this).focusNextInputField(event)",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan Bahan Makanan",));
                ?>
            </div>
        </div>
	</fieldset>
	<div class="block-tabel">
        <h6>Tabel Pengajuan Bahan Makanan</h6>
        <table class="table table-bordered table-condensed" id="tableBahanMakanan">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList',this);hitungSemua();"></th>
                    <th>No.Urut</th>
                    <th>Golongan</th>
                    <th>Jenis</th>
                    <th>Kelompok</th>
                    <th>Nama</th>
                    <th>Jumlah Persediaan</th>
                    <th>Satuan</th>
                    <th>Harga Netto</th>
                    <th>Harga Jual</th>
                    <th>Diskon</th>
                    <th>Tanggal Kadaluarsa</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan='13'><div class='pull-right'>Total Harga</div></td>
                    <td><?php 
			echo $form->textField($model, 'totalharganetto', array('readonly' => true, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
		    </td>
                </tr>
            </tfoot>
        </table>
	</div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
			 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	<?php 
$content = $this->renderPartial('../tips/transaksi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	

    </div>
</div>

    <?php $this->endWidget(); ?>

<script type="text/javascript">
    /**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
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
</script>
<?php
$totalHarga = CHtml::activeId($model, 'totalharganetto');
$urlBahan = $this->createUrl('getBahanMakanan');
$js = <<<JS
    function inputBahanMakanan(){
        var id = $('#idBahan').val();
        var qty= $('#qty').val();
        var ukuran = $('#ukuran').val();
        var merk = $('#merk').val();
        var satuanbahan = $('#satuanbahan').val();

        if (jQuery.isNumeric(id)){
        if(cekList(id)==true){    
              $.post("${urlBahan}", {id:id, qty:qty, ukuran:ukuran, merk:merk, stuanbahan:satuanbahan},
                function(data){

                    $('#tableBahanMakanan tbody').append(data.tr);
                    hitungSemua();
                    $("#tableBahanMakanan tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                    $("#tableBahanMakanan tbody tr:last .satuanbahan").val(satuanbahan);
                    renameInputRowObatAlkes($('#tableBahanMakanan'));
              }, "json");
              clear();
        }   
        }
        else{
            myAlert('Isi Data dengan Benar');
        }
    }
    
    function hitungSemua(){
        noUrut = 1;
        value = 0;
        $('.noUrut').each(function(){
            $(this).val(noUrut);
            noUrut++;
            if ($(this).parents('tr').find('#checkList').is(':checked')){
		netto = parseInt(unformatNumber($(this).parents('tr').find('.subNetto').val()));
                val = parseFloat(netto);
                value += val;
            }
            
            $('.cekList').each(function(){
               if ($(this).is(':checked')){

                     $(this).parents('tr').find('.cek').val(1);
                }else{
                    $(this).parents('tr').find('.cek').val(0);
                }
            });
        });
	total = formatInteger(value);
        $('#${totalHarga}').val(total);
    }
    
    function hitung(obj){
        var netto = $('#PengajuanbahandetailT_harganettobhn').val();
        var jml = $(obj).val();
        $(obj).parents('tr').find('.subNetto').val(netto*jml);
        hitungSemua();
    }
    function hapus(obj) {
        $(obj).parents('tr').remove();
        hitungSemua();
    }
    
    function cekList(id){
        x = true;
        $('.bahanmakanan_id').each(function(){
            if ($(this).val() == id){
                myAlert('Daftar Bahan Makanan telah ada di List');
                clear();
                x = false;
            }
        });
        return x;   
    }   
    function clear(){
        $('#namaBahan').val('');
        $('#qty').val('');
        $('#satuanbahan').val('');
        $('#ukuran').val('');
        $('#merk').val('');
    }
    
JS;
Yii::app()->clientScript->registerScript('fungsi', $js, CClientScript::POS_HEAD);
?>

<?php
//========= Dialog buat cari Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBahanMakanan',
    'options' => array(
        'title' => 'Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modBahanMakanan = new GZBahanMakananM('search');
$modBahanMakanan->unsetAttributes();
if (isset($_GET['GZBahanMakananM']))
    $modBahanMakanan->attributes = $_GET['GZBahanMakananM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzbahanmakanan-m-grid',
    'dataProvider' => $modBahanMakanan->search(),
    'filter' => $modBahanMakanan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "$(\'#idBahan\').val($data->bahanmakanan_id);
                                    $(\'#satuanbahan\').val(\'$data->satuanbahan\');
                                    $(\'#qty\').val(1); 
                                    $(\'#namaBahan\').val(\'$data->jenisbahanmakanan - $data->namabahanmakanan - $data->jmlpersediaan\');
                                    $(\'#dialogBahanMakanan\').dialog(\'close\');return false;"))',
        ),
        ////'bahanmakanan_id',
//        array(
//                        'name'=>'bahanmakanan_id',
//                        'value'=>'$data->bahanmakanan_id',
//                        'filter'=>false,
//                ),
        array(
            'name' => 'golbahanmakanan_id',
            'filter' => CHtml::listData(GolbahanmakananM::model()->findAll('golbahanmakanan_aktif = true'), 'golbahanmakanan_id', 'golbahanmakanan_nama'),
            'value' => '$data->golbahanmakanan->golbahanmakanan_nama',
        ),
//        'golbahanmakanan.golbahanmakanan_nama',
//        'sumberdanabhn',
        'jenisbahanmakanan',
        'kelbahanmakanan',
        'namabahanmakanan',
        'jmlpersediaan',
        'satuanbahan',
        'harganettobahan',
        'hargajualbahan',
        'discount',
        'tglkadaluarsabahan',
//        'jmlminimal',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));


$this->endWidget();
?>
<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

<?php Yii::app()->clientScript->registerScript('submit', '
    $("form").submit(function(){
        sumberDana = $("#'.CHtml::activeId($model, 'sumberdanabhn').'").val();
        jumlah = 0;
        
        if (sumberDana == ""){
            myAlert("'.CHtml::encode($model->getAttributeLabel('sumberdanabhn')).' harus diisi !");
            return false;
        }

        $(".cekList").each(function(){
            if ($(this).is(":checked")){
                jumlah++;
            }
        });
        
        
        if (jumlah < 1){
            myAlert("Pilih bahan makanan yang akan diajukan !");
            return false;
        }
    });
', CClientScript::POS_READY); ?>
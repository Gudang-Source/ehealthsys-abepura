<div class="white-container">
    <legend  class="rim2">Transaksi Pemesanan <b>Menu Diet Pasien</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gzpesanmenudiet-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#'.CHtml::activeId($model,'nama_pemesan'),
            ));
    ?>
    <?php
        if(!empty($_GET['id'])){
    ?>
    <div class="alert alert-block alert-success">
        <a class="close" data-dismiss="alert">×</a>
        Data berhasil disimpan
    </div>
    <?php } ?>
    
    
    <?php $this->renderPartial($this->path_view.'._dataForm', array('form'=>$form, 'model'=>$model)); ?>
    <fieldset class="box" id="fieldsetMenuDiet">
        <legend class="rim">Detail Menu Diet</legend>		
        <table width="100%" border="0">
            <tr>
                <td>
                    <div class="control-group ">
                    <?php //echo CHtml::hiddenField('jenisPesan'); ?>
                    <?php //echo $form->dropDownListRow($model, 'jenispesanmenu', GZPesanmenudietT::jenisPesan(), array('inline' => true, 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'setJenisPesan();', 'maxlength' => 50)); ?>
                        <label class='control-label'><?php echo CHtml::encode($model->getAttributeLabel('ruangan_id')); ?><span class="required">*</span></label>
                        <div class="controls">
                             <?php //echo CHtml::hiddenField('instalasi_id'); ?>
                            <?php //echo CHtml::hiddenField('ruangan_id'); ?>
                            <?php
                            //$model->ruangan_id = !empty($model->ruangan_id)?$model->ruangan_id:Yii::app()->user->getState('ruangan_id');
                           // $model->instalasi_id = !empty($model->instalasi_id)?$model->instalasi_id:Yii::app()->user->getState('instalasi_id');
                            echo $form->dropDownList($model, 'instalasi_id', CHtml::listData($model->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                                'ajax' => array('type' => 'POST',
                                    'url' => $this->createUrl('setDropdownRuangan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                    'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''),));
                            ?>
                            <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange'=>'clearAll()')); ?>
                            <?php echo $form->error($model, 'ruangan_id'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <label class='control-label'>Nama Pasien</label>
                        <div class="controls">
                            <?php echo CHtml::hiddenField('jenistarif_id'); ?>
                            <?php echo CHtml::hiddenField('kelaspelayanan_id'); ?>
                            <?php echo CHtml::hiddenField('penjamin_id'); ?>
                            <?php echo CHtml::hiddenField('pasien_id'); ?>
                            <?php echo CHtml::hiddenField('pendaftaran_id'); ?>
                            <?php echo CHtml::hiddenField('pasienadmisi_id'); ?>
                            <!--                <div class="input-append" style='display:inline'>-->
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'namaPasien',
                                'source' => 'js: function(request, response) {
                                                                               $.ajax({
                                                                                   url: "' . $this->createUrl('pasienUntukMenuDiet') . '",
                                                                                   dataType: "json",
                                                                                   data: {
                                                                                       namaPasien: request.term,
                                                                                       ruangan_id:$("#'.CHtml::activeId($model, 'ruangan_id').'").val(),
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
                                                                            $(this).val( ui.item.nama_pasien);
                                                                            $("#pasien_id").val(ui.item.pasien_id); 
                                                                            $("#pendaftaran_id").val(ui.item.pendaftaran_id); 
                                                                            $("#pasienadmisi_id").val(ui.item.pasienadmisi_id); 
                                                                            $("#kelaspelayanan_id").val(ui.item.kelaspelayanan_id); 
                                                                            $("#penjamin_id").val(ui.item.penjamin_id); 
                                                                            $("#jenistarif_id").val(ui.item.jenistarif_id); 
                                                                                                                                            refreshDialogMenuDiet();
                                                                            return false;
                                                                        }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'hurufs-only'
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPasien', 'jsFunction'=>'dialogMenuPasien()'),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <label class='control-label'>Menu Diet</label>
                        <div class="controls">
                            <?php echo CHtml::hiddenField('menudiet_id'); ?>
                            <!--                <div class="input-append" style='display:inline'>-->
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'menuDiet',
                                'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . $this->createUrl('menuDiet') . '",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                                   jenisdiet_id:$("#'.CHtml::activeId($model, 'jenisdiet_id').'").val(),
                                                   kelaspelayanan_id:$("#kelaspelayanan_id").val(),
                                                   penjamin_id:$("#penjamin_id").val(),

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
                                                                            $("#menudiet_id").val(ui.item.menudiet_id); 
                                                                            $("#URT").val(ui.item.ukuranrumahtangga); 
                                                                            return false;
                                                                        }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class'=>'span2 custom-only',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogMenuDiet'),
                            ));
                            ?>

                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <label class='control-label' style = "text-align:left;padding-left:25px;">Jenis Waktu</label>
                        <div >
                            <?php                 
                            $modJenisWaktu = JeniswaktuM::getJenisWaktu();
                            $myData = CHtml::encodeArray(CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_id'));
                            $myData = empty($myData) ? categories : $myData;
                            ?>
                            <fieldset>
                                    <?php echo '<table>
                                                    <tr >
                                                        <td>
                                                            '.Chtml::checkBoxList('jeniswaktu', $myData, CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_nama'), array('template'=>'<label class="checkbox inline">{input}{label}</label>', 'separator'=>'', 'style'=>'margin-left:2px;max-width:10px;','class'=>'span2 jeniswaktu', 'onkeypress' => "return $(this).focusNextInputField(event)")).'
                                                        </td>
                                                    </tr>
                                                    </table>'; 
                                    ?>
                            </fieldset>
                        </div>   
                    </div>
                    <div class="control-group ">
                        <label class='' style = "text-align:left;padding-left:25px;padding-right:5px;">Jumlah</label>
                     
                            <?php echo Chtml::textField('jumlah', 1, array('class'=>'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
                            <?php echo Chtml::dropDownList('URT', '', LookupM::getItems('ukuranrumahtangga'), array('empty'=>'-- Pilih --', 'class'=>'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
                            <?php
                            echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'inputMenuDiet();return false;',
                                'class' => 'btn btn-primary',
                                'onkeypress' => "inputMenuDiet();return $(this).focusNextInputField(event)",
                                'rel' => "tooltip",
                                'title' => "Klik untuk menambahkan Menu Diet",));
                            ?>
                        
                    </div>
                </td>
            </tr>
        </table>
        <style>
            .table thead tr th{
                vertical-align:middle;
            }
        </style>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel Pemesanan <b>Menu Diet Pasien</b></h6>
        <table class="table table-striped table-condensed" id="tableMenuDiet">
            <thead>
                <tr>
                    <th rowspan="2"><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList',this);hitungSemua();"></th>
                    <th rowspan="2">Instalasi/<br/>Ruangan</th>
                    <th rowspan="2">No. Pendaftaran/<br/>No. Rekam Medik</th>
                    <th rowspan="2">Nama Pasien</th>
                    <th rowspan="2">Umur</th>
                    <th rowspan="2">Jenis Kelamin</th>
                    <th colspan="<?php echo count($modJenisWaktu); ?>"><center>Menu Diet</center></th>
                    <th rowspan="2">Jumlah</th>
                    <th rowspan="2">Satuan/URT</th>
                </tr>
                <tr>      
                    <?php foreach($modJenisWaktu as $row){
                    echo '<th>'.$row->jeniswaktu_nama.'</th>';
                     } ?>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="form-actions">
        <?php
        if (isset($_GET['id'])){
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary disabled', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)'));
        }else{
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        }
             
        ?>
        <?php 
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/PesanmenudietT/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));   
        ?>
		<?php  $content = $this->renderPartial('gizi.views.tips.transaksi',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view.'_dialog', array('model'=>$model)); ?>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Daftar Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 700,
        'resizable' => false,
    ),
));

//$modKunjungan = new GZInfokunjunganriV('searchDialog');
$modKunjungan = new GZInfopasienmasukkamarV('searchRI');
$modKunjungan->unsetAttributes();
if (isset($_GET['GZInfopasienmasukkamarV'])){
    $modKunjungan->attributes = $_GET['GZInfopasienmasukkamarV'];       
   // if (isset($_GET['GZInfokunjunganriV']['kamarruangan_nokamar'])){
      //  $modKunjungan->kamarruangan_nokamar = $_GET['GZInfokunjunganriV']['kamarruangan_nokamar'];
   // } 
   // if (isset($_GET['GZInfokunjunganriV']['kamarruangan_nobed'])){
   //     $modKunjungan->kamarruangan_nobed = $_GET['GZInfokunjunganriV']['kamarruangan_nobed'];
  //  } 
     
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id'=>'gzinfokunjunganri-v-grid', 
    'dataProvider' => $modKunjungan->searchRI(),
    'filter' => $modKunjungan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectPasien",
				"onClick" => "
					$(\"#pasien_id\").val($data->pasien_id);
					$(\"#pendaftaran_id\").val($data->pendaftaran_id);
					$(\"#pasienadmisi_id\").val($data->pasienadmisi_id);
					$(\"#kelaspelayanan_id\").val($data->kelaspelayanan_id);
					$(\"#penjamin_id\").val($data->penjamin_id);
					$(\'#namaPasien\').val(\'$data->nama_pasien\');
					$(\"#dialogPasien\").dialog(\"close\");
//                                dialogMenuPasien($data->pendaftaran_id);
					refreshDialogMenuDiet();
				"))',
            'filter'=>CHtml::activeHiddenField($modKunjungan, 'kelaspelayanan_id'),
        ),
        'no_pendaftaran',
        'no_rekam_medik',
        'nama_pasien',
        'umur',
        array(
            'name'=>'jeniskelamin',
            'filter'=> CHtml::dropDownList('GZInfopasienmasukkamarV[jeniskelamin]',$modKunjungan->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
            'value'=>'$data->jeniskelamin'
        ),
        array(
            'name'=>'carabayar_id',
            'value'=>'$data->carabayar_nama',
            'filter'=>  CHtml::activeDropDownList($modKunjungan, 'carabayar_id', CHtml::listData(
           CarabayarM::model()->findAllByAttributes(array(
               'carabayar_aktif'=>true
           )), 'carabayar_id', 'carabayar_nama'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'name'=>'penjamin_id',
            'value'=>'$data->penjamin_nama',
            'filter'=>false,
        ),
        array(
            'name'=>'ruangan_id',
            'filter'=> CHtml::dropDownList('GZInfopasienmasukkamarV[ruangan_id]',$modKunjungan->ruangan_id,CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'--Pilih--','disabled'=>TRUE)),            
            'value'=>'$data->ruangan_nama'
        ),
        'kamarruangan_nokamar',
        'kamarruangan_nobed',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
$instalasi_id = CHtml::activeId($model, 'instalasi_id');
$ruangan_id = CHtml::activeId($model, 'ruangan_id');
$totalPesan = CHtml::activeId($model, 'totalpesan_org');
$bahandiet_id = CHtml::activeId($model, 'bahandiet_id');
$jenisdiet_id = CHtml::activeId($model, 'jenisdiet_id');
$namaPemesan = CHtml::activeId($model, 'nama_pemesan');
$url = Yii::app()->createUrl('gizi/pesanmenudietT/getMenuDietDetail');
$jsx = <<< JS
    function inputMenuDiet(){
        var pasien_id = $('#pasien_id').val();
        var pendaftaran_id = $('#pendaftaran_id').val();
        var pasienadmisi_id = $('#pasienadmisi_id').val();
        var kelaspelayanan_id = $('#kelaspelayanan_id').val();
        var menudiet_id = $('#menudiet_id').val();
        var jumlah = $('#jumlah').val();
        var jeniswaktu = new Array();
        var pendaftaranId = new Array();
        var pasienAdmisi = new Array();
        var urt = $('#URT').val();
        var ruangan_id = $('#${ruangan_id}').val();
        var instalasi_id = $('#${instalasi_id}').val();
        i = 0;
        $('.jeniswaktu').each(function(){
            value = $(this).val();
            if ($(this).is(':checked')){
                jeniswaktu[i]=value;
                i++;
            }
        });
        i = 0;
        $('.pendaftaranId').each(function(){
            value = $(this).val();
            valueAdmisi = $(this).attr('admisi');
            if ($(this).is(':checked')){
                pasienAdmisi[i]=valueAdmisi;
                pendaftaranId[i]=value;
                i++;
            }
            
        });
        
        if (!jQuery.isNumeric(ruangan_id)){
            myAlert('Pilih Ruangan !');
            return false;
        }
        else if ((!jQuery.isNumeric(pendaftaran_id))&&(pendaftaranId.length < 1)){
            myAlert('Isi Nama Pasien !');
            return false;
        }
        else if (!jQuery.isNumeric(menudiet_id)){
            myAlert('Isi Makanan Diet yang dipilih !');
            return false;
        }
        else if (jeniswaktu.length < 1){
            myAlert('Isi Jenis Waktu yang dipilih !');
            return false;
        }
        else{
            $.post('${url}', {pasien_id:pasien_id, pasienAdmisi:pasienAdmisi, pasienadmisi_id:pasienadmisi_id, pendaftaranId:pendaftaranId, jeniswaktu:jeniswaktu, pendaftaran_id:pendaftaran_id, menudiet_id:menudiet_id, jumlah:jumlah, urt:urt, ruangan_id:ruangan_id, instalasi_id:instalasi_id, kelaspelayanan_id:kelaspelayanan_id}, function(data){
                $('#tableMenuDiet tbody').append(data);
                $("#tableMenuDiet tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                hitungSemua();
            }, 'json');
        }
        clearAll(1);
    }
            
    function hitungSemua(){
        noUrut = 1;
        jumlah = 0;
        $('.cekList').each(function(){
            $(this).parents('tr').find('[name*="PesanmenudetailT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('PesanmenudetailT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','PesanmenudetailT['+(noUrut-1)+']'+data[1]);
                }
            });
            noUrut++;
            if($(this).is(':checked')){
                jumlah++;
            }
        });
        $('#${totalPesan}').val(jumlah);
    }
    
    function clearAll(code){
        var tempRuangan = $('#${ruangan_id}').val();
        var tempInstalasi = $('#${instalasi_id}').val();
        $('#fieldsetMenuDiet div').find('input,select').each(function(){
            if ($(this).attr('type') == 'checkbox'){
                
            }
            else{
                $(this).val('');
            }
        });
        if (!jQuery.isNumeric(code)){
            $('#fieldsetMenuDiet #tableMenuDiet tbody').find('tr').each(function(){
                $(this).remove();
            });
        }
        if(jQuery.isNumeric(tempRuangan)){
            $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
                   //data: "GZInfokunjunganriV[ruangan_id]="+tempRuangan
                   data: "GZInfopasienmasukkamarV[ruangan_id]="+tempRuangan 
        
            });
        }
        $('#jumlah').val(1);
        $('#${ruangan_id}').val(tempRuangan);
        $('#${instalasi_id}').val(tempInstalasi);
    }
    
    function dialogMenuPasien(){
        ruangan = $('#${ruangan_id}').val();
        if(!jQuery.isNumeric(ruangan)){
            $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
                    //data: $("#dialogPasien :input").serialize() + "&" + "GZInfokunjunganriV[ruangan_id]=0"
                    data: $("#dialogPasien :input").serialize() + "&" + "GZInfopasienmasukkamarV[ruangan_id]=0"
            });
        }
        else{
            $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
                    //data: $("#dialogPasien :input").serialize() + "&" + "GZInfokunjunganriV[ruangan_id]="+ruangan
                    data: $("#dialogPasien :input").serialize() + "&" + "GZInfopasienmasukkamarV[ruangan_id]="+ruangan
            });
        }
        if(!jQuery.isNumeric(ruangan)){
            myAlert('Isi ruangan terlebih dahulu');
            return false;
        }else{
            $('#dialogPasien').dialog('open');
        }
    }
JS;
Yii::app()->clientScript->registerScript('head', $jsx, CClientScript::POS_HEAD);
?>

<?php Yii::app()->clientScript->registerScript('submit', '
    $.fn.yiiGridView.update("gzinfokunjunganri-v-grid", {
		//data: "GZInfokunjunganriV[ruangan_id]=0"
                data: "GZInfopasienmasukkamarV[ruangan_id]=0"                
	});
    $("form").submit(function(){
        var jenisdiet_id =$("#'.$jenisdiet_id.'").val();
        jumlah = 0;
        $(".cekList").each(function(){
            if ($(this).is(":checked")){
                jumlah++;
            }
        });
        
        
        if (!jQuery.isNumeric($("#'.$jenisdiet_id.'").val())){
            myAlert("'.CHtml::encode($model->getAttributeLabel('jenisdiet_id')).' harus diisi !");
            return false;
        }
        else if ($("#'.$namaPemesan.'").val() == ""){
            myAlert("'.CHtml::encode($model->getAttributeLabel('nama_pemesan')).' harus diisi !");
            return false;
        }
        else if (jumlah < 1){
            myAlert("Pilih Menu Diet Pasien yang akan dipesan !");
            return false;
        }
        
    });
    
', CClientScript::POS_READY); ?>

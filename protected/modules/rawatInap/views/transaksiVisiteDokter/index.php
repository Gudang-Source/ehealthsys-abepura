<div class="white-container">
    <legend class="rim2">Transaksi <b>Visite Dokter</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php 
    Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#daftarPasien-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    "); ?>
	<?php 
	if(isset($_GET['sukses'])){
		Yii::app()->user->setFlash('success', "Data Visite Dokter berhasil disimpan !");
	}
	?>	
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>    
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pasienVisite-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#namaDokter',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    )); 
	?>
    <!-- <legend class="rim">Berdasarkan tanggal</legend> -->
    <div class="row-fluid">
        <div class="search-form">
            <table width="100%">
                <tr>
                    <td>
                        <div class="control-group">
                            <div class="control-label">
                                    <?php echo CHtml::label('Tanggal Visite <span class="required"> *</span>','Tanggal Visite *', array()); ?>
                            </div>
                            <div class="controls">
                                    <?php   
                                            $this->widget('MyDateTimePicker',array(
                                                            'name'=>'tanggalVisite',
                                                            'value'=>Yii::app()->dateFormatter->formatDateTime(
                                                                    CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd hh:mm:ss')),
                                                            'mode'=>'datetime',
                                                            'options'=> array(
                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                                    'maxDate' => 'd',

                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,
                                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                    'class'=>'isRequired'
                                                                    ),
                                            ));
                                    ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                    <?php echo CHtml::label('Jenis Visite','Jenis Visite', array()); ?>
                            </div>
                            <div class="controls">
                                <?php 
                                echo CHtml::dropDownList('jenisVisite', null, CHtml::listdata(RIDaftarTindakanM::model()->findAll('daftartindakan_visite=TRUE ORDER BY daftartindakan_nama ASC'),"daftartindakan_nama","daftartindakan_nama"), array(
                                        'empty'=>'-- Pilih --'
                                        ));
                                ?>
                                    <?php /* $this->widget('MyJuiAutoComplete',array(
                            'name'=>'jenisVisite',    
                            'value'=>'',
                            'sourceUrl'=> $this->createUrl('GetDaftarTindakanVisite'),
                            'options'=>array(
                               'showAnim'=>'fold',
                               'minLength' => 2,
                               'focus'=> 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);

                                    return false;
                                }',
                                'select'=>'js:function( event, ui ) {
                                 samakanVisite(ui.item.daftartindakan_id);
                                          }'

                            ),
                            'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                            )); */ ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        
                        <div class="control-group">
                            <div class="control-label">
                                    <?php echo CHtml::label('Dokter Visite <span class="required"> *</span>','Nama Dokter', array()); ?>
                            </div>
                            <div class="controls">
                                <?php $this->widget('MyJuiAutoComplete',array(
                                'name'=>'namaDokter',    
                                'value'=>'',
                                'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/GetDokterJenisKelamin'),
                                'options'=>array(
                                   'showAnim'=>'fold',
                                   'minLength' => 2,
                                   'focus'=> 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        $("#'.CHtml::activeId($model,'nama_pegawai').'").val( ui.item.nama_pegawai);
                                        $("#'.CHtml::activeId($model,'pegawai_id').'").val( ui.item.pegawai_id);

                                        return false;
                                    }',
                                    'select'=>'js:function( event, ui ) {
                                     samakanDokter(ui.item.pegawai_id);

                                              }'

                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogDokter'),
                                'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                                )); ?>
                                <?php echo CHtml::activeHiddenField($model,'nama_pegawai',array('class'=>'span4')); ?>
                                <?php echo CHtml::activeHiddenField($model,'pegawai_id',array('class'=>'span4')); ?>
                            </div>
                        </div>
                        <div class="control-group" style="padding-left: 124px;">
                            <label class='controls'>
                                <?php echo CHtml::activeCheckBox($model,'is_dokter',array('style'=>'width : 10px', 'onkeyup' => "return $(this).focusNextInputField(event)"))?>                
                                Dokter Penanggung Jawab
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="control-group">
                            <div class="control-label">No. Rekam Medik</div>
                            <div class="controls">				
                                    <?php echo CHtml::activeTextField($model,'no_rekam_medik',array('class'=>'span4','placeholder'=>'Ketikan No. Rekam Medik')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">Nama Pasien</div>
                            <div class="controls">
                                    <?php echo CHtml::activeTextField($model,'nama_pasien',array('class'=>'span4','placeholder'=>'Ketikan Nama Pasien')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Tampilkan', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button','onclick'=>'searchVisite();')); ?>
	</div>
    </div>
	<?php
		//$this->renderPartial('_rowVisiteDokter',array('model'=>$model));
	?>
	<div class="block-tabel">
        <h6>Tabel <b>Visite Dokter</b></h6>
        <table class="items table table-striped table-condensed" id="table-visite">
            <thead>
                <tr>
                    <th>Tanggal Admisi/<br/>Masuk Kamar</th>
                    <th>Tgl. Pendaftaran/<br/>No. Pendaftaran</th>
                    <th>No. Rekam Medik</th>
                    <th>Nama Pasien / Alias</th>
                    <th>Jenis Kelamin</th>
                    <th>Cara Bayar / Penjamin</th>
                    <th>Kamar/</br>Kelas Pelayanan</th>
                    <th>Kasus Penyakit</th>
                    <th>Dokter Penanggung Jawab</th>
                    <th>Visite Dokter <span class="required"> *</span></th>
                    <th>Pilih</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>     
	
	<div class="form-actions">
        <div style="display: none;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan')); ?>
        </div>    
        <?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
		?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'validasi()','disabled'=>$disableSave)); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
        Yii::app()->createUrl($this->module->id.'/TransaksiVisiteDokter/index'), 
        array('class'=>'btn btn-danger',
        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
        <?php
        $content = $this->renderPartial('../tips/transaksi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</div>
<?php
$this->endWidget();
$urlCekTarifTindakan = Yii::app()->createUrl('rawatInap/TransaksiVisiteDokter/getTarifTindakan');
$js = <<< JS

   
function samakanDokter(idPegawai){   
$('.idDokter').each(function(){
        $(this).val(idPegawai);
    });   
}

function samakanVisite(idVisite){   
    $('.idVisite').each(function(){
        $(this).parents('tr').find('.ceklist').attr('checked',false);
        $(this).val(idVisite);
        
        
    });   
} 

    function dipilih(obj){
    
        if($(obj).is(':checked')){
            daftartindakan_id = $(obj).parents('tr').find("select[name*='[daftartindakan_id]']").val();
            kelaspelayanan_id = $(obj).parents('tr').find("input[name*='[kelaspelayanan_id]']").val();
            
            if(daftartindakan_id != '' && kelaspelayanan_id != ''){
                $.post("${urlCekTarifTindakan}", { daftartindakan_id: daftartindakan_id, kelaspelayanan_id: kelaspelayanan_id },
                    function(data){
                        if(data.status == 'Ada')
                        {
                           $(obj).parent().find('input').val('Ya');
                        }
                        else
                        {
                            myAlert('Maaf, Daftar Tindakan tidak memiliki tarif');
                            $(obj).parent().find('.ceklist').attr('checked',false);
                        }
                }, "json");
            }else{
                myAlert('Pilih terlebih dahulu jenis Visite Dokter');
                $(obj).parent().find('.ceklist').attr('checked',false);
            }
        }else{
            $(obj).parent().find('input').val('Tidak');
        }
    }
    function validasi()
    {
        jumlahCeklist=0;
        validasiDokter='Ya';
        validasiVisite='Ya';
        
        $('.isRequired').each(function(){

            if($(this).val()==''){
                myAlert('Harap Isi Semua Yang Bertanda *')
                $(this).focus();
            }

        }); 
        
          $('.ceklist').each(function(){
            
            if($(this).is(':checked'))
               {
                  jumlahCeklist = jumlahCeklist +1;  
                  
                  if($(this).parent().prev().find('select').val()==''){
                        $(this).parent().prev().find('select').focus();
                                                validasiVisite='Tidak';

                    }
                  
                   if($(this).parent().prev().prev().find('select').val()==''){
                        $(this).parent().prev().prev().find('select').focus();
                        validasiDokter='Tidak';
                  }

               } 
          });
          
      if(jumlahCeklist==0){
        myAlert('Anda Belum Memilih Pasien');
      }else if(validasiDokter=='Tidak'){
        myAlert('Harap Isi Semua Data Dokter Yang Diperlukan');
      }else if (validasiVisite=='Tidak'){
        myAlert('Harap Isi Semua Data Visite Yang Diperlukan');
      }else{
        //$('#btn_simpan').click();
		$('#pasienVisite-form').submit();		
//        myAlert('simpan');
      }    
         
    }
JS;
Yii::app()->clientScript->registerScript('sasfsddfsgfhgdfgsgsdg',$js,CClientScript::POS_HEAD);
?>

<?php $this->renderPartial('_jsFunctions', array('model'=>$model)); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Pencarian Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modDokter = new DokterV('search');
$modDokter->unsetAttributes();
$modDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modDokter->pegawai_aktif = TRUE;
if(isset($_GET['DokterV'])){
    $modDokter->attributes = $_GET['DokterV'];
    $modDOkter->pegawai_aktif = TRUE;
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengajukan-m-grid',
    'dataProvider'=>$modDokter->search(),
    'filter'=>$modDokter,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"samakanDokter($data->pegawai_id);
                            $(\"#namaDokter\").val(\"$data->namaLengkap\");
                            $(\"#'.CHtml::activeId($model,'nama_pegawai').'\").val(\"$data->namaLengkap\");
                            $(\"#'.CHtml::activeId($model,'pegawai_id').'\").val(\"$data->pegawai_id\");
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),
        
        //'gelardepan',
         array(
            'name'=>'nama_pegawai',
            'header'=>'Nama Dokter',
            'value'=>'$data->namaLengkap',
         ),
        //'gelarbelakang_nama',
        'jeniskelamin',
        'notelp_pegawai',
        'nomobile_pegawai',
        array(
            'name'=>'nomorindukpegawai',
            'header'=>'NIK',
         ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>

<script>
//function pencarianForm(){
//	$.fn.yiiGridView.update('daftarPasien-grid', {
//        data: $('.search-form input').serialize()
//    });
//}
//function setDokter(obj){
//	var nama_pegawai = $('#<?php echo CHtml::activeId($model,'nama_pegawai'); ?>').val();
//	var pilih = $('#<?php echo CHtml::activeId($model,'is_dokter'); ?>');
//	if($(obj).is(':checked')){
//		if(nama_pegawai == ''){
//			myAlert('Pilih Dokter terlebih dahulu !');
//			$(obj).attr('checked', false);
//			pilih.val(0);
//		}
//		pilih.val(1);
//	}else{
//		pilih.val(0);
//	}
//	
//}
</script>
<legend class="rim2">Transaksi Pembebasan <b>Tarif Pasien</b></legend>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<fieldset>
    <table width="100%" class="table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RJPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('readonly'=>true)); ?></td>
            
            <td>
            <label  style="padding-left:40px;">No. Rekam Medik  <font class="no_rek">*</font></label>
            </td>
            <td>
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'RJPasienM[no_rekam_medik]',
                                    'value'=>$modPasien->no_rekam_medik,
                                    'source'=>'js: function(request, response) {
                                       $.ajax({
                                           url: "'.Yii::app()->createUrl('rawatJalan/PembebasanTarif/daftarPasienTindakanRuangan').'",
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
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {                                                
                                                isiDataPasien_fungsi(ui.item.value, ui.item.pendaftaran_id)
                                                return false;
                                            }',
                                    ),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 required'),
                                    'tombolDialog'=>array('idDialog'=>'dialogRekamedik','idTombol'=>'tombolDialogRekamedik'),
                                )); 
                ?>
            </td>
            <td rowspan="5">
                <?php 
                    if(!empty($modPasien->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasien->photopasien, 'photo pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'photo pasien', array('width'=>120));
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RJPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RJPasienM[jeniskelamin]', $modPasien->jeniskelamin, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RJPendaftaranT[umur]', $modPendaftaran->umur, array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RJPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RJPendaftaranT[jeniskasuspenyakit_nama]',isset($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama) ? $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama : '', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RJPasienM[nama_bin]', $modPasien->nama_bin, array('readonly'=>true)); ?></td>
        </tr>
    
                <?php echo CHtml::hiddenField('RJPendaftaranT[pendaftaran_id]',$modPendaftaran->pendaftaran_id, array('readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('RJPendaftaranT[pasien_id]',$modPendaftaran->pasien_id, array('readonly'=>true)); ?>
          
        </tr>
    </table>
</fieldset> 

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogRekamedik',
    'options'=>array(
        'title'=>'No. Rekamedik',
        'autoOpen'=>false,
        'resizable'=>false,
        'width'=>870,
 
        'modal'=>true,
    ),
));

$criteria = new CDbCriteria();
// $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
$criteria->order = 'tgl_pendaftaran DESC';
$models = RJInfokunjunganrjV::model()->findAll($criteria);
$dataProvider = new CActiveDataProvider('InfokunjunganrjV',array(
    'criteria'=>$criteria,
));

$modDataPasien = new RJInfokunjunganrjV('searchPasienPembebasanTarif');

$modDataPasien->statusperiksa = "SEDANG PERIKSA";
//$modDataPasien->tgl_pendaftaran = date('Y-m-d');
//$modDataPasien->unsetAttributes();
if(isset($_GET['RJInfokunjunganrjV'])){
    $modDataPasien->attributes = $_GET['RJInfokunjunganrjV'];
    $format = new MyFormatter();    
    $modDataPasien->tgl_pendaftaran  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_pendaftaran']);
    $modDataPasien->statusperiksa  = $_REQUEST['RJInfokunjunganrjV']['statusperiksa'];
    // $modDataPasien->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
    // $modDataPasien->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rjrekamedik-alkes-m-grid',
    'dataProvider'=>$modDataPasien->searchPasienPembebasanTarif(),
    'filter'=>$modDataPasien,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPasien",
                                    "onClick" => "
                                        isiDataPasien_fungsi(\"$data->no_rekam_medik\", \"$data->pendaftaran_id\");
                                        $(\"#dialogRekamedik\").dialog(\"close\");
                                        return false;
                                    "))',
            ),

            'no_rekam_medik',     
            //'ruangan_id',
                //'tgl_pendaftaran',
                array(
                    'name'=>'tgl_pendaftaran',
                    'value'=>'$data->tgl_pendaftaran',
                    'filter'=>$this->widget('MyDateTimePicker',array(
                    'model'=>$modDataPasien,
                    'attribute'=>'tgl_pendaftaran',
                    'mode'=>'date',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT
                    ),
                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3'),
                    ),true
                    ),
                    'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
                ),
                 'no_pendaftaran',
                 'nama_pasien', 
                 'alamat_pasien',
                 //'penjamin_nama',
                 array(
                   'name' => 'penjamin_nama',
                   'header' => 'Nama Penjamin',
                   'value' => '$data->penjamin_nama',
                   'filter'   => CHtml::dropDownList('RJInfokunjunganrjV[penjamin_nama]',$modDataPasien->penjamin_nama,CHtml::listData(PenjaminpasienM::model()->findAll("penjamin_aktif = TRUE ORDER BY penjamin_nama ASC"), 'penjamin_nama', 'penjamin_nama'),array('empty'=>'--Pilih--'))
                 ),
                 'nama_pegawai',
                 'jeniskasuspenyakit_nama',

                array(
                    'name'=>'statusperiksa',
                    'type'=>'raw',
                    'value'=>'$data->statusperiksa',
                    //'filter' => false,
                    // 'filter' => CHtml::listData(RJInfokunjunganrjV::model()->findAll(),'statusperiksa', 'statusperiksa'),
                    // 'filter' =>CHtml::activeDropDownList($modDataPasien,'statusperiksa',
                    //     LookupM::getItems('statusperiksa'),array('options' => array('SEDANG PERIKSA'=>array('selected'=>true)))),
                ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});

            jQuery(\'#RJInfokunjunganrjV_tgl_pendaftaran\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'id\'], {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
        }',
));

$this->endWidget('ext.bootstrap.widgets.BootGridView');
?>

<script type="text/javascript">
function isiDataPasien(data)
{
    $('#RJPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
    $('#RJPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
    $('#RJPendaftaranT_umur').val(data.umur);
    $('#RJPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit_nama);
    $('#RJPendaftaranT_instalasi_nama').val(data.instalasi_nama);
    $('#RJPendaftaranT_ruangan_nama').val(data.ruangan_nama);
    $('#RJPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
    $('#RJPendaftaranT_pasien_id').val(data.pasien_id);
    
    $('#RJPasienM_jeniskelamin').val(data.jeniskelamin);
    $('#RJPasienM_nama_pasien').val(data.nama_pasien);
    $('#RJPasienM_nama_bin').val(data.nama_bin);
    
    $.post('<?php echo Yii::app()->createUrl('rawatJalan/PembebasanTarif/loadTindakanKomponenPasien');?>', {pendaftaran_id:data.pendaftaran_id}, function(data){
        //$('#tblTindakanPasien tbody').html(data.formTindakanKomponen);
        $('#divTarifPasien').html(data.tabelPembebasanTarif);        
        $("#tblTindakanPasien .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
        $("#tblTindakanPasien .integer").each(function(){this.value = formatNumber(this.value)});
    }, 'json');
    
}

function isiDataPasien_fungsi(params, pendaftaran_id)
{
    $.post("<?php echo Yii::app()->createUrl('rawatJalan/PembebasanTarif/loadDataPasien');?>", {no_rekam_medik:params },
        function(data){
            $('#RJPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
            $('#RJPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
            $('#RJPendaftaranT_umur').val(data.umur);
            $('#RJPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit_nama);
            $('#RJPendaftaranT_instalasi_nama').val(data.instalasi_nama);
            $('#RJPendaftaranT_ruangan_nama').val(data.ruangan_nama);
            $('#RJPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
            $('#RJPendaftaranT_pasien_id').val(data.pasien_id);
            
            $('#RJPasienM_jeniskelamin').val(data.jeniskelamin);
            $('#RJPasienM_nama_pasien').val(data.nama_pasien);
            $('#RJPasienM_nama_bin').val(data.nama_bin);             
            $('#RJPasienM_no_rekam_medik').val(params);
        }, "json");

    $.post('<?php echo Yii::app()->createUrl('rawatJalan/PembebasanTarif/loadTindakanKomponenPasien');?>', {pendaftaran_id:pendaftaran_id}, function(data){
        $('#divTarifPasien').html(data.tabelPembebasanTarif);        
        $("#tblTindakanPasien .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
        $("#tblTindakanPasien .integer").each(function(){this.value = formatNumber(this.value)});
    }, 'json');
}

function setDataPasien(){
	var no_rekam_medik = $('#RJPasienM_no_rekam_medik').val();
	var pendaftaran_id = $('#RJPendaftaranT_pendaftaran_id').val();
	var pegawai_id = $('#RJPembebasantarifT_pegawai_id').val();
	
	if(no_rekam_medik != '' || pendaftaran_id != ''){
		$.post('<?php echo Yii::app()->createUrl('rawatJalan/PembebasanTarif/loadTindakanKomponenPasien');?>', {pendaftaran_id:pendaftaran_id, pegawai_id:pegawai_id}, function(data){
			$('#divTarifPasien').html(data.tabelPembebasanTarif);        
			$("#tblTindakanPasien .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
			$("#tblTindakanPasien .integer").each(function(){this.value = formatNumber(this.value)});
		}, 'json');
	}else{
		myAlert('Pilih pasien terlebih dahulu !');
		$('#RJPembebasantarifT_pegawai_nama').val('');
		$('#RJPembebasantarifT_pegawai_id').val('');
	}
}

</script>
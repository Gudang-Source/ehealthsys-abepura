<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<fieldset>
    <legend class="rim2">Transaksi Pembebasan Tarif Pasien </legend>
    <table class="table table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RIPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('readonly'=>true)); ?></td>
            
            <td>
            <label class="no_rek" style="padding-left:40px;">No. Rekam Medik</label>
            </td>
            <td>
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'RIPasienM[no_rekam_medik]',
                                    'value'=>$modPasien->no_rekam_medik,
                                    'source'=>'js: function(request, response) {
                                       $.ajax({
                                           url: "'.Yii::app()->createUrl('rawatInap/ActionAutoComplete/daftarPasienTindakanRuangan').'",
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
                                                isiDataPasien(ui.item);
                                                return false;
                                            }',
                                    ),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'),
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
            <td><?php echo CHtml::textField('RIPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RIPasienM[jeniskelamin]', $modPasien->jeniskelamin, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RIPendaftaranT[umur]', $modPendaftaran->umur, array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RIPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RIPendaftaranT[jeniskasuspenyakit_nama]',empty($modPendaftaran->jeniskasuspenyakit_id)?null:$modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama, array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RIPasienM[nama_bin]', $modPasien->nama_bin, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'instalasi_id',array('class'=>'control-label')); ?></td>
            <td>
                <?php echo CHtml::textField('RIPendaftaranT[instalasi_nama]',empty($modPendaftaran->instalasi_id)?null:$modPendaftaran->instalasi->instalasi_nama, array('readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('RIPendaftaranT[pendaftaran_id]',$modPendaftaran->pendaftaran_id, array('readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('RIPendaftaranT[pasien_id]',$modPendaftaran->pasien_id, array('readonly'=>true)); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('RIPendaftaranT[ruangan_nama]', empty($modPendaftaran->ruangan_id)?null:$modPendaftaran->ruangan->ruangan_nama, array('readonly'=>true)); ?></td>
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
        'width'=>600,
        'height'=>420,
        'modal'=>true,
    ),
));

$criteria = new CDbCriteria();
if (isset($_GET['term'])) {
    $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
}
$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
$criteria->order = 'tgl_pendaftaran DESC';
$models = RIInfokunjunganriV::model()->findAll($criteria);
$dataProvider = new CActiveDataProvider('InfokunjunganriV',array(
    'criteria'=>$criteria,
));

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rirekamedik-alkes-m-grid',
    'dataProvider'=>$dataProvider,
    //'filter'=>$moObatAlkes,
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

            array(
                'header'=>'No. Rekamedik',
                'value'=>'$data->no_rekam_medik',
            ),
            array(
                'header'=>'Nama Pasien',
                'value'=>'$data->nama_pasien',
            ),
            array(
                'header'=>'Tgl. Pendaftaran',
                'value'=>'$data->tgl_pendaftaran',
            ),
            array(
                'header'=>'No. Pendaftaran',
                'value'=>'$data->pendaftaran_id',
            ),
    )
));

$this->endWidget('ext.bootstrap.widgets.BootGridView');
?>

<script type="text/javascript">
function isiDataPasien(data)
{
    $('#RIPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
    $('#RIPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
    $('#RIPendaftaranT_umur').val(data.umur);
    $('#RIPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit_nama);
    $('#RIPendaftaranT_instalasi_nama').val(data.instalasi_nama);
    $('#RIPendaftaranT_ruangan_nama').val(data.ruangan_nama);
    $('#RIPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
    $('#RIPendaftaranT_pasien_id').val(data.pasien_id);
    
    $('#RIPasienM_jeniskelamin').val(data.jeniskelamin);
    $('#RIPasienM_nama_pasien').val(data.nama_pasien);
    $('#RIPasienM_nama_bin').val(data.nama_bin);
    
    $.post('<?php echo Yii::app()->createUrl('rawatInap/ActionAjax/loadTindakanKomponenPasien');?>', {pendaftaran_id:data.pendaftaran_id}, function(data){
        //$('#tblTindakanPasien tbody').html(data.formTindakanKomponen);
        $('#divTarifPasien').html(data.tabelPembebasanTarif);        
        $("#tblTindakanPasien .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
        $("#tblTindakanPasien .integer").each(function(){this.value = formatNumber(this.value)});
    }, 'json');
    
}

function isiDataPasien_fungsi(params, pendaftaran_id)
{
    $.post("<?php echo Yii::app()->createUrl('rawatInap/ActionAjax/loadDataPasien');?>", {no_rekam_medik:params },
        function(data){
            $('#RIPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
            $('#RIPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
            $('#RIPendaftaranT_umur').val(data.umur);
            $('#RIPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit_nama);
            $('#RIPendaftaranT_instalasi_nama').val(data.instalasi_nama);
            $('#RIPendaftaranT_ruangan_nama').val(data.ruangan_nama);
            $('#RIPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
            $('#RIPendaftaranT_pasien_id').val(data.pasien_id);
            
            $('#RIPasienM_jeniskelamin').val(data.jeniskelamin);
            $('#RIPasienM_nama_pasien').val(data.nama_pasien);
            $('#RIPasienM_nama_bin').val(data.nama_bin);             
            $('#RIPasienM_no_rekam_medik').val(params);
        }, "json");

    $.post('<?php echo Yii::app()->createUrl('rawatInap/ActionAjax/loadTindakanKomponenPasien');?>', {pendaftaran_id:pendaftaran_id}, function(data){
        $('#divTarifPasien').html(data.tabelPembebasanTarif);        
        $("#tblTindakanPasien .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
        $("#tblTindakanPasien .integer").each(function(){this.value = formatNumber(this.value)});
    }, 'json');
}

</script>
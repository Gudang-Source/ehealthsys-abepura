<?php $this->widget('bootstrap.widgets.BootAlert'); ?> 

<fieldset class="box">
    <legend class="rim">Identitas Pasien</legend>
    <table class="table table-condensed">
        <tr>
            <td>
				<?php //echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?>
				<label class="control-label no_rek" >No. Pendaftaran</label>
            </td>
            <td>
				<?php //echo CHtml::textField('ASPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true)); ?>
				<?php
				if (!empty($modPendaftaran->no_pendaftaran)) {
					echo CHtml::textField('ASPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly' => true));
				} else {
					echo CHtml::hiddenField('ASPendaftaranT[pendaftaran_id]', $modPendaftaran->pendaftaran_id, array('readonly' => true));
					echo CHtml::hiddenField('ASPendaftaranT[pasien_id]', $modPendaftaran->pasien_id, array('readonly' => true));
					$this->widget('MyJuiAutoComplete', array(
						'name' => 'ASPendaftaranT[no_pendaftaran]',
						'value' => $modPendaftaran->no_pendaftaran,
						'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('Autocompletenopendaftaran') . '",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           instalasiId: $("#ASPendaftaranT_instalasi_id").val(),
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
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
							'select' => 'js:function( event, ui ) {
											cekPendaftaran(ui.item.pendaftaran_id);
                                            return false;
                                            }',
						),
						'tombolDialog' => array('idDialog' => 'dialogPasien', 'idTombol' => 'tombolPasienDialog'),
						'htmlOptions' => array('class' => 'span2',
							'placeholder' => 'Ketik No. Pendaftaran', 'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
				}
				?>
            </td>
			<td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPasienM[jeniskelamin]', $modPasien->jeniskelamin, array('readonly' => true)); ?></td>  
			<td><?php echo CHtml::activeLabel($modPasien, 'agama', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPasienM[agama]', $modPasien->jeniskelamin, array('readonly' => true)); ?></td>  
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('readonly' => true)); ?></td>

			<td><?php echo CHtml::activeLabel($modPasien, 'pekerjaan_nama', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPasienM[pekerjaan_nama]', $modPasien->pekerjaan_nama, array('readonly' => true)); ?></td>

			<td><?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPendaftaranT[ruangan_nama]', isset($modPendaftaran->ruangan->ruangan_nama) ? $modPendaftaran->ruangan->ruangan_nama : '-', array('readonly' => true)); ?></td>
        </tr>
        <tr>
			<td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label ')); ?></td>
            <td><?php
				//echo CHtml::textField('ASPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly'=>true)); 
                    if (!empty($modPasien->no_rekam_medik)) {                        
                        echo CHtml::textField('ASPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly' => true));
                    }else{
                                
				$this->widget('MyJuiAutoComplete', array(
					'name' => 'ASPasienM[no_rekam_medik]',
					'value' => $modPasien->no_rekam_medik,
					'source' => 'js: function(request, response) {
                                                          $.ajax({
                                                              url: "' . $this->createUrl('Autocompletenorekammedik') . '",
                                                              dataType: "json",
                                                              data: {
                                                                  daftarpasien:true,
                                                                  term: request.term,
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
                                                       $(this).val(ui.item.value);
                                                       return false;
                                                   }',
						'select' => 'js:function( event, ui ) {
                                                      cekPendaftaran(ui.item.pendaftaran_id);
                                                       return false;
                                                   }',
					),
				));
                    }
				?></td>

			<td><?php echo CHtml::activeLabel($modPasien, 'pendidikan_nama', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPasienM[pendidikan_nama]', isset($modPasien->pendidikan->pendidikan_nama) ? $modPasien->pendidikan->pendidikan_nama : '-', array('readonly' => true)); ?></td>

            <td><?php echo CHtml::label('Kelas Pelayanan', 'kelaspelayanan_nama', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPendaftaranT[kelaspelayanan_nama]', isset($modPendaftaran->kelaspelayanan->kelaspelayanan_nama) ? $modPendaftaran->kelaspelayanan->kelaspelayanan_nama : '-', array('readonly' => true)); ?></td>

        </tr>
        <tr>
			<td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label ')); ?></td>
            <td><?php
				//echo CHtml::textField('ASPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly'=>true)); 
                        if (!empty($modPasien->no_rekam_medik)) {                        
                            echo CHtml::textField('ASPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly' => true));
                        }else{
				$this->widget('MyJuiAutoComplete', array(
					'name' => 'ASPasienM[nama_pasien]',
					'value' => $modPasien->nama_pasien,
					'source' => 'js: function(request, response) {
                                                          $.ajax({
                                                              url: "' . $this->createUrl('Autocompletenamapasien') . '",
                                                              dataType: "json",
                                                              data: {
                                                                  daftarpasien:true,
                                                                  term: request.term,
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
                                                       $(this).val(ui.item.value);
                                                       return false;
                                                   }',
						'select' => 'js:function( event, ui ) {
                                                       cekPendaftaran(ui.item.pendaftaran_id);
                                                       return false;
                                                   }',
					),
				));
                        }
				?></td>

            <td><?php echo CHtml::activeLabel($modPasien, 'alamat_pasien', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textArea('ASPasienM[alamat_pasien]', isset($modPasien->alamat_pasien) ? $modPasien->alamat_pasien : '-', array('readonly' => true)); ?></td>

			<td><?php echo CHtml::label('No Kamar / No Bed', 'no_kamarbed', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPendaftaranT[no_kamarbed]', isset($modPendaftaran->kamarruangan_nokamar) ? $modPendaftaran->kamarruangan_nokamar : '' . '/' . isset($modPendaftaran->kamarruangan_nobed) ? $modPendaftaran->kamarruangan_nobed : '', array('readonly' => true)); ?></td>


        </tr>
        <tr>
			<td><?php echo CHtml::activeLabel($modPasien, 'umur', array('class' => 'control-label')); ?></td>
			<td><?php echo CHtml::textField('ASPendaftaranT[umur]', isset($modPasien->umur) ? $modPasien->umur : '-', array('readonly' => true)); ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>

            <td><?php echo CHtml::activeLabel($modPasien, 'statusperkawinan', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPendaftaranT[statusperkawinan]', isset($modPendaftaran->statusperkawinan) ? $modPendaftaran->statusperkawinan : '-', array('readonly' => true)); ?></td>
        </tr>
    </table>
</fieldset> 
<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogPasien',
	'options' => array(
		'title' => 'Pencarian Data Kunjungan Pasien',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 540,
		'resizable' => false,
	),
));
$modDialogPasien = new ASPasienM('searchPasienRumahsakitV');
$modDialogPasien->unsetAttributes();
if (isset($_GET['ASPasienM'])) {
	$modDialogPasien->attributes = $_GET['ASPasienM'];
	$modDialogPasien->idInstalasi = isset($_GET['ASPasienM']['idInstalasi']) ? $_GET['ASPasienM']['idInstalasi'] : '';
	$modDialogPasien->no_pendaftaran = isset($_GET['ASPasienM']['no_pendaftaran']) ? $_GET['ASPasienM']['no_pendaftaran'] : '';
	$modDialogPasien->tgl_pendaftaran_cari = isset($_GET['ASPasienM']['tgl_pendaftaran_cari']) ? $_GET['ASPasienM']['tgl_pendaftaran_cari'] : '';
	$modDialogPasien->instalasi_nama = isset($_GET['ASPasienM']['instalasi_nama']) ? $_GET['ASPasienM']['instalasi_nama'] : '';
	$modDialogPasien->carabayar_nama = isset($_GET['ASPasienM']['carabayar_nama']) ? $_GET['ASPasienM']['carabayar_nama'] : '';
	$modDialogPasien->ruangan_nama = isset($_GET['ASPasienM']['ruangan_nama']) ? $_GET['ASPasienM']['ruangan_nama'] : '';
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'pendaftaran-t-grid',
	'dataProvider' => $modDialogPasien->searchPasienRumahsakitV(),
	'filter' => $modDialogPasien,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogPasien\").dialog(\"close\");
                                            cekPendaftaran(\"$data->pendaftaran_id\");
                                        "))',
		),
		array(
			'name' => 'no_rekam_medik',
			'type' => 'raw',
			'value' => '$data->no_rekam_medik',
		),
		array(
			'name' => 'nama_pasien',
			'type' => 'raw',
			'value' => '$data->nama_pasien',
		),
		'jeniskelamin',
		'no_pendaftaran',
		array(
			'name' => 'tgl_pendaftaran',
			'filter' =>
			CHtml::activeTextField($modDialogPasien, 'tgl_pendaftaran_cari', array('placeholder' => 'contoh: 15 Jan 2013')),
		),
		array(
			'name' => 'instalasi_nama',
			'type' => 'raw',
		),
		array(
			'name' => 'ruangan_nama',
			'type' => 'raw',
		),
		array(
			'name' => 'carabayar_nama',
			'type' => 'raw',
			'value' => '$data->carabayar_nama',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
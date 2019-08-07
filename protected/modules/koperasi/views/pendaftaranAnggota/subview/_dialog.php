<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawaiM('searchDialog');
$modPegawai->unsetAttributes();
if(isset($_GET['PegawaiM'])) {
    $modPegawai->attributes = $_GET['PegawaiM'];
}

$prov = $modPegawai->search();
$prov->criteria->join = 'left join keanggotaan_t a on a.pegawai_id = t.pegawai_id';
$prov->criteria->addCondition('a.keanggotaan_id is null');

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-m-grid',
	'dataProvider'=>$prov,
        'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>function($data) {
					$dat = $data->attributes;
					$dat['namaLengkap'] = $data->namaLengkap;
					$dat['jabatan'] = !empty($data->jabatan_id)?$data->jabatan->attributes:array();
					$dat['pangkat'] = !empty($data->pangkat_id)?$data->pangkat->attributes:array();
					$dat['pendidikan'] = !empty($data->pendidikan_id)?$data->pendidikan->attributes:array();
					$dat['kelompokpegawai'] = !empty($data->kelompokpegawai_id)?$data->kelompokpegawai->attributes:array();
					
					return CHtml::Link('<i class="icon-form-check"></i>',"",array("class"=>"btn-small", 
                        "id" => "selectPegawai",
                        "href"=>"#",
                        "onClick" => '
                            pilihPegawai('.CJSON::encode($dat).');
                            $("#dialogPegawai").dialog("close");    
                            return false;
						'));
                },
            ),
            'nomorindukpegawai',
            array(
				'name'=>'nama_pegawai',
				'value'=>'$data->namaLengkap',
            ),
            
            'tempatlahir_pegawai',
            array(
                'name'=>'tgl_lahirpegawai',
                'filter'=>false,
            ),
            array(
                'name'=>'jeniskelamin',
                'filter'=>CHtml::activeDropDownList($modPegawai, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --')),
            ),
            array(
                'name'=>'statusperkawinan',
                'filter'=>CHtml::activeDropDownList($modPegawai, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty'=>'-- Pilih --')),
            ),
            array(
                'header'=>'Jabatan',
                'type'=>'raw',
                'value'=>'isset($data->jabatan_id) ? $data->jabatan->jabatan_nama : ""',
                'filter'=>CHtml::activeDropDownList($modPegawai, 'jabatan_id', 
                        CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'), 
                        array('empty'=>'-- Pilih --')),
            ),
            'alamat_pegawai',
        ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiKoperasi',
    'options'=>array(
        'title'=>'Daftar Pegawai Koperasi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawaiV'])) {
    $modPegawai->attributes = $_GET['PegawaiV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaikoperasi-m-grid',
	'dataProvider'=>$modPegawai->search(),
        'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>function($data) {
					$dat = $data->attributes;
					$kel = KelompokpegawaiM::model()->findByPk($data->kelompokpegawai_id);
					$dat['namaLengkap'] = $data->namaLengkap;
					$dat['jabatan'] = !empty($data->jabatan_id)?$data->jabatan->attributes:array();
					$dat['pangkat'] = !empty($data->pangkat_id)?$data->pangkat->attributes:array();
					$dat['pendidikan'] = !empty($data->pendidikan_id)?$data->pendidikan->attributes:array();
					
					$dat['kelompokpegawai'] = !empty($kel)?$kel->attributes:array();
					
					return CHtml::Link('<i class="icon-form-check"></i>',"",array("class"=>"btn-small", 
                        "id" => "selectPegawai",
                        "href"=>"#",
                        "onClick" => '
                            pilihPegawai('.CJSON::encode($dat).');
                            $("#dialogPegawai").dialog("close");    
                            return false;
						'));
                },
            ),
            'nomorindukpegawai',
            array(
				'name'=>'nama_pegawai',
				'value'=>'$data->namaLengkap',
            ),
            array(
                'header'=>'Jabatan',
                'type'=>'raw',
                'value'=>'isset($data->jabatan_id) ? $data->jabatan->jabatan_nama : ""',
                'filter'=>CHtml::activeDropDownList($modPegawai, 'jabatan_id', 
                        CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'), 
                        array('empty'=>'-- Pilih --')),
            ),
            'alamat_pegawai',
        ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogAnggota',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modAnggota = new KeanggotaanV;
if (isset($_GET['KeanggotaanV'])) {
        $modAnggota->attributes = $_GET['KeanggotaanV'];        
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
'id'=>'anggota-m-grid',
'dataProvider'=>$modAnggota->search(),
'filter'=>$modAnggota,
'itemsCssClass' => 'table table-striped table-bordered table-condensed',
'columns'=>array(

            array(
                'header' =>  'Pilih',
                'type'=>'raw',
                'value'=>function($data) {
                        return CHtml::link('<i class="icon-form-check"></i>', '#', array('onclick'=>'loadAnggotaAjax("'.$data->nokeanggotaan.'"); $("#dialogAnggota").dialog("close"); return false;'));
                },
            ),
            array(
                'header' => 'No Keanggotaan',
                'name' => 'nokeanggotaan',
                'value' => '$data->nokeanggotaan',
                'filter' => Chtml::activeTextField($modAnggota, 'nokeanggotaan', array('class' => 'numbers-only'))
            ),            
            array (
                'header'=>'NIP',
                'name'=>'nomorindukpegawai',
                'value'=>'$data->nomorindukpegawai',
                'filter' => Chtml::activeTextField($modAnggota, 'nomorindukpegawai', array('class' => 'numbers-only'))
            ),  
            array(
                'header' => 'Nama Pegawai',
                'name' => 'nama_pegawai',
                'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                'filter' => Chtml::activeTextField($modAnggota, 'nama_pegawai', array('class' => 'hurufs-only'))
            ),
            array(
                'header' => 'Jabatan',
                'name' => 'jabatan_id',
                'value' => '$data->jabatan_nama',
                'filter' => Chtml::activeDropDownList($modAnggota, 'jabatan_id', Chtml::listData(JabatanM ::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "),'jabatan_id', 'jabatan_nama'),array('empty' => '-- Pilih --'))
            ),          
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
                        . '$(".numbers-only").keyup(function(){'
                        . '  setNumbersOnly(this);'
                        . '});'
                        . '$(".hurufs-only").keyup(function(){'
                        . '  setHurufsOnly(this);'
                        . '});'
                        . '}',
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

<!-- Dialog pengurus koperasi -->
<div class="modal fade custom-width" id="dialog_pegawai_pengurus">
	<div class="modal-dialog" style="width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Data Pegawai Koperasi</h4>
			</div>
			<div class="modal-body">
				<?php 
					echo CHtml::hiddenField('target_attr', null);
					$pegawai = new PegawaiM;
					if (isset($_GET['PegawaiM'])) $pegawai->attributes = $_GET['PegawaiM'];
					$this->widget('ext.bootstrap.widgets.BootGridView',array(
					'id'=>'pegawai-pengurus-m-grid',
					'dataProvider'=>$pegawai->searchPengurus(),
					'filter'=>$pegawai,
					'itemsCssClass' => 'table-bordered datatable dataTable',
					'columns'=>array(
						array(
							'header'=>'Pilih',
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadPengurusDariDialog("'.$data->pegawai_id.'", "'.$data->nama_pegawai.'"); $("#dialog_pegawai_pengurus").modal("hide"); return false;'));
							},
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
						),
						'nomorindukpegawai',
						//'no_kartupegawainegerisipil',
						//'pegawai_id',
						//'noidentitas',
						array(
							'header'=>'Nama Pegawai',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
							),
						/*array(
							'header'=>'Jabatan',
							'type'=>'raw',
							'value'=>'!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
						array(
							'header'=>'Pangkat',
							'type'=>'raw',
							'value'=>'!empty($data->pangkat_id)?$data->pangkat->pangkat_nama:"-"',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
						array(
							'header'=>'Golongan',
							'type'=>'raw',
							'value'=>'!empty($data->golonganpegawai_id)?$data->golonganpegawai->golonganpegawai_nama:"-"',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
							'nomobile_pegawai',
							'alamatemail',*/
						),
					)); 
				
				?>
			</div>
		</div>
	</div>
</div>



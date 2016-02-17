<div id='tblDiagnosa'>
<?php 
$modDiagnosaPasien = new DiagnosaV('searchDiagnosis');
$modDiagnosaPasien->unsetAttributes();  // clear any default values
    if(isset($_GET['DiagnosaV'])){
        $modDiagnosaPasien->attributes=$_GET['DiagnosaV'];
        //$modDiagnosaPasien->diagnosa_aktif=TRUE;
	}

$criteriaTab = new CDbCriteria;
$criteriaTab->compare('tabularlist_id', $modDiagnosaPasien->tabularlist_id);
$criteriaTab->addCondition('dtd_aktif = true');
$criteriaTab->order = 'dtd_nourut';        
        
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rjdiagnosa-m-grid',
    'dataProvider'=>$modDiagnosaPasien->search(),
    'filter'=>$modDiagnosaPasien,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-condensed',
    'columns'=>array(   
        /*
        array(
            'name'=>'diagnosa_nourut',
            'value'=>'$data->diagnosa_nourut',
            'filter'=>false,
        ),
		array(
			'header'=>'Klasifikasi Diagnosa',
            'name'=>'klasifikasidiagnosa_id',
            'value'=>'isset($data->klasifikasidiagnosa_id) ? $data->klasifikasidiagnosa->KlasifikasiKodeNama : ""',
			'filter'=> CHtml::activeDropDownList($modDiagnosaPasien,'klasifikasidiagnosa_id',CHtml::listData(RIKlasifikasidiagnosaM::model()->findAll("klasifikasidiagnosa_aktif is true"), "klasifikasidiagnosa_id", "KlasifikasiKodeNama"),array('empty'=>'--Pilih--')),
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',
        'diagnosa_katakunci',
         * 
         */
        array(
            'header'=>'Tabulasi List',
            'type'=>'raw',
            'name'=>'tabularlist_id',
            'value'=>'$data->tabularlist_chapter',
            'filter'=>Chtml::activeDropDownList($modDiagnosaPasien, 'tabularlist_id', CHtml::listData(
                    TabularlistM::model()->findAll(array('order'=>'tabularlist_id', 'condition'=>'tabularlist_aktif = true')), 'tabularlist_id', 'tabularlist_chapter'
            ), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Daftar Tabulasi Data',
            'type'=>'raw',
            'name'=>'dtd_id',
            'value'=>'$data->dtd_kode',
            'filter'=>Chtml::activeDropDownList($modDiagnosaPasien, 'dtd_id', CHtml::listData(
                    DtdM::model()->findAll($criteriaTab), 'dtd_id', 'dtd_kode'
            ), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Klasifikasi Kode',
            'type'=>'raw',
            'name'=>'klasifikasidiagnosa_kode',
            'value'=>'$data->klasifikasidiagnosa_kode',
        ),
        array(
            'header'=>'Klasifikasi Nama',
            'type'=>'raw',
            'name'=>'klasifikasidiagnosa_nama',
            'value'=>'$data->klasifikasidiagnosa_nama',
        ),
        array(
            'header'=>'Diagnosa Kode',
            'type'=>'raw',
            'name'=>'diagnosa_kode',
            'value'=>'$data->diagnosa_kode',
        ),
        array(
            'header'=>'Diagnosa',
            'type'=>'raw',
            'name'=>'diagnosa_nama',
            'value'=>'$data->diagnosa_nama',
        ),
        array(
            'header'=>'Nama Lain',
            'type'=>'raw',
            'name'=>'diagnosa_namalainnya',
            'value'=>'$data->diagnosa_namalainnya',
        ),
        array(
            'header'=>'Kata Kunci',
            'name'=>'diagnosa_katakunci',
            'value'=>'$data->diagnosa_katakunci',
        ),
        array(
            'header'=>'Kelompok Diagnosa',
            'type'=>'raw',
            'value'=>'CHtml::dropDownList("kelompokDiagnosa_$data->diagnosa_id","",CHtml::listData(RIKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif is true"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);",))',
        ), 
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputDiagnosa(this,$data->diagnosa_id);return false;"))',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 
</div>
   
<div id="tblKasuspenyakitDiagnosa" class="hide">
<?php 
//$modDiagnosaKasusPenyakit = new RIKasusPenyakitDiagnosaM('search');
//$modDiagnosaKasusPenyakit->unsetAttributes();  // clear any default values
//$modDiagnosaKasusPenyakit->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
//if(isset($_GET['RIKasusPenyakitDiagnosaM'])){
//    $modDiagnosaKasusPenyakit->attributes=$_GET['RIKasusPenyakitDiagnosaM'];
//    $modDiagnosaKasusPenyakit->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
//}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rikasuspenyakitdiagnosa-m-grid',
    'dataProvider'=>$modKasuspenyakitDiagnosa->search(),
    'filter'=>$modKasuspenyakitDiagnosa,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-condensed',
    'columns'=>array(        
        /*
        array(
            'header'=>'No. Urut',
            'value'=>'(isset($data->diagnosa->diagnosa_nourut) ? $data->diagnosa->diagnosa_nourut : "")',
//            'filter'=>false,
        ),
		array(
			'header'=>'Klasifikasi Diagnosa',
            'value'=>'isset($data->diagnosa->klasifikasidiagnosa_id) ? $data->diagnosa->klasifikasidiagnosa->KlasifikasiKodeNama : ""',
			'filter'=> CHtml::activeDropDownList($modDiagnosaPasien,'klasifikasidiagnosa_id',CHtml::listData(RIKlasifikasidiagnosaM::model()->findAll("klasifikasidiagnosa_aktif is true"), "klasifikasidiagnosa_id", "KlasifikasiKodeNama"),array('empty'=>'--Pilih--')),
        ),
        array(
			'name'=>'diagnosa_kode',
            'header'=>'Kode Diagnosa',
            'value'=>'(isset($data->diagnosa->diagnosa_kode) ? $data->diagnosa->diagnosa_kode : "")',
        ),
        array(
			'name'=>'diagnosa_nama',
            'header'=>'Nama Diagnosa',
            'value'=>'(isset($data->diagnosa->diagnosa_nama) ? $data->diagnosa->diagnosa_nama : "")',
        ),
        array(
			'name'=>'diagnosa_namalainnya',
            'header'=>'Nama Lain ',
            'value'=>'(isset($data->diagnosa->diagnosa_namalainnya) ? $data->diagnosa->diagnosa_namalainnya : "")',
        ),
        array(
			'name'=>'diagnosa_katakunci',
            'header'=>'Kata Kunci',
            'value'=>'(isset($data->diagnosa->diagnosa_katakunci) ? $data->diagnosa->diagnosa_katakunci : "")',
        ),
         * 
         */
        array(
            'header'=>'Tabulasi List',
            'type'=>'raw',
            'name'=>'tabularlist_id',
            'value'=>'$data->tabularlist_chapter',
            'filter'=>Chtml::activeDropDownList($modDiagnosaPasien, 'tabularlist_id', CHtml::listData(
                    TabularlistM::model()->findAll(array('order'=>'tabularlist_id', 'condition'=>'tabularlist_aktif = true')), 'tabularlist_id', 'tabularlist_chapter'
            ), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Daftar Tabulasi Data',
            'type'=>'raw',
            'name'=>'dtd_id',
            'value'=>'$data->dtd_kode',
            'filter'=>Chtml::activeDropDownList($modDiagnosaPasien, 'dtd_id', CHtml::listData(
                    DtdM::model()->findAll($criteriaTab), 'dtd_id', 'dtd_kode'
            ), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Klasifikasi Kode',
            'type'=>'raw',
            'name'=>'klasifikasidiagnosa_kode',
            'value'=>'$data->klasifikasidiagnosa_kode',
        ),
        array(
            'header'=>'Klasifikasi Nama',
            'type'=>'raw',
            'name'=>'klasifikasidiagnosa_nama',
            'value'=>'$data->klasifikasidiagnosa_nama',
        ),
        array(
            'header'=>'Diagnosa Kode',
            'type'=>'raw',
            'name'=>'diagnosa_kode',
            'value'=>'$data->diagnosa_kode',
        ),
        array(
            'header'=>'Diagnosa',
            'type'=>'raw',
            'name'=>'diagnosa_nama',
            'value'=>'$data->diagnosa_nama',
        ),
        array(
            'header'=>'Nama Lain',
            'type'=>'raw',
            'name'=>'diagnosa_namalainnya',
            'value'=>'$data->diagnosa_namalainnya',
        ),
        array(
            'header'=>'Kata Kunci',
            'name'=>'diagnosa_katakunci',
            'value'=>'$data->diagnosa_katakunci',
        ),
        array(
            'header'=>'Kelompok Diagnosa',
            'type'=>'raw',
            'value'=>'CHtml::dropDownList("kelompokDiagnosa_$data->diagnosa_id","",CHtml::listData(RIKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif is true"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);",))',
        ),
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputDiagnosa(this,$data->diagnosa_id);return false;"))',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?> 
</div>
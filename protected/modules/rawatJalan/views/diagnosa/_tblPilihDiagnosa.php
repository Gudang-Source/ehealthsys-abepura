
<div id='tblDiagnosa'>

<?php 
$modDiagnosaPasien = new RJDiagnosaM('searchDiagnosis');
$modDiagnosaPasien->unsetAttributes();  // clear any default values
if(isset($_GET['RJDiagnosaM'])){
	$modDiagnosaPasien->attributes=$_GET['RJDiagnosaM'];
	$modDiagnosaPasien->klasifikasidiagnosa_id=$_GET['RJDiagnosaM']['klasifikasidiagnosa_id'];
}
            
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rjdiagnosa-m-grid',
    'dataProvider'=>$modDiagnosaPasien->searchDiagnosis(),
    'filter'=>$modDiagnosaPasien,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(        
        array(
            'name'=>'diagnosa_nourut',
            'value'=>'$data->diagnosa_nourut',
        ),
        array(
			'header'=>'Klasifikasi Diagnosa',
            'name'=>'klasifikasidiagnosa_id',
            'value'=>'isset($data->klasifikasidiagnosa_id) ? $data->klasifikasidiagnosa->KlasifikasiKodeNama : ""',
			'filter'=> CHtml::activeDropDownList($modDiagnosaPasien,'klasifikasidiagnosa_id',CHtml::listData(RJKlasifikasidiagnosaM::model()->findAll("klasifikasidiagnosa_aktif is true"), "klasifikasidiagnosa_id", "KlasifikasiKodeNama"),array('empty'=>'--Pilih--')),
        ),
        array(
            'name'=>'diagnosa_kode',
            'value'=>'$data->diagnosa_kode',
        ),
        array(
            'name'=>'diagnosa_nama',
            'value'=>'$data->diagnosa_nama',
        ),
        array(
            'name'=>'diagnosa_namalainnya',
            'value'=>'$data->diagnosa_namalainnya',
        ),
        array(
            'name'=>'diagnosa_katakunci',
            'value'=>'$data->diagnosa_katakunci',
        ),
        array(
            'header'=>'Kelompok Diagnosa',
            'type'=>'raw',
            'value'=>'CHtml::dropDownList("kelompokDiagnosa_$data->diagnosa_id","",CHtml::listData(RJKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif is true"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);",))',
        ),    
		array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputDiagnosa(this,$data->diagnosa_id);return false;"))',
        ),
        /*
        'diagnosa_imunisasi',
        'diagnosa_aktif',
        */
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?> 
</div>
   
<div id="tblKasuspenyakitDiagnosa" class="hide">
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rjkasuspenyakitdiagnosa-m-grid',
    'dataProvider'=>$modKasuspenyakitDiagnosa->search(),
    'filter'=>$modKasuspenyakitDiagnosa,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
        array(
            'name'=>'diagnosa_nourut',
            'value'=>'$data->diagnosa->diagnosa_nourut',
//            'filter'=>true,
        ),
        array(
			'header'=>'Klasifikasi Diagnosa',
			'name'=>'klasifikasidiagnosa_id',
            'value'=>'isset($data->diagnosa->klasifikasidiagnosa_id) ? $data->diagnosa->klasifikasidiagnosa->KlasifikasiKodeNama : ""',
			'filter'=> CHtml::activeDropDownList($modKasuspenyakitDiagnosa,'klasifikasidiagnosa_id',CHtml::listData(RJKlasifikasidiagnosaM::model()->findAll("klasifikasidiagnosa_aktif is true"), "klasifikasidiagnosa_id", "KlasifikasiKodeNama"),array('empty'=>'--Pilih--')),
        ),
		array(
            'name'=>'diagnosa_kode',
            'value'=>'$data->diagnosa->diagnosa_kode',
        ),
        array(
            'name'=>'diagnosa_nama',
            'value'=>'$data->diagnosa->diagnosa_nama',
//			'filter'=>true,
        ),
        array(
            'name'=>'diagnosa_namalainnya',
            'value'=>'$data->diagnosa->diagnosa_namalainnya',
//			'filter'=>true,
        ),
        array(
            'name'=>'diagnosa_katakunci',
            'value'=>'$data->diagnosa->diagnosa_katakunci',
//			'filter'=>true,
        ),
        array(
            'header'=>'Kelompok Diagnosa',
            'type'=>'raw',
            'value'=>'CHtml::dropDownList("kelompokDiagnosa_$data->diagnosa_id","",CHtml::listData(RJKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif is true"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);",))',
//			'filter'=>true,
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
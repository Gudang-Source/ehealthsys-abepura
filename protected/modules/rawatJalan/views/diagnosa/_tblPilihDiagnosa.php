
<div id='tblDiagnosa'>

<?php 
$modDiagnosaPasien = new DiagnosaV('searchDiagnosis');
$modDiagnosaPasien->unsetAttributes();  // clear any default values
if(isset($_GET['DiagnosaV'])){
	$modDiagnosaPasien->attributes=$_GET['DiagnosaV'];
}


$criteriaTab = new CDbCriteria;
$criteriaTab->compare('tabularlist_id', $modDiagnosaPasien->tabularlist_id);
$criteriaTab->addCondition('dtd_aktif = true');
$criteriaTab->order = 'dtd_nourut';
            
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rjdiagnosa-m-grid',
    'dataProvider'=>$modDiagnosaPasien->searchDiagnosis(),
    'filter'=>$modDiagnosaPasien,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
        /*
        array(
            'name'=>'diagnosa_nourut',
            'value'=>'$data->diagnosa_nourut',
        ),
        array(
			'header'=>'Klasifikasi Diagnosa',
            'name'=>'klasifikasidiagnosa_id',
            'value'=>'isset($data->klasifikasidiagnosa_id) ? $data->klasifikasidiagnosa_kode." - ".$data->klasifikasidiagnosa_nama : ""',
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
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"}); injekEnterDiagnosa();}',
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
        /*
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
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"}); injekEnterPenyakitDiagnosa();}',
)); ?> 
</div>
<script>
function injekEnterDiagnosa() {
    $("#tblDiagnosa :input").keypress(function(e) {
        if (e.key.toLowerCase() === "enter") {
            $.fn.yiiGridView.update("rjdiagnosa-m-grid", {data: $("#tblDiagnosa :input").serialize()});
        }
    });
}

function injekEnterPenyakitDiagnosa() {
    $("#tblKasuspenyakitDiagnosa :input").keypress(function(e) {
        if (e.key.toLowerCase() === "enter") {
            $.fn.yiiGridView.update("rjkasuspenyakitdiagnosa-m-grid", {data: $("#tblKasuspenyakitDiagnosa :input").serialize()});
        }
    });
}

injekEnterDiagnosa(); injekEnterPenyakitDiagnosa();
</script>
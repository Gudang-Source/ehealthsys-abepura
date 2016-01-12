<div id='isiScroll'>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pencucianlinen-grid',
    'dataProvider'=>$modInfoPencucian->searchPencucianLinen(),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
            array(
                'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemua',true,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua obat','rel'=>'tooltip')),
                'type'=>'raw',
                'value'=>'
                    CHtml::hiddenField(\'LAPenyimpananlinendetT[\'.$data->pencucianlinen_id.\'][linen_id]\',$data->linen_id).
                    CHtml::hiddenField(\'LAPenyimpananlinendetT[\'.$data->pencucianlinen_id.\'][pencucianlinen_id]\',$data->pencucianlinen_id).
                    CHtml::hiddenField(\'LAPenyimpananlinendetT[\'.$data->pencucianlinen_id.\'][perawatanlinen_id]\',$data->perawatanlinen_id).
                    CHtml::checkBox(\'LAPenyimpananlinendetT[\'.$data->pencucianlinen_id.\'][checklist]\', true, array(\'class\'=>\'checklist\', \'onclick\'=>\'setNol(this);\'));
                    ',
            ),
            array(
                'header'=>'Lokasi Penyimpanan',
                'type'=>'raw',
                'value'=>'CHtml::dropDownList(\'LAPenyimpananlinendetT[\'.$data->pencucianlinen_id.\'][lokasipenyimpanan_id]\',"",CHtml::listData(LALokasipenyimpananM::model()->findAll(),"lokasipenyimpanan_id","lokasipenyimpanan_nama"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);"))'
            ),
            array(
                'header'=>'Sub Rak',
                'type'=>'raw',
                'value'=>'CHtml::dropDownList(\'LAPenyimpananlinendetT[\'.$data->pencucianlinen_id.\'][rakpenyimpanan_id]\',"",CHtml::listData(LARakpenyimpananM::model()->findAll(),"rakpenyimpanan_id","rakpenyimpanan_nama"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);"))'
            ),
            array(
                'header'=>'No. Pencucian',
                'type'=>'raw',
                'value'=>'isset($data->nopencucianlinen) ? $data->nopencucianlinen : ""',
            ),            
            array(
                'header'=>'Ruangan Asal',
                'type'=>'raw',
                'value'=>'isset($data->ruangan_nama) ? $data->ruangan_nama : ""',
            ),            
            array(
                'header'=>'Kode Linen',
                'type'=>'raw',
                'value'=>'isset($data->kodelinen) ? $data->kodelinen : ""',
            ),            
            array(
                'header'=>'Nama Linen',
                'type'=>'raw',
                'value'=>'isset($data->namalinen) ? $data->namalinen : ""',
            ),            
            array(
                'header'=>'Keterangan',
                'type'=>'raw',
                'value'=>'CHtml::textField(\'LAPenyimpananlinendetT[\'.$data->pencucianlinen_id.\'][keterangan_penyimpananlinen]\')'
            ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                }',
)); ?> 
</div>
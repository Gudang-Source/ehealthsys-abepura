<div id='isiScroll'>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'penerimaanpengeluaran-grid',
    'dataProvider'=>$modInfoPencucian->searchPencucianLinen(),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
            array(
                'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemua',true,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua linen','rel'=>'tooltip')),
                'type'=>'raw',
                'value'=>'
                    CHtml::hiddenField(\'LAPencuciandetailT[\'.$data->penerimaanlinen_id.\'][\'.$row.\'][linen_id]\',$data->linen_id).
                    CHtml::hiddenField(\'LAPencuciandetailT[\'.$data->penerimaanlinen_id.\'][\'.$row.\'][penerimaanlinen_id]\',$data->penerimaanlinen_id).
                    CHtml::hiddenField(\'LAPencuciandetailT[\'.$data->penerimaanlinen_id.\'][\'.$row.\'][perawatanlinen_id]\',$data->perawatanlinen_id).
                    CHtml::checkBox(\'LAPencuciandetailT[\'.$data->penerimaanlinen_id.\'][\'.$row.\'][checklist]\', true, array(\'class\'=>\'checklist\', \'onclick\'=>\'setNol(this);\'));
                    ',
            ),
            array(
                'header'=>'Ruangan Asal',
                'type'=>'raw',
                'value'=>'isset($data->ruangan_nama) ? $data->ruangan_nama : ""',
            ),
            array(
                'header'=>'No. Penerimaan',
                'type'=>'raw',
                'value'=>'isset($data->nopenerimaanlinen) ? $data->nopenerimaanlinen : ""',
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
                'value'=>'CHtml::textField(\'LAPencuciandetailT[\'.$data->penerimaanlinen_id.\'][\'.$row.\'][keteranganpenerimaanlinen_item]\',$data->keteranganpenerimaanlinen_item)'
            ),
            array(
                'header'=>'Status Perawatan',
                'type'=>'raw',
                'value'=>'CHtml::dropDownList(\'LAPencuciandetailT[\'.$data->penerimaanlinen_id.\'][\'.$row.\'][jenisperawatanlinen]\',"",LookupM::getItems("statusperawatan"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);","options" => array("SELESAI"=>array("selected"=>true))))'
            ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                }',
)); ?> 
</div>
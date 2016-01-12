<?php
if(count($modKarcisVs) > 0){
    echo "<table class='table table-condensed table-bordered table-striped'>";
    echo "<thead>";
    echo "<th>Karcis</th>";
    echo "<th>Harga</th>";
    echo "<th>Pilih</th>";
    echo "</thead>";
    foreach($modKarcisVs AS $i =>$karcis){
        $class = "";
        $modTindakan->is_pilihtindakan = 0;
        $modTindakan->attributes = $karcis->attributes;
        if(isset($dataTindakanKarcis->karcis_id)){
            if($karcis->karcis_id == $dataTindakanKarcis->karcis_id){
                $modTindakan->is_pilihtindakan = 1;
                $class = "class='checked'";
            }
        }
        $modTindakan->karcis_id = $karcis->karcis_id;
        $modTindakan->jenistarif_id = $karcis->jenistarif_id;
        $modTindakan->tarif_satuan = $format->formatNumberForUser($karcis->harga_tariftindakan);
        echo '<tr '.$class.'>
                <td>'.CHtml::label($karcis['karcis_nama'],$karcis['karcis_nama']).'</td>
                <td>'.CHtml::activeTextField($modTindakan, '['.$i.']tarif_satuan',array('readonly'=>true, 'class'=>'span1 integer', 'style'=>'width:96px;text-align:right;')).'</td>
                <td><a data-karcis="'.$karcis['karcis_id'].'class="btn-small" href="javascript:void(0);" onclick="pilihKarcis(this);return false;">
                    <i class="icon-form-check"></i>
                    </a>'
                .CHtml::activeHiddenField($modTindakan, '['.$i.']is_pilihtindakan',array('readonly'=>true, 'class'=>'span1'))  
                .CHtml::activeHiddenField($modTindakan, '['.$i.']daftartindakan_id',array('readonly'=>true, 'class'=>'span1'))  
                .CHtml::activeHiddenField($modTindakan, '['.$i.']karcis_id',array('readonly'=>true, 'class'=>'span1'))  
                .CHtml::activeHiddenField($modTindakan, '['.$i.']jenistarif_id',array('readonly'=>true, 'class'=>'span1'))  
            .'</td>'
            .'</tr>';
    }
    echo "</table>";
}else{
    echo "Data karcis tidak ditemukan!";
}

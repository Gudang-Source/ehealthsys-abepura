<tr>
    <td><?php echo CHtml::activeTextField($row, 'waktu_awal[]', array('class'=>'timings span2', 'value'=>$row->waktu_awal, 'style'=>'text-align: right')); ?></td>
    <td><?php echo CHtml::activeTextField($row, 'waktu_selesai[]', array('class'=>'timings span2', 'value'=>$row->waktu_awal, 'style'=>'text-align: right')); ?></td>
    <td width="100%"><?php echo $oa->obatalkes_nama
            .Chtml::activeHiddenField($row, 'obatalkes_id[]', array('value'=>$oa->obatalkes_id))
            .Chtml::activeHiddenField($row, 'satuankecil_id[]', array('value'=>$oa->satuankecil_id)); ?></td>
    <td nowrap><?php echo CHtml::activeTextField($row, 'kapasitas[]', array('class'=>'numbers-only span1', 'value'=>$oa->kekuatan, 'style'=>'text-align: right', 'readonly'=>true))." ".$oa->satuankekuatan; ?></td>
    <td nowrap><?php echo CHtml::activeTextField($row, 'qty_gasmedis[]', array('class'=>'numbers-only span1', 'value'=>$row->qty_gasmedis, 'style'=>'text-align: right'))." ".$oa->satuankecil->satuankecil_nama; ?></td>
    <td style="text-align: center;"><?php echo CHtml::link('<i class="icon-remove"></i>', '#', array('onclick'=>'batalProduksi(this)', 'rel'=>'tooltip', 'title'=>'Klik untuk batal produksi ini')); ?></td>
</tr>

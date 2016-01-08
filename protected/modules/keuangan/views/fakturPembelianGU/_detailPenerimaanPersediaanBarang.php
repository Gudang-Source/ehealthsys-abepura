<tr>   
    <td><?php 
        echo CHtml::activeHiddenField($modDetail, '['.$key.']barang_id', array('class'=>'barang')); 
        echo CHtml::activeHiddenField($modDetail, '['.$key.']terimapersdetail_id'); 
        echo $modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama; 
        ?>
    </td>
    <td><?php echo $modBarang->bidang->subkelompok->kelompok->kelompok_nama; ?></td>
    <td><?php echo $modBarang->bidang->subkelompok->subkelompok_nama; ?></td>
    <td><?php echo $modBarang->bidang->bidang_nama; ?></td>
    <td><?php echo $modBarang->barang_nama; ?></td>
	<td><?php echo CHtml::activeTextField($modDetail, '['.$key.']jmlterima', array('class'=>'span1 numbersOnly qty', 'onblur'=>'setTotalHarga();' )); ?></td>
	<td><?php echo CHtml::activeDropDownList($modDetail, '['.$key.']satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
	<td><?php echo CHtml::activeTextField($modDetail, '['.$key.']jmldalamkemasan', array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '['.$key.']hargabeli', array('class'=>'span1 numbersOnly beli',)); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '['.$key.']hargasatuan', array('class'=>'span1 numbersOnly satuan', 'onblur'=>'setTotalHarga();')); ?></td>
    <td></td>
    <td><?php echo CHtml::activeDropDownList($modDetail, '['.$key.']kondisibarang', LookupM::getItems('inventariskeadaan'), array('class'=>'span2')); ?></td>
    <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        
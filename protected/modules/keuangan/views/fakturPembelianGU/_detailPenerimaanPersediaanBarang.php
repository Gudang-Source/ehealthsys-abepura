<tr>   
    <td><?php 
        echo CHtml::activeHiddenField($modDetail, '['.$key.']barang_id', array('class'=>'barang')); 
        echo CHtml::activeHiddenField($modDetail, '['.$key.']terimapersdetail_id'); 
        echo $modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan->golongan_nama;
        $modDetail->hargabeli = MyFormatter::formatNumberForPrint($modDetail->hargabeli);
        $modDetail->hargasatuan = MyFormatter::formatNumberForPrint($modDetail->hargasatuan);
        // $modDetail->hargabeli = MyFormatter::formatNumberForPrint($modDetail->hargabeli);
        ?>
    </td>
	<td><?php echo $modBarang->subsubkelompok->subkelompok->kelompok->bidang->bidang_nama; ?></td>
    <td><?php echo $modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama; ?></td>
    <td><?php echo $modBarang->subsubkelompok->subkelompok->subkelompok_nama; ?></td>
    <td><?php echo $modBarang->subsubkelompok->subsubkelompok_nama; ?></td>
    <td><?php echo $modBarang->barang_kode."/<br/>".$modBarang->barang_nama; ?></td>
	<td><?php echo CHtml::activeTextField($modDetail, '['.$key.']jmlterima', array('class'=>'span1 integer2 qty', 'onblur'=>'setTotalHarga();' )); ?></td>
	<td><?php echo CHtml::activeDropDownList($modDetail, '['.$key.']satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
	<td><?php echo CHtml::activeTextField($modDetail, '['.$key.']jmldalamkemasan', array('empty'=>'-- Pilih --', 'class'=>'span1 jml', 'style'=>'text-align: right;')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '['.$key.']hargasatuan', array('class'=>'span2 integer2 satuan', 'onblur'=>'setTotalHarga();')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '['.$key.']hargabeli', array('class'=>'span2 integer2 beli',)); ?></td>
    <!--td><?php // echo CHtml::activeTextField($modDetail, '['.$key.']total', array('class'=>'span2 integer2 satuan', 'readonly'=>true)); ?></td-->
    <td><?php echo CHtml::activeDropDownList($modDetail, '['.$key.']kondisibarang', LookupM::getItems('inventariskeadaan'), array('class'=>'span2')); ?></td>
    <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        
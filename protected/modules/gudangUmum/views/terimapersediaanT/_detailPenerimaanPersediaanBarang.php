<tr>   
    <td><?php 
        echo CHtml::activeHiddenField($modDetail, '[]barang_id', array('class'=>'barang')); 
        echo $modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan->golongan_nama; 
        ?>
    </td>
    <td><?php echo $modBarang->subsubkelompok->subkelompok->kelompok->bidang->bidang_nama; ?></td>
    <td><?php echo $modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama; ?></td>
    <td><?php echo $modBarang->subsubkelompok->subkelompok->subkelompok_nama; ?></td>
    <td><?php echo $modBarang->subsubkelompok->subsubkelompok_nama; ?></td>
    <td><?php echo $modBarang->barang_nama; ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]jmlterima', array('class'=>'span1 integer2 qty', 'onblur'=>'setTotalHarga();',  'style'=>'text-align: right' )); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]hargasatuan', array('class'=>'span2 integer2 satuan', 'onblur'=>'setTotalHarga();',  'style'=>'text-align: right')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]hargabeli', array('class'=>'span2 integer2 beli', 'style'=>'text-align: right')); ?></td>
    <td><?php echo CHtml::activeDropDownList($modDetail, '[]satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]jmldalamkemasan', array('empty'=>'-- Pilih --', 'class'=>'span2 integer2', 'style'=>'text-align: right')); ?></td>
    <td><?php echo CHtml::activeDropDownList($modDetail, '[]kondisibarang', LookupM::getItems('inventariskeadaan'), array('class'=>'span2')); ?></td>
    <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        
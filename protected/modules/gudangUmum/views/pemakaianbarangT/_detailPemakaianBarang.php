<tr>   
    <td><?php 
        echo CHtml::hiddenField('no_urut', '', array('class'=>'')); 
        echo CHtml::activeHiddenField($modDetail, '[ii]barang_id', array('class'=>'barang')); 
        echo CHtml::activeHiddenField($modDetail, '[ii]ppn', array('class'=>'ppn')); 
        echo CHtml::activeHiddenField($modDetail, '[ii]disc', array('class'=>'disc')); 
        echo CHtml::activeHiddenField($modDetail, '[ii]hpp', array('class'=>'hpp'));
        echo $modBarang->barang_kode;
        ?>
    </td>
    <td><?php echo $modBarang->barang_type ?></td>
    <td><?php echo $modBarang->barang_nama ?></td>
    <td><?php echo $modBarang->barang_merk.' / '.$modBarang->barang_noseri ?></td>
    <td><?php echo $modBarang->barang_ukuran.' / '.$modBarang->barang_bahan ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[ii]harganetto', array('class'=>'span2 integer beli',)); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[ii]hargajual', array('class'=>'span2 integer satuan', )); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[ii]jmlpakai', array('class'=>'span1 float qty', )); ?></td>
    <td><?php echo CHtml::activeDropDownList($modDetail, '[ii]satuanpakai', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
    <td><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        
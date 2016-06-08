<tr>   
    <!--<td><?php 
        //echo CHtml::activeHiddenField($modDetail, '[]barang_id', array('class'=>'barang')); 
        //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan->golongan_nama:null; 
        ?>
    </td>
    <td><?php //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->bidang_nama:null; ?></td>
    <td><?php //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama:null; ?></td>
    <td><?php //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->subkelompok_nama:null; ?></td>
    <td><?php //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subsubkelompok_nama:null; ?></td>-->
    <td>
        <?php echo CHtml::activeHiddenField($modDetail, '[]barang_id', array('class'=>'barang')); ?>
        <?php echo $modBarang->barang_type; ?>
    </td>
    <td><?php echo $modBarang->barang_kode; ?></td>
    <td><?php echo $modBarang->barang_nama; ?></td>
    <td><?php echo $modBarang->barang_merk; ?></td>        
    <td><?php echo CHtml::activeTextField($modDetail, '[]jmlbeli', array('class'=>'span1 numbersOnly qty', 'style'=>'text-align: right;', 'onchange'=>'hitungTotal(this)')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]hargasatuan', array('class'=>'span2 integer2 satuan', 'style'=>'text-align: right;', 'onchange'=>'hitungTotal(this)')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]hargabeli', array('class'=>'span2 integer2 beli', 'style'=>'text-align: right;', 'readonly'=>true)); ?></td>
    <td><?php echo CHtml::activeDropDownList($modDetail, '[]satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]jmldlmkemasan', array('class'=>'span1 numbersOnly', 'style'=>'text-align: right;')); ?></td>
    <td><?php echo $modBarang->barang_ukuran; ?></td>
    <td><?php echo $modBarang->barang_ekonomis_thn; ?></td>
    <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        
<tr>   
    <!--<td><?php 
        //echo CHtml::activeHiddenField($modDetail, '[]barang_id', array('class'=>'barang')); 
       // echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama:null; 
        ?>
    </td>
    <td><?php //echo !empty($modBarang->bidang_id)? $modBarang->bidang->subkelompok->kelompok->kelompok_nama:null; ?></td>
	<td><?php //echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->subkelompok_nama:null; ?></td>
	<td><?php //echo !empty($modBarang->bidang_id)?$modBarang->bidang->bidang_nama:null; ?></td>-->
    <td><?php 
    echo CHtml::activeHiddenField($modDetail, '[]barang_id', array('class'=>'barang'));
    //echo CHtml::activeTextField($modBarang, '[]barang_type', array('class'=>'span1','readonly'=>true));
    echo $modBarang->barang_type; ?></td>
    <td><?php echo $modBarang->barang_kode; ?></td>
    <td><?php echo $modBarang->barang_nama; ?></td>
    <td><?php echo $modBarang->barang_merk; ?></td>
    <?php //if (isset($_GET['id'])){ ?>
    <td><?php echo CHtml::activeTextField($modDetail, '[]qty_pesan', array('class'=>'span1','readonly'=>true, 'style'=>'text-align:right;')); ?></td>
    <?php //} ?>
    <td><?php echo CHtml::activeTextField($modDetail, '[]qty_mutasi', array('class'=>'span1 numbersOnly mutasi', 'onblur'=>'cekStok(this);', 'style'=>'text-align:right;')); ?></td>
    <td><?php echo CHtml::activeDropDownList($modDetail, '[]satuanbrg', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
    <td><?php echo $modBarang->barang_ukuran; ?></td>
    <td><?php echo $modBarang->barang_ekonomis_thn; ?></td>
    <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        
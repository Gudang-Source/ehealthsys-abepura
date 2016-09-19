<tr>   
    <td><?php 
    
        $golongan = "";
        $bidang = "";
        $kelompok = "";
        $subkelompok = "";
        $subsubkelompok = "";
        
        if (!empty($modBarang->subsubkelompok_id)) {
            if (!empty($modBarang->subusbkelompok->subkelompok_id)) {
                if (!empty($modBarang->subsubkelompok->subkelompok->kelompok_id)) {
                    if (!empty($modBarang->subsubkelompok->subkelompok->kelompok->bidang_id)) {
                        if (!empty($modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan_id)) {
                            $golongan = $modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan->golongan_nama;
                        }
                        $bidang = $modBarang->subsubkelompok->subkelompok->kelompok->bidang->bidang_nama;
                    }
                    $kelompok = $modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama;
                }
                $subkelompok = $modBarang->subsubkelompok->subkelompok->subkelompok_nama;
            }
            $subsubkelompok = $modBarang->subsubkelompok->subsubkelompok_nama;
        }
    
        echo CHtml::activeHiddenField($modDetail, '['.$key.']barang_id', array('class'=>'barang')); 
        echo CHtml::activeHiddenField($modDetail, '['.$key.']terimapersdetail_id'); 
        echo $golongan;
        $modDetail->hargabeli = MyFormatter::formatNumberForPrint($modDetail->hargabeli);
        $modDetail->hargasatuan = MyFormatter::formatNumberForPrint($modDetail->hargasatuan);
        // $modDetail->hargabeli = MyFormatter::formatNumberForPrint($modDetail->hargabeli);
        ?>
    </td>
	<td><?php echo $bidang; ?></td>
    <td><?php echo $kelompok; ?></td>
    <td><?php echo $subkelompok; ?></td>
    <td><?php echo $subsubkelompok; ?></td>
    <td><?php echo $modBarang->barang_kode."/<br/>".$modBarang->barang_nama; ?></td>
	<td><?php echo CHtml::activeTextField($modDetail, '['.$key.']jmlterima', array('class'=>'span1 integer2 qty', 'onblur'=>'hitungSemua();' )); ?></td>
	<td><?php echo CHtml::activeDropDownList($modDetail, '['.$key.']satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
	<td><?php echo CHtml::activeTextField($modDetail, '['.$key.']jmldalamkemasan', array('empty'=>'-- Pilih --', 'class'=>'span1 jml', 'style'=>'text-align: right;')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '['.$key.']hargasatuan', array('class'=>'span2 integer2 satuan', 'onblur'=>'hitungSemua();')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '['.$key.']hargabeli', array('class'=>'span2 integer2 beli', 'onblur'=>'hitungSatuan();')); ?></td>
    <!--td><?php // echo CHtml::activeTextField($modDetail, '['.$key.']total', array('class'=>'span2 integer2 satuan', 'readonly'=>true)); ?></td-->
    <td><?php echo CHtml::activeDropDownList($modDetail, '['.$key.']kondisibarang', LookupM::getItems('inventariskeadaan'), array('class'=>'span2')); ?></td>
    <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        

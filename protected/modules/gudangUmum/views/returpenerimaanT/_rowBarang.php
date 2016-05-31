<?php 
if (isset($modDetails)){
foreach ($modDetails as $i=>$detail){?>
<?php $modBarang = BarangM::model()->findByPk($detail->terimapersdetail->barang->barang_id); ?>
    <tr>   
        <td><?php  
            echo CHtml::activeHiddenField($detail, '['.$i.']terimapersdetail_id');
            $gol = $modBarang->subsubkelompok->subkelompok->kelompok;
            echo $gol->bidang->bidang_nama;
            ?>
        </td>
        <td><?php echo $modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama; ?></td>
        <td><?php echo $modBarang->subsubkelompok->subkelompok->subkelompok_nama; ?></td>
        <td><?php echo $modBarang->subsubkelompok->subsubkelompok_nama; ?></td>
        <td><?php echo $modBarang->barang_nama; ?></td>
        <td>
        <?php 
            $detail->hargasatuan = MyFormatter::formatNumberForPrint($detail->hargasatuan);

            echo CHtml::activeTextField($detail, '['.$i.']hargasatuan', array('class'=>'span2 integer2 satuan', 'readonly'=>true, 'style'=>'text-align: right;'));
            echo '<br/>';
            echo CHtml::error($detail, '['.$i.']hargasatuan');
        ?>
        </td>
        <td>
        <?php 
            echo CHtml::activeTextField($detail, '['.$i.']jmlterima', array('class'=>'span1 numbersOnly terima', 'readonly'=>true, 'style'=>'text-align: right;'));
            echo '<br/>';
            echo CHtml::error($detail, '['.$i.']jmlterima');
        ?>
        </td>
        <td>
        <?php 
            echo CHtml::activeTextField($detail, '['.$i.']jmlretur', array('class'=>'span1 numbersOnly retur', 'onblur'=>'cekRetur(this);', 'style'=>'text-align: right;'));
            echo '<br/>';
            echo CHtml::error($detail, '['.$i.']jmlterima');
        ?>
        </td>
        <td><?php echo CHtml::activeDropDownList($detail, '['.$i.']satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
        <td style="text-align: right;"><?php echo $modBarang->barang_jmldlmkemasan ; ?>
            </td>
            <td><?php echo CHtml::activeDropDownList($detail, '['.$i.']kondisibarang', LookupM::getItems('inventariskeadaan'),array('class'=>'span2')); ?></td>
        <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
    </tr>   
<?php }
}
?>
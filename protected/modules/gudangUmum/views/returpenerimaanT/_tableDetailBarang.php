<?php echo CHtml::css('#tableDetailBarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-striped table-condensed" id="tableDetailBarang">
    <thead>
        <tr>
            <th>Golongan</th>
            <th>Kelompok</th>
            <th>Sub Kelompok</th>
            <th>Bidang</th>
            <th>Barang</th>
            <th>Harga Satuan</th>
            <th>Jumlah Terima</th>
            <th>Jumlah Retur</th>
            <th>Satuan</th>
            <th>Jumlah Dalam Kemasan</th>
            <th>Kondisi Barang</th>
            <th>Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (isset($modDetails)){
        foreach ($modDetails as $i=>$detail){?>
        <?php $modBarang = BarangM::model()->findByPk($detail->terimapersdetail->barang->barang_id); ?>
            <tr>   
                <td><?php  
                    echo CHtml::activeHiddenField($detail, '['.$i.']terimapersdetail_id');
                    echo $modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama; 
                    ?>
                </td>
                <td><?php echo $modBarang->bidang->subkelompok->kelompok->kelompok_nama; ?></td>
                <td><?php echo $modBarang->bidang->subkelompok->subkelompok_nama; ?></td>
                <td><?php echo $modBarang->bidang->bidang_nama; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']hargasatuan', array('class'=>'span1 numbersOnly satuan', 'readonly'=>true));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']hargasatuan');
                ?>
                </td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']jmlterima', array('class'=>'span1 numbersOnly terima', 'readonly'=>true));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']jmlterima');
                ?>
                </td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']jmlretur', array('class'=>'span1 numbersOnly retur', 'onblur'=>'cekRetur(this);'));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']jmlterima');
                ?>
                </td>
                <td><?php echo CHtml::activeDropDownList($detail, '['.$i.']satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
                <td><?php echo $modBarang->barang_jmldlmkemasan ; ?>
                    </td>
                    <td><?php echo CHtml::activeDropDownList($detail, '['.$i.']kondisibarang', LookupM::getItems('inventariskeadaan'),array('class'=>'span2')); ?></td>
                <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
            </tr>   
        <?php }
        }
        ?>
    </tbody>
</table>


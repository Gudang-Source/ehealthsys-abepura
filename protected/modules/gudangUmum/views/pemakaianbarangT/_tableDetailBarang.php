<?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-striped table-condensed" id="table-detailbarang">
    <thead>
        <tr>
            <th>Kode Barang</th>
            <th>Tipe Barang</th>
            <th>Nama Barang</th>
            <th>Merk / No. Seri</th>
            <th>Ukuran / Bahan Barang</th>
            <th>Harga Netto</th>
            <th>Harga Satuan</th>
            <th>Jumlah Pakai</th>
            <th>Satuan</th>
            <!-- <th>Jumlah Dalam Kemasan</th> -->
            <th>Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (isset($modDetails)){
        foreach ($modDetails as $i=>$detail){?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr>   
                <td><?php 
                    echo CHtml::activeHiddenField($detail, '['.$i.']barang_id',array('class'=>'barang')); 
                    echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama:null; 
                    ?>
                </td>
                <td><?php echo !empty($modBarang->bidang_id)? $modBarang->bidang->subkelompok->kelompok->kelompok_nama:null; ?></td>
				<td><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->subkelompok_nama:null; ?></td>
				<td><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->bidang_nama:null; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']harganetto', array('class'=>'span1 integer mutasi', 'onblur'=>'cekStok(this);'));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']harganetto');
                ?>
                </td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']hargajual', array('class'=>'span1 integer mutasi', 'onblur'=>'cekStok(this);'));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']hargajual');
                ?>
                </td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']jmlpakai', array('class'=>'span1 integer qty', 'onblur'=>'cekStok(this);'));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']jmlpakai');
                ?>
                </td>
                <td><?php echo CHtml::activeDropDownList($detail, '['.$i.']satuanpakai', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
                <!-- <td><?php //echo CHtml::activeTextField($detail, '['.$i.']jmldlmkemasan', array('class'=>'span1 integer qty', 'onblur'=>'cekStok(this);'));
                    //echo '<br/>';
                    //echo $form->error($detail, '['.$i.']jmlpakai'); ?></td> -->
                <td><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
            </tr>   
        <?php }
        }
        ?>
    </tbody>
</table>
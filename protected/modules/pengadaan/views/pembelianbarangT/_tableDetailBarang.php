<?php echo CHtml::css('#tableDetailBarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-striped table-condensed" id="tableDetailBarang">
    <thead>
        <tr>
           <!-- <th>Golongan</th>
            <th>Bidang</th>
            <th>Kelompok</th>
            <th>Sub Kelompok</th>
            <th>Sub Sub Kelompok</th>                        -->
            <th>Tipe Barang</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Merk</th>    
            <th>Ukuran</th>
            <th>Tahun Ekonomis</th>
            <th>Isi Dalam Kemasan</th>
            <th>Jumlah Permintaan</th>    
            <th>Harga Satuan (Rp)</th>    
            <th>Harga Beli (Rp)</th>
            <!--<th>Satuan</th>            -->
            
			<?php if ($model->isNewRecord) { ?>
            <th>Batal</th>
			<?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (isset($modDetails)){
        foreach ($modDetails as $i=>$detail){?>
        <?php 
            $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr>   
                <!--<td><?php 
                   // 
                         // echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan->golongan_nama:null; 
                    ?>
                </td>
                <td><?php //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok_id->subkelompok->kelompok->bidang->bidang_nama:null; ?></td>
                <td><?php //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok_id->subkelompok->kelompok->kelompok_nama:null; ?></td>
                <td><?php// echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok_id->subkelompok->subkelompok_nama:null; ?></td>
                <td><?php //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok_id->subsubkelompok_id_nama:null; ?></td>-->
                <td>
                    <?php echo CHtml::activeHiddenField($detail, '['.$i.']barang_id',array('class'=>'barang')); ?>
                    <?php echo CHtml::activeHiddenField($detail, '['.$i.']satuanbeli');  ?>
                    <?php echo $modBarang->barang_type; ?></td>
                <td><?php echo $modBarang->barang_kode; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td><?php echo $modBarang->barang_merk; ?></td>
                <td><?php echo $modBarang->barang_ukuran; ?></td>
                <td><?php echo $modBarang->barang_ekonomis_thn; ?></td>
                <td><?php echo CHtml::activeTextField($detail, '['.$i.']jmldlmkemasan', array('class'=>'span1 numbers-only qty', 'onchange'=>'hitungTotal(this);', 'style'=>'text-align: right;'));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']jmlbeli'); ?></td>                
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']jmlbeli', array('class'=>'span1 numbers-only qty', 'onblur'=>'hitungTotal(this);', 'style'=>'text-align: right;')).' '.$modBarang->barang_satuan;
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']jmlbeli');
                ?>
                </td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']hargasatuan', array('class'=>'span2 integer2 satuan', 'onblur'=>'hitungTotal(this);', 'style'=>'text-align: right;'));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']hargasatuan');
                ?>
                </td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']hargabeli', array('class'=>'span2 integer2 beli', 'onblur'=>'hitungTotal(this);', 'style'=>'text-align: right;'));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']hargabeli');
                ?>
                </td>
              <!--  <td><?php //echo CHtml::activeDropDownList($detail, '['.$i.']satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>                -->
				<?php if ($model->isNewRecord) { ?>
                <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
				<?php } ?>
            </tr>   
        <?php }
        }
        ?>
    </tbody>
</table>
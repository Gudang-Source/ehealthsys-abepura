<?php echo CHtml::css('#tableDetailBarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-striped table-condensed" id="tableDetailBarang">
    <thead>
        <tr>
            <th>Golongan</th>
            <th>Kelompok</th>
            <th>Sub Kelompok</th>
            <th>Bidang</th>
            <th>Barang</th>
            <th>Harga Beli</th>
            <th>Harga Satuan</th>
            <?php if (!empty($modBeli->pembelianbarang_id)) { ?>
            <th>Jumlah Beli</th>
            <?php } ?>
            <th>Jumlah Terima</th>
            <th>Satuan</th>
            <th>Ukuran<br/>Bahan</th>
            <th>kondisi Barang</th>
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
                    echo CHtml::activeTextField($detail, '['.$i.']hargabeli', array('class'=>'span2 numbersOnly', 'onblur'=>'setTotalHarga();',  'readonly'=>true, 'style'=>'text-align: right;'));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']hargabeli');
                ?>
                </td>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']hargasatuan', array('class'=>'span2 numbersOnly satuan', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;'));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']hargasatuan');
                ?>
                </td>
                <?php if (isset($modBeli)) { ?>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']jmlbeli', array('class'=>'span1 numbersOnly beli', 'readonly'=>true, 'style'=>'text-align: right;'));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']jmlbeli');
                ?>
                </td>
                <?php } ?>
                <td>
                <?php 
                    echo CHtml::activeTextField($detail, '['.$i.']jmlterima', array('class'=>'span1 numbersOnly qty', 'onblur'=>'setTotalHarga();'.(isset($modBeli)) ?'cekTerima(this)':'', 'style'=>'text-align: right;'));
                    echo '<br/>';
                    echo $form->error($detail, '['.$i.']jmlterima');
                ?>
                </td>
                <td><?php echo CHtml::activeDropDownList($detail, '['.$i.']satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
                <td><?php echo CHtml::activeTextField($detail, '['.$i.']jmldalamkemasan', array( 'class'=>'span1')); ?></td>
                <td><?php echo CHtml::activeDropDownList($detail, '['.$i.']kondisibarang', LookupM::getItems('inventariskeadaan'), array('class'=>'span2')); ?></td>
                
                <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
            </tr>   
        <?php }
        }
        ?>
    </tbody>
</table>

<?php if (isset($modBeli)){
$js2 =<<< JS
    function cekTerima(obj){
        beli = $(obj).parents('tr').find('.beli').val();
        terima = $(obj).val();
        if (terima > beli){
            myAlert('Jumlah Terima tidak boleh lebih dari yang di Beli');
            $(obj).val(beli);
            return false;
        }
    }
JS;

Yii::app()->clientScript->registerScript('tes', $js2, CClientScript::POS_HEAD); 
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<br>
<fieldset>
    <legend>Data Faktur</legend>
    <table class="table table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modFakturBeli, 'tglfaktur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[tglfaktur]', $modFakturBeli->tglfaktur, array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modFakturBeli, 'tgljatuhtempo',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[tgljatuhtempo]', $modFakturBeli->tgljatuhtempo, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modFakturBeli, 'totalhargabruto',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[totalhargabruto]', number_format($modFakturBeli->totalhargabruto), array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modFakturBeli, 'nofaktur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPasienM[nofaktur]', $modFakturBeli->nofaktur, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modFakturBeli, 'supplier_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[supplier_id]', (!empty($modFakturBeli->supplier_id)?$modFakturBeli->supplier->supplier_nama:"-"), array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modFakturBeli, 'keteranganfaktur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textArea('FAPasienM[keteranganfaktur]', $modFakturBeli->keteranganfaktur, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::label('No. Penerimaan','',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('', (!empty($modFakturBeli->penerimaanbarang_id)?$modFakturBeli->penerimaanbarang->noterima:"-"), array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::label('No. PO','',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('', isset($modFakturBeli->penerimaanbarang->permintaanpembelian->nopermintaan)?$modFakturBeli->penerimaanbarang->permintaanpembelian->nopermintaan:'', array('readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset> 

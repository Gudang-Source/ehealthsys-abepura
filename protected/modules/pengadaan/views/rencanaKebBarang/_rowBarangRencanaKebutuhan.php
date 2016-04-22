<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]barang_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]harga_barangdet',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]minstok_barangdet',array('readonly'=>true,'class'=>'span1')); ?>                
        <?php echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]makstok_barangdet',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]stokakhir_barangdet',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>		
    </td>
    <td>
        <span><?php echo (!empty($modRencanaDetailKebBarang->asal_barang) ? $modRencanaDetailKebBarang->asal_barang : "") ?></span> 
	</td>
	<td>
		<span><?php echo (!empty($modRencanaDetailKebBarang->barang_nama) ? $modRencanaDetailKebBarang->barang_nama : "") ?></span>
	</td>	
    <td>
        <?php echo CHtml::activeDropDownList($modRencanaDetailKebBarang, '[ii]satuanbarangdet', LookupM::getItems('satuanbarang'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;')); ?><br>     
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]jmlpermintaanbarangdet',array('readonly'=>false,'class'=>'span2 integer','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]harga_barang',array('readonly'=>false,'class'=>'span2 integer','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]minstok_barangdet',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:45px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]makstok_barangdet',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:45px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]stokakhir_barangdet',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:45px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
    </td>
	<td>
        <a onclick="batalBarang(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>
<?php //$this->renderPartial($this->path_view.'_jsFunctions', array('modRencanaKebFarmasi'=>$modRencanaKebFarmasi,'modRencanaDetailKeb'=>$modRencanaDetailKebBarang)); ?>
<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]dekontaminasi_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]penerimaansterilisasi_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]ruangan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]barang_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeCheckBox($penerimaan,'[ii]checklist', array('class'=>'checklist','onclick'=>'setNol(this);')); ?>
    </td>
	<td>
        <span><?php echo (!empty($penerimaan->ruangan_nama) ? $penerimaan->ruangan_nama : "") ?></span>
    </td>
    <td>
        <span><?php echo (!empty($penerimaan->penerimaansterilisasi_tgl) ? MyFormatter::formatDateTimeForUser($penerimaan->penerimaansterilisasi_tgl) : "") ?>/<br><?php echo (!empty($penerimaan->penerimaansterilisasi_no) ? $penerimaan->penerimaansterilisasi_no : "") ?></span>
    </td>    
    <td>
        <span><?php echo (!empty($penerimaan->barang_nama) ? $penerimaan->barang_nama : "") ?></span>
    </td>
	<td>
        <?php echo CHtml::activeTextField($penerimaan,'[ii]sterilisasidetail_jml',array('readonly'=>false,'class'=>'span2 integer','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
        <?php echo CHtml::activeTextArea($penerimaan,'[ii]sterilisasidetail_ket',array('readonly'=>false,'class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
        <?php echo CHtml::activeDropDownList($penerimaan, '[ii]jenissterilisasi_id', CHtml::listData(STJenissterilisasiM::model()->findAll(),'jenissterilisasi_id','jenissterilisasi_nama'),array('style'=>'width:80px;')); ?>
    </td>
	<td>
        <?php echo CHtml::activeDropDownList($penerimaan, '[ii]alatmedis_id', CHtml::listData(STAlatmedisM::model()->findAll(),'alatmedis_id','alatmedis_nama'),array('style'=>'width:80px;')); ?>
    </td>
	<?php if(!empty($penerimaan->sterilisasidetail_id)){ ?>
	<td>
		<ol type="1">
		<?php 
			$modSterilisasiBahan = STSterilisasibahanT::model()->findAllByAttributes(array('sterilisasidetail_id'=>$penerimaan->sterilisasidetail_id));
			foreach($modSterilisasiBahan as $a=>$bahan){ ?>
			<li><?php echo $bahan->bahansterilisasi->bahansterilisasi_nama; ?></li>
		<?php } ?>
			</ol>
	</td>
	<?php }else{ ?>
		<td>
			<div style="display:block;">
				<?php echo CHtml::activeDropDownList($penerimaan, '[ii]bahansterilisasi_nama', array(),array('class'=>'fcbkcomplete hide')); ?>
			</div>
		</td>
	<?php } ?>
	<td>
        <?php echo CHtml::activeTextField($penerimaan, '[ii]kemasanygdigunakan',array('class'=>'span2')); ?>
    </td>
	<td>
		<div class="input-append">
			<?php echo CHtml::activeTextField($penerimaan, '[ii]waktukadaluarsa', array('readonly'=>true,'class'=>'tanggal dtPicker2 datemask', 'style'=>'float:left;')); ?>
			<span class="add-on"><i class="icon-calendar"></i></span>
		</div>
	</td>	
</tr>
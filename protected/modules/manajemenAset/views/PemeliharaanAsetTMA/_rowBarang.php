<?php $detail->pemeliharaanasetdet_tgl = (!empty($detail->pemeliharaanasetdet_tgl) ? MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($detail->pemeliharaanasetdet_tgl))) : null); ?>
<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activehiddenField($detail,'[ii]invgedung_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($detail,'[ii]invasetlain_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activehiddenField($detail,'[ii]inventarisasi_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activehiddenField($detail,'[ii]invperalatan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activehiddenField($detail,'[ii]barang_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activehiddenField($detail,'[ii]kategori_aset',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activehiddenField($detail,'[ii]kode_aset',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activehiddenField($detail,'[ii]nama_aset',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activehiddenField($detail,'[ii]asal_aset',array('readonly'=>true,'class'=>'span1')); ?>		
        <?php echo CHtml::activehiddenField($detail,'[ii]pemeliharaanaset_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activehiddenField($detail,'[ii]pemeliharaanasetdet_tgl',array('readonly'=>true,'class'=>'span1')); ?>        
        <?php //echo CHtml::activehiddenField($detail,'[ii]kondisiaset',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activehiddenField($detail,'[ii]keteranganaset',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeCheckBox($detail,'[ii]checklist', array('class'=>'checklist','onclick'=>'setNol(this,'.$no.');')); ?>
    </td>
	<td>
        <span><?php echo (!empty($detail->barang_id) ? $detail->barang_id : "") ?></span>
    </td>  
	<td>
        <span><?php echo (!empty($detail->kategori_aset) ? $detail->kategori_aset : "") ?></span>
    </td>
	<td>
        <span><?php echo (!empty($detail->kode_aset) ? $detail->kode_aset : "") ?></span>
    </td>      
    <td>
        <span><?php echo (!empty($detail->nama_aset) ? $detail->nama_aset : "") ?></span>
    </td>	
	<td>
		<?php   
				//$detail->pemeliharaanasetdet_tgl = (!empty($detail->pemeliharaanasetdet_tgl) ? date("Y-m-d",strtotime($detail->pemeliharaanasetdet_tgl)) : null);
				/*$this->widget('MyDateTimePicker',array(
					'model'=>$detail,
					'attribute'=>'[ii]pemeliharaanasetdet_tgl',
					'mode'=>'date',
					'options'=> array(
						'showOn' => false,
						'yearRange'=> "-150:+0",
					),
					'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
					),
			));<a href='#' onclick = "$('#dialogDetailsTarif').dialog('open')">asdasdas</a>*/                              
                            
                           echo    $this->renderPartial($this->path_view.'_waktu', array('detail'=>$detail,'no'=>$no), false, true);
                                ?>
                           
                                <?php
                                ?>        
    </td>
	<td>
        <?php 
                        //echo CHtml::activeDropDownList($detail, '[ii]waktuAset', CHtml::listData(MALookupM::jenis(),'lookup_id','lookup_name'),array('empty'=>'Kodisi Aset', 'style'=>'width:80px;'));
			echo CHtml::activeDropDownList($detail, '[ii]kondisiaset', CHtml::listData(MALookupM::jenis(),'lookup_id','lookup_name'),array('empty'=>'-- Pilih --', 'style'=>'width:80px;','class'=>'required'));
		?>
    </td>
	
    <td>
        <?php 
			echo CHtml::activetextField($detail,'[ii]keteranganaset',array('onkeyup'=>"return $(this).focusNextInputField(event);")); 
		?>
    </td>
</tr>
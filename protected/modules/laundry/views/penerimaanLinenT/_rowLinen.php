<tr>
        <td style="width:30px;"><?php echo $i+1; ?></td>
        <td>
                <?php echo CHtml::activeHiddenField($detail,'['.$i.']linen_id',array('readonly'=>true));?>
                <?php echo $detail->linen->noregisterlinen; ?>
        </td>
        <td><?php echo $detail->linen->namalinen; ?></td>
        <td>
                <?php echo CHtml::activeDropDownList($detail, '['.$i.']jenisperawatan', LookupM::getItems('jenisperawatan'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?>
        </td>
        <td>
                <?php echo CHtml::activeTextField($detail,'['.$i.']keterangan_pengperawatan',array('readonly'=>true));?>
        </td>
<!--			<td>
                <a onclick="batalLinen(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan linen"><i class="icon-remove"></i></a>
        </td>-->
</tr>

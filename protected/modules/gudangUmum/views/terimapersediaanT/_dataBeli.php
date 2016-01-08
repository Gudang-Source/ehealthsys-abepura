<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modBeli, 'nopembelian', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modBeli, 'nopembelian', array('readonly'=>false))
                    ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modBeli, 'tglpembelian', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modBeli, 'tglpembelian', array('readonly'=>false))
                    ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modBeli, 'supplier_id', array('class'=>'control-label')) ?>
                <div class="controls">
				
                    <?php
						echo CHtml::activeDropDownList($modBeli,'supplier_id', CHtml::listData(SupplierM::model()->findAll('supplier_aktif = true'), 'supplier_id', 'supplier_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                    ?>
                </div>
            </div>
        </td>
    </tr>
</table>
<fieldset class="box">
    <legend class="rim">Data Supplier</legend>
    <table width="100%" class="table-condensed">
        <tr>            
            <td>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_nama',array('class'=>'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modSupplier,'supplier_id', array('readonly'=>true)); ?>
                    <div class="controls">
                        <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            'model'=>$modSupplier,
                                            'attribute'=>'supplier_nama',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('keuangan/BayarUangMukaBeli/daftarSupplier').'",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                             'options'=>array(
                                                   'showAnim'=>'fold',
                                                   'minLength' => 2,
                                                   'focus'=> 'js:function( event, ui ) {
                                                        $(this).val(""); //SUPAYA TERLIHAT DATA SUDAH TERPILIH ATAU BELUM
                                                        return false;
                                                    }',
                                                   'select'=>'js:function( event, ui ) {
                                                        isiDataSupplier(ui.item);
                                                        return false;
                                                    }',
                                            ),
                                        )); 
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_alamat',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modSupplier,'supplier_alamat', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_website',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modSupplier,'supplier_website', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_email',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modSupplier,'supplier_email', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_kode',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activetextField($modSupplier,'supplier_kode', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_telp',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modSupplier,'supplier_telp', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_fax',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modSupplier,'supplier_fax', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td> 
        </tr>
<!--             <td><?php //echo CHtml::activeLabel($modSupplier, 'supplier_npwp',array('class'=>'control-label')); ?></td>
            <td><?php //echo CHtml::activeTextField($modSupplier,'supplier_npwp', array('readonly'=>true)); ?></td> -->
    </table>
</fieldset> 

<script type="text/javascript">
function isiDataSupplier(data)
{
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_kode');?>').val(data.supplier_kode);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_alamat');?>').val(data.supplier_alamat);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_telp');?>').val(data.supplier_telp);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_npwp');?>').val(data.supplier_npwp);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_fax');?>').val(data.supplier_fax);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_website');?>').val(data.supplier_website);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_email');?>').val(data.supplier_email);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_id');?>').val(data.supplier_id);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_nama');?>').val(data.value);
    
    $('#KUTandabuktikeluarT_namapenerima').val(data.supplier_nama);
    $('#KUTandabuktikeluarT_alamatpenerima').val(data.supplier_alamat);
        
    $('.currency').each(function(){this.value = formatNumber(this.value)})
}
</script>
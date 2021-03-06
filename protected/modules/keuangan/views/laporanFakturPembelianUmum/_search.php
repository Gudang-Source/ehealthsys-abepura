<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'searchLaporan',
        'type'=>'horizontal',
)); ?>
<style>

        #penjamin label.checkbox{
            width: 350px;
            display:inline-block;
        }
		label.checkbox{
			width:200px;
			display:inline-block;
		}
    </style>  
<div class = "row-fluid">
     <div class="span4">
                    <?php $format = new MyFormatter(); ?>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php echo $form->hiddenField($model, 'filter', array('readonly'=>'TRUE')); ?>
                    <?php echo CHtml::label('Tanggal Faktur', 'tgl_pendaftaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
                    </div>
                </div>
                <div class="span4">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">  
                            <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
                        </div> 

                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_awal',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
                        </div> 
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="span4">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">  
                            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                        </div> 
                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls"> 
                            <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_akhir',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
                        </div> 
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </div>
         <table width="100%" border="0">
                <tr>
                <td> 
                    <div id='searching'>
                    <fieldset>    
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'kunjungan',
                            'slide'=>true,
                            'content'=>array(
                            'content2'=>array(
                                'header'=>'Berdasarkan Supplier',
                                'isi'=>  
                                        CHtml::checkBox('cek_all', true, array("id"=>"checkSemuaid",'value'=>'cek', "onclick"=>"checkSemua()")).'Pilih Semua <br\>                                             
                                            <table class="penjamin">                                            
                                            <tr>
                                                    <td>'.
                                                           $form->checkBoxList($model, 'supplier_id', CHtml::listData(SupplierM::model()->findAll("supplier_aktif = TRUE ORDER BY supplier_nama ASC"), 'supplier_id', 'supplier_nama'))
                                                    .'</td>
                                            </tr>
                                            </table>',            
                                'active'=>false,
                                    ),
                            ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>											
                    </fieldset>	
                    </div>
                </td>
                <td>
                     &nbsp;
                </td>
                </tr>
            </table>
	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                Yii::app()->createUrl($this->route), 
                array('class'=>'btn btn-danger')); ?>
            <?php  
//                $content = $this->renderPartial('../tips/informasi',array(),true);
//                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
$( document ).ready(function(){
    checkSemua();
    $("#kunjungan").on("hide.bs.collapse", function(){
        $("#KUInformasifakturumumV_filter").val("");
    });
    $("#kunjungan").on("show.bs.collapse", function(){
        $("#KUInformasifakturumumV_filter").val("supplier");
    });
}); 
    
function checkSemua() {
    if ($("#checkSemuaid").is(":checked")) {
        $('.penjamin input[name*="KUInformasifakturumumV"]').each(function(){
           $(this).attr('checked',true);
        })
    } else {
       $('.penjamin input[name*="KUInformasifakturumumV"]').each(function(){
           $(this).removeAttr('checked');
        })
    }
            //setAll();
}
</script>
<?php $this->renderPartial('billingKasir.views.laporan._jsFunctions', array('model' => $model)); ?>

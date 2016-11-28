<fieldset id="panel-partograf" hidden>
    <fieldset class='box'>
        <legend class='rim'>Pemeriksaan Partograf</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo Chtml::label('Waktu Pemeriksaan', 'gin_keluhan', array('class' => 'control-label')) ?>
                        <div class="controls">
                             <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modGinekologi,
                                'attribute' => 'tglperiksaobgyn',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));                            
                            ?>                            
                            <?php echo $form->error($modGinekologi, 'tglperiksaobgyn'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group ">
                        <?php echo Chtml::label('Ketuban Pecah', 'gin_keluhan', array('class' => 'control-label')) ?>
                        <div class="controls">
                             <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modGinekologi,
                                'attribute' => 'tglperiksaobgyn',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));                            
                            ?>                            
                            <?php echo $form->error($modGinekologi, 'tglperiksaobgyn'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group ">
                        <?php echo Chtml::label('Mules', 'gin_keluhan', array('class' => 'control-label')) ?>
                        <div class="controls">
                             <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modGinekologi,
                                'attribute' => 'tglperiksaobgyn',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));                            
                            ?>                            
                            <?php echo $form->error($modGinekologi, 'tglperiksaobgyn'); ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("DJJ",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('class'=>'numbers-only span1', 'style' => 'text-align:right;')).' /menit'; ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Air Ketuban",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modGinekologi, 'gin_jmlkawin_kali', LookupM::getItems('jeniskelamin'), array('class'=>'span2', 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Penyusupan",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modGinekologi, 'gin_jmlkawin_kali',  LookupM::getItems('jeniskelamin'),array('class'=>'span2', 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Pembukaan",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')); ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Penurunan",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')); ?>
                        </div>
                    </div>
                    
                    <br/>
                    
                    <!--kontraksi-->
                    <div class = "control-group">
                        <?php echo Chtml::label("KONTRAKSI :",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">                            
                        </div>
                    </div>
                    
                                         
                    <div class = "control-group">
                        <?php echo Chtml::label("Jumlah",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')); ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Lama",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modGinekologi, 'gin_jmlkawin_kali', LookupM::getItems('jeniskelamin'), array('class'=>'span2', 'empty' => '-- Pilih --')).' detik'; ?>
                        </div>
                    </div>
                    <br/>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Oksitosin",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')).' unit'; ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Tetes",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')).' /menit'; ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Obat / Cairan",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php  
                                 echo CHtml::hiddenField('obatalkes_id'); 
                                $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'obatalkes_nama',
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.$this->createUrl('AutocompleteObatAlkes').'",
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
                                                $(this).val("");
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                $("#obatalkes_id").val(ui.item.obatalkes_id);
                                                $("#obatalkes_nama").val(ui.item.obatalkes_nama);
                                                return false;
                                            }',
                                    ),
                                    'htmlOptions'=>array(
                                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                                        'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); '
                                    ),
                                    'tombolDialog'=>array('idDialog'=>'dialogObatAlkes'),
                                )); 
                               ?>
                            
                        </div>
                    </div>
                </td> 
                <td>
                  
                    <div class = "control-group">                        
                        <div class="controls">
                            <?php echo Chtml::label("TEKANAN DARAH :",'djj', array('style' => 'margin:80px;'));  ?>
                            <?php //echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')).' /menit'; ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("mm",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php 
                            echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
                            echo Chtml::label("Hg",'djj', array()).'&nbsp;&nbsp;'; 
                            echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')).'&nbsp;&nbsp;&nbsp;'; 
                            ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Nadi",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php 
                            echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;'));                             
                            ?>
                        </div>
                    </div>
                    <br/>
                    
                     <div class = "control-group">                        
                        <div class="controls">
                            <?php echo Chtml::label("URINE :",'djj', array('style' => 'margin:80px;'));  ?>
                            <?php //echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')).' /menit'; ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Protein",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php 
                                echo $form->dropDownList($modGinekologi, 'gin_jmlkawin_kali', LookupM::getItems('jeniskelamin'), array('class'=>'span2', 'empty' => '-- Pilih --')).' detik';
                            ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Aseton",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php 
                                echo $form->dropDownList($modGinekologi, 'gin_jmlkawin_kali', LookupM::getItems('jeniskelamin'), array('class'=>'span2', 'empty' => '-- Pilih --')).' detik';
                            ?>
                        </div>
                    </div>
                    
                     <div class = "control-group">
                        <?php echo Chtml::label("Volume",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php 
                                echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')).' cc';                             
                            ?>
                        </div>
                    </div>
                </td>
            </tr>           
        </table>
    </fieldset>
</fieldset>
<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatAlkes',
    'options'=>array(
        'title'=>'Daftar Stok Ruangan -'.Yii::app()->user->getState('ruangan_nama').'-',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>620,
        'resizable'=>false,
    ),
));
$format = new MyFormatter();
$modObatAlkes = new PSInfostokobatalkesruanganV('searchDialogMutasi');
$modObatAlkes->unsetAttributes();
$modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modObatAlkes->instalasi_id = Yii::app()->user->getState('instalasi_id');
if(isset($_GET['PSInfostokobatalkesruanganV'])){
    $modObatAlkes->attributes = $_GET['PSInfostokobatalkesruanganV'];
    $modObatAlkes->obatalkes_kode = isset($_GET['PSInfostokobatalkesruanganV']['obatalkes_kode']) ? $_GET['GFInfostokobatalkesruanganV']['obatalkes_kode'] : null;
    $modObatAlkes->jenisobatalkes_nama = isset($_GET['PSInfostokobatalkesruanganV']['jenisobatalkes_nama']) ? $_GET['GFInfostokobatalkesruanganV']['jenisobatalkes_nama'] : null;
    $modObatAlkes->satuankecil_nama = isset($_GET['PSInfostokobatalkesruanganV']['satuankecil_nama']) ? $_GET['GFInfostokobatalkesruanganV']['satuankecil_nama'] : null;
    $modObatAlkes->tglkadaluarsa = isset($_GET['PSInfostokobatalkesruanganV']['tglkadaluarsa']) ? $format->formatDateTimeForDb($_GET['GFInfostokobatalkesruanganV']['tglkadaluarsa']) : null;
}

$provider = $modObatAlkes->searchDataObat();
$provider->sort->defaultOrder = 'obatalkes_nama asc';

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'obatalkes-m-grid',
	'dataProvider'=>$modObatAlkes->searchDataObat(),
	'filter'=>$modObatAlkes,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
                ),
                array(
                    'header'=>'Jenis Obat Alkes',
                    'name'=>'jenisobatalkes_id',
                    'type'=>'raw',
                    'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes_nama : "")',
                    'filter'=>  CHtml::activeDropDownList($modObatAlkes, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll(array(
                        'condition'=>'jenisobatalkes_aktif = true',
                        'order'=>'jenisobatalkes_nama'
                    )), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --')),
                ),
                
                array(
                    'name'=>'obatalkes_kategori',
                    'filter'=> CHtml::activeDropDownList($modObatAlkes, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --'))
                ),
                array(
                    'name'=>'obatalkes_golongan',
                    'filter'=> CHtml::activeDropDownList($modObatAlkes, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --'))
                ),
                'obatalkes_kode',
                'obatalkes_nama',
                //'obatalkes_kategori',
                //'obatalkes_golongan',
                // 'nobatch',
		array(
                    'header'=>'Tgl Kadaluarsa',
                    'name'=>'tglkadaluarsa',
                    'type'=>'raw',
                    'value'=>'(!empty($data->tglkadaluarsa) ? MyFormatter::formatDateTimeForUser($data->tglkadaluarsa) : "")',
                    'filter'=>$this->widget('MyDateTimePicker',array(
						'model'=>$modObatAlkes,
						'attribute'=>'tglkadaluarsa',
						'mode'=>'date',
						'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
						),
						'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3 datemask','placeholder'=>'00/00/0000', 'id'=>'tglkadaluarsa'),
						),true
					),
                ), /*
                array(
                    'name'=>'satuankecil_id',
                    'type'=>'raw',
//                    'value'=>'isset($data->satuankecil->satuankecil_nama) ? $data->satuankecil->satuankecil_nama : isset($data->satuankecil_nama) ? $data->satuankecil_nama : ""',
                    'value'=>'$data->satuankecil_nama',
                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama'),
                ), */
		// dicomment karena RND-5732
//                array(
//                    'name'=>'hargajual',
//                    'type'=>'raw',
//                    'value'=>'"Rp.".MyFormatter::formatNumberForPrint($data->hargajual)',
//                    'filter'=>false,
//                ),
                array(
                    'header'=>'Jumlah Stok',
                    'value'=>function($data) {
                        //$stok = StokobatalkesT::model()->findAllByAttributes(array(
                          //  'obatalkes_id'=>$data->obatalkes_id,
                            //'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                        //));
    
                        $r = Yii::app()->user->getState('ruangan_id');
    
                        $criteria = new CDbCriteria();
                        $criteria->compare('obatalkes_id',$data->obatalkes_id);
                        $criteria->addCondition("tglkadaluarsa = '".MyFormatter::formatDateTimeForDb($data->tglkadaluarsa)."' ");
                      //  if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GUDANG_FARMASI)
                       // {
                            $criteria->addCondition("ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
                        //}
                        $stok = StokobatalkesT::model()->findAll($criteria);
                        $total = 0;
                        foreach ($stok as $item) {
                            $total += $item->qtystok_in - $item->qtystok_out;
                        }
                        $satuan = ($data->satuankecil_nama==null)?$data->satuankecil->satuankecil_nama:$data->satuankecil_nama;

                        return $total." ".$satuan;

                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: right;'
                    )
                ),

                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			jQuery(\'#tglkadaluarsa\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tglkadaluarsa_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});}',
)); 

$this->endWidget();
?>
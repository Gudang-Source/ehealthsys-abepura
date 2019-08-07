<?php
    
?>
<div class='biru form_partograf' id = 'par0' data-id="<?php echo $id; ?>">
        <div class="white">
            <fieldset class='box fbase'>
        <legend class='rim'>Pemeriksaan Partograf</legend>
        <table width="100%" class="table-condensed" id='hapusPar'>
            <tbody>                        
            </tbody>
        </table>
        <table width="100%" class="table-condensed" id='statusPar'>
            <tr>
                <td>
                    <?php echo $form->hiddenField($modPartograf,'['.$id.']pemeriksaanpartograf_id') ?>
                    <?php echo $form->hiddenField($modPartograf,'['.$id.']persalinan_id') ?>                                        
                    <div class="control-group ">
                        <?php echo Chtml::label('Waktu Pemeriksaan', 'pto_tglperiksa', array('class' => 'control-label')) ?>
                        <div class="controls">
                             <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPartograf,
                                'attribute' => '['.$id.']pto_tglperiksa',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));                            
                            ?>                            
                            <?php echo $form->error($modPartograf, 'pto_tglperiksa'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group ">
                        <?php echo Chtml::label('Ketuban Pecah', 'pto_ketubanpecah', array('class' => 'control-label')) ?>
                        <div class="controls">
                             <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPartograf,
                                'attribute' => '['.$id.']pto_ketubanpecah',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));                            
                            ?>                            
                            <?php echo $form->error($modPartograf, 'pto_ketubanpecah'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group ">
                        <?php echo Chtml::label('Mules', 'pto_mules', array('class' => 'control-label')) ?>
                        <div class="controls">
                             <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPartograf,
                                'attribute' => '['.$id.']pto_mules',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));                            
                            ?>                            
                            <?php echo $form->error($modPartograf, 'pto_mules'); ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("DJJ",'pto_djj_menit', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->textField($modPartograf, '['.$id.']pto_djj_menit', array('class'=>'numbers-only span1', 'style' => 'text-align:right;')).' /menit'; ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Air Ketuban",'pto_airketuban', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPartograf, '['.$id.']pto_airketuban', LookupM::getItems('partografketuban'), array('class'=>'span2', 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Penyusupan",'pto_penyusupan', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPartograf, '['.$id.']pto_penyusupan',  LookupM::getItems('partografpenyusupan'),array('class'=>'span2', 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Pembukaan",'pto_pembukaan', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->textField($modPartograf, '['.$id.']pto_pembukaan', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')); ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Penutupan",'pto_penutupan', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->textField($modPartograf, '['.$id.']pto_penutupan', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')); ?>
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
                        <?php echo Chtml::label("Jumlah",'kontraksi_jml', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->textField($modPartograf, '['.$id.']kontraksi_jml', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')); ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Lama",'kontraksi_lama_detik', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPartograf, '['.$id.']kontraksi_lama_detik', LookupM::getItems('partograflama'), array('class'=>'span2', 'empty' => '-- Pilih --')).' detik'; ?>
                        </div>
                    </div>
                    <br/>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Oksitosin",'kontraksi_oksitosin_unit', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->textField($modPartograf, '['.$id.']kontraksi_oksitosin_unit', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')).' unit'; ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Tetes",'kontraksi_tetes_menit', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php echo $form->textField($modPartograf, '['.$id.']kontraksi_tetes_menit', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')).' /menit'; ?>
                        </div>
                    </div>
                    
                    <div class = "control-group input_oa">
                        <?php echo Chtml::label("Obat / Cairan",'djj', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php  
                                echo CHtml::hiddenField('obatalkes_id['.$id.']', '', array('class'=>'p_obatalkes_id')); 
                                $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'obatalkes_nama['.$id.']',
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
                                        'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); ',
										'class' => 'input_obatalkes_nama',
                                    ),
                                    'tombolDialog'=>array('idDialog'=>'dialogObatAlkes', 'jsFunction'=>'ubahNomor("'.$id.'")'),
                                )); 
                               ?>                                 
                              
                                       
                                   
                        </div>
                          <div class="controls">
                              <label>Qty</label>
                         <?php echo CHtml::textField('qty_input', '1', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer2 qty_oa')) ?>
                                        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                                array('onclick'=>'tambahObat(this);return false;',
                                                      'class'=>'btn btn-primary btn_tambah_oa',                                                      
                                                      'rel'=>"tooltip",
                                                      'id'=>"btn_input",
                                                      'title'=>"Klik untuk menambahkan obat / cariran",)); ?>
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
                        <?php echo Chtml::label("mm",'pto_systolic', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php 
                            echo $form->textField($modPartograf, '['.$id.']pto_systolic', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
                            echo Chtml::label("Hg",'pto_diastolic', array()).'&nbsp;&nbsp;'; 
                            echo $form->textField($modPartograf, '['.$id.']pto_diastolic', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')).'&nbsp;&nbsp;&nbsp;'; 
                            ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Nadi",'pto_tekanandarah', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php 
                            echo $form->textField($modPartograf, '['.$id.']pto_tekanandarah', array('class'=>'span3 numbers-only', 'style' => 'text-align:right;','readonly' => TRUE));                             
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
                        <?php echo Chtml::label("Protein",'urine_protein', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php 
                                echo $form->dropDownList($modPartograf, '['.$id.']urine_protein', LookupM::getItems('partografproteinaseton'), array('class'=>'span2', 'empty' => '-- Pilih --'));
                            ?>
                        </div>
                    </div>
                    
                    <div class = "control-group">
                        <?php echo Chtml::label("Aseton",'urine_aseton', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php 
                                echo $form->dropDownList($modPartograf, '['.$id.']urine_aseton', LookupM::getItems('partografproteinaseton'), array('class'=>'span2', 'empty' => '-- Pilih --'));
                            ?>
                        </div>
                    </div>
                    
                     <div class = "control-group">
                        <?php echo Chtml::label("Volume",'urine_volumen', array('class' => 'control-label'));  ?>
                        <div class="controls">
                            <?php 
                                echo $form->textField($modPartograf, '['.$id.']urine_volumen', array('class'=>'span1 numbers-only', 'style' => 'text-align:right;')).' cc';                             
                            ?>
                        </div>
                    </div>
                </td>
            </tr>           
        </table>
        
        <div class="block-tabel">
                        <h6>Pemakaian Obat / Cairan</h6>
                        <table class="table table-striped table-condensed periksaParObat" id="periksaParObat_<?php echo $id; ?>">
                            <thead>
                            <tr>
                                <th>Kode</th>        
                                <th>Obat</th>        
                                <th>Jumlah</th>                                        
                                <th>Batal</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php                                     
                                    $this->renderPartial('_pemeriksaanPartogObat', array('form'=>$form, 'modPartograf' => $modPartograf, 'id'=>$id)); 
                                ?>
                            </tbody>
                        </table>
                    </div>
    </fieldset>               
    </div>
</div>




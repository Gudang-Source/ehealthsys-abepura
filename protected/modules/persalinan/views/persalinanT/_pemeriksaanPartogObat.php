
    <?php
        
        
        $i = 0;
        if (!empty($modPartograf->pemeriksaanpartograf_id)){            
            $modPartografObat = ObatalkespasienT::model()->findAll(" pemeriksaanpartograf_id = '".$modPartograf->pemeriksaanpartograf_id."' ORDER BY pemeriksaanpartograf_id ASC");
            if (count($modPartografObat)< 1){
                $modPartografObat = null;
            }
        }else{
            $modPartografObat = null;
        }
            
            if (count($modPartografObat)>0){
            //var_dump($modPemeriksaan->pemeriksaanobstetrik_id);
            foreach($modPartografObat as $data){               
    ?>          
                <tr>
                    <td>
                        <?php                        
                        echo $form->hiddenField($data,'['.$id.']['.$i.']obatalkespasien_id', array(
							'class'=>'row_obatalkespasien_id',
						));
                        echo $form->hiddenField($data,'['.$id.']['.$i.']obatalkes_id', array(
							'class'=>'row_obatalkes_id',
						));
                        echo $data->obatalkes->obatalkes_kode;
                       ?>                      
                          
                    </td>                  
                    <td>
                        <?php echo $data->obatalkes->obatalkes_nama;                        ?>
                    </td>
                    <td width="80">                                                                    
                        <?php echo $form->textField($data,'['.$id.']['.$i.']qty_oa',array('readonly'=>true, 'class'=>'span2 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10, 'style'=>'text-align: right; width: 80px;'));?>              
                    </td>
					<td width="50" style="text-align: center;">
						<?php if (empty($data->oasudahabayar)): ?>
						<?php echo CHtml::link('<i class="icon-remove"></i>', '#', array(
							'onclick'=>'batalOASubmit(this); return false;',
						)); ?>
						<?php else : ?>
						-
						<?php endif; ?>
					</td>
                   
    <?php       $i++;
            }
        }
    ?>
  




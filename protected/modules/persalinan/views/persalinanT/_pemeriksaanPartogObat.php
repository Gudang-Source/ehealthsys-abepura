
    <?php
        
        
        $i = 0;
        if (!empty($modPartograf->pemeriksaanpartograf_id)){            
            $modPartografObat = PSPemeriksaanpartografobatT::model()->findAll(" pemeriksaanpartograf_id = '".$modPartograf->pemeriksaanpartograf_id."' ORDER BY pemeriksaanpartograf_id ASC");
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
                        echo $form->hiddenField($data,'['.$id.']['.$i.']pemeriksaanpartografobat_id');
                        echo $form->hiddenField($data,'['.$id.']['.$i.']obatalkes_id');
                        echo $data->obatAlkes->obatalkes_kode;
                       ?>                      
                          
                    </td>                  
                    <td>
                        <?php echo $data->obatAlkes->obatalkes_nama;                        ?>
                    </td>
                    <td>                                                                    
                        <?php echo $form->textField($data,'['.$id.']['.$i.']obatalkes_jumlah',array('readonly'=>true, 'class'=>'span2 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));?>              
                    </td>
                   
    <?php       $i++;
            }
        }
    ?>
  




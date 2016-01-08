<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Odontogram extends CWidget
{
//    public $gigiSeri = 2;
//    public $gigiTaring = 1;
//    public $gigiGerahamKecil = 2;
//    public $gigiGeraham = 3;
    
    protected $gigi = array();
    public $gigis;

    public function init() {
        // init gigi dewasa  ==================================================
        $i = 0;
        for($i=18;$i>10;$i--){
            $code = (!empty($this->gigis[$i])) ? $this->gigis[$i] : 'wwwww';
            $this->gigi[$i] = $this->render('odontogram/gigi', array('i'=>$i,'code'=>$code),true);
        }
        for($j=21;$j<29;$j++){
            $code = (!empty($this->gigis[$j])) ? $this->gigis[$j] : 'wwwww';
            $this->gigi[$j] = $this->render('odontogram/gigi', array('i'=>$j,'code'=>$code),true);
        }
        for($i=48;$i>40;$i--){
            $code = (!empty($this->gigis[$i])) ? $this->gigis[$i] : 'wwwww';
            $this->gigi[$i] = $this->render('odontogram/gigi', array('i'=>$i,'code'=>$code),true);
        }
        for($j=31;$j<39;$j++){
            $code = (!empty($this->gigis[$j])) ? $this->gigis[$j] : 'wwwww';
            $this->gigi[$j] = $this->render('odontogram/gigi', array('i'=>$j,'code'=>$code),true);
        }
        // end init gigi dewasa  ==============================================
        
        
        // init gigi anak  ==================================================
        for($i=55;$i>50;$i--){
            $code = (!empty($this->gigis[$i])) ? $this->gigis[$i] : 'wwwww';
            $this->gigi[$i] = $this->render('odontogram/gigi', array('i'=>$i,'code'=>$code),true);
        }
        for($j=61;$j<66;$j++){
            $code = (!empty($this->gigis[$j])) ? $this->gigis[$j] : 'wwwww';
            $this->gigi[$j] = $this->render('odontogram/gigi', array('i'=>$j,'code'=>$code),true);
        }
        for($i=85;$i>80;$i--){
            $code = (!empty($this->gigis[$i])) ? $this->gigis[$i] : 'wwwww';
            $this->gigi[$i] = $this->render('odontogram/gigi', array('i'=>$i,'code'=>$code),true);
        }
        for($j=71;$j<76;$j++){
            $code = (!empty($this->gigis[$j])) ? $this->gigis[$j] : 'wwwww';
            $this->gigi[$j] = $this->render('odontogram/gigi', array('i'=>$j,'code'=>$code),true);
        }
        // end init gigi anak  ==============================================
    }
    
    public function run() {
        $cs=Yii::app()->clientScript;
        $i = 0;
        echo '<center>';
        // gigi dewasa ================================
        echo '<table style="margin:0px;width:520px;">';
        echo '<tr>';
            for($i=18;$i>10;$i--){
                echo '<td>';
                echo $this->gigi[$i];
                echo '</td>';
            }
            for($j=21;$j<29;$j++){
                echo '<td>';
                echo $this->gigi[$j];
                echo '</td>';
            }
        echo '</tr>';
        echo '</table>';
        
        echo '<table style="margin:0px;width:520px;">';
        echo '<tr>';
            for($i=48;$i>40;$i--){
                echo '<td>';
                echo $this->gigi[$i];
                echo '</td>';
            }
            for($j=31;$j<39;$j++){
                echo '<td>';
                echo $this->gigi[$j];
                echo '</td>';
            }
        echo '</tr>';
        echo '</table>';
        // end gigi dewasa ============================
        
        // gigi anak ================================
        echo '<table style="margin:0px;width:350px;">';
        echo '<tr>';
            for($i=55;$i>50;$i--){
                echo '<td>';
                echo $this->gigi[$i];
                echo '</td>';
            }
            for($j=61;$j<66;$j++){
                echo '<td>';
                echo $this->gigi[$j];
                echo '</td>';
            }
        echo '</tr>';
        echo '</table>';
        
        echo '<table style="margin:0px;width:350px;">';
        echo '<tr>';
            for($i=85;$i>80;$i--){
                echo '<td>';
                echo $this->gigi[$i];
                echo '</td>';
            }
            for($j=71;$j<76;$j++){
                echo '<td>';
                echo $this->gigi[$j];
                echo '</td>';
            }
        echo '</tr>';
        echo '</table>';
        // end gigi anak ============================
                
        echo '</center>';
        echo CHtml::hiddenField('code', '', array('readonly'=>true));
        echo CHtml::hiddenField('tambahCode', '', array('readonly'=>true));
        
        $js="
function changeCode(code){
    $('#code').val(code);
    $('#tambahCode').val('');
}

function addCode(code){
    $('#code').val('');
    $('#tambahCode').val(code);
}

function newOdontogram(idTabel,position){
    var changeCode = $('#code').val();
    var addCode = $('#tambahCode').val();
    var code = $('#'+idTabel).find('input[name^=\"codeOdon\"]').val();
    var lastCode = code.substr(code.length-1);
    var arr = code.split('');
	var active = $('#'+idTabel+' > tbody').find('.'+position+'.active').length;
	
	hapusTanda(idTabel,position);
	
	if(changeCode=='')
        changeCode = 'w';
    
    if(arr[4]!='' && arr[4]!='w') {
        if(changeCode!='K')
            if(arr[4]!='K' && changeCode=='w')
                changeCode = arr[4];
    }
    
    switch(position)
    {
        case 't':
            arr[0] = changeCode;
            break;
        case 'r':
            arr[1] = changeCode;
            break;
        case 'b':
            arr[2] = changeCode;
            break;
        case 'l':
            arr[3] = changeCode;
            break;
        case 'c':
            arr[4] = changeCode;
            break;
        default:
            break;
    }
	
    if(lastCode != addCode){
        code = arr.join('')+addCode;
    } else {
        code = arr.join('');
    }
	
    url = '".Yii::app()->controller->createUrl('myOdontogram')."&code='+code;
    $('#'+idTabel).find('input[name^=\"codeOdon\"]').val(code);
    $('#'+idTabel).css('background-image','url('+url+')');
	$('#'+idTabel).find('.'+position).addClass('active');
	
}

function hapusTanda(idTabel,position){
	var changeCode = $('#code').val();
    var addCode = $('#tambahCode').val();
    var code = $('#'+idTabel).find('input[name^=\"codeOdon\"]').val();
    var lastCode = code.substr(code.length-1);
    var arr = code.split('');
	var active = $('#'+idTabel+' > tbody').find('.'+position+'.active').length;
	
	if(changeCode=='')
        changeCode = 'w';
    
    if(arr[4]!='' && arr[4]!='w') {
        if(changeCode!='K')
            if(arr[4]!='K' && changeCode=='w')
                changeCode = arr[4];
    }

	if(active > 0){
		myConfirm(' Yakin Akan hapus tanda?', 'Perhatian!', function(r){
            if(r){
				$('#'+idTabel+' > tbody').find('.'+position+'.active').removeClass('active');
				switch(position)
				{
					case 't':
						arr[0] = changeCode;
						if(active > 0){
							arr[0] = 'w';
							if(arr.length == 6){
								addCode = '';
								lastCode = '';
								arr[5] = '';
							}
						}
						break;
					case 'r':
						arr[1] = changeCode;
						if(active > 0){
							arr[1] = 'w';
							if(arr.length == 6){
								addCode = '';
								lastCode = '';
								arr[5] = '';
							}
						}
						break;
					case 'b':
						arr[2] = changeCode;
						if(active > 0){
							arr[2] = 'w';
							if(arr.length == 6){
								addCode = '';
								lastCode = '';
								arr[5] = '';
							}
						}
						break;
					case 'l':
						arr[3] = changeCode;
						if(active > 0){
							arr[3] = 'w';
							if(arr.length == 6){
								addCode = '';
								lastCode = '';
								arr[5] = '';
							}
						}
						break;
					case 'c':
						arr[4] = changeCode;
						if(active > 0){
							arr[4] = 'w';
							if(arr.length == 6){
								addCode = '';
								lastCode = '';
								arr[5] = '';
							}
						}
						break;
					default:
						break;
				}

				if(lastCode != addCode){
					code = arr.join('')+addCode;
				} else {
					code = arr.join('');
				}
				
				url = '".Yii::app()->controller->createUrl('myOdontogram')."&code='+code;
				$('#'+idTabel).find('input[name^=\"codeOdon\"]').val(code);
				$('#'+idTabel).css('background-image','url('+url+')');
				
            }else{
                return false;
            }
        });
	}	
}

function onKlikTombol(obj) {
    $('.btn').each(function(){
        $(this).removeClass('active'); 
    });
    $(obj).addClass('active');
}

";
        $cs->registerScript('addCodeOdontogram', $js, CClientScript::POS_HEAD);
    }
}
?>
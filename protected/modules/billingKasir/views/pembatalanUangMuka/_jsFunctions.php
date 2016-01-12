<script type="text/javascript">
function formCarabayar(carabayar)
{
    //myAlert(carabayar);
    if(carabayar == 'TRANSFER'){
        $('#divCaraBayarTransfer').slideDown();
    } else {
        $('#divCaraBayarTransfer').slideUp();
    }
}

function printKasir(idTandaBukti)
{
    if(idTandaBukti != '')
    {
        window.open('<?php echo $this->createUrl('print/pembatalanUangMuka',array('caraPrint'=>'PDF','idTandaBukti'=>'')); ?>'+idTandaBukti,'printwin','left=100,top=100,width=640,height=480,scrollbars=1');
    }     
}


$(document).ready(function(){
	<?php if(isset($_GET['sukses'])){ ?>
		$("input,textarea,select").attr("disabled",true);
		$("button[type='submit']").attr("disabled",true);
		$("button[type='submit']").removeAttr("onkeypress");
	<?php } ?>
});
</script>


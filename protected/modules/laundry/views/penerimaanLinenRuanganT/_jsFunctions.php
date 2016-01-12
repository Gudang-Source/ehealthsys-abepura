<script type="text/javascript">
function print(caraPrint)
{
    var penlinenruangan_id = '<?php echo isset($_GET['penlinenruangan_id']) ? $_GET['penlinenruangan_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penlinenruangan_id='+penlinenruangan_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>
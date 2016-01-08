
<?php

class KonfigsystemKController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';

	public function actionIndex($id=null)
	{
		if ($id == null){
			$id = 1;
		}
		$model=$this->loadModel($id);

		if(isset($_POST['SAKonfigsystemK']))
		{
			$model->attributes=$_POST['SAKonfigsystemK'];
			$model->jatuhtempoklaim=$_POST['SAKonfigsystemK']['jatuhtempoklaim'];
			$model->jatuhtempotagihan=$_POST['SAKonfigsystemK']['jatuhtempotagihan'];
			if($model->save()){
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
			}
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}        

	public function loadModel($id)
	{
		$model=SAKonfigsystemK::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

   /**
	* method import excel file into database
	* used in : 
	* 1. systemAdministrator -> konfig system -> import excel
	*/
   	public function actionImportExcel(){
	  
		$files = dirname(__FILE__).'/test.xls';

	  	/**
	   	* ajax request handlers
	   	*/
		if (Yii::app()->request->isAjaxRequest){
			if (isset($_FILES['upload'])){
				  $tableName = $_POST['tableName'];
				  $files = CUploadedFile::getInstanceByName('upload');
				  $object = Yii::app()->yexcel->readActiveSheet($files->tempName);
				  $table = Yii::app()->db->getSchema()->getTable($tableName);    
				  echo $this->renderTable($object,$table);
			}
			Yii::app()->end();
		}
		  
		/**
		* form method post handlers
		*/
		if (isset($_POST['tableName'],$_POST['Hasil'])){
			$tableName = $_POST['tableName'];
			if (isset($_POST['Hasil']))
				$value = $_POST['Hasil'];
			  	$files = $files = CUploadedFile::getInstanceByName('upload');
			  	$object = Yii::app()->yexcel->readActiveSheet($files->tempName);
			  	$transaction = Yii::app()->db->beginTransaction();
			  	try {
				  	$result = $this->saveMassTable($object,$tableName,$value);
				  	if ($result){
					  	$transaction->commit();
					  	Yii::app()->user->setFlash('success','<strong>Berhasil</strong> Data Berhasil disimpan');
					  	$this->refresh();
				  	}else{
					  	$transaction->rollback();
					  	Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan');
				  	}
			  	} catch (Exception $exc) {
				  	$transaction->rollback();
				  	Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan'.MyExceptionMessage::getMessage($exc));
			  	}
		}
		$this->render('test');
  	}
  
  	/**
   	* rendering table based on excel files
   	* @param array $object excel file that's already converted into array
   	* @param object $table table schema
   	*/
  	protected function renderTable($object,$table){
	  	$foreignKey = $table->foreignKeys; 
	  	$kolom = $table->columns;
	  	echo '<table class="table table-bordered table-condensed">
		  	<thead><th>Pilih</th>';
	  	foreach($object[1] as $key2=>$value2){
		  	echo '<th>'.$key2.'</th>';
	  	}
		  	echo '</thead><tbody>';
		  	$jumlahFK = count($foreignKey);
		  	$findKey = ($jumlahFK > 0) ? true : (($jumlahFK == 0) ? true: false);
		  	$list = array();
	  foreach ($object as $key => $value) {
		  echo '<tr valueField = "'.$key.'">';
		  if (!$findKey){
			  echo '<td><input type="checkbox" name="Hasil['.$key.'][cek]"></td>';
		  }else{
			  echo '<td></td>';
		  }
		  
		  foreach ($value as $counter => $value2) {
			  if (isset($list[$counter]) && !$findKey && (empty($value2))){
				  echo '<td columnField="'.$counter.'">
						  <div class="input-append">
							  <input type="hidden" name="Hasil['.$key.']['.$list[$counter][1].']" class="id"/>
							  <input type="text" name="Hasil['.$key.']['.$list[$counter][1].'_nama]" id="tableName" style="float:left;">
								  <span class="add-on"><i class="icon-list-alt"></i></span>
						  </div>
						</td>';
			  }else{
				  echo '<td columnField="'.$counter.'">'.$value2.'</td>';
			  }
			  
			  
			  if ($findKey){
				  if (isset($foreignKey[$value2]) && count($foreignKey[$value2]) == 2){
					  $list[$counter] = $foreignKey[$value2];
					  unset($foreignKey[$value2]);
				  }
				  $findKey = (count($foreignKey) > 0) ? true : false;
			  }
		  }
		  echo '</tr>';
	  }
	  echo '</tbody></table>';
	  $this->renderJavascript($list);
  	}
  
  	/**
   	* rendering javascript file to be used in table view
   	* @param array $list 
   	*/
  	protected function renderJavascript($list){
	  echo "<script>
		  $(document).ready(function(){
			var isMouseDown = false;
			$('#excel table td')
			  .mousedown(function () {
				isMouseDown = true;
				$(this).parents('tr').toggleClass('yellow_background').find('input[name*=\'[cek]\']').attr('checked', function(idx, oldAttr) {
					  return !oldAttr;
				});
			  })
			  .mouseover(function () {
				if (isMouseDown) {
				  $(this).parents('tr').toggleClass('yellow_background').find('input[name*=\'[cek]\']').attr('checked', function(idx, oldAttr) {
					  return !oldAttr;
				  });
				}
			  })
			  .bind('selectstart', function () {
				return false; 
			  });

			$(document)
			  .mouseup(function () {
				isMouseDown = false;
			  });
		  });
	   ";
	  if (count($list) > 0){
		  foreach ($list as $value) {
			  echo '$("input[name*=\'['.$value[1].'_nama]\']").autocomplete({"minLength":"3","source":"/simrs/index.php?r=actionAutoComplete/getValuePrimaryKey&table='.$value[0].'&primaryKey='.$value[1].'","select":function(event,ui){$(this).parents("td").find(".id").val(ui.item.id);}});';
		  }
	  }
	   echo '</script>';
  	}
  
  	/**
   	* method to save into table 
   	* @param array $objects
   	* @param string $tableName table name
   	* @param values $values variable contains post method 
   	* @return boolean result
   	*/
  	protected function saveMassTable($objects,$tableName,$values){
	  $kolom = array();
	  $table = Yii::app()->db->getSchema()->getTable($tableName);
	  $columns = $table->columns;
	  $listBoolean = array('Ya'=>'true','Tidak'=>'false');
	  $builder=Yii::app()->db->schema->getCommandBuilder();
	  $primaryKeys = $table->primaryKey;
	  
	  if (count($columns > 0)){
		  foreach ($columns as $counter => $column) {
			   $kolom[] = $column->name;
		  }
	  }

	  $data = array();
	  $aktifPrimaryKey = false;
	  $result = true;
	  if (count($values) > 0){
		  foreach ($values as $counter => $row) {
			  if (isset($objects[$counter])){
				  $i = 0;
				  foreach ($objects[$counter] as $key => $value) {
					  $data[$kolom[$i]] = (!empty($value)) ? ((isset($listBoolean[trim($value)])) ? $listBoolean[trim($value)] : $value ) : null;
					  if (!empty($row[$kolom[$i]])){
						  $data[$kolom[$i]] = $row[$kolom[$i]];
					  }
					  $i++;
				  }
				  if (!$aktifPrimaryKey){
					  if (is_string($primaryKeys)){
						  unset($data[$primaryKeys]);
					  }
					  else if (is_array($primaryKeys)){
						  foreach ($primaryKeys as $key => $primaryKey) {
							  unset($data[$primaryKey]);
						  }
					  }
				  }
				  $command=$builder->createInsertCommand($table,$data);
				  $result = $command->execute() && $result;
				  echo $result;
			  }
		  }
	  }
	  return $result;
  	}
  
  	/**
   	* output method of file excel contains template of table 
   	*/
  	public function actionCreateTemplateXcel(){
	  if (isset($_GET['tableName'])){
		  $this->layout='//layouts/printExcel';
		  $tableName = $_GET['tableName'];
		  $table = Yii::app()->db->getSchema()->getTable($tableName);     
		  $model = null;
		  if (!empty($table->name)){
			  $sql = "select *from {$table->name}";
			  $model = Yii::app()->db->createCommand($sql)->queryAll();
		  }
			  
		  $judul = "Template Excel $tableName";
		  $this->render('_template',array('table'=>$table, 'judul'=>$judul, 'model'=>$model));
	  }
  	}
}
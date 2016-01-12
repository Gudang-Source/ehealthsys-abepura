<?php
class DownloadAntrianController extends MyAuthController
{
	public $layout='//layouts/column1';

	public function actionIndex()
	{
            
		$this->render('index',array());
	}
}
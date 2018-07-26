<?php

class Controller
{
		private $model;
		private $view;

		public function __construct()
		{		
		    $this->model = new Model();
			$this->view = new View();
				
			if(!empty ($_POST))
			{	
				if (isset($_POST['convert']))
				{
					$this->model->getConvert($_POST['postValue'], $_POST['convert']);					
				}
				$this->view->render('result.php', 'index.php', $this->model->getData());
			}
			else
			{
				$this->pageDefault();	
			}
				
	    }	
		
		
		private function pageDefault()
		{   
			$this->view->render('result.php', 'index.php', $this->model->getData());
		}

		
		
		
}

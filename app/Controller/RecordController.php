<?php

class RecordController extends AppController {

    public $components = array('DataTable');

    public function index() {
        ini_set('memory_limit', '256M');
        set_time_limit(0);

        $this->setFlash('Listing Record page optimized. Implemented datatable server side by using DataTableComponent.');


        $this->set('title', __('List Record'));
    }

    public function data() {
        if ($this->request->is('ajax')) {
            /* Set layout to ajax and auto render false */
            $this->layout = "ajax";
            $this->autoRender = false;
            /* Load component config */
            $this->paginate = array(
                'fields' => array('Record.id', 'Record.name'),
            );
            $this->DataTable->mDataProp = true;
            echo json_encode($this->DataTable->getResponse());
        }
    }

// 		public function update(){
// 			ini_set('memory_limit','256M');
// 			$records = array();
// 			for($i=1; $i<= 1000; $i++){
// 				$record = array(
// 					'Record'=>array(
// 						'name'=>"Record $i"
// 					)			
// 				);
// 				for($j=1;$j<=rand(4,8);$j++){
// 					@$record['RecordItem'][] = array(
// 						'name'=>"Record Item $j"		
// 					);
// 				}
// 				$this->Record->saveAssociated($record);
// 			}
// 		}
}

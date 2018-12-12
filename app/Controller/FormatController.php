<?php
	class FormatController extends AppController{
		public function q1(){
			
			$this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
				
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
		public function q1_detail(){

			$this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
				
			
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
                
                public function q1_save(){
                    if ($this->request->is('post')) {
                        $selectedType = $this->request->data["type"];
                        $this->set("validRequest", true);
                        $this->set("selectedOption", $selectedType);
                        if($selectedType != "")
                            $this->setFlash('Type selected successfully.');
                        else
                            $this->setFlash('OOPS!!! you forgot to select a type.');
                    }else{
                        $this->set("validRequest", false);
                        $this->setFlash('Invalid Request Type.');
                    }
		}
		
	}
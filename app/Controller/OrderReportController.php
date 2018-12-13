<?php

class OrderReportController extends AppController {

    public function index() {

        $this->setFlash('Multidimensional Array.');

        $this->loadModel('Order');
        $orders = $this->Order->find('all', array('conditions' => array('Order.valid' => 1), 'recursive' => 2));
        // debug($orders);exit;

        $this->loadModel('Portion');
        $portions = $this->Portion->find('all', array('conditions' => array('Portion.valid' => 1), 'recursive' => 2));
        // debug($portions);exit;
        
        // Portion Report data from database
        $portionData = [];
        //portion data
        foreach ($portions as $key => $PortionDetail) {
            //print_r($OrderDetail);die;
            foreach ($PortionDetail["PortionDetail"] as $ikey => $value) {
                //print_r($value);die;
                $portionData[$PortionDetail["Portion"]["item_id"]][$PortionDetail["Item"]["id"]][$value["Part"]["name"]] = $value["value"];
            }
            
        }
       //debug($portionData);
       
       // Order Report data from database
       $orderData = array();
        
        foreach ($orders as $key => $OrderDetail) {
            //print_r($OrderDetail);die;
            foreach ($OrderDetail["OrderDetail"] as $ikey => $value) {
                //print_r($value);die;
                $orderData[$OrderDetail["Order"]["name"]][$value["Item"]["name"]] = $value;
                $orderData[$OrderDetail["Order"]["name"]][$value["Item"]["name"]]["ingredient"] = ((isset($portionData[$OrderDetail["Order"]["id"]]) && isset($portionData[$OrderDetail["Order"]["id"]][$value["Item"]["id"]])) ? $portionData[$OrderDetail["Order"]["id"]][$value["Item"]["id"]] : array());
            }
            
        }
        
        //Assign to order report data
        $order_reports = $orderData;
        // To Do - write your own array in this format
        $order_reports_static = array('Order 1' => array(
                'Seafood Fried Rice' => array(
                    "quantity" => 1,
                    "ingredient" => array(
                        'Ingredient A' => 1,
                        'Ingredient B' => 12,
                        'Ingredient C' => 3,
                        'Ingredient G' => 5,
                        'Ingredient H' => 24,
                    )
                ),
                'Fried Rice with Silver Fish' => array(
                    "quantity" => 3,
                    "ingredient" => array(
                        'Ingredient A' => 1,
                        'Ingredient G' => 5,
                        'Ingredient H' => 24,
                        'Ingredient J' => 22,
                        'Ingredient F' => 9,
                    )
                ),
                'Vegetarian Fried Rice (V)' => array(
                    "quantity" => 2,
                    "ingredient" => array(
                        'Ingredient A' => 1,
                        'Ingredient H' => 24,
                        'Ingredient J' => 22,
                        'Ingredient F' => 9,
                    )
                ),
            ),
            'Order 2' => array(
                'Sing Chew Fried Bee Hoon' => array(
                    "quantity" => 5,
                    "ingredient" => array(
                        'Ingredient A' => 13,
                        'Ingredient B' => 2,
                        'Ingredient G' => 14,
                        'Ingredient I' => 2,
                    )
                ),
                'Fragrant Chicken' => array(
                    "quantity" => 3,
                    "ingredient" => array(
                        'Ingredient A' => 13,
                        'Ingredient B' => 2,
                        'Ingredient I' => 2,
                        'Ingredient D' => 6,
                    )
                ),
                'Lemon Chicken' => array(
                    "quantity" => 4,
                    "ingredient" => array(
                        'Ingredient B' => 2,
                        'Ingredient G' => 14,
                        'Ingredient I' => 2,
                        'Ingredient D' => 6,
                    )
                ),
                'Crispy Chicken Wings' => array(
                    "quantity" => 1,
                    "ingredient" => array(
                        'Ingredient B' => 2,
                        'Ingredient G' => 14,
                        'Ingredient I' => 2,
                        'Ingredient D' => 6,
                    )
                ),
            ),
        );
//			$order_reports = array('Order 1' => array(
//										'Ingredient A' => 1,
//										'Ingredient B' => 12,
//										'Ingredient C' => 3,
//										'Ingredient G' => 5,
//										'Ingredient H' => 24,
//										'Ingredient J' => 22,
//										'Ingredient F' => 9,
//									),
//								  'Order 2' => array(
//								  		'Ingredient A' => 13,
//								  		'Ingredient B' => 2,
//								  		'Ingredient G' => 14,
//								  		'Ingredient I' => 2,
//								  		'Ingredient D' => 6,
//								  	),
//								);
        // ...

        $this->set('order_reports', $order_reports);

        $this->set('title', __('Orders Report'));
    }

    public function Question() {

        $this->setFlash('Multidimensional Array.');

        $this->loadModel('Order');
        $orders = $this->Order->find('all', array('conditions' => array('Order.valid' => 1), 'recursive' => 2));

        // debug($orders);exit;

        $this->set('orders', $orders);

        $this->loadModel('Portion');
        $portions = $this->Portion->find('all', array('conditions' => array('Portion.valid' => 1), 'recursive' => 2));

        // debug($portions);exit;

        $this->set('portions', $portions);

        $this->set('title', __('Question - Orders Report'));
    }

}

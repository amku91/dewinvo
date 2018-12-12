<?php

class MigrationController extends AppController {

    public function q1() {

        //$this->setFlash('Question: Migration of data to multiple DB table');
        if ($this->data) {
            //debug($this->data);
            if (!empty($this->data) && is_uploaded_file($this->data['file']['tmp_name'])) {

                $file = $this->data['file']['tmp_name'];
                $type = $this->data['file']['type'];
                /* check for type */
                if ($this->isValidFileType($type)) {
                    /* Get model data */
                    $excelData = $this->getDataViewFromExcelComponent($file);
                    $associatedData = [];
                    foreach ($excelData as $key => $value) {
                        /* Make associative array */
                        $associatedData[$key]["Members"] = $value;
                        $associatedData[$key]["Transactions"] = $value;
                        $associatedData[$key]["Transactions"]["TransactionItems"] = $value;
                    }
                    /* Load the models now */
                    $this->loadModel('Members');
                    $this->loadModel('Transactions');
                    $this->loadModel('TransactionItems');
                    if ($this->Members->saveAll($associatedData, array('deep' => true))) {
                        $this->setFlash('Excel Migrated.');
                        /* redirect to index action */
                        $this->redirect(array('action' => 'q1'));
                    } else {
                        $this->setFlash('The excel file could not be saved. Please, try again.');
                    }
                } else {
                    $this->setFlash('Invalid file format.');
                }
            }
        }
    }

    protected function isValidFileType($fileType) {
        $mimesType = array('application/vnd.ms-excel', 'application/vnd.ms-excel.addin.macroEnabled.12', 'application/vnd.ms-excel.sheet.binary.macroEnabled.12', 'application/vnd.ms-excel.sheet.macroEnabled.12', 'application/vnd.ms-excel.template.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        return in_array($fileType, $mimesType);
    }

    protected function getDataViewFromExcelComponent($file) {
        /* load package */
        App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel/Classes/PHPExcel.php'));
        $phpExcel = new PHPExcel();

        $inputFileType = \PHPExcel_IOFactory::identify($file);
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file);
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);

        $excelData = array();
        $headersList = array();
        for ($row = 1; $row <= $highestRow; ++$row) {
            for ($column = 0; $column < $colNumber; $column++) {
                if ($row == 1) {
                    $head = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                    array_push($headersList, $head);
                } else {
                    if ($headersList[$column] == "Date") {
                        $date = PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($column, $row)->getValue());
                        $excelData[$row - 2]["date"] = date('Y-m-d', $date); //date
                        $excelData[$row - 2]["month"] = date('n', $date); //month without leading zero
                        $excelData[$row - 2]["year"] = date('Y', $date); //year
                    } else if ($headersList[$column] == "Member No") {
                        //Get type and no from member no
                        $memberData = explode(" ", $objWorksheet->getCellByColumnAndRow($column, $row)->getValue());
                        $excelData[$row - 2]["type"] = $memberData[0];
                        $excelData[$row - 2]["no"] = $memberData[1];
                    } else if ($headersList[$column] == "Member Name") {
                        //Assign Member Name to name and member_name
                        $memberName = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["member_name"] = $memberName;
                        $excelData[$row - 2]["name"] = $memberName;
                    } else if ($headersList[$column] == "Member Pay Type") {
                        //Pay Type
                        $memberPayType = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["member_paytype"] = $memberPayType;
                    } else if ($headersList[$column] == "Ref No.") {
                        //Pay Type
                        $refNo = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["ref_no"] = $refNo;
                    } else if ($headersList[$column] == "Receipt No") {
                        //Pay Type
                        $receiptNo = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["receipt_no"] = $receiptNo;
                    } else if ($headersList[$column] == "Payment By") {
                        //Pay Type
                        $paymentBy = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["payment_method"] = $paymentBy;
                    } else if ($headersList[$column] == "Batch No") {
                        //Pay Type
                        $batchNo = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["batch_no"] = $batchNo;
                    } else if ($headersList[$column] == "Cheque No") {
                        //Pay Type
                        $chequeNo = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["cheque_no"] = $chequeNo;
                    } else if ($headersList[$column] == "Renewal Year") {
                        //Pay Type
                        $renewalYear = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["renewal_year"] = $renewalYear;
                        $excelData[$row - 2]["description"] = "Being Payment For : " . $excelData[$row - 2]["payment_type"] . " : " . $renewalYear;
                    } else if ($headersList[$column] == "subtotal") {
                        //Pay Type
                        $subtotal = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["subtotal"] = $subtotal;
                        $excelData[$row - 2]["unit_price"] = $subtotal;
                        $excelData[$row - 2]["sum"] = $subtotal;
                        $excelData[$row - 2]["quantity"] = 1;
                    } else if ($headersList[$column] == "totaltax") {
                        //Pay Type
                        $tax = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["tax"] = $tax;
                    } else if ($headersList[$column] == "Renewal Year") {
                        //Pay Type
                        $total = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["total"] = $total;
                    } else if ($headersList[$column] == "Payment Description") {
                        //Pay Type
                        $description = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["payment_type"] = $description;
                    } else {
                        //Remaining Column
                        $excelData[$row - 2][$headersList[$column]] = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        $excelData[$row - 2]["table"] = "Member";
                        $excelData[$row - 2]["table_id"] = 1;
                        //$excelData[$row - 2]["member_id"] = $this->Members->;
                    }
                }
            }
        }
        return $excelData;
    }

    public function q1_instruction() {

        $this->setFlash('Question: Migration of data to multiple DB table');



// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
    }

}

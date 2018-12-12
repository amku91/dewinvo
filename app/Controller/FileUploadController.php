<?php

class FileUploadController extends AppController {

    public function index() {
        $this->set('title', __('File Upload Answer'));

        $file_uploads = $this->FileUpload->find('all');
        if ($this->data) {
            //debug($this->data);
            if (!empty($this->data) && is_uploaded_file($this->data['FileUpload']['file']['tmp_name'])) {
                $delimiter = ',';
                $mimesType = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
                $file = $this->data['FileUpload']['file']['tmp_name'];
                $type = $this->data['FileUpload']['file']['type'];
                /* check for type */
                if (in_array($type, $mimesType)) {
                    ini_set('auto_detect_line_endings', true);

                    $handle = fopen($file, 'r') or die('Unable to open file!');

                    $returnVal = array();
                    $header = null;
                    $haveValidHeader = true;
                    while (($row = fgetcsv($handle)) !== false) {
                        if ($header === null) {
                            $header = $row;
                            continue;
                        }
                        
                        if(!is_array($header) ||  !isset($header[0]) || !isset($header[1]) || $header[0] != "Name" || $header[1] != "Email"){
                            $haveValidHeader = false;
                            break;
                        }else{
                            $haveValidHeader = true;
                        }

                        $newRow = array('id' => '');
                        for ($i = 0; $i < count($row); $i++) {
                            $newRow[strtolower($header[$i])] = $row[$i];
                        }

                        $returnVal[] = $newRow;
                    }

                    fclose($handle);
                    /*Save to database*/
                    if(!$haveValidHeader){
                        $this->setFlash('Invalid file headers. Please, try again with valid file.');
                    }else if ($this->FileUpload->saveAll($returnVal)) {
                        $this->setFlash('File Uploaded.');
                        /*Get data again*/
                        $file_uploads = $this->FileUpload->find('all');
                        $this->set(compact('file_uploads'));
                        /*redirect to index action*/
                        $this->redirect(array('action' => 'index'));
                    } else {
                        $this->setFlash('The csv could not be saved. Please, try again.');
                    }
                } else {
                    $this->setFlash('Invalid file format.');
                }
            }
        }
        $this->set(compact('file_uploads'));
    }

}

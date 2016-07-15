<?php

class FileController extends Zend_Controller_Action {

    public function viewAction() {
        $this->getHelper('layout')->disableLayout();
        $this->getHelper('viewRenderer')->setNoRender(true);
        switch ($this->_getParam('file')) {
            case 'schema':
                $image = file_get_contents(APPLICATION_PATH . '/../data/documentation/openatlas_schema.png');
                header('Content-type: image/jpg');
                echo $image;
                return;
            default:
                return;
        }
    }

}

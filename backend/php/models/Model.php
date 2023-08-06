<?php

include_once 'utils/RequestHandler.php';
include_once 'objects/item.php'; // Asegúrate de incluir el archivo Item.php si no lo has hecho.

    class Model {
        private $conn;
        private $requestData;

        public function __construct($db) {
            $this->conn = $db;
            $this->requestData = RequestHandler::processRequest();
        }

        public function create() {
            $table_name = $this->requestData['data']['table_name']; // Corrección aquí
            $data = $this->requestData['data'];
        
            $item = new Item($this->conn, $table_name);
            foreach ($data as $field => $value) {
                $item->setField($field, $value);
            }
        
            return $item->insert();
        }
        
        public function update() {
            $table_name = $this->requestData['data']['table_name']; // Corrección aquí
            $data = $this->requestData['data'];
            $id = $this->requestData['data']['id']; // Corrección aquí
        
            $item = new Item($this->conn, $table_name);
            foreach ($data as $field => $value) {
                $item->setField($field, $value);
            }
        
            return $item->update($id);
        }        

        public function getAll() {
            $table_name = $this->requestData['data']['table_name'];

            $item = new Item($this->conn, $table_name);

            return $item->getAll();
        }
        
        public function delete() {

            $table_name = $this->requestData['data']['table_name'];
            $id = $this->requestData['data']['id'];
        
            $item = new Item($this->conn, $table_name);
        
            return $item->delete($id);
        }        
        
    }
    
?>



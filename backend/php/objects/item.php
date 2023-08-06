<?php 

    class Item {
        private $conn;
        private $table_name;
        private $fields;

        public function __construct($db, $table_name) {
            $this->conn = $db;
            $this->table_name = $table_name;
            $this->fields = array();
        }

        // Método para establecer el valor de un campo del registro
        public function setField($field, $value) {
            $this->fields[$field] = $value;
        }

        // Método para obtener todos los registros de la tabla
        public function getAll() {
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function insert() {
            $query = "INSERT INTO " . $this->table_name . " (" . implode(',', array_keys($this->fields)) . ")
                    VALUES (:" . implode(',:', array_keys($this->fields)) . ")";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($this->fields);
        
            return $result;
        }

        public function update($id) {
        
            $query = "UPDATE " . $this->table_name . " SET ";
            foreach ($this->fields as $field => $value) {
                $query .= $field . "=:" . $field . ",";
            }
            $query = rtrim($query, ',');
            $query .= " WHERE id=:id";
        
            $stmt = $this->conn->prepare($query);
            $this->fields['id'] = $id;
            $result = $stmt->execute($this->fields);
        
            return $result;
        }
        
        // Método para eliminar un registro de la tabla
        public function delete($id) {
            $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute(array('id' => $id));
        }

        // Agrega otros métodos específicos si es necesario.
    }
?>



<?php 

include_once 'utils/validations.php'; // Incluir la clase Validations

class RequestHandler {
    public static function processRequest() {
        
        $table_name = $_GET['table'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);
        $data = $data['data'] ?? null;
        $id = $data['id'] ?? null;

        if ($data !== null) {
            Validations::validateData($data); // Validar los datos antes de crear el array
        }

        return ['data' => ['table_name' => $table_name, 'id' => $id]];
    }
}

?>

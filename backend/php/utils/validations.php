<?php 

class Validations {
    public static function validateData($data) {
        $emptyFields = array();

        foreach ($data as $key => $value) {
            if ($value === null || $value === '') {
                $emptyFields[] = $key;
            }
        }

        if (!empty($emptyFields)) {
            $fields = implode(', ', $emptyFields);
            throw new Exception("Fields [$fields] cannot be null or empty.");
        }
    }
}                                                                                                                                                                                                                                                

?>
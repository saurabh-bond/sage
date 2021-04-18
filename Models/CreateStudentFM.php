<?php

class CreateStudentFM extends DBClass
{
        public $requestData;
        public $errors = [];
        public $id;
        
        public function formValidation()
        {
                $fields = ['firstname', 'lastname', 'dob', 'contact_no'];
                $optionalFields = [];
                
                foreach ($fields as $field) {
                        if (empty($this->requestData[$field]) && !in_array($field, $optionalFields)) {
                                $this->errors[] = $field . " is required.";
                        }
                        if ($field == 'firstname' || $field == 'lastname') {
                                if (!preg_match("/^[a-zA-Z-' ]*$/", $this->requestData[$field])) {
                                        $this->errors[] = "Only letters and white space allowed in " . $field;
                                }
                        }
                        if ($field == 'contact_no') {
                                if (!preg_match('/^\d{10}$/', $this->requestData[$field])) {
                                        $this->errors[] = $field . " should be of 10 digits.";
                                }
                        }
                        if ($field == 'dob') {
                                if (strtotime($this->requestData['dob']) >= time()) {
                                        $this->errors[] = $field . " should lesser than current date.";
                                }
                        }
                }
                
        }
        
        public function processBusinessRules()
        {
                $this->formValidation();
                if (!empty($this->errors)) {
                        return $this->sendResponse(400, $this->errors, 'Please enter valid inputs');
                }
                
                if ($this->requestData['id']) {
                        // Edit case
                        $rawQuery = "UPDATE `student` SET
                                    `firstname` = :firstname,
                                    `lastname` = :lastname,
                                    `dob` = :dob,
                                    `contact` = :contact,
                                    `updated` = :updated
                                    WHERE `student`.`id` = :id;";
                        $bindParams = array(
                                ':firstname' => $this->requestData['firstname'],
                                ':lastname' => $this->requestData['lastname'],
                                ':dob' => strtotime($this->requestData['dob']),
                                ':contact' => $this->requestData['contact_no'],
                                ':updated' => time(),
                                ':id' => $this->requestData['id'],
                        );
                } else {
                        // Create case
                        $rawQuery = "INSERT INTO `student` (`firstname`, `lastname`, `dob`, `contact`, `created`, `updated`)
                              VALUES (:firstname, :lastname, :dob, :contact, :created, :updated)";
                        $bindParams = array(
                                ':firstname' => $this->requestData['firstname'],
                                ':lastname' => $this->requestData['lastname'],
                                ':dob' => strtotime($this->requestData['dob']),
                                ':contact' => $this->requestData['contact_no'],
                                ':created' => time(),
                                ':updated' => time(),
                        );
                }
                $inserted = $this->insertData($rawQuery, $bindParams);
                return $inserted;
        }
        
        public function deleteStudent()
        {
                $recordExist = $this->selectQuery(
                        "SELECT * FROM student WHERE id = :id AND active = :active",
                        [
                                ':id' => $this->requestData['id'],
                                ':active' => 1
                        ]
                );
                if (empty($recordExist['data'])) {
                        return $this->sendResponse(200, null, 'Student not found Or has already been deactivated.');
                }
                $rawQuery = "UPDATE `student` SET
                                    `active` = :active,
                                    `updated` = :updated
                                    WHERE `student`.`id` = :id;";
                $bindParams = array(
                        ':active' => 0,
                        ':updated' => time(),
                        ':id' => $this->requestData['id'],
                );
                $inserted = $this->insertData($rawQuery, $bindParams);
                if ($inserted['status'] == 200) {
                        return $this->sendResponse(200, null, 'Student has been deactivated successfully.');
                } else {
                        return $this->sendResponse(400, null, 'Some error occurred, please try reloading the page.');
                }
        }
        
        public function sendResponse($status, $err = null, $msg = "", $data = [])
        {
                return ['status' => $status, 'error' => $err, 'message' => $msg, 'data' => $data];
        }
}

?>

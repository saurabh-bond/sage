<?php

class CreateCourseFM extends DBClass
{
        public $requestData;
        public $errors = [];
        public $id;
        
        public function formValidation()
        {
                $fields = ['name', 'details'];
                $optionalFields = [];
                
                foreach ($fields as $field) {
                        if (empty($this->requestData[$field]) && !in_array($field, $optionalFields)) {
                                $this->errors[] = $field . " is required.";
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
                        $rawQuery = "UPDATE `course` SET
                                    `name` = :name,
                                    `details` = :details,
                                    `active` = :active,
                                    `updated` = :updated
                                    WHERE `course`.`id` = :id;";
                        $bindParams = array(
                                ':name' => $this->requestData['name'],
                                ':details' => $this->requestData['details'],
                                ':active' => 1,
                                ':updated' => time(),
                                ':id' => $this->requestData['id']
                        );
                } else {
                        // Create case
                        $rawQuery = "INSERT INTO `course` (`name`, `details`, `active`, `created`, `updated`)
                              VALUES (:name, :details, :active, :created, :updated)";
                        $bindParams = array(
                                ':name' => $this->requestData['name'],
                                ':details' => $this->requestData['details'],
                                ':active' => 1,
                                ':created' => time(),
                                ':updated' => time()
                        );
                }
                $inserted = $this->insertData($rawQuery, $bindParams);
                return $inserted;
        }
        
        public function removeCourse()
        {
                $recordExist = $this->selectQuery(
                        "SELECT * FROM course WHERE id = :id AND active = :active",
                        [
                                ':id' => $this->requestData['id'],
                                ':active' => 1
                        ]
                );
                if (empty($recordExist['data'])) {
                        return $this->sendResponse(200, null, 'Course details not found Or has already been deactivated.');
                }
                $rawQuery = "UPDATE `course` SET
                                    `active` = :active,
                                    `updated` = :updated
                                    WHERE `course`.`id` = :id;";
                $bindParams = array(
                        ':active' => 0,
                        ':updated' => time(),
                        ':id' => $this->requestData['id'],
                );
                $inserted = $this->insertData($rawQuery, $bindParams);
                if ($inserted['status'] == 200) {
                        return $this->sendResponse(200, null, 'Course has been deactivated successfully.');
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

<?php

class CreateCourseSubscription extends DBClass
{
        public $requestData;
        public $errors = [];
        public $id;
        
        public function formValidation()
        {
                $fields = ['course_id', 'student_id'];
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
                // Check if record already exist
                $recordExist = $this->selectQuery(
                        "SELECT * FROM course_subscription WHERE course_id = :course_id AND student_id = :student_id",
                        [
                                ':course_id' => $this->requestData['course_id'],
                                ':student_id' => $this->requestData['student_id']
                        ]
                );
                if (!empty($recordExist['data'])) {
                        return $this->sendResponse(200, null, 'Course has already been subscribed.');
                }
                
                $rawQuery = "INSERT INTO `course_subscription` (`course_id`, `student_id`, `created`, `updated`)
                              VALUES (:course_id, :student_id, :created, :updated)";
                $bindParams = array(
                        ':course_id' => $this->requestData['course_id'],
                        ':student_id' => $this->requestData['student_id'],
                        ':created' => time(),
                        ':updated' => time()
                );
                $inserted = $this->insertData($rawQuery, $bindParams);
                if ($inserted['status'] == 200) {
                        return $this->sendResponse(200, null, 'Course has been subscribed successfully.');
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

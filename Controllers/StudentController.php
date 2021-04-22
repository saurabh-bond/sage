<?php
require_once './Models/CreateStudentFM.php';
require_once './Models/FetchStudent.php';

class StudentController extends Controller
{
        
        /**
         * @desc This function is used to create student
         * @params $firstname, $lastname, $dob, $contact_no
         * @returns student registration view
         */
        public static function registration()
        {
                $data = [];
                $data['title'] = "Student Registration";
                
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (!isset($_POST['registration'])) {
                                goto getRequest;
                        }
                        
                        $postData = $_POST;
                        $createStudentModel = new CreateStudentFM();
                        $createStudentModel->requestData = $postData;
                        $output = $createStudentModel->processBusinessRules();
                        $data = array_merge($data, $output);
                        StudentController::renderView('student-registration', $data);
                        
                }
                
                getRequest:
                if (isset($_GET['id']) && $_GET['id'] != "") {
                        // Edit mode
                        $studentId = $_GET['id'];
                        $studentDetails = DBClass::getInstance()
                                ->selectQuery("SELECT *, FROM_UNIXTIME(dob, '%Y-%m-%d') AS dob
                                                      FROM student WHERE id = :id", [':id' => $studentId]);
                        $data = $studentDetails['data'];
                        if (!empty($data)) {
                                $data = $data[0];
                                $_POST['firstname'] = $data['firstname'];
                                $_POST['lastname'] = $data['lastname'];
                                $_POST['dob'] = $data['dob'];
                                $_POST['contact_no'] = $data['contact'];
                                $_POST['editMode'] = true;
                                $_POST['id'] = $data['id'];
                        } else {
                                $data['error'] = ['Student details not found.'];
                        }
                }
                StudentController::renderView('student-registration', $data);
                
        }
        
        /**
         * @desc This function is for displaying student list
         * @params $requestedPage
         * @returns student list view
         */
        public static function studentList()
        {
                $data = [];
                $data['title'] = "Student List";
                
                $postData = $_POST;
                $fetchStudentModel = new FetchStudent();
                $fetchStudentModel->requestData = $postData;
                $output = $fetchStudentModel->processBusinessRules();
                $data = array_merge($data, $output);
                
                StudentController::renderView('student-list', $data);
        }
        
        /**
         * @desc This function is used to remove student
         * @params $studentId
         */
        public static function removeStudent()
        {
                $createStudentModel = new CreateStudentFM();
                $createStudentModel->requestData = $_POST;
                $createStudentModel->id = $_POST['id'];
                $output = $createStudentModel->deleteStudent();
                echo json_encode($output);
                die;
        }
        
}

?>

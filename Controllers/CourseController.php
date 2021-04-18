<?php
require_once './Models/CreateCourseFM.php';
require_once './Models/FetchCourse.php';

class CourseController extends Controller
{
        
        public static function addCourse()
        {
                $data = [];
                $data['title'] = "Add Course";
                
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $postData = $_POST;
                        $createCourseModel = new CreateCourseFM();
                        $createCourseModel->requestData = $postData;
                        $output = $createCourseModel->processBusinessRules();
                        $data = array_merge($data, $output);
                        StudentController::renderView('course-add', $data);
                        
                }
                
                if (isset($_GET['id']) && $_GET['id'] != "") {
                        // Edit mode
                        $courseId = $_GET['id'];
                        $courseDetails = DBClass::getInstance()
                                ->selectQuery("SELECT * FROM course WHERE id = :id", [':id' => $courseId]);
                        $data = $courseDetails['data'];
                        if (!empty($data)) {
                                $data = $data[0];
                                $_POST['name'] = $data['name'];
                                $_POST['details'] = $data['details'];
                                $_POST['editMode'] = true;
                                $_POST['id'] = $data['id'];
                        } else {
                                $data['error'] = ['Course details not found.'];
                        }
                }
                CourseController::renderView('course-add', $data);
                
        }
        
        public static function courseList()
        {
                $data = [];
                $data['title'] = "Student List";
                
                $postData = $_POST;
                $fetchCourseModel = new FetchCourse();
                $fetchCourseModel->requestData = $postData;
                $output = $fetchCourseModel->processBusinessRules();
                $data = array_merge($data, $output);
                
                StudentController::renderView('course-list', $data);
        }
        
}

?>

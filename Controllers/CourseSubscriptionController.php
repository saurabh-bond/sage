<?php
require_once './Models/Student.php';
require_once './Models/Course.php';
require_once './Models/CreateCourseSubscription.php';
require_once './Models/FetchCourseSubscription.php';

class CourseSubscriptionController extends Controller
{
        /**
         * @desc This function is for student and course subscription
         * @returns student and course dropdown list
         */
        public static function courseSubscription()
        {
                $data = [];
                $data['title'] = "Course Subscription";
                
                $data['student'] = Student::fetchAll();
                $data['course'] = Course::fetchAll();
                
                CourseSubscriptionController::renderView('course-subscription', $data);
        }
        
        /**
         * @desc This function is used for course subscription
         * @params $studentId, $courseId
         */
        public static function courseSubscriptionAjaxHandler()
        {
                $createCourseSubscription = new CreateCourseSubscription();
                $createCourseSubscription->requestData = $_POST;
                $output = $createCourseSubscription->processBusinessRules();
                echo json_encode($output);
                die;
        }
        
        /**
         * @desc This function is for displaying subscribed course report
         * @returns course subscription report
         */
        public static function courseSubscriptionList()
        {
                $data = [];
                $data['title'] = "Course Subscription List";
                
                $postData = $_POST;
                $fetchCourseSubscriptionModel = new FetchCourseSubscription();
                $fetchCourseSubscriptionModel->requestData = $postData;
                $output = $fetchCourseSubscriptionModel->processBusinessRules();
                $data = array_merge($data, $output);
                
                StudentController::renderView('course-subscription-list', $data);
        }
        
}

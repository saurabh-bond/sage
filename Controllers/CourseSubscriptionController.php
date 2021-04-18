<?php
require_once './Models/Student.php';
require_once './Models/Course.php';
require_once './Models/CreateCourseSubscription.php';
require_once './Models/FetchCourseSubscription.php';

class CourseSubscriptionController extends Controller
{
        public static function courseSubscription()
        {
                $data = [];
                $data['title'] = "Course Subscription";
                
                $data['student'] = Student::fetchAll();
                $data['course'] = Course::fetchAll();
                
                CourseSubscriptionController::renderView('course-subscription', $data);
        }
        
        public static function courseSubscriptionAjaxHandler()
        {
                $createCourseSubscription = new CreateCourseSubscription();
                $createCourseSubscription->requestData = $_POST;
                $output = $createCourseSubscription->processBusinessRules();
                echo json_encode($output);
                die;
        }
        
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

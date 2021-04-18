<?php

Route::call('index.php', function () {
        Index::renderView('index');
});

Route::call('student-registration', function () {
        StudentController::registration();
});

Route::call('student-list', function () {
        StudentController::studentList();
});

Route::call('removeStudentAjaxHandler', function () {
        StudentController::removeStudent();
});

Route::call('course-add', function () {
        CourseController::addCourse();
});

Route::call('course-list', function () {
        CourseController::courseList();
});

Route::call('course-subscription', function () {
        CourseSubscriptionController::courseSubscription();
});

Route::call('courseSubscriptionAjaxHandler', function () {
        CourseSubscriptionController::courseSubscriptionAjaxHandler();
});

Route::call('course-subscription-list', function () {
        CourseSubscriptionController::courseSubscriptionList();
});

?>

<?php

namespace Controller;

use Src\Auth\Auth;
use Src\View;
use Src\Request;
use Model\User;
use Model\Discipline;
use Model\Student;
use Model\Performance;
use Model\Group;
use Src\Validator\Validator;

class Site
{

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if($validator->fails()){
                return new View('site.signup',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }


    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function discipline(Request $request): string
    {
        if($request->method === 'POST'){
            $validator = new Validator($request->all(), [
                'discipline_name' => ['required'],
            ], [
                'required' => 'Поле :field пусто',
            ]);

            if($validator->fails()){
                return new View('site.discipline', ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if(Discipline::create($request->all())){
                app()->route->redirect('/hello');
            }
        }
        return new View('site.discipline', ['message' => '']);
    } 

    public function student(Request $request): string
    {
        $groups = Group::all();

        if($request->method === 'POST'){
            $validator = new Validator($request->all(), [
                'last_name' => ['required'],
                'first_name' => ['required'],
                'middle_name' => ['required'],
                'gender' => ['required'],
                'birth_date' => ['required'],
                'address' => ['required'],
                'group_id' => ['required'],
                'image' => ['required'],
            ], [
                'required' => 'Поле :field пусто',
            ]);

            if($validator->fails()){
                return new View('site.student', ['groups' => $groups, 'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            $image = $request->all()['image'];
            $image_name = $image['name'];
            $image_tmp = $image['tmp_name'] ;
            $img_ex = pathinfo($image_name, PATHINFO_EXTENSION);

            $new_path = 'uploads/';
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex;
            move_uploaded_file($image_tmp, $new_path . $new_img_name);

            $studentData = $request->all();
            $studentData['image'] = $new_path . $new_img_name;

            if(Student::create($studentData)){
                app()->route->redirect('/hello');
            }
        }
        return new View('site.student', ['groups' => $groups , 'message' => '']);
    }

    public function group(Request $request): string
    {
        $disciplines = Discipline::all();

        if($request->method === 'POST'){
            $validator = new Validator($request->all(), [
                'discipline_id' => ['required'],
                'group_number' => ['required'],
                'speciality' => ['required'],
                'course' => ['required'],
                'semester' => ['required'],
            ], [
                'required' => 'Поле :field пусто',
            ]);

            if($validator->fails()){
                return new View('site.group', ['disciplines' => $disciplines, 'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if(Group::create($request->all())){
                app()->route->redirect('/hello');
            }
        }
        return new View('site.group', ['disciplines' => $disciplines, 'message' => '']);
    }    

    public function performance(Request $request): string
    {
        $students = Student::all();
        $disciplines = Discipline::all();
        
        if($request->method === 'POST'){
            $validator = new Validator($request->all(), [
                'discipline_id' => ['required'],
                'student_id' => ['required'],
                'avg' => ['required'],
                'hours' => ['required'],
            ], [
                'required' => 'Поле :field пусто',
            ]);

            if($validator->fails()){
                return new View('site.performance', ['students'=> $students, 'disciplines' => $disciplines, 'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if(Performance::create($request->all())){
                app()->route->redirect('/performance');
            }
        }

        return new View('site.performance', ['students'=> $students, 'disciplines' => $disciplines, 'message' => '']);
    }

    public function student_list(Request $request): string
    {
        $disciplines = Discipline::all();

        if($request->method === 'POST'){
            $temp = $request->all();
            $discipline_id = $temp['discipline'];
            if(!empty($discipline_id)){
                app()->route->redirect('/student-list?discipline='.$discipline_id);
            }
            else {
                app()->route->redirect('/student-list');
            }
        }

        if(array_key_exists('discipline', $request->all())){
            $discipline_id = $request->discipline;
            
            $performances = Group::where('discipline_id', $discipline_id)->get();
            
            $studentsingroup = [];

            foreach($performances as $performance){
                $student_id = $performance->group_id;

                $studentPerformance = Student::where('group_id', $student_id)->get(); 
                foreach($studentPerformance as $student){
                    $studentsingroup[] = $student;
                }
            }
            $students = $studentsingroup;
        }
        else{
            $students = Student::all();
        }

        foreach($students as $student){
            $studentPerformance = Performance::where('student_id', $student->student_id)->get();
            foreach($studentPerformance as $stpf){
                $disciplineName = Discipline::where('discipline_id', $stpf->discipline_id)->get();
                $stpf->discipline_id = $disciplineName[0]->discipline_name;
                $student->performance = $studentPerformance;
            }
        }
        return new View('site.student-list', ['disciplines' => $disciplines, 'students' => $students]);
    }

    public function student_group(Request $request): string
    {
        $groups = Group::all();
        $disciplines = Discipline::all();

        if($request->method === 'POST'){
            $temp = $request->all();
            $discipline_id = $temp['discipline_id'];
            $group_id = $temp['group_id'];
            
            if (!empty($discipline_id) && !empty($group_id)) {
                app()->route->redirect('/student-group?discipline=' . $discipline_id . '&group=' . $group_id);
            } elseif (!empty($discipline_id)){
                app()->route->redirect('/student-group?discipline=' . $discipline_id);
            }  elseif (!empty($group_id)){
                app()->route->redirect('/student-group?group=' . $group_id);
            } 
            else {
                app()->route->redirect('/student-group');
            }
        }

        if (array_key_exists('discipline', $request->all()) && array_key_exists('group', $request->all())) {
            $discipline_id = $request->discipline;
            $group_id = $request->group;
            
            $performances = Group::where('group_id', $group_id)->get();
            
            $studentsingroup = [];

            foreach($performances as $performance){
                $student_id = $performance->group_id;

                $studentPerformance = Student::where('group_id', $student_id)->get(); 
                foreach($studentPerformance as $student){
                    $studentsingroup[] = $student;
                }
            }


            $students = $studentsingroup;
            
            foreach($students as $student){
                $studentPerformance = Performance::where('student_id', $student->student_id)->get();
                foreach($studentPerformance as $stpf){
                    $disciplineName = Discipline::where('discipline_id', $stpf->discipline_id)->get();
                    $stpf->discipline_id = $disciplineName[0]->discipline_name;
                    $student->performance = $studentPerformance;
                }
            }
        } elseif(array_key_exists('discipline', $request->all())){
            $discipline_id = $request->discipline;
            
            $performances = Group::where('discipline_id', $discipline_id)->get();

            $studentsingroup = [];

            foreach($performances as $performance){
                $student_id = $performance->group_id;

                $studentPerformance = Student::where('group_id', $student_id)->get(); 
                foreach($studentPerformance as $student){
                    $studentsingroup[] = $student;
                }
            }

            $students = $studentsingroup;
            
            foreach($students as $student){
                $studentPerformance = Performance::where('student_id', $student->student_id)->get();
                foreach($studentPerformance as $stpf){
                    $disciplineName = Discipline::where('discipline_id', $stpf->discipline_id)->get();
                    $stpf->discipline_id = $disciplineName[0]->discipline_name;
                    $student->performance = $studentPerformance;
                }
            }
        } elseif(array_key_exists('group', $request->all())){
            $group_id = $request->group;
            $students = Student::where('group_id', $group_id)->get();  
            
            
            foreach($students as $student){
                $studentPerformance = Performance::where('student_id', $student->student_id)->get();
                foreach($studentPerformance as $performance){
                    $disciplineName = Discipline::where('discipline_id', $performance->discipline_id)->get();
                    $performance->discipline_id = $disciplineName[0]->discipline_name;
                    $student->performance = $performance;
                }
            }
        } else {
            $students = Student::all();

            foreach($students as $student){
                $studentPerformance = Performance::where('student_id', $student->student_id)->get();
                foreach($studentPerformance as $stpf){
                    $disciplineName = Discipline::where('discipline_id', $stpf->discipline_id)->get();
                    $stpf->discipline_id = $disciplineName[0]->discipline_name;
                    $student->performance = $studentPerformance;
                }
            }
        }
        return new View('site.student-group', ['disciplines' => $disciplines, 'groups' => $groups , 'students' => $students]);
    }

    public function discipline_list(Request $request): string
    {
        $disciplines = Discipline::all();
        $filter = Group::all();

        if($request->method === 'POST'){
            $temp = $request->all();
            $group = $temp['group'];
            $semester = $temp['semester'];
            $course = $temp['course'];

            if (!empty($group) && !empty($semester) && !empty($course)) {
                app()->route->redirect('/discipline-list?group=' . $group . '&semester=' . $semester . '&course=' . $course);
            } elseif (!empty($group) && !empty($semester)) {
                app()->route->redirect('/discipline-list?group=' . $group . '&semester=' . $semester);
            } elseif (!empty($group) && !empty($course)) {
                app()->route->redirect('/discipline-list?group=' . $group . '&course=' . $course);
            } elseif (!empty($semester) && !empty($course)) {
                app()->route->redirect('/discipline-list?semester=' . $semester . '&course=' . $course);
            } elseif (!empty($group)){
                app()->route->redirect('/discipline-list?group=' . $group);
            } elseif (!empty($semester)){
                app()->route->redirect('/discipline-list?semester=' . $semester);
            } elseif (!empty($course)){
                app()->route->redirect('/discipline-list?course=' . $course);
            } else {
                app()->route->redirect('/discipline-list');
            }
        }

        if (array_key_exists('group', $request->all()) && array_key_exists('semester', $request->all()) && array_key_exists('course', $request->all())) {
            $group_id = $request->group;
            $semester_id = $request->semester;
            $course_id = $request->course;

            $groups = Group::where('group_id', $group_id)->where('semester' , $semester_id)->where('course', $course_id)->get();
            foreach($groups as $group){
                $disciplineName= Discipline::where('discipline_id', $group->discipline_id)->get();
                $group->discipline_id = $disciplineName[0]->discipline_name;
            }
        }
        elseif (array_key_exists('group', $request->all()) && array_key_exists('semester', $request->all())) {
            $group_id = $request->group;
            $semester_id = $request->semester;

            $groups = Group::where('group_id', $group_id)->where('semester' , $semester_id)->get();
            foreach($groups as $group){
                $disciplineName= Discipline::where('discipline_id', $group->discipline_id)->get();
                $group->discipline_id = $disciplineName[0]->discipline_name;
            }
        }
        elseif (array_key_exists('group', $request->all()) && array_key_exists('course', $request->all())) {
            $group_id = $request->group;
            $course_id = $request->course;
            
            $groups = Group::where('group_id', $group_id)->where('course', $course_id)->get();
            foreach($groups as $group){
                $disciplineName= Discipline::where('discipline_id', $group->discipline_id)->get();
                $group->discipline_id = $disciplineName[0]->discipline_name;
            }
        }
        elseif (array_key_exists('semester', $request->all())  && array_key_exists('course', $request->all())){
            $semester_id = $request->semester;
            $course_id = $request->course;
            
            $groups = Group::where('semester' , $semester_id)->where('course', $course_id)->get();
            foreach($groups as $group){
                $disciplineName= Discipline::where('discipline_id', $group->discipline_id)->get();
                $group->discipline_id = $disciplineName[0]->discipline_name;
            }
        }
        elseif (array_key_exists('group', $request->all())){
            $group_id = $request->group;
            
            $groups = Group::where('group_id' , $group_id)->get();
            foreach($groups as $group){
                $disciplineName= Discipline::where('discipline_id', $group->discipline_id)->get();
                $group->discipline_id = $disciplineName[0]->discipline_name;
            }
        }
        elseif (array_key_exists('semester', $request->all())){
            $semester_id = $request->semester;
            
            $groups = Group::where('semester' , $semester_id)->get();
            foreach($groups as $group){
                $disciplineName= Discipline::where('discipline_id', $group->discipline_id)->get();
                $group->discipline_id = $disciplineName[0]->discipline_name;
            }
        }
        elseif (array_key_exists('course', $request->all())){
            $course_id = $request->course;
            
            $groups = Group::where('course' , $course_id)->get();
            foreach($groups as $group){
                $disciplineName= Discipline::where('discipline_id', $group->discipline_id)->get();
                $group->discipline_id = $disciplineName[0]->discipline_name;
            }
        }
        else{
            $groups = Group::all();
            foreach($groups as $group){
                $disciplineName= Discipline::where('discipline_id', $group->discipline_id)->get();
                $group->discipline_id = $disciplineName[0]->discipline_name;
            }
        }

        return new View('site.discipline-list', ['disciplines' => $disciplines, 'groups' => $filter, 'items' => $groups]);
    }

    public function poisk(Request $request): string
    {
        $students = Student::all();

        if($request->method === 'POST'){
            $studentName = $request->all()['student_name'];
            $students = Student::where('first_name', 'LIKE', "%$studentName%")->get();
        }

        return new View('site.poisk', ['students' => $students]);
    }
}

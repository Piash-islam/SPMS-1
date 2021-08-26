<?php

    $query = "SELECT department, program, semester, course, credits, student_id, SUM(obtained) as 'total' FROM
    (SELECT section.semester, course.id as 'course', course.credits, enrollment.student_id, program.name as 'program', department.id as 'department', 
    IF(assessment.type = 'final', (SUM(evaluation.obtained_mark) / SUM(assessment.mark)) * 40, (SUM(evaluation.obtained_mark) / SUM(assessment.mark)) * 30) as 'obtained', assessment.type
    FROM department LEFT JOIN program on department.id = program.department_id 
    LEFT JOIN course on program.id = course.program_id 
    LEFT JOIN section ON course.id = section.course_id 
    LEFT JOIN assessment ON section.id = assessment.section_id 
    LEFT JOIN evaluation ON assessment.id = evaluation.assessment_id 
    LEFT JOIN co ON assessment.section_id = co.section_id AND assessment.co_number = co.indx 
    LEFT JOIN plo ON co.plo_id = plo.id 
    LEFT JOIN enrollment ON evaluation.enrollment_id = enrollment.id 
    WHERE section.semester = LOWER('$semester')
    GROUP BY course.id, enrollment.student_id, assessment.type, course.id) as iQuery
    GROUP BY semester, student_id, course";

    $result = $conn->query($query);

    $data = array();

    foreach($result as $r){
        if(!array_key_exists($r['course'], $data)){
            $data[$r['course']] = array();
            $data[$r['course']]['gpa']=0;
            $data[$r['course']]['student']=0;
        }
        

        if($r['total']>=85){
            $data[$r['course']]['gpa'] += 4.0;
        }else if($r['total']>=80){
            $data[$r['course']]['gpa'] += 3.7;
        }else if($r['total']>=75){
            $data[$r['course']]['gpa'] += 3.3;
        }else if($r['total']>=70){
            $data[$r['course']]['gpa'] += 3.0;
        }else if($r['total']>=65){
            $data[$r['course']]['gpa'] += 2.7;
        }else if($r['total']>=60){
            $data[$r['course']]['gpa'] += 2.3;
        }else if($r['total']>=55){
            $data[$r['course']]['gpa'] += 2.0;
        }else if($r['total']>=50){
            $data[$r['course']]['gpa'] += 1.7;
        }else if($r['total']>=45){
            $data[$r['course']]['gpa'] += 1.3;
        }else if($r['total']>=40){
            $data[$r['course']]['gpa'] += 1.0;
        }

        $data[$r['course']]['student']++;
    }

    $course = array();

    foreach($data as $k => $crs){
        $course[strtoupper($k)] = round(($crs['gpa'] / $crs['student']), 2);
    }  
    

?>
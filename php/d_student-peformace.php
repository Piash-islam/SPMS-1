<?php
    include 'mysql.php';

    $query = "SELECT name FROM school WHERE id = ".$_SESSION['school'];
    $school_name = $conn->query($query)->fetch_row()[0];

    $query = "SELECT dean FROM school WHERE id = ".$_SESSION['school'];
    $school_dean = $conn->query($query)->fetch_row()[0];

    $school_id = $_SESSION['school'];

    if(isset($_GET['semester'])){
        $semester = $_GET['semester'];
        include 'd_student-peformance-dep.php';
        include 'd_student-peformance-prog.php';
        include 'd_student-peformance-crs.php';
        include 'd_student-peformance-fac.php';

        // foreach($department as $k => $v){
        //     echo $k ." ". $v."<br/>";
        // }
        // foreach($program as $k => $v){
        //     echo $k ." ". $v."<br/>";
        // }
        // foreach($course as $k => $v){
        //     echo $k ." ". $v."<br/>";
        // }
        // foreach($faculty as $k => $v){
        //     echo $k ." ". $v."<br/>";
        // }
    }

?>
<?php
include('db.php');

if (isset($_GET['key'])) {
    $key = mysqli_real_escape_string($con, $_GET['key']);
    $query = "SELECT * FROM api_token WHERE token = '$key'";
    $checkKey = mysqli_query($con, $query);
    if (mysqli_num_rows($checkKey) > 0) {
        $checkStatus = mysqli_fetch_assoc($checkKey);
        // var_dump($checkStatus);die;
        if ($checkStatus['status'] == 1) {
            if($checkStatus['hit_count'] >= $checkStatus['hit_limit']){
                echo json_encode(['status' => 'false', 'msg' => 'API hit limit exceed']);
                die;
            }else{
                 $updateCount = "UPDATE api_token SET hit_count = hit_count + 1 WHERE token = '$key'";
                // die;
                mysqli_query($con,$updateCount);
            }
            $sql = "SELECT * FROM user";
            $res = mysqli_query($con, $sql);
            $count = mysqli_num_rows($res);
            
            header('Content-Type:application/json');
            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $arr[] = $row;
                }
                echo json_encode(['status' => 'true', 'data' => $arr, 'result' => 'found']);
            } else {
                echo json_encode(['status' => 'true', 'msg' => 'No data found', 'result' => 'not']);
            }
        } else {
            echo json_encode(['status' => 'false', 'msg' => 'API key deactivated']);
        }
    } else {
        echo json_encode(['status' => 'false', 'msg' => 'Please provive valid api key']);
    }
} else {
    echo json_encode(['status' => 'false', 'msg' => 'Please provive api key']);
}

<?php namespace app\helpers;

function checkSqlExecution ($stmt)
{
    if($stmt->execute()){
        $response = ['status' => 1, 'message' => 'Record created'];
        print_r($response);
    } else {
        $response = ['status' => 0, 'message' => 'Failed created'];
        print_r($response);
    }
}

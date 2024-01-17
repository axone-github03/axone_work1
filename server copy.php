<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, GET, POST');

include 'connect.php';

$response = [];
$responserow = [];
$upload_dir = '../uploads/floor/';

if (isset($_POST['project_id']) && isset($_POST['floor_id']) && isset($_POST['image'])) {
    $project_id = $_POST['project_id'];
    $floor_id = $_POST['floor_id'];
    $imagebase64 = $_POST['image'];

    // $date_save = date('y-m-d H:i:s');

    date_default_timezone_set('Asia/Kolkata'); //India Time (GMT +5:30)
    $date_save = date('y-m-d');

    if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
        $base64String = substr($base64String, strpos($base64String, ',') + 1);
        $type = strtolower($type[1]); // jpg, png, gif, etc.
        if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
            // throw new \Exception('Invalid image type');
            $response['RETURNCODE'] = '0';
            $response['RETURNMESSAGE'] = 'Invalid image type';
            $response['ALERTTYPECODE'] = '0';
        }
    } else {
        // throw new \Exception('Invalid image data');
        $response['RETURNCODE'] = '0';
        $response['RETURNMESSAGE'] = 'Invalid image data';
        $response['ALERTTYPECODE'] = '0';
    }

    // Decode the Base64 string
    $data = base64_decode($base64String);

    // Check if decoding was successful
    if ($data === false) {
        // throw new \Exception('Base64 decode failed');
        $response['RETURNCODE'] = '0';
        $response['RETURNMESSAGE'] = 'Base64 decode failed';
        $response['ALERTTYPECODE'] = '0';
    }

    // Save the decoded data to a file
    $file = $upload_dir . $project_id . $floor_id . uniqid('_file_') . '.' . $type;
    $file_path = $upload_dir . $project_id . $floor_id . uniqid('_file_') . '.' . $type;
    if (file_put_contents($file, $data) === false) {
        $response['RETURNCODE'] = '0';
        $response['RETURNMESSAGE'] = 'File write failed';
        $response['ALERTTYPECODE'] = '0';
    }

    $sql =
        "INSERT INTO mst_floor_images (`project_id`, `floor_id`, `date`, `url`,`created_at`) VALUES
        ('" .
        $project_id .
        "', '" .
        $floor_id .
        "', '" .
        $date_save .
        "', '" .
        $file .
        "','" .
        $date_save .
        "')";

    if ($conn->query($sql) === true) {
        $response['RETURNCODE'] = '1';
        $response['RETURNMESSAGE'] = "Floor Image Saved Successfully";
        $response['ALERTTYPECODE'] = '1';
    } else {
        $response['RETURNCODE'] = '0';
        $response['RETURNMESSAGE'] = mysqli_error($conn);
        $response['ALERTTYPECODE'] = '0';
    }
} else {
    $response['RETURNCODE'] = '0';
    $response['RETURNMESSAGE'] = 'required parameters are not available 11';
    $response['ALERTTYPECODE'] = '0';
}

$rowdata['ZMESSAGE'] = [$response];
$rowdata['ROW'] = [$responserow];

$set = $rowdata;

header('Content-Type: application/json; charset=utf-8');
echo $val = str_replace('\\/', '/', json_encode($set, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

<?php
function saveCarImageUpload($imageUpload)
{
    if (!is_array($imageUpload)
        || !isset($imageUpload['error'], $imageUpload['size'], $imageUpload['name'], $imageUpload['tmp_name'])
        || !is_int($imageUpload['error'])
        || !is_numeric($imageUpload['size'])
        || !is_string($imageUpload['name'])
        || !is_string($imageUpload['tmp_name'])
        || $imageUpload['tmp_name'] === '')
    {
        return array('path' => '', 'absolute_path' => '', 'error' => 'ERRCARIMGUPLOAD');
    }

    if ($imageUpload['error'] != UPLOAD_ERR_OK || $imageUpload['size'] > 5 * 1024 * 1024)
    {
        return array('path' => '', 'absolute_path' => '', 'error' => 'ERRCARIMGUPLOAD');
    }

    $allowedExtensions = array('jpg', 'jpeg', 'png');
    $allowedMimeTypes = array('image/jpeg', 'image/png');
    $fileExtension = strtolower(pathinfo($imageUpload['name'], PATHINFO_EXTENSION));
    if (!is_uploaded_file($imageUpload['tmp_name']))
    {
        error_log('Rejected a car image that was not uploaded through the request.');
        return array('path' => '', 'absolute_path' => '', 'error' => 'ERRCARIMGUPLOAD');
    }

    $imageInfo = getimagesize($imageUpload['tmp_name']);
    if (!in_array($fileExtension, $allowedExtensions, true) || $imageInfo === false || !in_array($imageInfo['mime'], $allowedMimeTypes, true))
    {
        return array('path' => '', 'absolute_path' => '', 'error' => 'ERRCARIMGTYPE');
    }

    $uploadDirectory = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'cars';
    if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory))
    {
        error_log('Unable to create the car image upload directory.');
        return array('path' => '', 'absolute_path' => '', 'error' => 'ERRCARIMGUPLOAD');
    }

    $imageFileName = bin2hex(random_bytes(16)) . '.' . $fileExtension;
    $uploadedImagePath = $uploadDirectory . DIRECTORY_SEPARATOR . $imageFileName;
    if (!move_uploaded_file($imageUpload['tmp_name'], $uploadedImagePath))
    {
        error_log('Unable to save an uploaded car image.');
        return array('path' => '', 'absolute_path' => '', 'error' => 'ERRCARIMGUPLOAD');
    }

    return array(
        'path' => 'images/cars/' . $imageFileName,
        'absolute_path' => $uploadedImagePath,
        'error' => ''
    );
}

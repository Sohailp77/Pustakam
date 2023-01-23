<?php

use Plivo\RestClient;

function base64_url_encode($input)
{
    return strtr(base64_encode($input), '+/=', '._-');
}

function base64_url_decode($input)
{
    return base64_decode(strtr($input, '._-', '+/='));
}
function in_array_r($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
function imageadd_multiple($path, $files, $wd, $ht)
{
    $CI = &get_instance();
    $config = array(
        'upload_path'   => $path,
        'allowed_types' => 'gif|jpg|jpeg|png',
        'max_size' => '0',
        'max_width' => '0',
        'max_height' => '0',
    ); 
    if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
    }
    $CI->load->library('upload', $config);
    $images = array();
    foreach ($files['name'] as $key => $image) {
        $_FILES['images[]']['name'] = $files['name'][$key];
        $_FILES['images[]']['type'] = $files['type'][$key];
        $_FILES['images[]']['tmp_name'] = $files['tmp_name'][$key];
        $_FILES['images[]']['error'] = $files['error'][$key];
        $_FILES['images[]']['size'] = $files['size'][$key];
        $config['file_name'] = $image;
        $CI->upload->initialize($config);
        if (!$CI->upload->do_upload('images[]'))
            $CI->upload->display_errors();
        else {
            $config1 = [];
            $fInfo = $CI->upload->data(); //uploading
            $CI->thumb_path = $path . 'thumb'; //fetching path
            if (!is_dir($CI->thumb_path)) {
                mkdir($CI->thumb_path, 0777, TRUE);
            }
            $config1 = array(
                'source_image' => $fInfo['full_path'], //get original image
                'new_image' => $CI->thumb_path, //save as new image //need to create thumbs first
                'maintain_ratio' => false,
                'width' => $wd,
                'height' => $ht
            );
            $CI->load->library('image_lib', $config1); //load library
            $CI->image_lib->initialize($config1);
//            $CI->image_lib->resize(); //generating thumb
        }
        $images[] = $fInfo['file_name'];
    }
    return $images;
}
function Send_mail($email, $subject, $message, $arrAttachments = array())
{
    $CI = &get_instance();
    $CI->load->library('email');
    $CI->email->initialize(array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.hostinger.com',
        'smtp_user' => 'admin@audiopustakam.com',
        'smtp_pass' => 'Audiopustakam@2022',
        'smtp_port' => '587',
        'smtp_timeout' => '7',
        'crlf' => "\r\n",
        'newline' => "\r\n",
        'mailtype' => 'html', //plaintext 'text' mails or 'html'
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE,
    ));
    $CI->email->from('admin@audiopustakam.com', 'audioPustakam');
    $CI->email->to('admin@audiopustakam.com');
    $CI->email->subject($subject);
    $CI->email->message($message);

    if(count($arrAttachments) > 0){
        foreach($arrAttachments as $strAttachPath){
            $CI->email->attach($strAttachPath);
        }
    }

    if ($CI->email->send()) {
        return true;
    } else {
        // $CI->email->print_debugger();
        return false;
    }
}

function image_upload($path, $img, $wd = 0, $ht = 0, $custom_name = "", $fl_overwrite = false)
{
    $CI = &get_instance();
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'gif|jpg|png|jpeg|mp4';
    $config['max_size'] = '0';
    $config['max_width'] = '0';
    $config['max_height'] = '0';
    $config['file_name'] = $custom_name;
    $config['overwrite'] = $fl_overwrite;
    $CI->load->library('upload');
    $CI->upload->initialize($config);
    if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
    }
    if (!$CI->upload->do_upload($img)) {
        $error = array('error' => $CI->upload->display_errors());
        return $error;
    }else {

        $upload_data = $CI->upload->data();

        if($wd > 0 && $ht > 0){
            $data['upload_data'] = $upload_data;
            $source_img = $upload_data['full_path'];    //Defining the Source Image
            $new_img = $upload_data['file_path'] . $upload_data['raw_name'] . $upload_data['file_ext'];  //Defining the Destination/New Image
            $data['source_image'] = $new_img;
            if (image_resize($upload_data, $source_img, $new_img, $wd, $ht)) {  //Creating Thumbnail for Gallery which keeps the original
                $filename =  $upload_data['raw_name'] . $upload_data['file_ext'];
                return ['error' => '', 'filename' => $filename];
            }
        }
        else{
            $filename =  $upload_data['raw_name'] . $upload_data['file_ext'];
            return ['error' => '', 'filename' => $filename];
        }
    }
}

function file_upload($path, $file, $allowed_types = NULL)
{
    $CI = &get_instance();
    $config['upload_path'] = $path;
    $config['allowed_types'] = $allowed_types ? $allowed_types : 'jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
    $config['max_size']      = 1024000;
    $CI->load->library('upload');
    $CI->upload->initialize($config);
    if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
    }
    if (!$CI->upload->do_upload($file)) {
        $error = array('error' => $CI->upload->display_errors('', ''));
        return $error;
    } else {
        $upload_data = $CI->upload->data();
        $filename =  $upload_data['raw_name'] . $upload_data['file_ext'];
        return ['error' => '', 'filename' => $filename];
    }
}

function image_resize($upload_data, $source_img, $new_img, $width, $height)
{
    $CI = &get_instance();
    //Copy Image Configuration
    $config['image_library'] = 'gd2';
    $config['source_image'] = $source_img;
    $config['create_thumb'] = TRUE;
    $config['new_image'] = $new_img;
    $config['quality'] = '100%';
    $CI->load->library('image_lib');
    $CI->image_lib->initialize($config);
    if (!$CI->image_lib->resize()) {
        $error = array('error' => $CI->image_lib->display_errors());
        return $error;
    } else {
        //Images Copied
        //Image Resizing Starts
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_img;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['quality'] = '100%';
        $config['new_image'] = $source_img;
        $config['overwrite'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        $dim = (intval($upload_data['image_width']) / intval($upload_data['image_height'])) - ($config['width'] / $config['height']);
        $config['master_dim'] = ($dim > 0) ? 'height' : 'width';
        $CI->image_lib->clear();
        $CI->image_lib->initialize($config);
        if (!$CI->image_lib->resize()) {
            $error = array('error' => $CI->image_lib->display_errors());
            return $error;
        } else {
            //echo 'Thumnail Created';
            return true;
        }
    }

}

function sendSMS($mobile, $message)
{
    // $client = new RestClient("MAYZEXZWVHYTE3M2VIMT", "NWFjNDY4NjYzNWMxMGMyNDZhYTUzMThiMzQ3MzFi");
    // // $client = new RestClient("MAY2JMNTK3M2RHN2NKOT", "MDIwZTg5ZTNiOGJjYmU3MzY1NzA1YWRhZTI0ZGYz");
    // $message_created = "";
    // try {
    //     $message_created = $client->messages->create(
    //         '+918078041901',
    //         [$mobile],
    //         $message
    //     );
    // } catch (Exception $e) {
    //     echo 'Message: ' . $e->getMessage();
    // }

    // return $message_created;

    $msg = rawurlencode($message);

    $url = "http://adlinks.websmsc.com/api/sendhttp.php?authkey=2617ArI5wR4voxu61de66f2P43&mobiles=".$mobile."&message=".$msg."&sender=BEuTIK&route=4&country=91&DLT_TE_ID=1607100000000184990";

    $ch = curl_init();                       // initialize CURL
    curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);                         // Close CURL

    // Use file get contents when CURL is not installed on server.
    if(!$output){
       $output =  file_get_contents($url);  
    }

    return $output;
}

function video_upload($path, $video,$custom_name = "", $fl_overwrite = false)
{
    $CI = &get_instance();
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'mp4';
    $config['max_size'] = '0';
    $config['max_width'] = '0';
    $config['max_height'] = '0';
    $config['file_name'] = $custom_name;
    $config['overwrite'] = $fl_overwrite;
    $CI->load->library('upload');
    $CI->upload->initialize($config);
    if (!is_dir($config['upload_path'])) 
    {
        mkdir($config['upload_path'], 0777, TRUE);
    }
    if (!$CI->upload->do_upload($video)) 
    {
        $error = array('error' => $CI->upload->display_errors());
        return $error;
    }
    else 
    {
        $upload_data = $CI->upload->data();
        $filename =  $upload_data['raw_name'] . $upload_data['file_ext'];
        return ['error' => '', 'filename' => $filename];
    }
}
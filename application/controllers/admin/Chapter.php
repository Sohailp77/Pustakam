<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chapter extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata(ADMIN_SESSION_NAME)) {
            redirect('admin/logout');
        }

        $this->load->model('Chapter_model');
        $this->load->model('Common_model');

    }
    // Default function
    public function index($ParentId = 0)
    {
       
        $objChapter = $this->Chapter_model->getChapter();

     
        $arrChapter = array();
        $intCount = 0;
        if ($objChapter) {

            $update = $this->Common_model->get_moduleId('Chapter', 'update');
            $delete = $this->Common_model->get_moduleId('Chapter', 'delete');

            foreach ($objChapter as $objChapterInfo) {

                $arrChapter[$intCount]['CL'] = htmlentities($objChapterInfo->class);
                $arrChapter[$intCount]['CP'] = htmlentities($objChapterInfo->chapter);
                $arrChapter[$intCount]['TT'] = htmlentities($objChapterInfo->state);
                $arrChapter[$intCount]['DS'] = htmlentities($objChapterInfo->description);
                $arrChapter[$intCount]['SO'] = htmlentities($objChapterInfo->sort_order);
                $arrChapter[$intCount]['PT'] = ($objChapterInfo->payment == "Y") ? "Paid" : "Free";
                $arrChapter[$intCount]['ST'] = ($objChapterInfo->status == "Y") ? "Active" : "Inactive";

                if (in_array($update->module_id, $this->session->permission)) {
                    $updateLink = "<a href=\"" . site_url('admin/chapter/update/' . $objChapterInfo->cid) . "\" class=\"px-3 text-primary\" title=\"Edit\"><i class=\"uil uil-pen font-size-18\"></i></a>";
                } else {
                    $updateLink = "";
                }
                if (in_array($delete->module_id, $this->session->permission)) {
                    $deleteLink = "<a href=\"" . site_url('admin/chapter/delete/' . $objChapterInfo->cid) . "\" onclick=\"javascript: return confirm('Are you sure?')\" class=\"px-3 text-danger\" title=\"Delete\"><i class=\"uil uil-trash-alt font-size-18\"></i></a>";
                } else {
                    $deleteLink = "";
                }

                $ListLink = "<a href=\"" . site_url('admin/chapter/chapter_list/' . $objChapterInfo->cid) . "\" class=\"px-3 text-success\" title=\"List\"><i class=\"uil uil-align font-size-18\"></i></a>";

                $arrChapter[$intCount]['BN'] = "<ul class=\"list-inline mb-0\"> <li class=\"list-inline-item dropdown\">" . $updateLink . "</li>
                     <li class=\"list-inline-item dropdown\">" . $deleteLink . "</li><li class=\"list-inline-item dropdown\">" . $ListLink . "</li></ul>";

                $intCount++;
            }
        }

        $arrStatus = array(
            "Y" => "Active",
            "N" => "Inactive",
        );

        $arrPayment = array(
            "Y" => "Paid",
            "N" => "Free",
        );

        // Pass view params
        $arrViewParams = array();
        $arrViewParams['parentPage'] = "Catalogue";
        $arrViewParams['pageTitle'] = "Chapter";
        $arrViewParams['pageCode'] = "CH";
        $arrViewParams['arrStatus'] = $arrStatus;
        $arrViewParams['arrChapter']=$arrChapter;
        $arrViewParams['arrPayment']=$arrPayment;

        // Function call to display the view contents
        $this->load->adminPages('chapter/list', $arrViewParams);
    }
    // Function to display add screen
    public function create()
    {
        $sortOrder = $this->Chapter_model->getLastsortOrder();
        $Nxtsort = $sortOrder->lastSortOrder ? $sortOrder->lastSortOrder + 1 : '1';

        // Pass view params
        $arrViewParams = array();
        $arrViewParams['arrParentPage'] = array("Catalogue" => "", "Chapter" => site_url('admin/Chapter'));
        $arrViewParams['pageTitle'] = "Add Chapter";
        $arrViewParams['pageCode'] = "AM";
        $arrViewParams['action'] = site_url('admin/Chapter/create_action');
        $arrViewParams['cid'] = set_value('cid');
        $arrViewParams['class'] = set_value('class');
        $arrViewParams['chapter'] = set_value('chapter');
        $arrViewParams['state'] = set_value('state');
        $arrViewParams['description'] = set_value('description');
        $arrViewParams['status'] = set_value('status','Y');
        // $arrViewParams['text_file'] = set_value('text_file');
        $arrViewParams['image_file'] = set_value('image_file');
        $arrViewParams['audio_file'] = set_value('audio_file');
        $arrViewParams['payment'] = set_value('payment','N');
        $arrViewParams['sort_order'] = set_value('sort_order',$Nxtsort);

        $arrViewParams['arrClass']=$this->Chapter_model->getClass();
        $arrViewParams['arrState']=$this->Chapter_model->getState();

        // Function call to display the view contents
        $this->load->adminPages('chapter/form', $arrViewParams);
    }
    // Function to insert/update user group info
    public function create_action()
    {
        $this->form_validation->set_rules('class', 'Class', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('chapter', 'Chapter', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');

        // if(empty($_FILES['text_file']['name'])) {
        //   $this->form_validation->set_rules('text_file', 'Pdf File', 'required');
        // }
        // else{
        //   $text_field = "text_file";
        //   $this->form_validation->set_rules('text_file', 'Pdf File', 'callback_validate_text[' . $text_field . ']');
        // }

        if(empty($_FILES['image_file']['name'])) {
          $this->form_validation->set_rules('image_file', 'Image', 'required');
        }
        else{
          $image_field = "image_file";
          $this->form_validation->set_rules('image_file', 'Image', 'callback_validate_image[' . $image_field . ']');
        }

        if(empty($_FILES['audio_file']['name'])) {
          $this->form_validation->set_rules('audio_file', 'Audio', 'required');
        }
        else{
          $audio_field = "audio_file";
          $this->form_validation->set_rules('audio_file', 'Audio', 'callback_validate_audio[' . $audio_field . ']');
        }

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == TRUE) 
        {

            // $text_file = "";
            // if (!empty($_FILES['text_file']['name'])) {
            //     $upload_data = file_upload(UPLOAD_PATH . 'pdf/', 'text_file','pdf|doc|docx');
            //     if (!$upload_data['error']) {
            //       $text_file = $upload_data['filename'];
            //     }
            // }

            $image_file = "";
            if (!empty($_FILES['image_file']['name'])) {
                $upload_data = file_upload(UPLOAD_PATH . 'images/', 'image_file');
                if (!$upload_data['error']) {
                  $image_file = $upload_data['filename'];
                }
            } 

            $audio_file = "";
            if (!empty($_FILES['audio_file']['name'])) {
                $upload_data = file_upload(UPLOAD_PATH . 'audio/', 'audio_file','mp3|ogg');
                if (!$upload_data['error']) {
                  $audio_file = $upload_data['filename'];
                }
            }

            $arrInsertParams = array(
                "class" => $this->input->post('class'),
                "chapter" => $this->input->post('chapter'),
                "state" => $this->input->post('state'),
                "description" => $this->input->post('description'),
                // "text_file" => $text_file,
                "image_file" => $image_file,
                "audio_file" => $audio_file,
                "payment" => $this->input->post('payment'),
                "sort_order" => $this->input->post('sort_order'),
                "status" => $this->input->post('status'),
            );
            if ($this->Chapter_model->insert($arrInsertParams)) {
                $this->session->set_flashdata('alert', ['message' => 'Record added successfully.', 'type' => 'success']);
            } else {
                $this->session->set_flashdata('alert', ['message' => 'Record NOT added successfully.', 'type' => 'danger']);
            }
            redirect(site_url('admin/chapter'));
        } else {
            $this->create();
        }
    }
    // Function to display form with existing details.
    public function update($id = NULL)
    {
        ini_set("memory_limit", "500000M");
        $row = $this->Chapter_model->get_by_id($id);
        if ($row) {
            // Pass view params
            $arrViewParams = array();
            $arrViewParams['arrParentPage'] = array("Catalogue" => "", "Chapter" => site_url('admin/Chapter'));
            $arrViewParams['pageTitle'] = "Update Chapter";
            $arrViewParams['pageCode'] = "UC";
            $arrViewParams['action'] = site_url('admin/chapter/update_action');
            $arrViewParams['cid'] = set_value('cid',$row->cid);
            $arrViewParams['class'] = set_value('class',$row->class);
            $arrViewParams['chapter'] = set_value('chapter',$row->chapter);
            $arrViewParams['state'] = set_value('state',$row->state);
            $arrViewParams['description'] = set_value('description',$row->description);
            $arrViewParams['status'] = set_value('status',$row->status);
            // $arrViewParams['text_file'] = set_value('text_file',$row->text_file);
            $arrViewParams['image_file'] = set_value('image_file',$row->image_file);
            $arrViewParams['audio_file'] = set_value('audio_file',$row->audio_file);
            $arrViewParams['payment'] = set_value('payment',$row->payment);
            $arrViewParams['sort_order'] = set_value('sort_order',$row->sort_order);

            $arrViewParams['arrClass']=$this->Chapter_model->getClass();
            $arrViewParams['arrState']=$this->Chapter_model->getState();

            $this->load->adminPages('chapter/form', $arrViewParams);
        } else {
            $this->session->set_flashdata('alert', ['message' => 'Record Not Found', 'type' => 'danger']);
            redirect(site_url('admin/chapter'));
        }
    }
    // Function to update user group values.
    public function update_action()
    {   
        $cid = $this->input->post('cid');
        $this->form_validation->set_rules('class', 'Class', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('chapter', 'Chapter', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->update($cid);
        } else {

            // $text_file = "";
            // if (!empty($_FILES['text_file']['name'])) {
            //     $upload_data = file_upload(UPLOAD_PATH . 'pdf/', 'text_file','pdf|doc|docx');
            //     if (!$upload_data['error']) {
            //       $text_file = $upload_data['filename'];
            //     }
            // }
            // else
            // {
            //     $text_file=$this->input->post('text');
            // }

            $image_file = "";
            if (!empty($_FILES['image_file']['name'])) {
                $upload_data = file_upload(UPLOAD_PATH . 'images/', 'image_file');
                if (!$upload_data['error']) {
                  $image_file = $upload_data['filename'];
                }
            }
            else
            {
                $image_file=$this->input->post('image');
            } 

            $audio_file = "";
            if (!empty($_FILES['audio_file']['name'])) {
                $upload_data = file_upload(UPLOAD_PATH . 'audio/', 'audio_file','mp3|ogg');
                if (!$upload_data['error']) {
                  $audio_file = $upload_data['filename'];
                }
            }
            else
            {
                $audio_file=$this->input->post('audio');
            }

            $arrInsertParams = array(
                "class" => $this->input->post('class'),
                "chapter" => $this->input->post('chapter'),
                "state" => $this->input->post('state'),
                "description" => $this->input->post('description'),
                // "text_file" => $text_file,
                "image_file" => $image_file,
                "audio_file" => $audio_file,
                "payment" => $this->input->post('payment'),
                "sort_order" => $this->input->post('sort_order'),
                "status" => $this->input->post('status'),
            );

            if ($this->Chapter_model->update($cid, $arrInsertParams)) {
                $this->session->set_flashdata('alert', ['message' => 'Record updated successfully.', 'type' => 'success']);
            } else {
                $this->session->set_flashdata('alert', ['message' => 'Record NOT updated successfully.', 'type' => 'danger']);
            }
            redirect(site_url('admin/chapter'));
        }
    }
    
    // Function to delete 
    public function delete($id)
    {
        $data = array(
            'deleted_at' => date("Y-m-d H:i:s")
        );
        if ($this->Chapter_model->update($id, $data)) {
            $this->session->set_flashdata('alert', ['message' => 'Delete Record Success', 'type' => 'success']);
        } else {
            $this->session->set_flashdata('alert', ['message' => 'Delete Record Failed', 'type' => 'danger']);
        }
        redirect(site_url('admin/chapter'));
    }

    public function validate_image($image = "", $field_name = "")
    {
        $arrAllowedTypes = array('image/x-png', 'image/png', 'image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg', 'image/gif');

        $strFileType = mime_content_type($_FILES[$field_name]["tmp_name"]);
            
        if(!in_array($strFileType, $arrAllowedTypes)){
            $this->form_validation->set_message('validate_image', 'Invalid file type. Supported file types are .jpg, .jpeg, .png and .gif');
            return false;
        }

        return true;
    }

    // public function validate_text($text = "", $field_name = "")
    // {
    //     $arrAllowedTypes = array('application/pdf', 'application/msword', 'application/vnd.ms-powerpoint', 'application/vnd.oasis.opendocument.text', 'application/vnd.oasis.opendocument.spreadsheet');

    //     $strFileType = mime_content_type($_FILES[$field_name]["tmp_name"]);
            
    //     if(!in_array($strFileType, $arrAllowedTypes)){
    //         $this->form_validation->set_message('validate_text', 'Invalid file type. Supported file type is .pdf');
    //         return false;
    //     }

    //     return true;
    // }

    public function validate_audio($audio = "", $field_name = "")
    {
        $arrAllowedTypes = array('audio/mpeg');

        $strFileType = mime_content_type($_FILES[$field_name]["tmp_name"]);
            
        if(!in_array($strFileType, $arrAllowedTypes)){
            $this->form_validation->set_message('validate_audio', 'Invalid file type. Supported file type is .mp3');
            return false;
        }

        return true;
    }

    public function chapter_list($cid)
    {
        $objChapter = $this->Chapter_model->getChapterList($cid);

     
        $arrChapter = array();
        $intCount = 0;
        if ($objChapter) {

            foreach ($objChapter as $objChapterInfo) {

                $arrChapter[$intCount]['CH'] = htmlentities($objChapterInfo->chapter);
                $arrChapter[$intCount]['IM'] = "<img src='".base_url()."uploads/chapter/".$objChapterInfo->image."' width='80px' height='100px'/>";
                $arrChapter[$intCount]['SO'] = htmlentities($objChapterInfo->sort_order);
                $arrChapter[$intCount]['ST'] = ($objChapterInfo->status == "Y") ? "Active" : "Inactive";

              
                    $updateLink = "<a href=\"" . site_url('admin/chapter/update_chapter/'.$objChapterInfo->lid.'/'.$objChapterInfo->cid) . "\" class=\"px-3 text-primary\" title=\"Edit\"><i class=\"uil uil-pen font-size-18\"></i></a>";
               
                
                    $deleteLink = "<a href=\"" . site_url('admin/chapter/delete_chapter/'.$objChapterInfo->lid.'/'.$objChapterInfo->cid) . "\" onclick=\"javascript: return confirm('Are you sure?')\" class=\"px-3 text-danger\" title=\"Delete\"><i class=\"uil uil-trash-alt font-size-18\"></i></a>";
              

                $arrChapter[$intCount]['BN'] = "<ul class=\"list-inline mb-0\"> <li class=\"list-inline-item dropdown\">" . $updateLink . "</li>
                     <li class=\"list-inline-item dropdown\">" . $deleteLink . "</li></ul>";

                $intCount++;
            }
        }

        $arrStatus = array(
            "Y" => "Active",
            "N" => "Inactive",
        );


        // Pass view params
        $arrViewParams = array();
        $arrViewParams['parentPage'] = "Catalogue";
        $arrViewParams['pageTitle'] = "Chapter Images";
        $arrViewParams['pageCode'] = "CHL";
        $arrViewParams['arrStatus'] = $arrStatus;
        $arrViewParams['arrChapter']=$arrChapter;
        $arrViewParams['cid']=$cid;

        // Function call to display the view contents
        $this->load->adminPages('chapter/chapter_list', $arrViewParams);
    }

    public function create_chapter($cid)
    {
        $sortOrder = $this->Chapter_model->getListLastsortOrder($cid);
        $Nxtsort = $sortOrder->lastSortOrder ? $sortOrder->lastSortOrder + 1 : '1';

        // Pass view params
        $arrViewParams = array();
        $arrViewParams['arrParentPage'] = array("Catalogue" => "", "Chapter List" => site_url('admin/Chapter/create_chapter/'.$cid));
        $arrViewParams['pageTitle'] = "Add Chapter Image";
        $arrViewParams['pageCode'] = "AMI";
        $arrViewParams['action'] = site_url('admin/Chapter/create_image_action');
        $arrViewParams['lid'] = set_value('lid');
        $arrViewParams['cid']=set_value('cid',$cid);
        $arrViewParams['image_file'] = set_value('image_file');
        $arrViewParams['status'] = set_value('status','Y');
        $arrViewParams['sort_order'] = set_value('sort_order',$Nxtsort);

        // Function call to display the view contents
        $this->load->adminPages('chapter/chapter_form', $arrViewParams);
    }

    public function create_image_action()
    {
        
        if(empty($_FILES['image_file']['name'])) {
          $this->form_validation->set_rules('image_file', 'Image', 'required');
        }
        else{
          $image_field = "image_file";
          $this->form_validation->set_rules('image_file', 'Image', 'callback_validate_image[' . $image_field . ']');
        }

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');


        if ($this->form_validation->run() == TRUE) 
        {

            $image_file = "";
            if (!empty($_FILES['image_file']['name'])) {
                $upload_data = file_upload(UPLOAD_PATH . 'chapter/', 'image_file');
                if (!$upload_data['error']) {
                  $image_file = $upload_data['filename'];
                }
            } 


            $arrInsertParams = array(
                "cid" => $this->input->post('cid'),
                "image_file" => $image_file,
                "sort_order" => $this->input->post('sort_order'),
                "status" => $this->input->post('status'),
            );

            if ($this->Chapter_model->insertChapter($arrInsertParams)) {
                $this->session->set_flashdata('alert', ['message' => 'Record added successfully.', 'type' => 'success']);
            } else {
                $this->session->set_flashdata('alert', ['message' => 'Record NOT added successfully.', 'type' => 'danger']);
            }
            redirect(site_url('admin/chapter/chapter_list/'.$this->input->post('cid')));
        } else {
            $this->create_chapter($this->input->post('cid'));
        }
    }

    public function update_chapter($lid = NULL,$cid = NULL)
    {
        $row = $this->Chapter_model->get_by_id_chapter($lid);
        if ($row) {
            // Pass view params
            $arrViewParams = array();
            $arrViewParams['arrParentPage'] = array("Catalogue" => "", "Chapter List" => site_url('admin/Chapter/create_chapter/'.$cid));
            $arrViewParams['pageTitle'] = "Update Chapter Images";
            $arrViewParams['pageCode'] = "UCI";
            $arrViewParams['action'] = site_url('admin/chapter/update_image_action');

            $arrViewParams['lid'] = set_value('lid',$row->lid);
            $arrViewParams['cid'] = set_value('cid',$row->cid);
            $arrViewParams['status'] = set_value('status',$row->status);
            $arrViewParams['image_file'] = set_value('image_file',$row->image_file);
            $arrViewParams['sort_order'] = set_value('sort_order',$row->sort_order);

            $this->load->adminPages('chapter/chapter_form', $arrViewParams);
        } else {
            $this->session->set_flashdata('alert', ['message' => 'Record Not Found', 'type' => 'danger']);
            redirect(site_url('admin/chapter/chapter_list/'.$cid));
        }
    }

    public function update_image_action()
    {   
        $lid = $this->input->post('lid');
        $cid = $this->input->post('cid');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->update_chapter($lid,$cid);
        } else {

            $image_file = "";
            if (!empty($_FILES['image_file']['name'])) {
                $upload_data = file_upload(UPLOAD_PATH . 'images/', 'image_file');
                if (!$upload_data['error']) {
                  $image_file = $upload_data['filename'];
                }
            }
            else
            {
                $image_file=$this->input->post('image');
            } 


            $arrInsertParams = array(
                "image_file" => $image_file,
                "sort_order" => $this->input->post('sort_order'),
                "status" => $this->input->post('status'),
            );

            if ($this->Chapter_model->updateChapter($lid, $arrInsertParams)) {
                $this->session->set_flashdata('alert', ['message' => 'Record updated successfully.', 'type' => 'success']);
            } else {
                $this->session->set_flashdata('alert', ['message' => 'Record NOT updated successfully.', 'type' => 'danger']);
            }
            redirect(site_url('admin/chapter/chapter_list/'.$cid));
        }
    }

    
    public function delete_chapter($lid,$cid)
    {
        $data = array(
            'deleted_at' => date("Y-m-d H:i:s")
        );
        if ($this->Chapter_model->updateChapter($lid, $data)) {
            $this->session->set_flashdata('alert', ['message' => 'Delete Record Success', 'type' => 'success']);
        } else {
            $this->session->set_flashdata('alert', ['message' => 'Delete Record Failed', 'type' => 'danger']);
        }
        redirect(site_url('admin/chapter/chapter_list/'.$cid));
    }
    
}

<?php
class Notification_Helper extends CI_Controller{
    var $data;

    function createNotificationHelper($job_id, $author_id, $title, $notification, $extraIds = array(), $forExtraOnly = 0, $is_system = 0){
        $receiver_ids = array();
        if($forExtraOnly){
            $receiver_ids = !is_array($extraIds) ? array($extraIds) : $extraIds;
        }
        else{
            $this->main_model->setSelectFields('ID');
            $this->main_model->setNormalized('ID');
            $fId = $this->main_model->getInfo('tbl_user', 4 ,'AccountType !=');
            $fId = array_unique($fId);

            $receiver_ids = array_merge($fId, array($author_id));
        }

        $receiver_ids = array_unique($receiver_ids);
        if(count($receiver_ids) > 0){
            foreach($receiver_ids as $receiver_id){
                $post = array(
                    'job_id' => $job_id,
                    'author_id' => $author_id,
                    'receiver_id' => $receiver_id,
                    'title' => $title,
                    'notification' => $notification,
                    'is_new' => 1,
                    'is_system' => $is_system
                );
                $this->main_model->insert('tbl_notification', $post, false);
            }
        }
    }
}
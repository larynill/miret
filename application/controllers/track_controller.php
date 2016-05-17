<?php
include('merit.php');
class Track_Controller extends Merit
{

    function track()
    {
        if($this->uri->segment(2) == 'client')
        {

            if($this->uri->segment(3) == 'current'){
                $this->data['monthBase'] = 'current_month';

            }
            if($this->uri->segment(3) == 'next')
            {
                $this->data['monthBase'] = 'next_month';

            }
            $this->clientTrack();
        }
    }

    private function clientTrack()
    {
        /*$this->main_model->setSelectFields(array('tbl_client_equipment.ID','tbl_client.ID AS ClientID','InspectionDate','FirstName','LastName','CompanyName','PlantDescription'));*/
        //current month inspections
        $this->data['_pageTitle'] .= ' Month of ' . date('F',strtotime('+1 month'));
        $this->main_model->setSelectFields(array('ID','CompanyName','StatusID'));
        $this->data['tableHeader'] = 'Inspections for ' . date('F');
        $clientData = $this->GetMonthlyClient();

        //next month inspections
        //check if first reminder is sent


        $this->main_model->setJoin(
            array(
                'table' => array('tbl_tracker','tbl_user'),
                'join_field' => array('ClientID','ID'),
                'source_field' => array('tbl_client.ID','tbl_tracker.AssignedToID'),
                'type' => 'left'
            )
        );

        $this->main_model->setSelectFields(array(
            'tbl_tracker.ID AS TrackerID','tbl_client.ID',
            'CompanyName','tbl_client.DateRegistered',
            'tbl_client.PersonInCharge', 'tbl_client.FaxNumber',
            'tbl_client.AreaDesignationID','tbl_client.Notes',
            'tbl_client.LastUpdate', 'tbl_client.FirstName', 'tbl_client.LastName',
            'tbl_client.WorkPhone','tbl_client.Email','tbl_client.MobilePhone','tbl_client.PostalAdress',
            'tbl_client.PhysicalAddress', 'tbl_tracker.FirstReminder', 'tbl_tracker.QuoteRequest',
            'tbl_tracker.QuoteRequestDate', 'tbl_tracker.ToManager','tbl_tracker.ToManagerDate',
            'tbl_tracker.QuoteSent','tbl_tracker.QuoteSentDate', 'tbl_tracker.QuoteAccepted',
            'tbl_tracker.QuoteAcceptedDate', 'tbl_tracker.AssignedToID','tbl_tracker.AssignedToDate',
            'concat(tbl_user.FName," ",tbl_user.LName) as AssignedToName'
        ));

        $nextMonthInspectionData = $this->GetMonthlyClient('', '', date('Y-m', strtotime('+1 month')));
        //DisplayArray($nextMonthInspectionData);
        //echo $this->encryption->decode('49gsBoDcUCgpriFwQNtiaB_lvqWN-tCGQZ7lg0BlRDg');
        $equipmentData = $this->main_model->getinfo('tbl_client_equipment');
        $this->data['nextMonthTableHeader'] = 'Possible Inspections for ' . date('F',strtotime('+1 month'));
        $this->data['clientData'] = $clientData;
        $this->data['equipmentData'] = $equipmentData;
		//DisplayArray($nextMonthInspectionData);
        $this->data['nextMonthInspectionData'] = $nextMonthInspectionData;
        $this->data['_pageLoad'] = 'track/track_client_view';
        $this->load->view('main_view', $this->data);
    }
}
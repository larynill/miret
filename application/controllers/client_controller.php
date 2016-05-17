<?php
include('merit.php');
class Client_Controller extends Merit
{

    //the client tracker of monthly equipment inspections
    private function clientTrack()
    {
        $this->data['_pageTitle'] .= ' Month of ' . date('F');
        $this->main_model->setSelectFields(array(
            'tbl_client_equipment.ID',
            'tbl_client.ID AS ClientID',
            'InspectionDate',
            'FirstName',
            'LastName',
            'CompanyName',
            'PlantDescription'
        ));
        $this->data['tableHeader'] = 'Inspections for ' . date('F');
        $clientData = $this->GetMonthlyInspection();
        $this->main_model->setSelectFields(array(
            'tbl_client_equipment.ID',
            'tbl_client.ID AS ClientID',
            'InspectionDate',
            'FirstName',
            'LastName',
            'CompanyName',
            'PlantDescription'
        ));
        $nextMonthInspectionData = $this->GetMonthlyInspection('','',date('Y-m', strtotime('+1 month')));
        $this->data['nextMonthTableHeader'] = 'Possible Inspections for ' . date('F',strtotime('+1 month'));
        $this->data['clientData'] = $clientData;
        $this->data['nextMonthInspectionData'] = $nextMonthInspectionData;
        $this->data['_pageLoad'] = 'client/clients_view';
        $this->load->view('main_view', $this->data);
    }

    //response to action to client
    private function clientTrackAction()
    {
        if(isset($_POST['sendReminder']))
        {
            $clientID = $_POST['clientID'];
            $this->main_model->setSelectFields(array('ID', 'StatusID', 'Email'));
            $monthlyEquipData = $this->GetMonthlyClient($clientID);
            if(count($monthlyEquipData) > 0)
            {
                $data['equipData'] = array();
                foreach($monthlyEquipData as $client)
                {
                    $email = $client->Email; //client email
                    if(count($client->Equipment) > 0)
                    {
                        foreach($client->Equipment as $equip)
                        {
                            $data['equipData'][$equip->PlantDescription] = date('F d Y', strtotime($equip->InspectionDate));

                            //insert an equipment status
                            $insertData = array(
                                'EquipmentID' => $equip->ID,
                                'ClientID' => $client->ID,
                                'StatusID' => 8 //set to Inspection Reminder Sent
                            );
                            $this->main_model->insert('tbl_possible_inspection', $insertData);
                        }
                    }
                    $data['clientID'] = $clientID;
                    $emailMessage = $this->load->view('emailMessages/reminder/first_reminder_view', $data,true);
                    $this->sendmail($emailMessage, $email); ;
                }
            }
            $this->data['_pageLoad'] = 'client/success/action_success_view';
            $this->load->view('main_view', $this->data);
        }
    }
}
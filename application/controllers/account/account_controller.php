<?php
class Account_Controller extends CI_Controller{

    function login(){
        $this->data['_registrationSuccess'] = false;
        $this->data['_hasLogError'] = false;
        $this->data['_errorMessage'] = '';
        $isGM = false;

        //get the account types for the signup page.
        $userTypeDataTable = $this->main_model->getinfo('tbl_user_type');
        $types = array();
        foreach($userTypeDataTable as $userType){
			$types[''] = '-';
            $types[$userType->ID] = $userType->AccountType;
        }
        $this->data['_accountType'] = $types;

        if(isset($_POST['signup'])){ //if user is signing
			if($_POST['AccountType'] != 7){
				$signupPost =  $this->GetPostEqualField($_POST, 'tbl_user');
				$signupPost['DateRegistered'] = date('Y-m-d');
				$signupPost['Password'] = $this->encrypt->encode($_POST['Password']);
				$users = $this->main_model->getinfo('tbl_user');
				if(count($users) > 0){
					foreach($users as $user){
						if($user->Username == $_POST['Username']){ // if username already exits.
							$this->data['_hasLogError'] = true;
							$this->data['_errorMessage'] = "your username is already taken.";
							break;
						}
					}
				}
				if(isset($_POST['Authenticate'])){
					if($_POST['Authenticate'] == $this->encrypt->decode($this->config->item('GM_pass'))){
						$this->data['_registrationSuccess'] = true;
						$isGM = true;
						$this->main_model->insert('tbl_user', $signupPost); //insert new user
					}
				}

				if(!$isGM){
					if($this->data['_hasLogError'] == false){
						$this->data['_registrationSuccess'] = true;
						$this->main_model->insert('tbl_user', $signupPost); //insert new user
					}
				}
			}else{
				if($this->data['_hasLogError'] == false){
					$this->main_model->setLastId('ID');
					$getID = $this->main_model->getinfo('tbl_client');
					$this->main_model->insert('tbl_client', array('Email'=>$_POST['EmailAddress'])); //insert new user

					redirect('registration_request/'.$getID + 1);
				}
			}

        }

        $this->load->view('pages/login', $this->data);
    }

    function logging(){
		$this->data['_hasLogError'] = false;
        if(isset($_POST['submit'])){
            $userData = $this->LoginValidate($_POST['login'], $_POST['pass']);
            if($userData['isLogged']){
                $this->session->set_userdata($userData);
                $userID = $this->session->userdata('userID');
                $this->Redirection($userID); // redirect after successful logging
            }
            else{
				echo 'not working';
                $this->data['_hasLogError'] = true;
                //$this->data['_errorMessage'] = "Invalid username/password input";
				$this->session->set_flashdata(
					array(
						'_errorMessage'=>
						'<div class="ui-widget" style="color:red">
							<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
								<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
									<strong>Alert:</strong> Invalid username/password input</p>
							</div>
						</div>'
					)
				);
				redirect('login');
            }
        }
    }

    private function Redirection($userID){
        $userData = $this->main_model->getinfo('tbl_user', $userID);
        if(count($userData) > 0){
            foreach($userData as $user){
                $this->session->set_userdata('userAccountType', $user->AccountType);
                $allowed = array(1, 2); // super admin, administrator
                if(in_array($user->AccountType, $allowed))
                {
                    redirect('diary'); // redirect to allowed users
                }
                else if($user->AccountType == 3){
                    redirect('diary');
                }
                else if($user->AccountType == 4){
                    redirect('myDiary');
                }
                else if($user->AccountType == 5){
                    redirect('myDiary');
                }
                else if($user->AccountType == 6){
                    redirect('diary');
                }

				else if($user->AccountType == 7){
					redirect('myDiary');
				}
                else if($user->AccountType == 8){
                    redirect('myDiary');
                }
                else if($user->AccountType == 9){
                    redirect('myDiary');
                }
                else{
                    redirect('pageConstruction');
                }
            }
        }
    }

    private function LoginValidate($username, $password){
        $user = $this->main_model->getinfo('tbl_user', $username, 'Username');
        $userData = array(
            'isLogged' => false,

        );

        if(count($user) > 0){
            $encryption_key = $this->config->item('encryption_key');
            foreach($user as $u){
                if($password == $this->encrypt->decode($u->Password, $encryption_key) ){
                    $userData = array(
                        'isLogged' => true,
                        'userID' => $u->ID,
                    );
                }
            }
        }
        return $userData;
    }
}
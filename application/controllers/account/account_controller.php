<?php
include('shopping_cart.php');
class Account_Controller extends CI_Controller{

    var $data;

    function index(){
        $page = isset($_GET['p']) ? $_GET['p'] : '';
        $this->data['active'] = $page;
        $this->data['links'] = array(
            '' => 'Home',
            'search' => 'Search',
            'purchase' => 'Purchase',
            'request' => 'Request',
            'about' => 'About',
            'contact' => 'Contact Us',
            'login' => 'Login'
        );
        $this->data['icons'] = array(
            '' => 'fa-home',
            'about' => 'fa-fire',
            'purchase' => 'fa-money',
            'contact' => 'fa-phone',
            'login' => 'fa-sign-in',
            'search' => 'fa-search',
            'request' => 'fa-check',
        );

        $this->my_model->setNormalized('Name','id');
        $this->my_model->setSelectFields(array('id','Name'));
        $this->data['country'] = $this->my_model->getInfo('tbl_country');

        //region Request

        if(isset($_POST['request'])){
            unset($_POST['request']);
            $_POST['user_id'] = $this->session->userdata('user_id');
            $_POST['contact_time'] = isset($_POST['contact_time']) ? date('Y-m-d H:i:s',strtotime($_POST['contact_time'])) : '';
            $id = $this->my_model->insert('tbl_leads',$_POST);

            if($id){
                $this->session->set_flashdata(
                    array(
                        'confirmation' => '<div class="alert alert-success" role="alert"><strong>Success!</strong> Request sent.</div>'
                    )
                );
            }
            else{
                $this->session->set_flashdata(
                    array(
                        'confirmation' => '<div class="alert alert-danger" role="alert"><strong>Error!</strong> Unable to send request.</div>'
                    )
                );
            }
            redirect('?p=request');
        }
        //endregion
        if($page){
            switch($page){
                case 'about':
                    $this->data['page'] = 'frontend/about';
                    break;
                case 'contact':
                    $this->data['page'] = 'frontend/contact_us';
                    break;
                case 'purchase':
                    $this->data['cart'] = [];
                    $cart = new Shopping_Cart();
                    if(isset($_POST['purchase'])){
                        $item_name = isset($_POST['name']) ? $_POST['name'] : '-';
                        $item_name = str_replace(',','.',$item_name);
                        $cart->data = [
                            'id'      => $_GET['id'],
                            'qty'     => 1,
                            'price'   => 9.95,
                            'name'    => $item_name
                        ];

                        $cart->add();
                        exit;
                    }
                    if(isset($_POST['remove'])){
                        $cart->data = [
                            'rowid'      => $_POST['rowid'],
                            'qty'     => 0
                        ];

                        $cart->remove();
                    }

                    $this->data['cart'] = $cart->show();
                    $this->data['page'] = 'frontend/purchase';
                    break;
                case 'login':
                    $this->data['page'] = 'frontend/login';
                    break;
                case 'request':
                    $this->data['page'] = 'frontend/request';
                    break;
                case 'search':
                    $this->data['page'] = 'frontend/search';
                    break;
                default:
                    redirect('pageConstruction');
                    break;
            }
        }
        else{
            $this->data['page'] = 'frontend/home';
        }
        //region Search Page
        if(isset($_GET['search']) && $_GET['search'] == 1){
            $job_fld = $this->my_model->getFields('tbl_job_registration');
            $this->my_model->setSelectFields(array('id','address','suburb','city','date_entered'));
            $jobs = $this->my_model->getinfo('tbl_job_registration');
            $_fld = [];
            $_include_fld = array('id','address','suburb','city','date_entered');
            if(count($job_fld) > 0){
                foreach($job_fld as $fld){
                    if(in_array($fld,$_include_fld)){
                        $_fld[$fld] = $fld;
                    }
                }
            }

            if(count($jobs) > 0){
                foreach($jobs as $key=>$val){
                    foreach($val as $k=>$v){
                        $val->$_fld[$k] = $val->$_fld[$k] && $val->$_fld[$k] != '-' ? $val->$_fld[$k] : '';
                    }
                    $val->date_report = date('d/m/Y',strtotime($val->date_entered));
                    $val->purchase_url = base_url().'?p=purchase&id='. $val->id;
                }
            }
            echo json_encode($jobs);
        } else if($this->data['page']){
            $this->load->view('frontend/main_view',$this->data);
        }
    }

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
				redirect('?p=login');
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
                if($password == $this->encrypt->decode($u->Password, $encryption_key) &&
                    $u->isActive){
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
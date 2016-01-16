
<?php
if(count($_userData) > 0){
    foreach($_userData as $user){
        switch($user->AccountType){
            case 9:
                $navTitles = array(
                    'Admin' => array(
                        'sendRegistration' => 'Mail Registration',
                        'registerClient' => 'Client Registration Form',
                        'equipmentExcelFileList' => 'Client Equipment Excel',
                        'equipment' => 'Equipment Register',
                        'monthlyReport/potential' => 'Monthly Report',
                        /*'joblist' => 'Job Sheet List',*/
                        'track/client/current' => 'Client Tracker',
                        /*'request/view' => 'View Quote Requests'*/
                    ),
                    'myDiary' => 'Diary',
                    'Jobs' => array(
                        'jobsAllocation' => 'Jobs Allocation',

                    ),
                    'Management' => array(
                        'historyReports' => 'History Reports'
                    ),
                    'notices' => 'Notices',
                    'Personal Stuff' => array(
                        'staffProfile' => 'My Profile',
                        'staff_leave' => 'Leave',
                        'payment_detail' => 'Payment Detail'
                    ),
                    'Staff' => array(
                        'staff_list' => 'Lists',
                        'holidays' => 'Holidays',
                        /*'leave_application' => 'Leave Application Form',*/
                        'wage_management' => 'Wage Management',
                        'wage_summary' => 'Wage Summary',
                        'paye' => 'PAYE'
                    ),
                );
                break;
            case 8:
                $navTitles = array(
                    'Accounting' => array(
                        'jobsDone' => 'Jobs Done',
                        'invoices' => 'Invoices For Month',
                        'outstandingBalance' => 'Outstanding Balance'
                    ),
                    'myDiary' => 'Diary',
                    'Personal Stuff' => array(
                        'staffProfile' => 'My Profile',
                        'staff_leave' => 'Leave',
                        'payment_detail' => 'Payment Detail'
                    ),
                    'Staff' => array(
                        'staff_list' => 'Lists',
                        'wage_management' => 'Wage Management',
                        'wage_summary' => 'Wage Summary',
                        'paye' => 'PAYE'
                    ),
                    'Jobs' => array(
                        'jobsAllocation' => 'Jobs Allocation',

                    ),
                    'Management' => array(
                        'historyReports' => 'History Reports'
                    )
                );
                break;
			case 7:
				$navTitles = array(
                    'Accounting' => array(
                        'jobsDone' => 'Jobs Done',
                        'invoices' => 'Invoices For Month',
                        'outstandingBalance' => 'Outstanding Balance'
                    ),
                    'myDiary' => 'Diary',
                    'Personal Stuff' => array(
                        'staffProfile' => 'My Profile',
                        'staff_leave' => 'Leave',
                        'payment_detail' => 'Payment Detail'
                    )
				);
				break;
            case 6:
                $navTitles = array(
                    'Admin' => array(
                        'sendRegistration' => 'Mail Registration',
                        'registerClient' => 'Client Registration Form',
                        'equipmentExcelFileList' => 'Client Equipment Excel',
                        'equipment' => 'Equipment Register',
                        'monthlyReport/potential' => 'Monthly Report',
                        /*'joblist' => 'Job Sheet List',*/
                        'track/client/current' => 'Client Tracker',
                        /*'request/view' => 'View Quote Requests'*/
                    ),
                    'diary' => 'Diary',
                    'Jobs' => array(
                        'jobsAllocation' => 'Jobs Allocation',

                    ),
                    'Management' => array(
                        'historyReports' => 'History Reports'
                    ),
                    'Personal Stuff' => array(
                        'staffProfile' => 'My Profile',
                        'staff_leave' => 'Leave',
                        'payment_detail' => 'Payment Detail'
                    ),
                    'Staff' => array(
                        'staff_list' => 'Lists',
                        'holidays' => 'Holidays',
                        /*'leave_application' => 'Leave Application Form',*/
                        'wage_management' => 'Wage Management',
                        'wage_summary' => 'Wage Summary',
                        'paye' => 'PAYE'
                    )
                );
                break;
            case 5:
                $navTitles = array(
                    'Accounting' => array(
                        'jobsDone' => 'Jobs Done',
                        'invoices' => 'Invoices For Month',
                        'outstandingBalance' => 'Outstanding Balance'
                    ),
                    'myDiary' => 'Diary',
                    'Personal Stuff' => array(
                        'staffProfile' => 'My Profile',
                        'staff_leave' => 'Leave',
                        'payment_detail' => 'Payment Detail'
                    )
                );
                break;
            case 4:
                $navTitles = array(
                    'dashboard' => 'Home',
                    'myDiary' => 'Diary',
					'Personal Stuff' => array(
						'staffProfile' => 'My Profile',
						'staff_leave' => 'Leave',
						'payment_detail' => 'Payment Detail'
					)
                );
                break;
			case 3:
				$navTitles = array(
					'diary' => 'Diary',
                    'Jobs' => array(
                        'jobsAllocation' => 'Jobs Allocation',

                    ),
                    'Management' => array(
                        'historyReports' => 'History Reports'
                    ),
					'Personal Stuff' => array(
						'staffProfile' => 'My Profile',
						'staff_leave' => 'Leave',
						'payment_detail' => 'Payment Detail'
					),
                    'Staff' => array(
                        'staff_list' => 'Lists',
                        'holidays' => 'Holidays',
                        /*'leave_application' => 'Leave Application Form',*/
                        'wage_management' => 'Wage Management',
                        'wage_summary' => 'Wage Summary',
                        'paye' => 'PAYE'
                    )
				);
				break;
            case 1:
                $navTitles = array(
                    'Accounting' => array(
                        'jobsDone' => 'Jobs Done',
                        'invoices' => 'Invoices For Month',
                        'outstandingBalance' => 'Outstanding Balance'
                    ),
                    'Admin' => array(
                        'sendRegistration' => 'Mail Registration',
                        'registerClient' => 'Client Registration Form',
                        'equipmentExcelFileList' => 'Client Equipment Excel',
                        'equipment' => 'Equipment Register',
                        'monthlyReport/potential' => 'Monthly Report',
                        /*'joblist' => 'Job Sheet List',*/
                        'track/client/current' => 'Client Tracker',
                        /*'request/view' => 'View Quote Requests'*/
                    ),
					'Management' => array(
						'historyReports' => 'History Reports'
					),
                    'PDF Archive' => array(
                        'pdfSummary/credit' => 'Credit Note',
                        'pdfSummary/invoice' => 'Invoice',
                        'pdfSummary/statement' => 'Statement',
                        'pdfSummary/outstanding' => 'Outstanding'
                    ),
                    'Staff' => array(
						'staff_list' => 'Lists',
                        'holidays' => 'Holidays',
                        /*'leave_application' => 'Leave Application Form',*/
						'wage_management' => 'Wage Management',
						'wage_summary' => 'Wage Summary',
						'paye' => 'PAYE'
                    ),
                    'diary' => 'Diary',
                    'Jobs' => array(
                        'jobsAllocation' => 'Jobs Allocation',

                    ),
                    'notices' => 'Notices'
                );
                break;
            default:
                $navTitles = array();
                break;
        }
    }
}


function getSublink($link, $title, $uri){
    $active = array_key_exists($uri, $title);
    ?>
    <li class="<?php echo $active ? 'selected' : '';?>">
        <a><?php echo $link; ?> </a>
        <ul>
            <?php
            foreach($title as $subLink => $subTitle){
                if(is_array($subTitle)){
                    getSublink($subLink, $subTitle, $uri ? $uri : '');
                }
                else{
                    ?>
                    <li>
                        <a href="<?php echo $subTitle ? base_url() . $subLink : "#" ?>" style="white-space: nowrap!important;"
                           class="<?php echo $subLink.'Btn';?>"><?php echo $subTitle; ?></a>
                    </li>
                <?php
                }
            }
            ?>
        </ul>
    </li>
<?php
}
?>
<div class="grid_16">
    <ul class="sf-menu" id="navigationTop">
            <?php
            if(isset($navTitles) && count($navTitles) > 0){
                foreach($navTitles as $link => $title){
                    if(is_array($title)){
                        getSublink($link, $title, $this->uri->segment(1) ? $this->uri->segment(1) : '');
                    }else{

                        ?>
                        <li  class="<?php echo $this->uri->segment(1) == $link ? 'selected' : ''?>">
                            <a href="<?php echo $link ? base_url() . $link : "#"?>" class="<?php echo $link.'Btn';?>">
                                <?php echo $title; ?>
                            </a>
                        </li>
                    <?php
                    }
                }
            }
        ?>
    </ul>
</div>
<div class="clear"></div>

<?php
if(count($_userData) > 0){
    foreach($_userData as $user){
        switch($user->AccountType){
            case 2:
                $navTitles = array(
                    /*'Admin' => array(
                        'sendRegistration' => 'Mail Registration',
                        'registerClient' => 'Client Registration Form',
                        'equipmentExcelFileList' => 'Client Equipment Excel',
                        'equipment' => 'Equipment Register',
                        'monthlyReport/potential' => 'Monthly Report',
                        //'joblist' => 'Job Sheet List',
                        'track/client/current' => 'Client Tracker'
                        //'request/view' => 'View Quote Requests'
                    ),*/
                    'myDiary' => 'Home',
                    'trackingLog' => 'Tracking Log',
                    'Jobs' => array(
                        'jobsAllocation' => 'Allocation',
                        'jobRegistration' => 'Registration'
                    ),
                    /*'Inspections' => array(
                        'onSiteVisit' => 'On-site Visit',
                        //'inspectionReport' => 'Inspection Report'
                    ),*/
                    'Reports' => array(
                        'historyReports' => 'History Reports',
                    ),
                    'Management' => array(
                        'userList' => 'User'
                    ),
                    'contactList' => 'Contacts',
                    'Staff' => array(
                        'staff_list' => 'Lists',
                        'holidays' => 'Holidays',
                        /*'leave_application' => 'Leave Application Form',*/
                        'wage_management' => 'Wage Management',
                        'wage_summary' => 'Wage Summary',
                        'paye' => 'PAYE'
                    ), 'Personal Stuff' => array(
                        'staffProfile' => 'My Profile',
                        'staff_leave' => 'Leave',
                        'payment_detail' => 'Payment Detail'
                    ),
                    /*'notices' => 'Notices',*/
                );
                break;
            case 8:
                $navTitles = array(
                    'trackingLog' => 'Tracking Log',
                    'myDiary' => 'Home',
                    'Jobs' => array(
                        'jobsAllocation' => 'Allocation',
                        'jobRegistration' => 'Registration'
                    ),
                    /*'Inspections' => array(
                        'onSiteVisit' => 'On-site Visit',
                        //'inspectionReport' => 'Inspection Report'
                    ),*/
                    'Reports' => array(
                        'historyReports' => 'History Reports',
                    ),
                    'contactList' => 'Contacts',
                    'Staff' => array(
                        'staff_list' => 'Lists',
                        'wage_management' => 'Wage Management',
                        'wage_summary' => 'Wage Summary',
                        'paye' => 'PAYE'
                    ),
                    'Accounting' => array(
                        'jobsDone' => 'Jobs Done',
                        'invoices' => 'Invoices For Month',
                        'outstandingBalance' => 'Outstanding Balance'
                    ),
                    'Personal Stuff' => array(
                        'staffProfile' => 'My Profile',
                        'staff_leave' => 'Leave',
                        'payment_detail' => 'Payment Detail'
                    ),
                );
                break;
			case 7:
				$navTitles = array(
                    'myDiary' => 'Home',
                    'Accounting' => array(
                        'jobsDone' => 'Jobs Done',
                        'invoices' => 'Invoices For Month',
                        'outstandingBalance' => 'Outstanding Balance'
                    ),
                    'Personal Stuff' => array(
                        'staffProfile' => 'My Profile',
                        'staff_leave' => 'Leave',
                        'payment_detail' => 'Payment Detail'
                    )
				);
				break;
            case 6:
                $navTitles = array(
                    'diary' => 'Home',
                    'Jobs' => array(
                        'jobsAllocation' => 'Jobs Allocation',

                    ),
                    /*'Inspections' => array(
                        'onSiteVisit' => 'On-site Visit',
                        //'inspectionReport' => 'Inspection Report'
                    ),*/
                    'Reports' => array(
                        'historyReports' => 'History Reports',
                    ),
                    'contactList' => 'Contacts',
                    'Staff' => array(
                        'staff_list' => 'Lists',
                        'holidays' => 'Holidays',
                        /*'leave_application' => 'Leave Application Form',*/
                        'wage_management' => 'Wage Management',
                        'wage_summary' => 'Wage Summary',
                        'paye' => 'PAYE'
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

                    'Personal Stuff' => array(
                        'staffProfile' => 'My Profile',
                        'staff_leave' => 'Leave',
                        'payment_detail' => 'Payment Detail'
                    )
                );
                break;
            case 5:
                $navTitles = array(
                    'myDiary' => 'Home',
                    'Accounting' => array(
                        'jobsDone' => 'Jobs Done',
                        'invoices' => 'Invoices For Month',
                        'outstandingBalance' => 'Outstanding Balance'
                    ),
                    'Personal Stuff' => array(
                        'staffProfile' => 'My Profile',
                        'staff_leave' => 'Leave',
                        'payment_detail' => 'Payment Detail'
                    )
                );
                break;
            case 4:
                $navTitles = array(
                    'dashboard' => 'Dashboard',
                    'trackingLog' => 'Tracking Log',
                    /*'Inspections' => array(
                        'onSiteVisit' => 'On-site Visit',
                        //'inspectionReport' => 'Inspection Report'
                    ),*/
                    'myDiary' => 'Home',
					'Personal Stuff' => array(
						'staffProfile' => 'My Profile',
						'staff_leave' => 'Leave',
						'payment_detail' => 'Payment Detail'
					)
                );
                break;
			case 3:
				$navTitles = array(
					'diary' => 'Home',
                    'trackingLog' => 'Tracking Log',
                    'Jobs' => array(
                        'jobsAllocation' => 'Allocation',
                        'jobRegistration' => 'Registration'
                    ),
                    /*'Inspections' => array(
                        'onSiteVisit' => 'On-site Visit',
                        //'inspectionReport' => 'Inspection Report'
                    ),*/
                    'Reports' => array(
                        'historyReports' => 'History Reports',
                    ),
                    'contactList' => 'Contacts',
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
                    'diary' => 'Home',
                    'leads' => 'Leads',
                    'trackingLog' => 'Tracking Log',
                    'Jobs' => array(
                        'jobsAllocation' => 'Allocation',
                        'jobRegistration' => 'Registration'
                    ),
                    /*'Inspections' => array(
                        'onSiteVisit' => 'On-site Visit',
                        //'inspectionReport' => 'Inspection Report'
                    ),*/
                    'Reports' => array(
                        'historyReports' => 'History Reports',
                    ),
                    'contactList' => 'Contacts',
                    'franchiseList' => 'Franchise',
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

                    'Admin' => array(
                        'postalCodes' => 'Postal Codes',
                        'jobAuditLog' => 'Job Audit Log',
                        'jobsDone' => 'Jobs Done',
                        'invoices' => 'Invoices For Month',
                        'outstandingBalance' => 'Outstanding Balance',
                        'userList' => 'User',
                        'itemList' => 'Item',
                        'tag' => 'Tags',
                        'emailLog' => 'Email Log'
                    )
                    /*'Admin' => array(
                        'sendRegistration' => 'Mail Registration',
                        'registerClient' => 'Client Registration Form',
                        'equipmentExcelFileList' => 'Client Equipment Excel',
                        'equipment' => 'Equipment Register',
                        'monthlyReport/potential' => 'Monthly Report',
                        //'joblist' => 'Job Sheet List',
                        'track/client/current' => 'Client Tracker',
                        //'request/view' => 'View Quote Requests'
                    ),*/
                    /*'notices' => 'Notices'*/
                );
                break;
            default:
                $navTitles = array();
                break;
        }
    }
}
$navTitles['logout'] = 'Logout';

function getSublink($link, $title, $uri, $is_multi_level = false){
    $active = array_key_exists($uri, $title);
    ?>
    <li class="dropdown <?php echo $active ? 'active' : '';?> dropbtn" id="<?=$link;?>" onClick="myFunction(this)" >
        <a href="#" class="dropdown-toggle"><?php echo $link; ?> </a>
        <ul <?php echo $is_multi_level ? 'class="dropdown-menu multi-level"' : 'class="dropdown-menu"'?> id="myDropdown<?=$link;?>" >
            <?php
            foreach($title as $subLink => $subTitle){
                if(is_array($subTitle)){
                    getSublink($subLink, $subTitle, $uri ? $uri : '');
                }
                else{
                    ?>
                    <li >
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

function array_depth(array $array) {
    $max_depth = 1;

    foreach ($array as $value) {
        if (is_array($value)) {
            $depth = array_depth($value) + 1;

            if ($depth > $max_depth) {
                $max_depth = $depth;
            }
        }
    }

    return $max_depth;
}

?>
<ul class="nav navbar-nav">
        <?php
        if(isset($navTitles) && count($navTitles) > 0){
            foreach($navTitles as $link => $title){
                if(is_array($title)){
                    $is_multi_level = array_depth($title) > 1 ? true : false;
                    getSublink($link, $title, $this->uri->segment(1) ? $this->uri->segment(1) : '',$is_multi_level);
                }else{

                    ?>
                    <li  class="<?php echo $this->uri->segment(1) == $link ? 'active' : ''?>">
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
<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction(a) {
    var id = $(a).attr("id");
    if( $(window).width() < 768 ) {
        document.getElementById("myDropdown" + id).classList.toggle("show");
        event.stopPropagation();
    }
}

</script>
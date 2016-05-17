
<?php
ini_set("memory_limit","512M");
set_time_limit(9000000);

error_reporting(E_ALL ^ E_NOTICE);
require_once realpath(APPPATH."../application/views/excel_reader/excel_reader2.php");

//$data = new Spreadsheet_Excel_Reader("http://localhost/hitechag/uploads/3/plate meter/6 August 2013/Herd List Harris.xls");
$data = new Spreadsheet_Excel_Reader($filename);
?>
<html>
<head>
    <title><?php echo $page_title;?> | Pressure Vessel</title>
    <!--<link rel="shortcut icon" href="<?php /*echo base_url();*/?>plugins/images/shortcut-icon.png">-->
    <style>
        table.excel {
            border-style:ridge;
            border-width:1;
            border-collapse:collapse;
            font-family:sans-serif;
            font-size:12px;
            width: 100%;
        }
        table.excel tbody tr:first-child td{
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            padding: 5px;
            background: #484848;
            color: #ffffff!important;
        }
        table.excel thead th, table.excel tbody th {
            background:#CCCCCC;
            border-style:ridge;
            border-width:1;
            text-align: center;
            vertical-align:bottom;
        }
        table.excel tbody th {
            text-align:center;
            width:20px;
        }
        table.excel tbody td {
            vertical-align:bottom;
        }
        table.excel tbody td {
            padding: 0 3px;
            border: 1px solid #747474;
        }
        .headerTitleText{
            font-size: 15px;
            background: #262626;
            padding: 10px;
            color: #ffffff;
            font-family: Arial,sans-serif;
        }
        .green{
            text-decoration: none;
            cursor: pointer;
            padding: 5px 15px;
            font-size: 13px;
            color: #e8f0de;
            background: #35aa47;
        }
        .green:hover{
            background: #33a344;
        }
    </style>
</head>

<body>
<div style="border: 1px solid #a9a9a9">
    <div class="headerTitleText">
        <a href="<?php echo base_url().'equipmentExcelFileList';?>" class="m-btn green">Back</a>
    </div>
    <?php
    echo $data->dump(false,false);
    $data = $data->dump_csv(false,false);
    //echo $data->dump_csv(false,false);
    //echo $data;
    ?>
</div>
</body>
</html>

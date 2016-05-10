<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class excel_reader
{
    public function __construct()
    {
        require_once APPPATH . 'third_party/excel_reader/excel_reader2.php';
    }
}
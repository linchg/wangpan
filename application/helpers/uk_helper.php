<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('dateToString'))
{
    function dateToTips()
    {
        $tip = '';
        $date = intval(date("G")); 
        switch($date)
        {
            case $date <= 11:
               $tip = '早晨好'; 
                break;
            case $date <= 13:
                $tip = '中午好';
                break;
            case $date <= 17:
                $tip = '下午好';
                break;
            default:
                $tip = '晚上好';
        }
        return $tip;
    }
}

if ( ! function_exists('sendEmail'))
{
    function sendEmail($email, $title, $content){
        $CI = &get_instance();
        $CI->load->library('email');
        $CI->email->from('kingnettest@163.com', 'Kingnet Services');
        $CI->email->to($email); 

        $CI->email->subject($title);
        $CI->email->message($content); 

        return $CI->email->send();
    }
}

if ( ! function_exists('dataRatio'))
{
    function dataRatio(){
        $arg_list = func_get_args();
        $arg_list = (array)$arg_list;
        if (empty($arg_list)) return false; 
        $sum  = array_pop($arg_list);
        if (empty($arg_list)) return array(100); 
        $sum = $sum <= 0 ? array_sum($arg_list) : $sum;
        $count = count($arg_list); 
        $datasum = array_sum($arg_list);
        if ($sum == 0 || $datasum == 0)
        {
            $value = floor(100/$count);  
            return array_fill(0,$count , $value);
        }
        $ratio = array();
        $max_data = 0;
        foreach($arg_list as $value)
        {
            $max  = round($value  / $sum * 100);
            if ($max > $max_data)
            {
                $max_data = $max;
            }
           $ratio[] = $max; 
        }
        $sum = array_sum($ratio);
        $index = array_search($max_data , $ratio);
        if ($sum > 100)
        {
            $ratio[$index] = $ratio[$index] - 1;
        }
        else if($sum < 100)
        {
            $ratio[$index] = $ratio[$index] + 1;
        }
       return $ratio; 
    }
}

if ( !function_exists('static_url_version'))
{
	function static_url_version($file)
	{
		$CI = &get_instance();	
		return $CI->wangpan->static_version($file);
	}	
}


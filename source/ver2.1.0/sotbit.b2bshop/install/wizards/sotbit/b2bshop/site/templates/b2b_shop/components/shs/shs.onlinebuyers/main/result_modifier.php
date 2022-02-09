<?
if(!function_exists('BITGetDeclNum'))
{
    function BITGetDeclNum($value=1, $status)
    {
     $array =array(2,0,1,1,1,2);
     return $status[($value%100>4 && $value%100<20)? 2 : $array[($value%10<5)?$value%10:5]];
    }
}
?>
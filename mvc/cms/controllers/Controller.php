<?php //+
include_once '../init.php';

class Controller
{
    public function __construct(){}

    public function goUrl($url){
        header('Location: '.$url);
        exit();
    }

    public static function formatUrl ($ctrl_name='',$action_name='',$params=null){
        $url = '';

        if(!empty($ctrl_name))
            $url.=((empty($url))?'':'&').'controller='.$ctrl_name;

        if(!empty($action_name))
            $url.=((empty($url))?'':'&').'action='.$action_name;

        if(!is_null($params)){
            foreach ($params as $key => $value)
                $url.=((empty($url))?'':'&').$key.'='.$value;
        }

        return $url=(empty($url))?
            SITE_HOST.'cms/index.php':
            SITE_HOST.'cms/index.php?'.$url;
    }
}
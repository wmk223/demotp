<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2015/12/21
 * Time: 13:43
 */

namespace Org\Util;


class Leftnav
{
    static public function menu($cate , $lefthtml = '--' , $pid=0 , $lvl=0, $leftpin=0 ){
        $arr=array();
        foreach ($cate as $v){
            if($v['we_menu_leftid']==$pid){
                $v['lvl']=$lvl + 1;
                $v['leftpin']=$leftpin + 0;
                $v['lefthtml']=str_repeat($lefthtml,$lvl);
                $arr[]=$v;
                $arr= array_merge($arr,self::menu($cate,$lefthtml,$v['id'], $lvl+1 ,$leftpin+20));
            }
        }

        return $arr;
    }
}
<?php
class View{
    function fetch(array $data){
        $html="<table border=1 cellspacing='0'>";
        $html.="<thead><tr bgColor='lightgray'><th>ID号</th><th>帐号</th><th>密码</th></tr></thead><tbody>";
        foreach($data as $user):
           $html.="<tr><td>{$user['id']}</td>";
           $html.="<td>{$user['uname']}</td>";
           $html.="<td>{$user['pwd']}</td></tr>";
        endforeach; 
        $html.="</tbody></table>";
        return $html;       
    }
}

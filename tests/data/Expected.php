<?php 
function test_a($id=null,$txt=null){
        $id=$id*1;
        if($id==0)$id=10;
        if($txt=='')$txt='Added';
        $arr=[];
        $arr[out]="$id One";
        $arr[out].="Two $txt";
        $res=$arr[out];
        return $res;
}
echo test_a();

<?php  
$url = "http://localhost/php/api/test.php";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
$result=curl_exec($ch);
curl_close($ch);
$getData = json_decode($result,true);
// echo "<pre>";
// print_r($getData);
if(isset($getData['status'])){
    if($getData['status']==true){
         if(isset($getData['result'])){
            if($getData['result']==true){
               ?>
               <table>
                    <tr>
                        <td>Id</td>
                        <td>Name</td>
                        <td>Email</td>
                    </tr>
                    <?php foreach($getData['data'] as $list){
                        echo "<tr>
                                <td>".$list['id']."</td>
                                <td>".$list['name']."</td>
                                <td>".$list['email']."</td>
                            </tr>";
                    } ?>
               </table>               
               <?
            }else{
                
                echo $getData['data'];
            }
         }else{
            echo $getData['data'];
         }
    }
}else{
    echo "API not working";
}


?>
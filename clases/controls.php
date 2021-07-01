<?php
//functions
function ddBuilder($name,$size,$class,$tsql,$item){
    require("cn.php");echo "<pre>";
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    $getResults = sqlsrv_query($conn, $tsql) ;
    $dd = '<select onDblClick="alert(this.value)" name="'.$name.'" size="'.$size.' class="'.$class.' style="width: 80%;"" required>';
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_NUMERIC)) {
        $selected = ($item == $row[0]) ? ' selected>' : ' >';
        $desc = !($row[2]) ? ' (no description)' : " ($row[2] )" ;
        $dd .= '<option value="' . $row[0] . '" '. $selected . $row[1] . $desc .'</option>';
    } //end while
    $dd .= '</select>';
    return $dd;
}

function getItems($tsql,$x){
    require("cn.php");
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    $getResults = sqlsrv_query($conn, $tsql . $x, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
    if (!$getResults) {
        die( "<pre>" . print_r( sqlsrv_errors(). "</pre>", true)); ;
    }else{
        //print_r($stmt);
    }
    $items = '<tr><th colspan="1" style="text-align: center;">Param Name</th>
    <th colspan="1" style="text-align: center;">Value</th></tr>';
    //$i = 0;
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_NUMERIC)) {
        $items .= '<form name="forma" action="/fatfree/params/" target="_self" method="POST">
            <tr><th style="text-align: right;" >
                <input type="hidden" value="' . $row[0] . '" name="optID">
                <label>' . $row[1] . '</th><th>
                <input type="text" name="optVal" value="' . $row[2] . '" style="width: 80%;"></label>
                <button class="dentro">update</button>
                <input type="hidden" name="req" value="2">
                <input type="hidden" name="itemID" value="'.$x.'">
                <input type="hidden" name="oldVal" value="' . $row[2] . '">
            </th></tr></form>';
    } //end while
    //echo $f3->get('BASE');
    if(sqlsrv_num_rows($getResults)>0) {
        //$items .= '<tr><th colspan="2" style="text-align: right;"></th></tr></form>';
    }else{
        $items .= '<tr><th colspan="2" style="text-align: center;">No records</th></tr>';
    }
    //controls for adding new param
    $items .='
        <tr>
            <th colspan="2" style="text-align: center;">
                New
            </th>
        </tr>
        <tr>
            <form name="main1" action="/fatfree/params" target="_self" method="POST">
            <th>
                <input type="text" name="txtParam" placeholder="Panam Name" style="width: 80%;" required>
            </th>
            <th>
                <input type="text" name="txtValue" placeholder="Panam Value" style="width: 70%;" required>
                <button class="dentro">Submit</button>
                <input type="hidden" name="req" value="3">
                <input type="hidden" name="itemID" value="' . $x . '">
            </th>
            </form>
        </tr>';
    return $items;
}

function updateItem($val,$itemID){
    require("cn.php");
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    $tsql = "UPDATE dbo.tbl_PackageOptions SET opt_value = ( ? ), updated = (select GETDATE()) WHERE id = ( ? )"; 
    // $val = $f3->get('POST.optVal');
    // $itemID = $f3->get('POST.optID');
    //echo($val)."<br>";
    //echo($itemID)."<br>";
    $params = array($itemID,$val);
    //print_r($params);
    $stmt = sqlsrv_prepare( $conn, $tsql, $params); 
    if (!$stmt) {
        die( "<pre>" . print_r( sqlsrv_errors(). "</pre>", true)); ;
    }else{
        //print_r($stmt);
    }
    if( sqlsrv_execute($stmt))  
    {  
        return '<h1 style="color:green; text-align:center;"> Successfully updated!</h1>';  
    }else{  
        //return "Error in executing statement.$val[$i] :: $itemID[$i]\n";  
        die( "<pre>".print_r( sqlsrv_errors(), true))."</pre>";//die( "<pre>" . print_r( sqlsrv_errors(). "</pre>", true));  
    }
    sqlsrv_free_stmt( $stmt);  
    sqlsrv_close( $conn);
}

function addParam($name,$value,$itemID){
    require("cn.php");
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    $tsql = "INSERT into dbo.tbl_PackageOptions (opt_name,opt_value,pkg_id,active) values (?,?,?,?)";
    $params = array($name,$value,$itemID,'1');
    $stmt = sqlsrv_prepare( $conn, $tsql, $params);  
    if( sqlsrv_execute( $stmt))  
    {  
        return '<h1 style="color:green; text-align:center;">Successfully recorded!</h1>';  
    }else{  
        die( "<pre>" . print_r( sqlsrv_errors(). "</pre>", true)); 
    }
    sqlsrv_free_stmt( $stmt);  
    sqlsrv_close( $conn);

}
<!DOCTYPE html>
<?php require_once("cn.php");
/********************************************
 * Danny Monzon
 * 20210630
 ********************************************/
?>
<head>
    <link rel="stylesheet" type="text/css" href="/ham/ui/css/style.css">
</head>
<body>
    <div class="noprint">
        <table>
            <thead>
                <form id="main" action="<?php echo $f3->get('BASE');?>/confirm" target="_self" method="POST">
                    <tr>
                        <th colspan="4">DAILY CK LIST</th>
                        <th colspan="5" style="text-align: center;">DATE</th>
                    </tr>
                    <tr>
                        <th colspan="4">
                            <span style="font-style:oblique;">
                                <h3>VHAMSL10SVR</h3>
                            </span> 
                        </th>
                        <th colspan="5" style="text-align: center;">
                            <input type="date" id="txtDate" name="txtDate" placeholder="mm/dd/yyyy" value="<?php echo (!empty($f3->get('POST.txtDate'))) ? $f3->get('POST.txtDate') : date('Y-m-d'); ?>">
                        </th>
                    </tr>
            </thead>
            <tbody>
                <?php
                if($f3->get('PARAMS.count') > 0){
                    $conn = sqlsrv_connect($serverName, $connectionOptions);
                    $tsql = "select id,job_name from DailyJobs order by 2";
                    $getResults = sqlsrv_query($conn, $tsql);
                    $dd = '<select name="logid[]">';
                    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                        $dd .= '<option value="' . $row['id'] . '">' . $row['job_name'] . '</option>';
                        //$i++;
                    } //end while
                    $dd .= '</select>';
                    //echo $f3->logs;
                    if ($f3->get('PARAMS.count') <= 0) {
                        $control = 1;
                    } else {
                        $control = $f3->get('PARAMS.count');
                    }
                    for ($i = 0; $i < $control; $i++) {
                        echo '<tr>
                            <th colspan="4">' . $i + 1 . '. ' . $dd . '</th>
                            <th>Time:</th>
                            <th><input type="datetime-local" name="time[]" placeholder="runtime" value="'.date('Y-m-d\T00:00').'" required></th>
                            <th><input type="number" min="0" max="24" name="hh[]" style="width: 50px;"></th>
                            <th><input type="number" min="0" max="59" name="min[]" style="width: 50px;"></th>
                            <th><input type="number" min="0" max="59" name="ss[]" style="width: 50px;" required></th>
                            </tr>';
                    }
                }else{
                    !empty($f3->get('POST.txtDate')) ? $logDate=$f3->get('POST.txtDate') : $logDate = date('Y-m-d');
                    $conn = sqlsrv_connect($serverName, $connectionOptions);
                    $tsql = "select id,job_name from DailyJobs where Active = 1 order by job_Group,priority;";
                    $getResults = sqlsrv_query($conn, $tsql);
                    if ($getResults == FALSE)
                        die("<pre>".(sqlsrv_errors())."</pre>");
                    $i = 0;
                    //building form fields
                    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                        $i++;
                        echo '<tr>
                            <th colspan="4">' . $i . '. ' . $row['job_name'] . '<input type="hidden" name="logid[]" value="' . str_replace(' ', '', $row['id']) . '"></th>
                            <th>Runtime: <input type="datetime-local" name="time[]" placeholder="runtime" value="'.date('Y-m-d\T00:00').'" required></th>
                            <th><input type="number" min="0" max="24" name="hh[]" placeholder="hh" ></th>
                            <th><input type="number" min="0" max="59" name="min[]" placeholder="mm"></th>
                            <th><input type="number" min="0" max="59" name="ss[]" placeholder="ss" required></th>
                            </tr>';
                        
                    } //end while
                }
                ?>
                <tr><th colspan="9"><textarea name="notes" rows="4" cols="100" placeholder="Notas"></textarea></th></tr>
                <tr>
                    <th colspan="10">
                        <input type="hidden" name="total" value="<?php echo $i - 1; ?>">
                        <button class="dentro">Submit</button>
                    </form>
                    </th>
                </tr>
        </table>
    </div>
    <div class="print">
        <table>
            <thead>
                <?php
                //print_r($_POST);
                // resultados
                //$logDate = $f3->get('POST.txtDate');
                if ($f3->get('POST.txtDate')) {
                    $logDate = $f3->get('POST.txtDate');
                    $print = "Logs for " . date('F j, Y', strtotime($logDate));
                } else {
                    $logDate = date('Y-m-d');
                    $print = "Logs for Today's";
                }
                echo '<th colspan="9" style="text-align: center;">' . $print . '</th>
                    <tr>
                    <th colspan="9" style="text-align: center;" class="noprint">
                        <form id="form2" action="'. $f3->get('BASE').'/jobs" target="_self" method="POST">
                        <input type="date" id="txtDate" name="txtDate" class="noprint" required>
                        <input type="hidden" name="option" value="1">
                        <button class="dentro">View date logs</button>
                        <button onclick="javascript:window.print()"  class="dentro">Print</button>
                        </form>
                    </th>
                    </tr>';
                ?>
            </thead>
            <tbody>
                <?php
                    require("selectjobs.php");
                    sqlsrv_free_stmt($getResults);
                ?>
            </tbody>
        </table>
    </div>
</body>
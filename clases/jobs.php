<!DOCTYPE html>
<?php require_once("cn.php");
/********************************************
 * Danny Monzon
 * 20210629
 ********************************************/
?>
<head>
    <link rel="stylesheet" type="text/css" href="./clases/style.css">
</head>
<body>
    <div class="noprint">
        <table>
            <thead>
                <form id="main" action="confirm.php" target="_self" method="POST">
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
                        <th colspan="2" style="text-align: center;">
                            <input type="date" id="txtDate" name="txtDate" placeholder="mm/dd/yyyy" value="<?php echo (!empty($_POST)) ? $_POST['txtDate'] : date('Y-m-d'); ?>">
                        </th>
                        <th colspan="3" style="text-align: center;">HH - MM - SS</th>
                    </tr>
            </thead>
            <tbody>
                <?php
                    //form with logs from DB
                    !empty($POST) ? $logDate = $_POST['txtDate'] : $logDate = date('Y-m-d');
                    $conn = sqlsrv_connect($serverName, $connectionOptions);
                    $tsql = "select id,job_name
                        from DailyJobs
                        where Active = 1 
                        order by job_Group,priority;";
                    $getResults = sqlsrv_query($conn, $tsql);
                    if ($getResults == FALSE)
                        die(FormatErrors(sqlsrv_errors()));
                    $i = 0;
                    //building form fields
                    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                        $i++;
                        echo '<tr>
                            <th colspan="4">' . $i . '. ' . $row['job_name'] . '<input type="hidden" name="logid[]" value="' . str_replace(' ', '', $row['id']) . '"></th>
                            <th>Runtime:</th>
                            <th><input type="datetime-local" name="time[]" placeholder="runtime" value="' . date('yyyy-mm-ddT00:00:00', strtotime($logDate)) . '"required></th>
                            <th><input type="number" min="0" max="24" name="hh[]" style="width: 30px;" ></th>
                            <th><input type="number" min="0" max="59" name="min[]" style="width: 30px;"></th>
                            <th><input type="number" min="0" max="59" name="ss[]" style="width: 30px;" required></th>
                            </tr>';
                        
                    } //end while
                ?>
                <tr><th colspan="9"><textarea name="notes" rows="4" cols="100" placeholder="Notas"></textarea></th></tr>
                <tr>
                    <th colspan="10">
                    <input type="hidden" name="total" value="<?php echo $i - 1; ?>"><input type="submit" name="submit" value="Submit"></form>
                    </th>
                </tr>
        </table>
    </div>
    <div class="print" style="margin-top:0pc;">
        <table>
            <thead>
                <?php
                //print_r($_POST);
                // resultados
                if ($_POST) {
                    $logDate = $_POST['txtDate'];
                    $print = "Logs for " . date('F j, Y', strtotime($logDate));
                } else {
                    $logDate = date('Y-m-d');
                    $print = "Logs for Today's";
                }
                echo '<th colspan="9" style="text-align: center;">' . $print . '</th>
                    <tr>
                    <th colspan="9" style="text-align: center;" class="noprint">
                        <form id="form_2" action="jobs.php" target="_self" method="POST">
                        <input type="date" id="txtDate" name="txtDate" class="noprint" required>
                        <input type="hidden" name="option" value="1">
                        <input type="submit" name="submit1" value="View date logs" class="noprint">
                        <input type="button" name="submit1" value="Print" onclick="javascript:window.print()" class="noprint">
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
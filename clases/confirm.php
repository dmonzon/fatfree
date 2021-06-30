<!DOCTYPE html> 
<?php
/********************************************
 * Danny Monzon
 * created:20210607     updated: 20210622
 ********************************************/
?>
<head>
    <link rel="stylesheet" type="text/css" href="./clases/style.css">
</head>
<body>
    <div>
        <table>
            <thead>
            <tr>
                <th colspan="4">DAILY CK LIST</th>
                <th colspan="2">DATE: <?php echo $f3->get('POST.txtDate'); ?></th>
                <th><input type="button" name="submit1" value="Print" onclick="javascript:window.print()" class="noprint"></th>
            </tr>
            <tr>
                <th colspan="4">Server:<span style="font-style:oblique;"><h3>VHAMSL10SVR</h3></span> </th>
                <th colspan="2" style="text-align: left;">STARTED</th><th>DURATION</th>
            </tr>
            <tr></tr><tr></tr>
            </thead>
            <tbody>
                <?php 
                    if($_POST){
                        //connect to DB
                        echo "<pre>";
                        require_once("./clases/cn.php");
                        $conn = sqlsrv_connect($serverName, $connectionOptions);
                        if( $conn === false ){
                            echo "Could not connect.\n";
                            die( print_r( sqlsrv_errors(), true));
                        }
                        //preparing to insert
                        //echo "inserting ...";
                        //print_r($_POST);
                        $logDate =$f3->get('POST.txtDate');$logid =$f3->get('POST.logid');
                        $tot = $f3->get('POST.total');
                        //echo "$tot<br>";
                        $duration='';
                        for ($i=0; $i <= $tot; $i++) { 
                            $hh = !($f3->get('POST.hh')[$i]) ? '00' : $f3->get('POST.hh')[$i] ;
                            $min = !($f3->get('POST.min')[$i]) ? '00' : $f3->get('POST.min')[$i] ;
                            $ss = !($f3->get('POST.ss')[$i]) ? '00' : $f3->get('POST.ss')[$i] ;
                            $duration = date('H:i:s', strtotime($hh . ':' .  $min . ':' . $ss));
                            $time = str_replace('T', ' ', $f3->get('POST.time')[$i]);//$f3->get('POST.time')[$i]; 
                            //echo ">>>$time <br>" ;
                            $tsql = "insert into DailyJobsDet (JobID,job_date,runtime,duration) values (?,?,?,?)";
                            //echo "<br>$tsql";
                            $params = array($logid[$i],"$logDate","$time","$duration");
                            //print_r($params); 
                            $getResults= sqlsrv_query($conn, $tsql, $params);
                            if( $getResults === false ) {
                                die( print_r( sqlsrv_errors(), true));
                            }
                            //inserting note
                            if($f3->get('POST.notes')){
                                $notes = !($f3->get('POST.notes')) ? '' : $f3->get('POST.notes');
                                $tsql = "insert into DailyJobsNotes (jobs_date,note) values (?,?)";
                                $params = array("$logDate","$notes");
                                //print_r($params); 
                                $getResults= sqlsrv_query($conn, $tsql, $params);
                                if( $getResults === false ) {
                                    die( print_r( sqlsrv_errors(), true));
                                }
                            }
                        }
                        //echo "inserted!!";
                        sqlsrv_close($conn);
                        require_once("./clases/selectjobs.php");
                    } else{
                        $logDate = $_GET['d'];
                        require_once("./clases/cn.php");
                        require("./clases/selectjobs.php");
                        sqlsrv_close($conn);
                    }
                    echo "</pre>";
                ?>
            </tbody>    
        </table>
    </div>
    <div class="noprint" style="text-align: center; color: red"><a href="/fatfree/jobs">Home</a></div>
</body>
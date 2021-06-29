<!DOCTYPE html> 
<?php require_once("../inc/cn.php");
/********************************************
 * Danny Monzon
 * 20210607
 ********************************************/

 echo "<pre>";
 print_r($_POST);
?>

<head>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div>
        <table>
            <thead><form id="main" action="confirm.php" target="_self" method="POST">
               <tr>
                    <th colspan="4">DAILY CK LIST</th>
                    <th colspan="2"><center>DATE  <?php echo $_POST['txtDate']; ?></center></th>
                    <th colspan="3"><center>HH - MM - SS</center></th>
                </tr>
                <tr>
                    <th colspan="9"><span style="font-style:oblique;"><h3>SERVER: VHAMSL10SVR</h3></span> </th>
                    <!-- <th colspan="2" style="text-align: left;">
                    <center>
                        <input type="date" id="txtDate" name="txtDate" placeholder="mm/dd/yyyy" value="<?php echo(!empty($_POST)) ? $_POST['txtDate'] : date('Y-m-d'); ?>">
                    </center>
                    </th>
                    <th colspan="3"></th> -->
                </tr>
                <tr></tr><tr></tr>
            </thead>
            <tbody>
                    <tr>
                        <th colspan="9">
                            <input type="hidden" name="total" value="<?php echo $i;?>"><input type="submit" name="submit" value="Submit"></form>
                        </th>
                    </tr>
                    <?php 
                    //print_r($_POST);
                    if($_POST){
                        $logDate = $_POST['txtDate'];
                        $print = "Logs for " . date('F j, Y', strtotime($logDate)) ;
                    }else{
                        $logDate =date('Y-m-d');
                        $print ="Logs for Today's";
                    }
                    echo '<th colspan="9"><center>' . $print .'</center> </th>
                        <tr>
                          <th colspan="9"><center>
                          <form id="form_2" action="indexNew.php" target="_self" method="POST">
                          <input type="date" id="txtDate" name="txtDate">
                          <input type="hidden" name="option" value="1">
                          <input type="submit" name="submit1" value="View date logs">
                          </form></center> </th>
                        </tr>';
                    require("./inc/selectjobs.php");
                    sqlsrv_free_stmt($getResults); 
                    echo "</pre>";
                ?>
                 
            </tbody>    
        </table>
    </div>
</body>
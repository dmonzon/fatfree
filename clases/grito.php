<?php

class Grito
{
    public $name;

    function __construct($name) {
        $this->name = $name;
    }
    function get_name() {
        return $this->name;
    }

} 

// if ($_GET) {
    echo $this->name;
    require("/xampp/htdocs/fatfree/clases/cn.php");
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    $tsql = "select id,job_name from DailyJobs order by 2";
    $getResults = sqlsrv_query($conn, $tsql);
    $dd = '<select name="logid[]">';
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
        $dd .= '<option value="' . $row['id'] . '">' . $row['job_name'] . '</option>';
        //$i++;
    } //end while
    $dd .= '</select>';
    // if ($_GET['logs'] <= 0) {
        $control = 1;
    // } else {
    //     $control = $_GET['logs'];
    // }
    for ($i = 0; $i < $control; $i++) {
        echo '<tr>
            <th colspan="4">' . $i + 1 . '. ' . $dd . '</th>
            <th>Time:</th>
            <th><input type="datetime-local" name="time[]" placeholder="runtime" required></th>
            <th><input type="number" min="0" max="24" name="hh[]" style="width: 30px;"></th>
            <th><input type="number" min="0" max="59" name="min[]" style="width: 30px;"></th>
            <th><input type="number" min="0" max="59" name="ss[]" style="width: 30px;" required></th>
            </tr>';
    }
// }
<?php

$conn = sqlsrv_connect($serverName, $connectionOptions);
$tsql = "select j.id,j.job_name,d.job_date,d.runtime,d.duration,j.[Job_Group]
            from [dbo].[DailyJobs] j 
                inner join DailyJobsDet d on j.ID = d.JobID
            where Job_date = '$logDate'";
$getResults= sqlsrv_query($conn, $tsql);
$i = 0;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    echo '<tr>
    <th colspan="4">' . $row['job_name']. '</th>
    <th colspan="2">'. $row['runtime']->format('Y-m-d H:i:s') . '</th>
    <th colspan="3">'. $row['duration']->format('H:i:s') . '</th>
    </tr>';
    $i++;
}
$conn = sqlsrv_connect($serverName, $connectionOptions);
$tsql = "select note from dbo.DailyJobsNotes
    where jobs_date = '$logDate'";
$getResults= sqlsrv_query($conn, $tsql);
if($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    echo '<tr><th colspan="7"><h3>Notes:</h3><br>'. str_replace(PHP_EOL,"<br>",$row['note']) . '</th>
    </tr>';
}

?>
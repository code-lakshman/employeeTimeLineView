<?php

function timeline() {
    $activity = $this->allActivities();
    echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript">
    google.charts.load("current", {packages:["timeline"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var container = document.getElementById(\'example7.1\');
      var chart = new google.visualization.Timeline(container);
      var dataTable = new google.visualization.DataTable();
      dataTable.addColumn({ type: \'string\', id: \'Room\' });
      dataTable.addColumn({ type: \'string\', id: \'Name\' });
      dataTable.addColumn({ type: \'date\', id: \'Start\' });
      dataTable.addColumn({ type: \'date\', id: \'End\'});
      dataTable.addRows([
        [ \'Testing\', \'\', new Date(0,0,0,10,0,0), new Date(0,0,0,10,0,0)],';
    echo $activity;
    echo' [ \'Testing\', \'\', new Date(0,0,0,20,0,0), new Date(0,0,0,20,0,0)]]);

      var options = {
        timeline: { showRowLabels: false },
        avoidOverlappingGridLines: false
      };

      chart.draw(dataTable, options);
    }

  </script>

  <div id="example7.1" style="height: 180px;"></div>';
}

function allActivities() {


    //activity 1
    $qry = "SELECT CONCAT(TIME_FORMAT(last_login,'%H,%i,%s')) as ltime FROM " . TIMEHISTORY . " WHERE DATE(last_login) = CURDATE() AND username='" . $_SESSION['details']['username'] . "' AND TIME_FORMAT(last_login,'%H') BETWEEN '10' AND '20'";

    $sql = $this->db->query($qry);
    $li = 0;
    while ($run = $this->db->fetch_object()) {

        $str.='[ \'' . $_SESSION['details']['name'] . '\', \'' . ++$li . 'You Logged In\', new Date(0,0,0,' . $run->ltime . '), new Date(0,0,0,' . $run->ltime . ')],';
    }

    //activity 2, 3,4,5,6, 7

    $tables = array('' . TBL1 . '', '' . TBL2 . '');
    $new = 0;
    foreach ($tables as $v) {
        $qry1 = "SELECT CONCAT(TIME_FORMAT(added_datetime,'%H,%i,%s')) as ltime1 FROM `" . $v . "` WHERE DATE(added_datetime) = CURDATE() AND added_by='" . $_SESSION['details']['id'] . "' AND TIME_FORMAT(added_datetime,'%H') BETWEEN '10' AND '20'";

        $sql1 = $this->db->query($qry1);
        switch ($v) {
            case '' . TBL1 . '': $tag = 'Work Done';
                break;
            case '' . TBL2 . '': $tag = 'WORK DONE 2';
                break;
        }

        while ($run1 = $this->db->fetch_object()) {
            $str.='[ \'' . $_SESSION['details']['name'] . '\', \'' . ++$new . ' ' . $tag . '\', new Date(0,0,0,' . $run1->ltime1 . '), new Date(0,0,0,' . $run1->ltime1 . ')],';
        }
    }

    //activity 8
    $qry2 = "SELECT CONCAT(TIME_FORMAT(updated_date,'%H,%i,%s')) as ltime2 FROM " . CALLDETAILS . " WHERE DATE(updated_date) = CURDATE() AND added_by='" . $_SESSION['details']['id'] . "' AND TIME_FORMAT(updated_date,'%H') BETWEEN '10' AND '20'";
    $sql = $this->db->query($qry2);
    while ($run = $this->db->fetch_object()) {
        $str.='[ \'' . $_SESSION['details']['name'] . '\', \'\', new Date(0,0,0,' . $run->ltime2 . '), new Date(0,0,0,' . $run->ltime2 . ')],';
    }

    //activity 9
    $qry4 = "SELECT CONCAT(C.caller_number,' called ',C.receiver_number,' and call type is ',C.call_type) as summary,CONCAT(TIME_FORMAT(C.call_time,'%H,%i,%s')) as stime, CONCAT(TIME_FORMAT(ADDTIME(call_time, SEC_TO_TIME(call_duration)),'%H,%i,%s')) as ltime FROM " . CALLDETAILS . " C, " . EMPLOYEE . " E WHERE DATE(C.call_date) = CURDATE() AND (C.caller_number = E.mobile_office OR C.receiver_number = E.mobile_office) AND E.mobile_office='" . $_SESSION['details']['mobile_office'] . "' AND E.archive=0 AND TIME_FORMAT(C.call_time,'%H') BETWEEN '09' AND '21' group by stime";

    $sql = $this->db->query($qry4);
    $new = 0;
    while ($run4 = $this->db->fetch_object()) {
        $tag = '-' . $run4->summary;
        $str.='[ \'' . $_SESSION['details']['name'] . '\', \'' . ++$new . ' ' . $tag . '\', new Date(0,0,0,' . $run4->stime . '), new Date(0,0,0,' . $run4->ltime . ')],';
    }



    //activity 10
    $qry3 = "SELECT CONCAT(TIME_FORMAT(last_login,'%H,%i,%s')) as ltime FROM " . LOGINHISTORY . " WHERE DATE(last_login) = CURDATE() AND username='" . $_SESSION['details']['username'] . "' AND TIME_FORMAT(last_login,'%H') BETWEEN '10' AND '20'";

    $sql = $this->db->query($qry);
    $lo = 0;
    while ($run = $this->db->fetch_object()) {
        $str.='[ \'' . $_SESSION['details']['name'] . '\', \'' . ++$lo . ' You Logged Out\', new Date(0,0,0,' . $run->ltime . '), new Date(0,0,0,' . $run->ltime . ')],';
    }

    return $str;
}


?>
<div class="row">
                <?php timeline(); //call?>
                </div>
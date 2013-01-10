<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors',1);


function displayMonths(){ ?>
<form name="display_logs" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    Select Month:<br />
    <select name="month">
        <option value="null">--</option>
        <option value="01">January</option>
        <option value="02">February</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
        </select><br />
    <input type="submit" value="View Log" size="12" name="submit"><br />
    </form>
    <?php
}
displayMonths();


function listLogFiles($month = 'null'){

    $str = "logs/*";
    if ($_POST['month'] != 'null'){
        $str .= "-{$month}-*.log";

    }
    else {
        $str .= ".log";

    }
    foreach(glob($str) as $file){
        echo "{$file}<br/>";
    }

}




echo "<h4>Log File List</h4>";

listLogFiles($_POST['month']);
?>
<br/>
<br/>
<a href="proceduralApp.php">Go back to previous page</a>
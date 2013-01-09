<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors',1);


function displayMonths(){ ?>
<form name="display_logs" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    Select Month:<br />
    <select name="month">
        <option value="You did not select month">--</option>
        <option value="January">January</option>
        <option value="February">February</option>
        <option value="March">March</option>
        <option value="April">April</option>
        <option value="May">May</option>
        <option value="June">June</option>
        <option value="July">July</option>
        <option value="August">August</option>
        <option value="September">September</option>
        <option value="October">October</option>
        <option value="November">November</option>
        <option value="December">December</option>
        </select><br />
    <input type="submit" value="View Log" size="12" name="submit"><br />
    </form>
    <?php
}
displayMonths();



if(isset($_POST['month'])){
    echo "Selected month is " . $month = $_POST['month'];
}
else $month = "January by default";

function listLogFiles(){
    $files = glob("logs/*.log");
    if (count($files) > 0){
        foreach($files as $file){
            echo ($file);
            ?>
        <br/>
        <?php
            }
        }
    else {
        echo "No files matching '*.log' ";
        }
    }
echo "<h4>Log File List</h4>";

listLogFiles();
?>
<br/>
<br/>
<a href="proceduralApp.php">Go back to previous page</a>
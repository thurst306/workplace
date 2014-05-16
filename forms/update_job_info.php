<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="css/forms.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<?php
    require_once "require/db_connection.php";
    $update_con = new mysqli($db_host, $user_employee, $user_employee_pw, "workplace");
    $employees = mysqli_query($update_con, "SELECT * FROM employees");
    //Clients
    $clients = mysqli_query($update_con, "SELECT * FROM Clients");
    //Jobs
    $update_select_job_names = mysqli_query($update_con, "SELECT * FROM worktodo WHERE JobID = " . $job_id);
    //Test input function
    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    };
    //Check for submission
    if(isset($_POST["submit"])){
        //Test all input
        $job_name = test_input($_POST['jobname']);
        $job_desc = test_input($_POST['jobdesc']);
        $job_start = test_input($_POST['startdate']);
        $job_due = test_input($_POST['duedate']);
        $job_lead = test_input($_POST['employee']);
        $job_client = test_input($_POST['client']);
        $job_status = test_input($_POST['status']);
        //Check that each and every submission isn't somehow empty
        if(empty($_POST['jobname']) || empty($_POST['jobdesc']) || empty($_POST['startdate']) || empty($_POST['duedate']) || empty($_POST['startdate']) || empty($_POST['client']) || empty($_POST['status'])){
            //Alert and kill the process if something is empty
            echo "
                <script>
                    //console.log(\"Something is empty!\");
                    alert(\"ALL fields are required! The form has been reset.\");
                </script>
            ";
            while ($row = mysqli_fetch_array($update_select_job_names)){
                $job_name = $row['JobTitle'];
                $job_desc = $row['Description'];
                $job_start = $row['StartDate'];
                $job_due = $row['DueDate'];
                $job_lead = $row['employeeID'];
                $job_client = $row['ClientID'];
                $job_status = $row['currentStatus'];
            }
            //Otherwise check the formats for each
        } else if (!preg_match("/^[a-z0-9\s]+\z/i", $job_name) || (!preg_match("/^[2]{1}[01]{1}[0-9]{2}\-(0[1-9]|1[012])\-(0[1-9]|1[0-9]|2[0-9]|3[01])\z/", $job_start)) || (!preg_match("/^[2]{1}[01]{1}[0-9]{2}\-(0[1-9]|1[012])\-(0[1-9]|1[0-9]|2[0-9]|3[01])\z/", $job_due))) {
            //Submission syntax is wrong! Kill it with fire!
            echo "
                <script>
                    console.log(\"Submission syntax is wrong!\");
                    alert(\"Syntax is wrong somewhere! The form has been reset.\");
                </script>
            ";
            while ($row = mysqli_fetch_array($update_select_job_names)){
                $job_name = $row['JobTitle'];
                $job_desc = $row['Description'];
                $job_start = $row['StartDate'];
                $job_due = $row['DueDate'];
                $job_lead = $row['employeeID'];
                $job_client = $row['ClientID'];
                $job_status = $row['currentStatus'];
            }
        } else {
            //Submission successful, create query
            
            $update = mysqli_query($update_con, "UPDATE `worktodo` SET `currentStatus` = '$job_status', `ClientID` = '$job_client', `employeeID` = '$job_lead', `StartDate` = '$job_start', `DueDate` = '$job_due', `JobTitle` = '$job_name', `Description` = '$job_desc' WHERE `JobID` = '$job_id'");
            if (!mysqli_query($update_con, $update))
            {
                echo "
                    <script>
                        console.log(\"Query is: $update\");
                    </script>
                ";
                die('Error: ' . mysqli_error($update_con));
            } else {
                echo "
                    <script>
                        console.log('Submission successful!');
                    </script>
                ";
            }
        }
    } else {
        echo "
            <script>
                console.log('No submission. Default form info loaded.');
            </script>
        ";
        while ($row = mysqli_fetch_array($update_select_job_names)){
            $job_name = $row['JobTitle'];
            $job_desc = $row['Description'];
            $job_start = $row['StartDate'];
            $job_due = $row['DueDate'];
            $job_lead = $row['employeeID'];
            $job_client = $row['ClientID'];
            $job_status = $row['currentStatus'];
        }
    }
?>
<form class="add_info" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); echo "?key=" . $job_id;?>" method="post">
    <label>Job Name: 
        <input type="text" id="jobname" name="jobname" class="text_input" value="<?php echo $job_name; ?>" pattern="[A-Za-z0-9\s]+" required />
        <p id="error-text" class="error-text">This is required!</p>
    </label>
    <label>Job Description: 
        <textarea rows="4" id="jobdesc" columns="50" name="jobdesc" required /><?php echo $job_desc; ?></textarea>
        <p class="error-text">This is required!</p>
    </label>
    <label>Lead: 
        <select id="employee" name="employee" required>
            <option disabled style="display: none;"></option>
            <?php
                while($row = mysqli_fetch_array($employees)){
                    echo "<option value=" . $row["employeeID"] . ">" . $row["fName"] . " " . $row["lName"] . "</option>";
                }
            ?>
        </select>
        <p class="error-text">This is required!</p>
    </label>
    <label>Client: 
        <select id="client" name="client" required>
            <option selected disabled style="display: none;"></option>
            <?php
                while($client_row = mysqli_fetch_array($clients)){
        	        echo "<option value=\"" . $client_row["ClientID"] . "\">" . $client_row["Name"] . "</option>";
                }
            ?>
        </select>
        <p class="error-text">This is required!</p>
    </label>
    <label>Start Date: 
        <input type="text" id="startdate" value="<?php echo $job_start; ?>" name="startdate" class="datepicker" pattern="[2]{1}[01]{1}[0-9]{2}\-(0[1-9]|1[012])\-(0[1-9]|1[0-9]|2[0-9]|3[01])" required />
        <p class="error-text">This is required!</p>
    </label>
    <label>Due Date: 
        <input type="text" id="duedate" class="datepicker" value="<?php echo $job_due; ?>" name="duedate" pattern="[2]{1}[01]{1}[0-9]{2}\-(0[1-9]|1[012])\-(0[1-9]|1[0-9]|2[0-9]|3[01])" required />
        <p class="error-text">This is required!</p>
    </label>
    <label>Status: 
        <select id="status" name="status" required>
            <option selected disabled style="display: none;"></option>
            <?php require "includes/statuses.php" ?>
        </select>
    </label>
    <input type="submit" id="submit" name="submit" value="Update job" />
</form>
<script>
    /*$(function() {
        $(".datepicker").datepicker();
        $( ".datepicker" ).datepicker("option", "dateFormat", "yy-mm-dd");
    });*/
    $(function() {
        $( ".datepicker" ).datepicker({
          showOn: "button",
          buttonImage: "images/calendar.gif",
          buttonImageOnly: true,
          dateFormat: "yy-mm-dd"
        });
    });
    $("select#employee option[value='<?php echo $job_lead ?>']").attr("selected", "");
    $("select#client option[value='<?php echo $job_client ?>']").attr("selected", "");
    $("select#status option[value='<?php echo $job_status ?>']").attr("selected", "");
</script>

<!--Test Oracle file for UBC CPSC304 2018 Winter Term 1
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  This file shows the very basics of how to execute PHP commands
  on Oracle.
  Specifically, it will drop a table, create a table, insert values
  update values, and then query for values

  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the
  OCILogon below to be your ORACLE username and password -->

<html>
    <head>
        <title>CPSC 304 Group Project</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                display: flex;
                justify-content: space-between;
                background-color: #f5f5f5;
            }
            .content-container {
                height: 100vh;
                overflow: auto;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
                padding: 20px;
            }
            .left-content {
                flex: 60%; /* Set left content to 60% width */
                border-right: 1px solid #ddd;
                margin: 10px;
                padding-right: 20px;
            }
            .right-content {
                flex: 40%; /* Set right content to 40% width */
                background-color: #ffffff;
                border-radius: 5px;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
                margin: 10px;
                padding-left: 20px;
            }
            h2 {
                margin-top: 0;
                color: #333;
            }
            form {
                margin-bottom: 20px;
            }
            input[type="text"], input[type="radio"], input[type="submit"], input[type="checkbox"] {
                margin: 5px 0;
                border: 1px solid #ccc;
                padding: 5px;
                border-radius: 3px;
            }
            .radio-group {
                display: inline-block;
            }
            .radio-group input[type="radio"] {
                margin-right: 10px;
            }
            label {
                display: inline-block;
                width: 140px;
                font-weight: bold;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 10px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            hr {
                margin-top: 20px;
            }
        </style>
    </head>

    <body>
    <div class="content-container left-content">
        
        <h2>Show the Tuples in Table</h2>
        <form method="GET" action="CS304-Group-Project.php">
            <input type="hidden" id="showTupleRequest" name="showTupleRequest">
            Choose a table:
            <select name="tableName">
                <option value="FLOOR_I">FLOOR_I</option>
                <option value="FLOOR_T">FLOOR_T</option>
                <option value="CARD">CARD</option>
                <option value="ROOM_FIND">ROOM_FIND</option>
                <option value="HAS">HAS</option>
                <option value="ITEMCARD">ITEMCARD</option>
                <option value="OMENCARD">OMENCARD</option>
                <option value="ITEMGIVE">ITEMGIVE</option>
                <option value="MISSION_AWARD">MISSION_AWARD</option>
                <option value="EVENTCARDTRIGGER">EVENTCARDTRIGGER</option>
                <option value="CHARACTERS">CHARACTERS</option>
                <option value="MISSION_SUGGEST2">MISSION_SUGGEST2</option>
                <option value="SIDEQUESTTRIGGER">SIDEQUESTTRIGGER</option>
                <option value="ALIGNMENTS">ALIGNMENTS</option>
                <option value="SOLDIERBELONG">SOLDIERBELONG</option>
                <option value="WIZARDBELONG">WIZARDBELONG</option>
            </select>
            <br/><br/>
            <input type="submit" name="showSubmit" value="Show Table">
        </form>
        <hr />

        <h2>Change Your Aligment</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="CS304-Group-Project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            Last Name: <input type="text" name="LastName"> <br /><br />
            First Name: <input type="text" name="FirstName"> <br /><br />
        
            <?php
            $alignments = ['Red Wolf', 'Forever', 'Hunter', 'Thormchild', 'Tomorrow', 'Invisible'];

            foreach ($alignments as $alignment) {
                echo '<input type="radio" name="AlignmentsName" value="' . $alignment . '">' . $alignment . '<br>';
            }
            ?>
            
            <br/> 
            
            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <h2>Insert Values into RoomFind Table</h2>
        <form method="POST" action="CS304-Group-Project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Room ID: <input type="text" name="RoomID"> <br /><br />
            Name: <input type="text" name="name"> <br /><br />
            Difficulty Level: <input type="text" name="diffcultyLevel"> <br /><br />
            Card ID: <input type="text" name="CardID"> <br /><br />

            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

        <h2>Select Columns for Rooms to project on</h2>
        <form method="GET" action="CS304-Group-Project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectColumnRequest" name="selectColumnRequest">
            <input type="checkbox" id="RoomID" name="RoomID">
            <lable for="RoomID"> Display Room ID</label><br>
            <input type="checkbox" id="name" name="name">
            <lable for="name"> Display Room Name</label><br>
            <input type="checkbox" id="diffcultyLevel" name="diffcultyLevel">
            <lable for="diffcultyLevel"> Display Difficulty Level</label><br>
            <input type="checkbox" id="CardID" name="CardID">
            <lable for="CardID"> Display Card ID In the Room</label><br><br>
            <input type="submit" value="Sumbit"></p>
        </form>
        
        <hr />

        <h2>Delete</h2>
        <p>Delete one row from the room which have been removed by the company</p>

        <form method="POST" action="CS304-Group-Project.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="deleteRequest" name="deleteRequest">
            Room ID : <input type="text" name = "RoomID">
            <p><input type="submit" value="Delete" name="delete"></p>
        </form>

        <hr />

        <h2>Count</h2>
        <p>Count the number of Soldier in different alignments</p>

        <form method="POST" action="CS304-Group-Project.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="countRequest" name="countRequest">
            
            <p><input type="submit" value="count" name="count"></p>
        </form>

        <hr />

        <h2>Join</h2>
        <p>Join two table and find a limitation</p>

        <form method="POST" action="CS304-Group-Project.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="joinRequest" name="joinRequest">
            
            <p><input type="submit" value="join" name="join"></p>
        </form>

        <hr />

        <h2>Select</h2>
        <p>Show select values in table</p>
        <form method="GET" action="CS304-Group-Project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectRequest" name="selectRequest">
            
            Table: <input type="text" name = "Where">
            Attribute: <input type="text" name = "Which">
            From : <input type= "text" name = "What">
            <p><input type="submit" value= "Select" name="selectRequest"></p>
        </form>
        
        <hr />

        <h2>Find Rooms In All Floors</h2>
        <form method="GET" action="CS304-Group-Project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="divisionRequest" name="divisionRequest">

            <input type="submit" value="FIND ROOMS IN ALL FLOORS" name="divisionSubmit"></p>
        </form>

        <hr />

        <h2>Find Lowest HP Soldiers for each Allignment that has at least two Soldiers in it</h2>
        <form method="GET" action="CS304-Group-Project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="hasRequest" name="hasRequest">

            <input type="submit" value="Lowest HP Soldiers for each Allignment that has at least two Soldiers in it" name="hasSubmit"></p>
        </form>

        <hr />
        
        <h2>Floor Type with Highest Average Danger Level</h2>
        <form method="GET" action="CS304-Group-Project.php">
            <input type="hidden" name="executeQuery" value="true">
            <input type="submit" value="Execute Query">
        </form>
        </div>

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;
            
            $statement = OCIParse($db_conn, $cmdstr);
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printResult($result) { //prints results from a select statement
            echo "<div class=\"content-container right-content\">";
            echo "<br>Retrieved data:<br>";
            echo "<table>";
            echo "<tr>";

            // Get column names from the OCI result
            $columnNames = array();
            $ncols = oci_num_fields($result);
            for ($i = 1; $i <= $ncols; ++$i) {
                $columnNames[] = oci_field_name($result, $i);
                echo "<th>" . oci_field_name($result, $i) . "</th>";
            }

            echo "</tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr>";
                foreach ($columnNames as $columnName) {
                    echo "<td>" . $row[$columnName] . "</td>";
                }
                echo "</tr>";
            }

            echo "</table>";
            echo "</div>";
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example,
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_tianhaon", "a70845441", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        function handleDeleteRequest() {
            global $db_conn, $success;

            $room_id = $_POST['RoomID'];
            executePlainSQL("DELETE FROM Room_find WHERE RoomID='". $room_id . "'");
            OCICommit($db_conn);
            
        }

        function handleAggestGroup() {
            global $db_conn;

            $result = executePlainSQL("SELECT AlignmentsName, count(*) FROM SoldierBelong GROUP BY AlignmentsName");
            echo "<br>Retrieved data from table SoldierBelong:<br>";
            echo "<table>";
            echo "<tr><th>AlignmentsName</th><th>number</th><th>";

                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                    echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" ; //or just use "echo $row[0]"
                }
                echo "</table>";

            OCICommit($db_conn);
        }

        function handleJoin() {
            global $db_conn;

            $result = executePlainSQL("SELECT SoldierBelong.LastName, SoldierBelong.FirstName, SoldierBelong.AlignmentsName, Alignments.scale FROM SoldierBelong INNER JOIN Alignments ON SoldierBelong.AlignmentsName = Alignments.AlignmentsName WHERE Alignments.scale > 25");

            echo "<br>Retrieved data from table SoldierBelong:<br>";
            echo "<table>";
            echo "<tr><th>LastName</th><th>FirstName</th><th>AlignmentsName</th><th>Scale</th><th>";

                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                    echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>"; //or just use "echo $row[0]"  
                }
                echo "</table>";
                
            OCICommit($db_conn);   
        }

        function handleSelectRequest() {
            global $db_conn;
            
            $ask = $_GET['What'];
            $att = $_GET['Which'];
            $table = $_GET['Where'];

            $result = executePlainSQL("SELECT ". $att . " FROM " . $table . " WHERE  $ask " );
            printResult($result);            
        }

        function handleInsertRequest() {
            global $db_conn;
            global $success;

            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind1" => $_POST['RoomID'],
                ":bind2" => $_POST['name'],
                ":bind3" => $_POST['diffcultyLevel'],
                ":bind4" => $_POST['CardID']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into Room_find values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
            if ($success == True) {
                OCICommit($db_conn);
            } else {
                echo '<script>alert("Insertion Failed")</script>';
            }
        }
        
        function handleProjectRequest() {
            global $db_conn;

            $projection = '';
            if (array_key_exists('RoomID', $_GET)) {
                $projection .= 'RoomID, ';
            }
            if (array_key_exists('CardID', $_GET)) {
                $projection .= 'CardID, ';
            }
            if (array_key_exists('diffcultyLevel', $_GET)) {
                $projection .= 'diffcultyLevel, ';
            }
            if (array_key_exists('name', $_GET)) {
                $projection .= 'name, ';
            }
            $projection = substr($projection, 0 , -1);
            $projection = substr($projection, 0 , -1);
            $result = executePlainSQL("SELECT ". $projection." FROM Room_find");

            printResult($result);
        }

        function handleUpdateRequest() {
            global $db_conn;
            
            $last_name = $_POST['LastName'];
            $first_name = $_POST['FirstName'];
            $new_alignment = $_POST['AlignmentsName'];
            executePlainSQL("UPDATE WizardBelong SET AlignmentsName ='" .$new_alignment. "' WHERE LastName = '".$last_name."' AND FirstName = '".$first_name."'");
            OCICommit($db_conn);
        }

        function handleShowRequest() {
            $tableName = $_GET['tableName'];

            // Form the SQL query
            echo "<script type='text/javascript'>console.log('hitted');</script>";
            echo "<script type='text/javascript'>console.log('" . $tableName . "');</script>";
            $result = executePlainSQL("SELECT * FROM $tableName");
            printResult($result);
        }

        function getTableNames() {
            global $db_conn;
        
            $query = "SELECT table_name FROM user_tables"; // Query to retrieve table names
            $statement = executePlainSQL($query);
        
            $tableNames = array();
            while ($row = OCI_Fetch_Array($statement, OCI_ASSOC)) {
                $tableNames[] = $row['TABLE_NAME'];
            }
        
            return $tableNames;
        }

        function handleDivisionRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT RoomID FROM Room_find R WHERE NOT EXISTS ((SELECT FloorID From Floor_I F) MINUS (SELECT H.FloorID FROM Has H WHERE H.RoomID = R.RoomID))");

            printResult($result);
        }

        function handleExecuteQueryRequest() {
            global $db_conn;

            $result = executePlainSQL(" SELECT F.floorType
                                        FROM Floor_I F
                                        WHERE F.floorType = ANY (
                                            SELECT F2.floorType
                                            FROM Floor_I F2
                                            JOIN Has H ON F2.floorID = H.FloorID
                                            JOIN Room_find R ON H.RoomID = R.RoomID
                                            JOIN Floor_T FT ON F2.floorType = FT.floorType
                                            GROUP BY F2.floorType
                                            HAVING AVG(FT.dangerLevel) >= ALL (
                                                SELECT AVG(FT2.dangerLevel)
                                                FROM Floor_I F3
                                                JOIN Has H2 ON F3.floorID = H2.FloorID
                                                JOIN Room_find R2 ON H2.RoomID = R2.RoomID
                                                JOIN Floor_T FT2 ON F3.floorType = FT2.floorType
                                                WHERE F3.floorType = F2.floorType
                                                GROUP BY F3.floorType
                                            )
                                        )
                                    ");

            printResult($result);
        }

        function handleHasRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT AlignmentsName, MIN(HP) FROM (SELECT C.LastName, C.FirstName, C.HP, S.AlignmentsName FROM Characters C, SoldierBelong S WHERE C.LastName = S.LastName and C.FirstName = S.FirstName) GROUP BY AlignmentsName Having Count(*) > 1");

            printResult($result);
        }
        
        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                   handleInsertRequest();
                } else if (array_key_exists('joinRequest', $_POST)) {
                    handleJoin();
                } else if (array_key_exists('deleteRequest', $_POST)) {
                    handleDeleteRequest();
                } elseif (array_key_exists('countRequest', $_POST)) {
                    handleAggestGroup();
                }

                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('showSubmit', $_GET)) {
                    handleShowRequest();
                }else if (array_key_exists('RoomID', $_GET) || array_key_exists('CardID', $_GET) || array_key_exists('diffcultyLevel', $_GET) || array_key_exists('name', $_GET)) {
                    handleProjectRequest();
                }else if (array_key_exists('selectRequest', $_GET)) {
                    handleSelectRequest();
                }else if (array_key_exists('hasRequest', $_GET)) {
                    handleHasRequest();
                }else if (array_key_exists('divisionRequest', $_GET)) {
                    handleDivisionRequest();
                }else if (array_key_exists('executeQuery', $_GET)) {
                    handleExecuteQueryRequest();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['delete']) || isset($_POST['count']) || isset($_POST['join'])) {
            handlePOSTRequest();
        } else if (isset($_GET['showTupleRequest'])) {
            handleGETRequest();
        }else if (isset($_GET['selectColumnRequest'])) {
            handleGETRequest();
        }else if (isset($_GET['executeQuery'])){
            handleGETRequest();
        }else if (array_key_exists('selectRequest', $_GET)) {
            handleGETRequest();
        }else if (array_key_exists('hasRequest', $_GET)) {
            handleGETRequest();
        }else if (array_key_exists('divisionRequest', $_GET)) {
            handleGETRequest();
        }
		?>
	</body>
</html>

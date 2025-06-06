<?php

include('../db_folder/connection.php');
include('../db_folder/functions.php');


// Adding client to the database table

   if(isset($_POST["addClient"])) {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $type = $_POST["type"];
        $noOfLinkedContacts = 0;

        $confirmSQL = "SELECT * FROM clients WHERE name = '$name';";
        $result = mysqli_query($conn, $confirmSQL);
        
        if(empty($name) || empty($description) || empty($type)) {
             echo "
                <script>
                    alert('Please make sure everything is entered correctly!');
                </script>
                die;
             ";
        } elseif($result && mysqli_num_rows($result) > 0) {
            echo "
            <script>
                alert('Client with this name already exists!!');
            </script>
            die;
         ";
        } else {

        $client_code = generateClientCode($conn, $name);

        $sql = $conn->prepare("INSERT INTO clients (name, client_code, description, type, no_linked_contacts) values (?, ?, ?, ?, ?);");
        $sql->bind_param("ssssi", $name, $client_code, $description, $type, $noOfLinkedContacts);
        $sql->execute();
        echo "
           <script>
               alert('Client successfully added');
               window.location.href = 'clients.php';
           </script>
        ";
        $sql->close();
        }
   }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css_folder/newClient.css">
    <title>New Client</title>

</head>
<body>
<form method="post"  onsubmit="return validateInputs()">
       <div id="mainDiv">

       <!-- This is the header -->

            <header id="head">
                <div id="logoDiv">
                    <img id="logo" src="../images/binary_logo.png">
                </div>
                 <nav id="nav">
                        <a class="aTags" href="index.php">Home</a>
                        <a class="aTags" href="clients.php">Clients</a>
                        <a class="aTags" href="contacts.php">Contacts</a>
                 </nav>
            </header>

            <!-- This is the contentDiv, it contains everything and is where the input texts are -->

            <div id="contentDiv">
                 <div id="imageDiv">
                     <img id="image" src="../images/client4.jpg">
                 </div>
                 <div id="infoDiv">

                     <div id="inputDiv">
                          <label id="newClientTitle" type="label">New Client</label>
                           <input id="nameInput" class="inputs" type="text" placeholder="Name" name="name">
                           <input id="descInput" class="inputs" type="text" placeholder="Description" name="description">
                           <select id="typeInput" name="type" class="inputs" style="width:100%; cursor:pointer;">
                                 <option name="type" value="">Type</option>
                                 <option name="type" value="Banking">Banking</option>
                                 <option name="type" value="Education">Education</option>
                                 <option name="type" value="Healthcare">Healthcare</option>
                                 <option name="type" value="Hospitality">Hospitality</option>
                                 <option name="type" value="Manufacturing">Manufactoring</option>
                                 <option name="type" value="Hospitality">Hospitality</option>
                                 <option name="type" value="Legal">Legal</option>
                           </select>
                           <button id="addButton" type="submit" name="addClient">Add Client</button>
                     </div>

                 </div>
            </div>

       </div>
       </form>

       <script src="../js_folder/newClient.js"></script>

</body>
</html>
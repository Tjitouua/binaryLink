<?php

    include('../db_folder/connection.php');
    
    $clientId = $_GET['data'];     //Getting the clientId from the clients page

    $sql = "SELECT * FROM clients where id = '$clientId';";
    $result = mysqli_query($conn, $sql);


    // This is for updating the client
    if(isset($_POST['deleteClient'])) {
        $clientId = $_POST['clientId'];

        $sql2 = "DELETE FROM clients WHERE id = '$clientId';";
        mysqli_query($conn, $sql2);

        header("Location: clients.php");
        die;
    }


     // This is for deleting the client
    if(isset($_POST["updateClient"])) {
        $clientId = $_POST['clientId'];
        $name = $_POST['name'];
        $desc = $_POST['desc'];
        $type = $_POST['type'];

        if(empty($name) || empty($desc) || empty($type)) {
            echo "
                <script>
                     alert('Please enter everything!');
                </script>
            ";
        } else {
            $sql=$conn->prepare("UPDATE clients SET name = ?, description = ?, type = ? WHERE id = ?;");
            $sql->bind_param("sssi", $name, $desc, $type, $clientId);
            $sql->execute();


 
            $sql->close();
        }


    }



    $sql3 = "SELECT * FROM connections WHERE client_id = $clientId ORDER BY contact_name ASC;";
    $result3 = mysqli_query($conn, $sql3);


    $sql2 = "SELECT * FROM contacts WHERE id NOT IN (SELECT contact_id FROM connections WHERE client_id = $clientId) ORDER BY name ASC;";
    $result2 = mysqli_query($conn, $sql2);



    // Linking the client to different contacts
    if(isset($_POST["linkContactToClient"])) {
        $clientId = $_GET['data'];
        $clientName = $_GET['data2'];
        $clientCode = $_GET['data4'];
        $clientType = $_GET['data5']; 

        $contactId = $_POST['contactId'];
        $contactName = $_POST['contactName'];
        $contactEmail = $_POST['contactEmail'];
        $contactType = $_POST['contactType'];

        // $linkedContacts = $_GET['data3'];
        // $linked = "SELECT * FROM connections WHERE id = '$clientId';";


        $sql = $conn->prepare("INSERT INTO connections (client_id, client_name, client_code, client_type, contact_id, contact_name, contact_email, contact_type) value(?, ?, ?, ?, ?, ?, ?, ?);");
        $sql->bind_param("isssisss", $clientId, $clientName, $clientCode, $clientType, $contactId, $contactName, $contactEmail, $contactType);
        $sql->execute();
        $sql->close();


        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM connections WHERE client_id = $clientId");
        $row = mysqli_fetch_assoc($result);
        $linked = $row['total'];

        $sql2 = $conn->prepare("UPDATE clients SET no_linked_contacts = ? WHERE id = ?;");
        $sql2->bind_param("ii", $linked, $clientId);
        $sql2->execute();
        $sql2->close();

        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM connections WHERE contact_id = $contactId");
        $row = mysqli_fetch_assoc($result);
        $linked = $row['total'];
 
        $sql2 = $conn->prepare("UPDATE contacts SET no_linked_clients = ? WHERE id = ?;");
        $sql2->bind_param("ii", $linked, $contactId);
        $sql2->execute();
        $sql2->close();
        
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();

    }





   // Ullinking the contact to different clints

    if(isset($_POST["unlinkClients"])) {
        $contactId = $_POST['contactId'];
        $clientId = $_GET['data'];
        

        $sql = "DELETE FROM connections WHERE client_id = '$clientId' AND contact_id = '$contactId';";
        mysqli_query($conn, $sql);

        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM connections WHERE client_id = $clientId");
        $row = mysqli_fetch_assoc($result);
        $linked = $row['total'];

        $sql2 = $conn->prepare("UPDATE clients SET no_linked_contacts = ? WHERE id = ?;");
        $sql2->bind_param("ii", $linked, $clientId);
        $sql2->execute();
        $sql2->close();


        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM connections WHERE contact_id = $contactId");
        $row = mysqli_fetch_assoc($result);
        $linked = $row['total'];
 
        $sql2 = $conn->prepare("UPDATE contacts SET no_linked_clients = ? WHERE id = ?;");
        $sql2->bind_param("ii", $linked, $contactId);
        $sql2->execute();
        $sql2->close();
        


        header("Location: " . $_SERVER['REQUEST_URI']);

        exit();


    }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css_folder/clientForm.css">
    <title>Client Form</title>
</head>
<body>
       <div id="mainDiv">

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

    <!-- This is the general tab, where the information of the client is displayed -->
            <div id="contentDiv">
                 <div id="imageDiv">
                     <img id="image" src="../images/client4.jpg">
                 </div>
                 <div id="infoDiv">

                 <form method="post" onsubmit="return validateInputs()">

                 <?php
                    while($row = mysqli_fetch_assoc($result)) {
                 ?>
                     <div id="inputDiv">
                            <label id="newClientTitle" type="label">Client No: <?php echo $row['id'] ?></label>

                            <div id="generalContactsDiv">
                            <div id="generalContacts">
                                <div id="general" onclick="general()"></div>
                                <div id="contacts" onclick="contacts()"></div>
                            </div>
                            <div style="margin-top:-30pz; width: 100%; display:flex; justify-content:space-around; font-size:11px;">
                                <label type="label">General</label>
                                <label type="label">Contacts</label>
                            </div>
                            </div>

                           <input type="hidden" name="clientDesc" value="<?php echo $row['description'] ?>">
                           <input class="inputs" type="text" placeholder="Name" value="<?php echo $row['name']?>" name="name" id="nameInput">
                           <input class="inputs" type="text" placeholder="Client Code" value="<?php echo $row['client_code']?>" disabled>
                           <input class="inputs" type="text" placeholder="Description" value="<?php echo $row['description'] ?>" name="desc" id="descInput">
                           <input type="hidden" name="clientId" value="<?php echo $row['id']?>">
                           <select name="type" class="inputs" style="width:100%; cursor:pointer;" value="<?php echo $row['type']?>" id="typeInput">
                                 <option name="type" value="<?php echo $row['type']?>"><?php echo $row['type']?></option>
                                 <option name="type" value="Banking">Banking</option>
                                 <option name="type" value="Education">Education</option>
                                 <option name="type" value="Healthcare">Healthcare</option>
                                 <option name="type" value="Hospitality">Hospitality</option>
                                 <option name="type" value="Manufactoring">Manufactoring</option>
                                 <option name="type" value="Legal">Legal</option>
                           </select>
                           <div id="ButtonsDiv">
                           <button class="Buttons" type="submit" name="updateClient">Update client</button>
                           <button class="Buttons" type="submit" name="deleteClient">Delete client</button>
                           </div>
                     </div>
                    </form>
                     <?php
                       }
                     ?>


        <!-- This is the linked contacts div, this is where contacts that are linked to the client are display -->
                     <div id="contactsDiv">

                        <label type="label" style="font-size: 27px; font-weight:bold; font-family: Arial, sans-serif;">Linked Contacts</label>

                        <div id="generalContactsDiv" style="width:80%;">
                            <div id="generalContacts">
                                <div id="generalLinked" onclick="general()"></div>
                                <div id="contactsLinked" onclick="contacts()"></div>
                            </div>
                            <div style="margin-top:-30pz; width: 100%; display:flex; justify-content:space-around; font-size:11px;">
                                <label type="label">General</label>
                                <label type="label">Contacts</label>
                            </div>
                            </div>

                        <div id="searchDiv">
                           <input id="search" type="text" placeholder="Search for contact">
                           <button id="searchButt" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>

                        <?php if(mysqli_num_rows($result3) > 0): ?>
                        <div id="tableDiv">

                            <table>
                                <thead>
                                    <tr>
                                        <th class="left-align">Name</h>
                                        <th class="left-align">Email</h>
                                        <th class="center-align"></h>
                                    </tr>
                                </thead>

                                <tbody>

                                   <?php
                                   $i = 0;
                                     while($row = mysqli_fetch_assoc($result3)) {
                                        $color = ($i % 2 == 0) ? 'background-color:#FFFFFF;' : 'background-color:#E5E4E2;';
                                        $formId = 'form_' . $row['id'];
                                   ?>
                                 <form method="post">
                                  <input name="contactId" type="hidden" value="<?php echo $row['contact_id']?>">
                                     <tr style="<?php echo $color ?>;">
                                          <td class="left-align"><?php echo $row['contact_name']?></td>
                                          <td class="left-align"><?php echo $row['contact_email']?></td>
                                          <td class="left-align"><button type="submit" id="unlink" name="unlinkClients"><i class="fa-solid fa-trash"></i></button></td>
                                     </tr>
                                 </form>
                                   <?php
                                      $i++;
                                     }
                                    ?>



                                </tbody>

                            </table>

                        </div>
                        <?php else: ?>
                           <div id="noContactsDiv">No contact(s) found</div>
                        <?php endif; ?>

                        <div style="width:80%; display:flex; justify-content:end;"><button id="unlinkedContactsButton" onclick="showUnlinkedContacts()"><i class="fa-solid fa-hand-point-right" title="Unlinked Contacts"></i></button></div>

                     </div>



             <!-- This is the linked contacts div, this is where contacts that are linked to the client are display -->

                     <div id="contactsDiv2">

                        <label type="label" style="font-size: 27px; font-weight:bold; font-family: Arial, sans-serif;">Unlinked Contacts</label>

                        <div id="generalContactsDiv" style="width:80%;">
                            <div id="generalContacts">
                                <div id="generalLinked" onclick="general()"></div>
                                <div id="contactsLinked" onclick="contacts()"></div>
                            </div>
                            <div style="margin-top:-30pz; width: 100%; display:flex; justify-content:space-around; font-size:11px;">
                                <label type="label">General</label>
                                <label type="label">Contacts</label>
                            </div>
                            </div>

                        <div id="searchDiv">
                           <input id="search" type="text" placeholder="Search for contact">
                           <button id="searchButt" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>


                        <?php if(mysqli_num_rows($result2) > 0):  ?>
                        <div id="tableDiv">

                            <table>
                                <thead>
                                    <tr>
                                        <th class="left-align">Name</h>
                                        <th class="left-align">Email</h>
                                        <th class="center-align"></h>
                                    </tr>
                                </thead>

                                <tbody>



                                  <?php
                                  $i = 0;
                                     while($row = mysqli_fetch_assoc($result2)) {
                                        $color = ($i % 2 == 0) ? 'background-color:#FFFFFF;' : 'background-color:#E5E4E2;';
                                        $formId = 'form_' . $row['id'];
                                  ?>
                                  <form method="post">
                                  <input name="contactId" type="hidden" value="<?php echo $row['id']?>">
                                  <input name="contactName" type="hidden" value="<?php echo $row['name']?>">
                                  <input name="contactEmail" type="hidden" value="<?php echo $row['email']?>">
                                  <input name="contactType" type="hidden" value="<?php echo $row['type']?>">
                                     <tr style="<?php echo $color ?>;">
                                          <td class="left-align"><?php echo $row['name']?></td>
                                          <td class="left-align"><?php echo $row['email']?></td>
                                          <td class="center-align"><button name="linkContactToClient" id="link" type="submit"><i class="fa-solid fa-link"></i></button></td>
                                     </tr>
                                  </form>
                                   <?php
                                      $i++;
                                     }
                                   ?>

                                </tbody>

                            </table>

                        </div>

                        <?php else: ?>
                            <div>No contact(s) found</div>
                        <?php endif; ?>

                        <div style="width:80%; display:flex; justify-content:start;"><button id="unlinkedContactsButton" title="Linked Contacts" onclick="showLinkedContacts()"><i class="fa-solid fa-hand-point-left"></i></button></div>

                     </div>





                 </div>
            </div>

       </div>



   
       <script src="../js_folder/clientForm.js"></script>
</body>
</html>
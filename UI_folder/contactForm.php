<?php

include('../db_folder/connection.php');

   $contactId = $_GET['data'];     //Getting the clientId from the contacts page

   $sql = "SELECT * FROM contacts WHERE id = '$contactId';";
   $result = mysqli_query($conn, $sql);


   // This is for updating the contact

   if(isset($_POST["updateContact"])) {
        $clientId = $_POST['clientId'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $type = $_POST['type'];

        if(empty($name) || empty($surname) || empty($email) || empty($type)) {
             echo "
                <script>
                     alert('Please enter everything!');
                </script>
             ";
        } else {

        $sql=$conn->prepare("UPDATE contacts SET name = ?, surname = ?, email = ?, type = ? WHERE id = ?;");
        $sql->bind_param("ssssi", $name, $surname, $email, $type, $clientId);
        $sql->execute();
        echo "
            <script>
                alert('Contact updated successfully!');
                window.location.href = 'contacts.php';
            </script>
        ";
        $sql->close();
        }
   }


   // This is for deleting the contact

   if(isset($_POST["deleteContact"])) {
       $clientId = $_POST['clientId'];

       $sql = "DELETE FROM contacts WHERE id = '$clientId';";
       mysqli_query($conn, $sql);

       header("Location: contacts.php");
       die;
   }




   $sql3 = "SELECT * FROM connections WHERE contact_id = $contactId ORDER BY client_name ASC;";
   $result3 = mysqli_query($conn, $sql3);


   $sql2 = "SELECT * FROM clients WHERE id NOT IN (SELECT client_id FROM connections WHERE contact_id = $contactId) ORDER BY name ASC;";
   $result2 = mysqli_query($conn, $sql2);




   //Linking the contact to different clints

   if(isset($_POST["linkContactToClients"])) {

     $contactId = $_GET['data'];
     $contactName = $_GET['data2'];
     $contactEmail = $_GET['data3'];
     $contactType = $_GET['data4'];

       $clientId = $_POST['id'];
       $clientName = $_POST['name'];
       $clientCode = $_POST['code'];
       $clientType = $_POST['type'];

       $sql = $conn->prepare('INSERT INTO connections (client_id, client_name, client_code, client_type, contact_id, contact_name, contact_email, contact_type) values (?, ?, ?, ?, ?, ?, ?, ?);');
       $sql->bind_param("isssisss", $clientId, $clientName, $clientCode, $clientType, $contactId, $contactName, $contactEmail, $contactType);
       $sql->execute();
       $sql->close();

       $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM connections WHERE contact_id = $contactId");
       $row = mysqli_fetch_assoc($result);
       $linked = $row['total'];

       $sql2 = $conn->prepare("UPDATE contacts SET no_linked_clients = ? WHERE id = ?;");
       $sql2->bind_param("ii", $linked, $contactId);
       $sql2->execute();
       $sql2->close();

       $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM connections WHERE client_id = $clientId");
       $row = mysqli_fetch_assoc($result);
       $linked = $row['total'];

       $sql2 = $conn->prepare("UPDATE clients SET no_linked_contacts = ? WHERE id = ?;");
       $sql2->bind_param("ii", $linked, $clientId);
       $sql2->execute();
       $sql2->close();
       

       header("Location: " . $_SERVER['REQUEST_URI']);
       exit();

   }


  // Unlinking the contact from a specific clicnt
   if(isset($_POST["unlinkContact"])) {
        $clientId = $_POST['clientId'];
        $contactId = $_GET['data'];

        $sql = $conn->prepare("DELETE FROM connections WHERE client_id = ? AND contact_id = ?;");
        $sql->bind_param("ii", $clientId, $contactId);
        $sql->execute();
        $sql->close();



        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM connections WHERE contact_id = $contactId");
        $row = mysqli_fetch_assoc($result);
        $linked = $row['total'];
 
        $sql2 = $conn->prepare("UPDATE contacts SET no_linked_clients = ? WHERE id = ?;");
        $sql2->bind_param("ii", $linked, $contactId);
        $sql2->execute();
        $sql2->close();
 
 
        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM connections WHERE client_id = $clientId");
        $row = mysqli_fetch_assoc($result);
        $linked = $row['total'];
 
        $sql2 = $conn->prepare("UPDATE clients SET no_linked_contacts = ? WHERE id = ?;");
        $sql2->bind_param("ii", $linked, $clientId);
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
    crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="../css_folder/contactForm.css">
    <title>Contact Form</title>

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

            <div id="contentDiv">
                 <div id="imageDiv">
                     <img id="image" src="../images/client4.jpg">
                 </div>

        <!-- This is the general tab, where the information of the contact is displayed -->
                 <div id="infoDiv">
                    <?php
                       while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <form method="POST" onsubmit="return validateInputs()">
                     <div id="inputDiv">
                            <label id="newClientTitle" type="label">Contact No:<?php echo $row['id']?></label>

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
                           <input type="hidden" value="<?php echo $row['id']?>" name="clientId">
                           <input class="inputs" type="text" placeholder="Name" value="<?php echo $row['name']?>" name="name" id="inputName">
                           <input class="inputs" type="text" placeholder="Surname" value="<?php echo $row['surname']?>" name="surname" id="inputSurname">
                           <input class="inputs" type="text" placeholder="E-mail address" value="<?php echo $row['email']?>" name="email" id="inputEmail">
                           <select name="type" class="inputs" style="width:100%; cursor: pointer;" value="<?php echo $row['type']?>" name="type" id="inputType">
                                <option name="type" value="<?php echo $row['type']?>"><?php echo $row['type']?></option>
                                <option name="type" value="Customer">Customer</option>
                                <option name="type" value="Executive">Executive</option>
                                <option name="type" value="Manager">Manager</option>
                                <option name="type" value="Technical">Technical</option>
                                <option name="type" value="Finance">Finance</option>
                                <option name="type" value="Sales">Sales</option>
                                <option name="type" value="Support">Support</option>
                                <option name="type" value="Marketing">Marketing</option>
                                <option name="type" value="Procurement">Procurement</option>
                                <option name="type" value="Human Resources">Numan Resources</option>
                                <option name="type" value="Consultant">Consultant</option>
                           </select>
                           <div id="ButtonsDiv">
                           <button class="Buttons" type="submit" name="updateContact">Update contact</button>
                           <button class="Buttons" type="submit" name="deleteContact">Delete contact</button>
                           </div>
                     </div>
                    </form>
                     <?php
                       }
                     ?>


            <!-- This is the linked clients div, this is where clients that are linked to the contact are display -->
                     <div id="contactsDiv">

                        <label type="label" style="font-size: 27px; font-weight:bold; font-family: Arial, sans-serif;">Linked Clients</label>

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
                           <input id="search" type="text" placeholder="Search for client">
                           <button id="searchButt" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>

                        <?php if(mysqli_num_rows($result3) > 0): ?>
                        <div id="tableDiv">

                            <table>
                                <thead>
                                    <tr>
                                        <th class="left-align">Name</h>
                                        <th class="left-align">Code</h>
                                        <th class="left-align">Type</h>
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
                                 <input type="hidden" value="<?php echo $row['client_id']?>" name="clientId">
                                     <tr style="<?php echo $color?>">
                                          <td class="left-align"><?php echo $row['client_name']?></td>
                                          <td class="left-align"><?php echo $row['client_code']?></td>
                                          <td class="left-align"><?php echo $row['client_type']?></td>
                                          <td class="center-align"><button id="unlink" name="unlinkContact"><i class="fa-solid fa-trash"></i></button></td>
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
                           <div>No client(s) found</div>
                        <?php endif; ?>

                        <div style="width:80%; display:flex; justify-content:end;"><button id="unlinkedContactsButton" onclick="showUnlinkedContacts()"><i class="fa-solid fa-hand-point-right" title="Unlinked Contacts"></i></button></div>

                     </div>



                <!-- This is the Unlinked clients div, this is where clients that are not linked to the contact are display -->
                     
                     <div id="contactsDiv2">

                        <label type="label" style="font-size: 27px; font-weight:bold; font-family: Arial, sans-serif;">Unlinked Clients</label>

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
                           <input id="search" type="text" placeholder="Search for client">
                           <button id="searchButt" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>

                        <?php if(mysqli_num_rows($result2) > 0): ?>
                        <div id="tableDiv">

                            <table>
                                <thead>
                                    <tr>
                                        <th class="left-align">Name</h>
                                        <th class="left-align">Code</h>
                                        <th class="left-align">Type</h>
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
                                   <form method="post" id="<?php echo $formId;?>">
                                         <input type="hidden" name="id" value="<?php echo $row['id']?>">
                                         <input type="hidden" name="name" value="<?php echo $row['name']?>">
                                         <input type="hidden" name="code" value="<?php echo $row['client_code']?>">
                                         <input type="hidden" name="type" value="<?php echo $row['type']?>">
                                     <tr style="<?php echo $color?>">
                                          <td class="left-align"><?php echo $row['name']?></td>
                                          <td class="left-align"><?php echo $row['client_code'] ?></td>
                                          <td class="left-align"><?php echo $row['type']?></td>
                                          <td class="center-align"><button id="link" name="linkContactToClients" type="submit"><i class="fa-solid fa-link"></i></button></td>
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

                        <div style="width:80%; display:flex; justify-content:start;"><button id="unlinkedContactsButton" title="Linked Contacts" onclick="showLinkedContacts()"><i class="fa-solid fa-hand-point-left"></i></button></div>

                     </div>





                 </div>
            </div>

       </div>

       <script src="../js_folder/contactForm.js"></script>

</body>
</html>













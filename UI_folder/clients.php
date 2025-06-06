<?php

include('../db_folder/connection.php');

   $sql = "SELECT * FROM clients ORDER BY name ASC;";


   if (isset($_POST['searchClient'])) {
    $input = $_POST['inputSearched'];
    $sql = "SELECT * FROM clients WHERE name LIKE '%$input%' OR client_code LIKE '%$input%' ORDER BY name ASC;";
    $result = mysqli_query($conn, $sql);
   } else {
    $result = mysqli_query($conn, $sql);
   }



   $result = mysqli_query($conn, $sql);


   if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clientId'])) {
      $clientId = $_POST['clientId'];
      $clientName = $_POST['clientName'];
      $linkedContacts = $_POST['linkedContacts'];
      $clientCode = $_POST['clientCode'];
      $clientType = $_POST['clientType'];


      header("Location: clientForm.php?data=$clientId&data2=$clientName&data3=$linkedContacts&data4=$clientCode&data5=$clientType");
      die;
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
    <link rel="stylesheet" href="../css_folder/clients.css">
    <title>Clients</title>
     <script>
        function newClient() {
            window.location.href = 'newClient.php';
        }
        function viewClientDetails() {
            window.location.href = 'clientForm.php';
        }

        function submitForm(formId) {
               document.getElementById(formId).submit();
        }


        const navEntries = performance.getEntriesByType("navigation");
       if (navEntries.length > 0 && navEntries[0].type === "reload") {
           window.location.href = "clients.php"; 
       }
     </script>

</head>
<body>
       <div id="mainDiv">

            <header id="head">
                <div id="logoDiv">
                    <img id="logo" src="../images/binary_logo.png">
                </div>
                 <nav id="nav">
                        <a class="aTags" href="index.php">Home</a>
                        <a class="aTags" href="#">Clients</a>
                        <a class="aTags" href="contacts.php">Contacts</a>
                 </nav>
            </header>

            <div id="contentDiv">
                 <div id="imageDiv">
                     <img id="image" src="../images/client4.jpg">
                 </div>
                 <div id="infoDiv">
                    <div id="addClientDiv">
                     <label type="label">Clients</label>
                     <button id="addClientButt" type="button" onclick="newClient()">Add New Client</button>
                    </div>

                    <form method="POST">
                    <div id="searchDiv">
                    <input id="search" type="text" placeholder="Search for client" name="inputSearched">
                    <button id="searchButt" type="submit" name="searchClient"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    </form>


                    

                    <?php if(mysqli_num_rows($result) > 0): ?>

                    <div id="tableDiv">
                          <table>
                            <thead>
                                <tr>
                                    <th class="left-align">Name</th>
                                    <th class="left-align">Client Code</th>
                                    <th class="center-align">No. of Linked Contacts</th>
                                </tr>
                            </thead>

                            <tbody>
                                
                            <?php
                            $i = 0;
                               while($row = mysqli_fetch_assoc($result)) {
                                   $color = ($i % 2 == 0) ? 'background-color:#FFFFFF;' : 'background-color:#E5E4E2;';
                                   $formId = 'form_' . $row['id'];
                             ?>
                             <form method="post" id="<?php echo $formId; ?>">
                             <input name="clientId" type="hidden" value="<?php echo $row['id']?>">
                             <input type="hidden" name="clientName" value="<?php echo $row['name']?>">
                             <input type="hidden" name="clientCode" value="<?php echo $row['client_code']?>">
                             <input type="hidden" name="clientType" value="<?php echo $row['type']?>">
                             <input type="hidden" name="linkedContacts" value="<?php echo $row['no_linked_contacts']?>">
                                <tr id="client" style="<?php echo $color ?>;" onclick="submitForm('<?php echo $formId; ?>')">
                                   <td class="left-align"><?php echo $row['name']?></td>
                                   <td class="left-align"><?php echo $row['client_code'] ?></td>
                                   <td class="center-align"><?php echo $row['no_linked_contacts']?></td>
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
                        <div id="noClientsDiv">No client(s) found</div>
                    <?php endif; ?>

                    



                 </div>
            </div>

       </div>
</body>
</html>




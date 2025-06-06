<?php

include('../db_folder/connection.php');


   $sql = "SELECT * FROM contacts ORDER BY name ASC;";   // Getting all the contacts data from the database


//    Thhis is where you search for a specific contact

   if (isset($_POST['searchContact'])) {
        $input = $_POST['inputSearched'];
        $sql = "SELECT * FROM contacts WHERE name LIKE '%$input%' OR surname LIKE '%$input%' OR email LIKE '%$input%' ORDER BY name ASC;";
        $result = mysqli_query($conn, $sql);
   } else {
    $result = mysqli_query($conn, $sql);
   }

    
   $result = mysqli_query($conn, $sql);


//    Carrying data from  contacts page to contactForm page

   if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contactId'])) {
      $contactId = $_POST['contactId'];
      $contactName = $_POST['name'];
      $contactEmail = $_POST['email'];
      $contactType = $_POST['type'];

      header("Location: contactForm.php?data=$contactId&data2=$contactName&data3=$contactEmail&data4=$contactType");
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
    <link rel="stylesheet" href="../css_folder/contacts.css">
    <title>Contacts</title>

    <script>
        function newContact() {
            window.location.href = "newContact.php";
        }
        function goToContactForm() {
            window.location.href = "contactForm.php";
        }

        function submitForm(formId) {
              document.getElementById(formId).submit();
        }

        const navEntries = performance.getEntriesByType("navigation");
    if (navEntries.length > 0 && navEntries[0].type === "reload") {
        window.location.href = "contacts.php"; 
    }

    </script>

</head>
<body>
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

      <!-- We have the contentDiv, where all the information and images are  -->

            <div id="contentDiv">
                 <div id="imageDiv">
                     <img id="image" src="../images/client4.jpg">
                 </div>
                 <div id="infoDiv">
                    <div id="addClientDiv">
                     <label type="label">Contacts</label>
                     <button id="addClientButt" type="button" onclick="newContact()">Add New Contact</button>
                    </div>

                    <form method="POST">
                    <div id="searchDiv">
                    <input id="search" type="text" placeholder="Search for client" name="inputSearched">
                    <button id="searchButt" type="submit" name="searchContact"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    </form>

             <!-- This is the tableDiv, where the contacts are displayed -->
                  <?php if(mysqli_num_rows($result) > 0): ?>
                    <div id="tableDiv">
                          <table>
                            <thead>
                                <tr>
                                    <th class="left-align">Name</th>
                                    <th class="left-align">Surname</th>
                                    <th class="left-align">Email address</th>
                                    <th class="center-align">No. of Linked Clients</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                  $i = 0;
                                  while($row = mysqli_fetch_assoc($result)) {
                                    $color = ($i % 2 == 0) ? 'background-color:#FFFFFF;' : 'background-color:#E5E4E2;';
                                    $formId = 'form_' . $row['id'];
                                ?>
                                <form method="post" id="<?php echo $formId;?>">
                                <input type="hidden" value="<?php echo $row['id']?>" name="contactId">
                                <input type="hidden" value="<?php echo $row['name']?>" name="name">
                                <input type="hidden" value="<?php echo $row['email']?>" name="email">
                                <input type="hidden" value="<?php echo $row['type']?>" name="type">
                                <tr id="contactForm" style="<?php echo $color?>" onclick="submitForm('<?php echo $formId?>')">
                                   <td class="left-align"><?php echo $row['name']?></td>
                                   <td class="left-align"><?php echo $row['surname']?></td>
                                   <td class="left-align"><?php echo $row['email']?></td>
                                   <td class="center-align"><?php echo $row['no_linked_clients'] ?></td>
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


                 </div>
            </div>

       </div>
</body>
</html>
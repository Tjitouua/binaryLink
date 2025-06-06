<?php

    include('../db_folder/connection.php');

    // Adding client to the database table

     if(isset($_POST["addContact"])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $type = $_POST['type'];
        $noLinkedClients = 0;

        $confirmSQL = "SELECT * FROM contacts WHERE email = '$email';";
        $result = mysqli_query($conn, $confirmSQL);

      if(empty($name) || empty($surname) || empty($email) || empty($type)) {
         echo "
             <script>
                  alert('Please enter everything!');
             </script>
         ";
      } elseif($result && mysqli_num_rows($result) > 0) {
                  
            echo "
            <script>
                alert('Contact with this email address already exists!!');
                window.history.back();
            </script>
            die;
         ";
      } else {
         $stmt = $conn->prepare("INSERT INTO contacts (name, surname, email, type, no_linked_clients) VALUES (?, ?, ?, ?, ?);");
         $stmt->bind_param("ssssi", $name, $surname, $email, $type, $noLinkedClients);
         $stmt->execute();
         echo "
            <script>
                alert('Contact successfully added!');
                window.location.href = 'contacts.php';
            </script>
         ";
         $stmt->close();
      }
     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css_folder/newContact.css">
    <title>New Contact</title>

</head>
<body>
    <form method="post" onsubmit="return validateInputs()">
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
                          <label id="newContactTitle" type="label">New Contact</label>
                           <input id="inputName" class="inputs" type="text" placeholder="Name" name="name">
                           <input id="inputSurname" class="inputs" type="text" placeholder="Surname" name="surname">
                           <input id="inputEmail" class="inputs" type="text" placeholder="E-mail" name="email">
                           <select id="inputType" name="type" class="inputs" style="width:100%; cursor: pointer;">
                                <option name="type" value="">Type</option>
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
                           <button id="addButton" type="submit" name="addContact">Add Contact</button>
                     </div>
                 </div>
            </div>

       </div>
    </form>

    <script src="../js_folder/newContact.js"></script>

</body>
</html>
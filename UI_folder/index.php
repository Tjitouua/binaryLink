<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css_folder/index.css">
    <script>
        function clients() {
            window.location.href = "clients.php";
        }
        function contacts() {
            window.location.href = "contacts.php";
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
                        <a class="aTags" href="#">Home</a>
                        <a class="aTags" href="clients.php">Clients</a>
                        <a class="aTags" href="contacts.php">Contacts</a>
                 </nav>
            </header>

            <div id="contentDiv">
                 <div id="imageDiv">
                     <img id="image" src="../images/client4.jpg">
                 </div>
                 <div id="infoDiv">
                     <label type="label">Welcome to</label>
                   <label id="binaryLink" type="label">Binary<spam style="color:#E3735E;">Link</spam></label>
                   <label type="label">BinaryLink makes it super easy to keep track of your clients and contacts.
                     You can link them, manage them, and see everything in one clean place. No stress, no mess — just
                      a simple tool to help you stay organized and in control of your business connections.</label>

                    <div id="buttonsDiv">
                          <button class="button" type="button" onclick="clients()">Clients</button>
                          <button class="button" type="button" onclick="contacts()">Contacts</button>
                    </div>
                 </div>
            </div>

       </div>
</body>
</html>
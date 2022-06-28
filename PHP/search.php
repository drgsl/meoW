<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;1,200&display=swap" rel="stylesheet">
    <title>MeoW</title>
    <link href="../CSS/search.css" rel="stylesheet">
    <link href="../CSS/popup.css" rel="stylesheet">
</head>

<body>
    <div class="div-body">
        <div id="nav-background">
            <div id="nav-container">
                <header id="nav-header">
                    <h1><a class="nav-logo-function" href="../PHP/index.php#home" id="nav-logo">

                            MeoW
                        </a></h1>
                    <img src="https://i.imgur.com/xcFvxAK.png" class="hamburger-img" id="nav-menu-button">
                </header>
                <nav>
                    <ul id="navv" class="nav-ul hide-ul">
                        <li><a class="nav-link" href="../PHP/index.php#about">About Us</a></li>
                        <li><a class="nav-link" href="../PHP/index.php#contact">Contact</a></li>
                        <li><a class="nav-link" href="../PHP/search.php">Animals</a></li>
                        <li><a class="nav-link" href="../HTML/login.html">Login</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="page">
            <div class="left">
                <div class="title"> Filter </div>
                <form action="" method="post">
                    <div class="subtitle"> <b class="susbtitle1"> Region: </b> <br></div>
                    <select name="Region">
                        <option value="">All</option>
                        <?php
                        $db = mysqli_connect('localhost', 'root', '', 'tw');
                        $query = "SELECT DISTINCT region FROM animals ";
                        $result = $db->query($query);
                        $row = $result->fetch_assoc();
                        while ($row) {
                            echo "<option value=" . $row['region'] . ">" . $row['region'] . "</option>";
                            $row = $result->fetch_assoc();
                        }
                        ?>
                    </select>


                    <div class="subtitle"> <b class="susbtitle1"> Habitat: </b><br></div>
                    <select name="Habitat">
                        <option value="">All</option>
                        <?php
                        $db = mysqli_connect('localhost', 'root', '', 'tw');
                        $query = "SELECT DISTINCT habitat FROM animals ";
                        $result = $db->query($query);
                        $row = $result->fetch_assoc();
                        while ($row) {
                            echo "<option value=" . $row['habitat'] . ">" . $row['habitat'] . "</option>";
                            $row = $result->fetch_assoc();
                        }
                        ?>
                    </select>


                    <div class="subtitle"> <b class="susbtitle1"> Type: </b><br></div>
                    <select name="Type">
                        <option value="">All</option>
                        <?php
                        $db = mysqli_connect('localhost', 'root', '', 'tw');
                        $query = "SELECT DISTINCT tip FROM animals ";
                        $result = $db->query($query);
                        $row = $result->fetch_assoc();
                        while ($row) {
                            echo "<option value=" . $row['tip'] . ">" . $row['tip'] . "</option>";
                            $row = $result->fetch_assoc();
                        }
                        ?>
                    </select>


                    <div class="subtitle"> <b class="susbtitle1"> Conservation: </b><br></div>
                    <select name="Conservation">
                        <option value="">All</option>
                        <?php
                        $db = mysqli_connect('localhost', 'root', '', 'tw');
                        $query = "SELECT DISTINCT conservation FROM animals ";
                        $result = $db->query($query);
                        $row = $result->fetch_assoc();
                        while ($row) {
                            echo "<option value=" . $row['conservation'] . ">" . $row['conservation'] . "</option>";
                            $row = $result->fetch_assoc();
                        }
                        ?>
                    </select>


                    <input class="submitFilter" type="submit" name="submit" value="Filter">
                </form>

                <?php
                
                if (isset($_COOKIE['user'])) 
                {
                    $username = $_COOKIE['user'];
                    $db = mysqli_connect('localhost', 'root', '', 'tw');
                    $query = "SELECT admin FROM accounts WHERE email='$username' ";
                    $result = $db->query($query);
                    $row = $result->fetch_assoc();
                    
                    if ($row['admin'] == 1)
                    echo 
                    '<br><br><div class="import">
                        <h2>Import:</h2>
                        <form action="import.php" method="get"
                            enctype="multipart/form-data">
                            <input class = "file" type="file" id="myfile" accept=".xml, .json" name="myfile"/>
                            <br/><br/>                
                            <input class="button" type="submit"/>
                        </form>
                    </div>';
                }
                ?>

            </div>
            <div class="right">
                <div class="search-section">
                <form action="" method="post">
                    <input type="text" name="searchbar" id="searchbar" class="search-input" placeholder="search by name">
                    <input class="submitName" type="submit" name="submitName" value="All animals">
            </form>
                </div>

                <?php
                $db = mysqli_connect('localhost', 'root', '', 'tw');
                $query = "SELECT * FROM animals";
                $result = $db->query($query);
                $row = $result->fetch_assoc();

                echo 
                
                "<div id = 'popup' class ='hide' onclick='showOverlay()'>" .
                "<p id = 'popup-name'> Animal Name</p>" .
                "<p id = 'popup-description'> Animal description</p>" .

            "<div class = 'button'>" .
            "<a href ='exportJSON.php?name=" . $row["name"] . "' target = '_self' >" . "Export JSON" . "</a>" .
            "</div>" .  
            "<div class = 'button'>" .
            "<a href ='exportXML.php?name=" . $row["name"] . "' >" . "Export XML" . "</a>" .
            "</div>" .
            "</div>"
            ?>

                <script src="../JS/popup.js"></script>

                <?php
                echo "<style>";
                include '../CSS/animals.css';
                echo "</style>";

                $db = mysqli_connect('localhost', 'root', '', 'tw');
                $ok = 0;
                $region = "";
                $habitat = "";
                $type = "";
                $conservation = "";
                if(isset($_POST['submitName'])){
                    if(!empty($_POST['searchbar']))
                        $query = "SELECT name, image FROM animals WHERE name LIKE '%" . $_POST['searchbar'] . "%' ORDER BY name";
                    else $query = "SELECT name, image FROM animals ORDER BY name";
                }
                else{
                if (isset($_POST['submit'])) {
                    if (!empty($_POST['Region'])) {
                        $region = "WHERE region='" . $_POST['Region'] . "' ";
                        $ok = 1;
                    }

                    if (!empty($_POST['Habitat'])) {
                        if ($ok == 1)
                            $habitat = "AND habitat='" . $_POST['Habitat'] . "' ";
                        else {
                            $habitat = "WHERE habitat='" . $_POST['Habitat'] . "' ";
                            $ok = 1;
                        }
                    }

                    if (!empty($_POST['Type'])) {
                        if ($ok == 1)
                            $type = "AND tip='" . $_POST['Type'] . "' ";
                        else {
                            $type = "WHERE tip='" . $_POST['Type'] . "' ";
                            $ok = 1;
                        }
                    }

                    if (!empty($_POST['Conservation'])) {
                        if ($ok == 1)
                            $conservation = "AND conservation='" . $_POST['Conservation'] . "' ";
                        else {
                            $conservation = "WHERE conservation='" . $_POST['Conservation'] . "' ";
                            $ok = 1;
                        }
                    }
                }
                $query = "SELECT name, image,description FROM animals " . $region . $habitat . $type . $conservation . "ORDER BY name";
                }
                //echo $query;
                $result = $db->query($query);
                $row = $result->fetch_assoc();
                $nr = 0;
                echo "<div class='animal-section'>";

                while ($row) {
                    $nr++;

                    if ($nr % 3 == 1)
                    echo "<div class='row' id='animalSection'>";
                        echo
                        "<div class='animal-container' onclick='showOverlay(\"" . $row["name"] . "\",\"" . $row["description"] . "\")' >" .
<<<<<<< Updated upstream
                            
=======
>>>>>>> Stashed changes
                            "<a>" . "<img src=" . $row['image'] . "<' class = 'animal-img'>" .
                            "</a>" .

                        "<div class = 'name' >" . $row["name"] . "<br>" . "</div>" .

                        "</div>";


                    $row = $result->fetch_assoc();
                    if ($nr % 3 == 0 || !$row)
                        echo "</div>";
                }

                ?>
            </div>
        </div>
    </div>

    <footer class="footer-reference">
        <br>
        <p>Authors: Bobu Dragos & Breahna Teodora & Zaharie Robert </p>
        <br>
        <p> <a href="doc.html"> Scholarly HTML Documentation </a></p>
    </footer>
    <script src="../JS/navbar.js"></script>

</body>

</html>
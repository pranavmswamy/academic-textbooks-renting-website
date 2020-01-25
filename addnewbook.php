<!-----------------------ENTERING TO DB CODE--------------------------------->       
        <?php
            $bousnErr = $pwdErr = $insertsuccess = "";
            $conn = new mysqli("localhost","root","root123","atrtcs092");

            // Check connection
            if ($conn->connect_error) 
            {
                die("Connection failed: " . $conn->connect_error);
            } 
            
            //$submit = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                //$nameErr = $emailErr = $genderErr = $websiteErr = "";
                //$name = $email = $gender = $comment = $website = "";
                //check for all values optimum range.
                //$bousnErr = "";
                
                $isbn = test_input($_POST["isbn"]);
                $name = test_input($_POST["name"]);
                $edition = test_input(intval($_POST["edition"]));
                $lang = test_input($_POST["lang"]);
                $subject = test_input($_POST["subject"]);
                $bousn = test_input($_POST["bousn"]);
                $qty = test_input(intval($_POST["qty"]));
                $price = test_input(intval($_POST["price"]));
                $password = $_POST["password"];
              
                
                $check_bousn_st = "select count(usn) from student where usn = '$bousn';";
                $check_bousn_result = $conn->query($check_bousn_st);
                if($check_bousn_result->num_rows > 0)
                    while($row = $check_bousn_result->fetch_assoc())
                        {
                            if(intval($row["count(usn)"]) == 0)
                            {
                                
                                $bousnErr = "Enter a registered USN to add books.";
                            }
                            else
                            {
                                $bousnErr = "";
                            }
                        }   
                
                $check_pwd_st = "select password from student where usn='$bousn';";
                $check_pwd_result = $conn->query($check_pwd_st);
                if($check_pwd_result->num_rows > 0)
                    while($row = $check_pwd_result->fetch_assoc())
                    {
                        if($row["password"] == $password )
                        {
                            $pwdErr = "";
                            //insert statement
                            $insert_st = "insert into books values('$isbn','$name',$edition,'$subject','$bousn',$qty,$price,'$lang');";
                            if($conn->query($insert_st) == TRUE)
                            {
                                $insertsuccess = "Submitted";
                            }
                            else
                            {
                                $insertsuccess = "Error - Could not be submitted to server.";
                            }
                        }
                        else
                        {
                            $pwdErr= "Wrong Password. Please check your USN and password."." ".$conn->error;
                        }
                    }
                
                $author_1 = test_input($_POST["author_1"]);
                $author_2 = test_input($_POST["author_2"]);
                $insert_author = "insert into author values('$isbn','$author_1','$author_2');";
                if($conn->query($insert_author) != TRUE)
                            {
                                $insertsuccess = "Error - Could not be submitted to server.";
                            }
                           
                        
                }

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
                }
        
            $conn->close();
        ?>
  <!------------------------------------------------------------------------------>      
<html lang ="en">
<link href="https://fonts.googleapis.com/css?family=Lora|Spectral+SC:500" rel="stylesheet">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
<style>
        body {
            background-color: #CACD84;
            font-family: 'Lora',sans-serif;
        }
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color:#8C8F51;
             font-size: 16px;
            }

        li {
            float: left;
            }

        li a {
                display: block;
                color:black;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                width: 496px;
            }
        li a:hover {
                    background-color:#616339;
                    }
        .active {
            background-color: #616339;
        }
        
        input[type=text], input[type=number], input[type=password], select {
                                    width: 100%;
                                    padding: 12px 20px;
                                    margin: 8px 0;
                                    display: inline-block;
                                    border: 1px solid #ccc;
                                    border-radius: 4px;
                                    box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            background-color: #8C8F51;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #616339;
        }
    .formcol {
        background-color: #E5E8A3;
        margin-top: 50px;
    }
      
    .error {
        color: red;
    }
    .btncolor {
            background-color: #8C8F51;
            font-weight: bold;
        }
    </style> 
    
<head>
<title>rentAbook!</title>
</head>    
<body>
    <!------------------------------BANNER----------------------------------------------------------------------------->
    <div class="container-fluid">
        <div id="banner" class="text-center">
        <img src="http://newhorizonindia.edu/nhengineering/wp-content/uploads/2017/06/nhce-2017-june20.png" alt="College banner" id="college_banner">
            <h1 id="heading" class="text-center"><em style="font-family: 'Spectral SC',serif">rentAbook!</em></h1> 
        </div>
        <!--nAVIGATION bAR ------------------------------------------------------------->
        <ul>
            <li><a  href="http://localhost:80/mainpage.html"><b>RENT A BOOK</b></a></li>
            <li><a class = "active" href="http://localhost:80/addnewbook.php"><b>ADD A BOOK</b></a></li>
            <li><a href="http://localhost:80/registernewstudent.php"><b>REGISTER</b></a></li>
        </ul>
        <!-------------------------------------------------------------------------------->
    </div>
    <!------------------------------FORM---------------------------------------------------------------------->
    
    <div class="row">
        <div class="col-md-3"></div>
        <div class="well col-md-6 formcol">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" placeholder="ISBN of the Book" required>
            
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Name of the Book" required>
            
            <label for="author_1">Author (Primary)</label>
            <input type="text" id="auth1" name="author_1" required>
            
            <label for="author_2">Author (Secondary)</label>
            <input type="text" id="auth2" name="author_2" placeholder="If exists...">
            
            <label for="edition">Edition</label>
            <input type="number" id="edition" name="edition" placeholder="Year of Publication" required>
            
            <label for="language">Language</label>
            <select id="subject" name="lang">
                <option value="English">English</option>
                <option value="Spanish">Spanish</option>
                <option value="Kannada">Kannada</option>
                <option value="Hindi">Hindi</option>
            </select>
            
            
            <label for="subject">Subject</label>
            <select id="subject" name="subject">
                <option value="CSE">Computer Science Engineering</option>
                <option value="BT">Biotechnology</option>
                <option value="DS">Data Science</option>
                <option value="AU">Automobile Engineering</option>
                <option value="ME">Mechanical Engineering</option>
                <option value="EC">Electronics and Communication Engineering</option>
                <option value="CV">Civil Engineering</option>
            </select>
            
            <label for="bousn">USN</label>
            <input type="text" id="bousn" name="bousn" placeholder="Enter your USN" required><br>
            <span class="error"><?php echo "$bousnErr"; ?></span><br>
            
            
            <label for="quantity">Quantity</label>
            <input type="number" id="qty" name="qty" placeholder="Number of books you have..." required>
            
            <label for="price">Price</label>
            <input type="number" id="price" name="price" placeholder="Price per Semester" required>
            
             <label for="password">Password</label>
            <input type="password" id="password" name="password" required><br>
            <span class="error"><?php echo "$pwdErr"; ?></span><br>
            
            <b><input type="submit" value="SUBMIT"></b><br>
            <span class="text-primary text-center"><?php echo "$insertsuccess"; ?></span><br>
        </form>
            <!--<span class="text-center"><?php //echo "$submit"; ?></span>
            <i class="fa fa-check"></i>-->
        </div>
        <div class="col-md-3"></div>
    </div>
    
</body>
</html>
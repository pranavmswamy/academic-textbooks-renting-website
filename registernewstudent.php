<?php
$conn = new mysqli("localhost","root","root123","atrtcs092");
$uniquesuccess = $insertsuccess =  "";
            // Check connection
            if ($conn->connect_error) 
            {
                die("Connection failed: " . $conn->connect_error);
            } 
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                $usn = test_input($_POST["usn"]);
                $name = test_input($_POST["name"]);
                $sem = test_input(intval($_POST["sem"]));
                $branch = test_input($_POST["branch"]);
                $add_house_no = test_input(intval($_POST["add_house_no"]));
                $add_street = test_input($_POST["add_street"]);
                $add_city = test_input($_POST["add_city"]);
                $phno = test_input($_POST["phno"]);
                $pwd = test_input($_POST["password"]);
                
                $check_unique_usn = "select * from student where usn = '$usn';";
                $cuu_result = $conn->query($check_unique_usn);
                if($cuu_result->num_rows > 0)
                {
                    $uniquesuccess = "Already registered, please try another USN.";
                }
                else
                {
                    $insert_std = "insert into student values('$usn','$name',$sem,'$branch',$add_house_no,'$add_street','$add_city','$phno','$pwd');";
                            if($conn->query($insert_std) == TRUE)
                            {
                                $insertsuccess = "Registered!";
                            }
                            else
                            {
                                $insertsuccess = "Error - Could not register.".$conn->error;
                            }
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

<html lang ="en">
<link href="https://fonts.googleapis.com/css?family=Lora|Spectral+SC:500" rel="stylesheet">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>
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
                text-decoration:none;
                width: 496px;
            }
        li a:hover {
                    background-color:#616339;
                    }
        .active {
            background-color: #616339;
        }
        
        input[type=text], select,input[type=password] {
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
        
    </style> 
    
<head>
<title>rentAbook!</title>
</head>    
<body>
    <!------------------------------BANNER----------------------------------------------------------------------------->
    <div class="container-fluid">
        <div id="banner" class="text-center">
        <img src="http://newhorizonindia.edu/nhengineering/wp-content/uploads/2017/06/nhce-2017-june20.png" alt="College banner" id="college_banner">
            <h1 id="heading" class="text-center"><em style="font-family:'Spectral SC',serif">rentAbook!</em></h1> 
        </div>
        <!--nAVIGATION bAR ------------------------------------------------------------->
        <ul>
            <li><a  href="http://localhost:80/mainpage.html"><b>RENT A BOOK</b></a></li>
            <li><a href="http://localhost:80/addnewbook.php"><b>ADD A BOOK</b></a></li>
            <li><a class = "active" href="http://localhost:80/registernewstudent.php"><b>REGISTER</b></a></li>
        </ul>
        <!-------------------------------------------------------------------------------->
    </div>
    <!------------------------------FORM------------------------------------------------------------------------------->
    
    <div class="row">
        <div class="col-md-3"></div>
        <div class="well col-md-6 formcol">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="usn">USN</label>
            <input type="text" id="usn" name="usn" placeholder="Enter your USN"><br>
            <span class="text-danger text-center"><?php echo "$uniquesuccess"; ?></span><br>
            
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your Name">
            
            <label for="semester">Semester</label>
            <select id="sem" name="sem">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
            
            <label for="branch">Branch</label>
            <select id="branch" name="branch">
                <option value="CSE">Computer Science Engineering</option>
                <option value="BT">Biotechnology</option>
                <option value="DS">Data Science</option>
                <option value="AU">Automobile Engineering</option>
                <option value="ME">Mechanical Engineering</option>
                <option value="EC">Electronics and Communication Engineering</option>
                <option value="CV">Civil Engineering</option>
            </select>
            
            <label for="address">Address</label>
            <input type="text" id="add_house_no" name="add_house_no" placeholder="House No.">
            <input type="text" id="add_street" name="add_street" placeholder="Street">
            <input type="text" id="add_city" name="add_city" placeholder="City">
            
            <label for="phno">Phone Number</label>
            <input type="text" id="phno" name="phno" placeholder="Enter your phone number">
            
            <label for="password">Enter New Password</label>
            <input type="password" id="pwd" name="password" placeholder="Enter your new password">
            
            <b><input type="submit" value="SUBMIT"></b><br>
            <span class="text-primary text-center"><?php echo "$insertsuccess"; ?></span><br>
        </form>
        </div>
        <div class="col-md-3"></div>
    </div>
    
</body>
</html>
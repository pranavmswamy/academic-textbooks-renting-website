<?php
     $con = mysqli_connect("localhost","root","root123","atrtcs092"); 
    $usnErr = $delisbn = $price = $bnErr = $isbn = $bonErr = $bousn = $pwdErr = $insertsuccess = $delisbn = "";
    
                            // Check connection 
                            if (!$con) 
                            { 
                                echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
                            } 

     if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                $usn = test_input($_POST["usn"]);
                $bname = test_input($_POST["bname"]);
                $boname = test_input($_POST["boname"]);
                $duedate = test_input($_POST["due_date"]);
                $pwd = test_input($_POST["password"]);
                $isbn = $bousn = $price =  "";
         
                $check_usn_st = "select * from student where usn = '$usn';";
                $check_usn_result = $con->query($check_usn_st);
                if($check_usn_result->num_rows > 0) 
                {
                    $usnErr = "";
                }
                else 
                {
                    $usnErr = "Enter a registered USN to add books. ";
                }
         
                $price_st = "select price from books where name = '$bname';";
                $price_result = $con->query($price_st);
                if($price_result->num_rows > 0) 
                {
                    while($row = $price_result->fetch_assoc())
                    {
                        $price = $row["price"];
                    }
                }
         
                $check_bn_st = "select * from books where name = '$bname';";
                $check_bn_result = $con->query($check_bn_st);
                if($check_bn_result->num_rows > 0) 
                {
                    $bnErr = "";
                     $isbn_select = "select isbn from books where name='$bname';";
                    $isbn_result = $con->query($isbn_select);
                    while($row = $isbn_result->fetch_assoc())
                    {
                        $isbn = $row["isbn"];
                    }
                    
                }
                else 
                {
                    $bnErr = "Wrong book name entered. Please check again.";
                }
                
                $check_bon_st = "select s.name from student s,books b where s.usn = b.book_owner and b.name = '$bname';";
                $check_bon_result = $con->query($check_bon_st);
                if($check_bon_result->num_rows > 0) 
                {
                    while($row = $check_bon_result->fetch_assoc())
                    {
                        if($row["name"] == $boname )
                          {  
                            $bonErr = "";
                            $bousn_select = "select book_owner from books where name='$bname';";
                            $bousn_result = $con->query($bousn_select);
                            while($row = $bousn_result->fetch_assoc())
                            {
                                $bousn = $row["book_owner"];
                            }
                        }
                        else 
                        {
                            $bonErr = "Wrong book owner name entered. Please check again.";
                        }
                    }
                }
                
                
               
                
                
                $check_pwd_st = "select password from student where usn='$usn';";
                $check_pwd_result = $con->query($check_pwd_st);
                if($check_pwd_result->num_rows > 0)
                    while($row = $check_pwd_result->fetch_assoc())
                    {
                        if($row["password"] == $pwd )
                        {
                            $pwdErr = "";
                            //insert statement
                            $insert_st = "insert into rented_books values('$usn','$isbn','$bousn',SYSDATE(),'$duedate',$price,null);";
                            $update_st = "update books set quantity = quantity - 1 where name = '$bname' and isbn = '$isbn' and book_owner = '$bousn';";
                            
                            if($con->query($insert_st) == TRUE and $con->query($update_st) == TRUE)
                            {
                                $insertsuccess = "Rented! Please collect the book from the owner at your convenience.";
                            }
                            else
                            {
                                $insertsuccess = "Error - Could not be submitted to server.".$con->error;
                            }
                            
                            $delete_when_qty_0 = "select isbn from books where quantity = 0;";
                            $result_del = $con->query($delete_when_qty_0);
                            if($result_del->num_rows > 0)
                                while($row = $result_del->fetch_assoc())
                                {   
                                    $delisbn = $row["isbn"];
                                }
                            $del_from_author = "delete from author where isbn = '$delisbn';";
                            
                            if(!$con->query($del_from_author))
                            {
                                    echo "del_from_author".$con->error;
                            }
                             $del_from_books = "delete from books where quantity = 0;";
                            if(!$con->query($del_from_books))
                            {
                                    echo "del_from_books".$con->error;
                            }
                                
                            
                        }
                        else
                        {
                            $pwdErr= "Wrong Password. Please check your USN and password."." ".$con->error;
                        }
                    }
                
                
                           
            }   
            

    function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
                }

        $con->close();
?>
        <html lang ="en">
        <link href="https://fonts.googleapis.com/css?family=Lora|Spectral+SC:500" rel="stylesheet">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>
        <head>
        <title>rentAbook!</title>
        </head>    
        <body>
            <style>
                #grid {
                    background-color: darkkhaki; 
                }
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
                        width: 502px;
                    }
                li a:hover {
                            background-color:#616339;
                }
                .active {
                    background-color: #616339;
                }

            input[type=text], input[type=number], input[type=password],input[type=date] {
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
                #rentform {
                    margin-top: 50px;
                    background-color: #F8F9FA;
                }


            </style> 
            <div class="container-fluid">
                <div class="text-center">
                <img src="http://newhorizonindia.edu/nhengineering/wp-content/uploads/2017/06/nhce-2017-june20.png" alt="College banner" id="college_banner">
                    <h1 id="heading" class="text-center"><em style="font-family:'Spectral SC',serif">rentAbook!</em></h1> 
                </div>
                <!--nAVIGATION bAR ------------------------------------------------------------->
                <ul>
                    <li><a class = "active" href="http://localhost:80/mainpage.html"><b>RENT A BOOK</b></a></li>
                    <li><a href="http://localhost:80/addnewbook.php"><b>ADD A BOOK</b></a></li>
                    <li><a href="http://localhost:80/registernewstudent.php"><b>REGISTER</b></a></li>
                </ul>
                <!-------------------------------------------------------------------------------->
                       <h3 class="text-center"><?php echo "$usnErr"."$bnErr"."$bonErr"."$pwdErr"."$insertsuccess";?></h3>
                    </div>
        </body>
        </html>
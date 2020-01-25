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
                        width: 496px;
                    }
                li a:hover {
                            background-color:#616339;
                            }
                .active {
                    background-color: #616339;
                }
                .subcol {
                    background-color:#F8F9FA;
                }

                #bookstable {
                    
                    border-collapse: collapse;
                    width: 100%;
                    margin-top: 10px;
                    margin-bottom: 30px;
                    border-radius: 5px;
                    }

                    #bookstable td, #bookstable th {
                            border: 1px solid #000;
                            padding: 8px;
                            }

                    #bookstable tr{background-color: #E5E8A3;}

                    #bookstable tr:hover {background-color: #CACD84;}

                        #bookstable th {
                                        padding-top: 12px;
                                        padding-bottom: 12px;
                                        text-align: left;
                                        background-color: #8C8F51;
                                        color: #343602;
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
                    margin-top: 20px;
                    background-color: #E5E8A3;
                }
                .btncolor {
            background-color: #8C8F51;
            font-weight: bold;
        }

            </style> 
            <div class="container-fluid">
                <div class="text-center">
                <img src="http://newhorizonindia.edu/nhengineering/wp-content/uploads/2017/06/nhce-2017-june20.png" alt="College banner" id="college_banner">
                    <h1 id="heading" class="text-center"><em style="font-family: 'Spectral SC',serif">rentAbook!</em></h1> 
                </div>
                <!--nAVIGATION bAR ------------------------------------------------------------->
                <ul>
                    <li><a class = "active" href="http://localhost:80/mainpage.html"><b>RENT A BOOK</b></a></li>
                    <li><a href="http://localhost:80/addnewbook.php"><b>ADD A BOOK</b></a></li>
                    <li><a href="http://localhost:80/registernewstudent.php"><b>REGISTER</b></a></li>
                </ul>
                <!-------------------------------------------------------------------------------->
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10 well-sm">
                        <div id="bookslist">
    <?php 
                        $con = mysqli_connect("localhost","root","root123","atrtcs092"); 
                            // Check connection 
                            if (!$con) 
                            { 
                                echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
                            } 

                            $sub = $_POST["subject"];
                            $sql = "select b.isbn,b.name,a.author_1,s.name as book_owner,b.price from books b, student s, author a where a.isbn = b.isbn and s.usn = b.book_owner and b.subject='$sub' and b.quantity > 0;";
                            $result = $con->query($sql);

                            if ($result->num_rows > 0) 
                            {
                                // output data of each row
                                echo "<div>";
                                echo "<h2 class='text-center'>$sub</h2><br>";
                                echo "<table border='1' id='bookstable'>
                                <tr>
                                <th>ISBN</th>
                                <th>NAME</th>
                                <th>AUTHOR</th>
                                <th>BOOK OWNER</th>
                                <th>PRICE</th>
                                </tr>";
                                while($row = mysqli_fetch_array($result))
                                {
                                    echo "<tr>";
                                    echo "<td>" . $row["isbn"] . "</td>";
                                    echo "<td>" . $row["name"] . "</td>";
                                    echo "<td>" . $row["author_1"] . "</td>";
                                    echo "<td>" . $row["book_owner"] . "</td>";
                                    echo "<td>" . $row["price"] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table> </div>";
                            } 
                            else 
                            {
                                echo "No books found!";
                            }

                            $con->close();
    ?>
                            
                        </div>
                        <h2 class="text-center">RENT FORM</h2>

                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 well" id="rentform">
                            <form action="http://localhost/rentbook.php" method="post">
                            
                            <label for="usn">USN</label>
                            <input type="text" id="usn" name="usn" placeholder="Enter your USN" required><br>
                                
                            <label for="name">Name of the Book</label>
                            <input type="text" id="name" name="bname" placeholder="Name of the Book" required>
                                
                            
                            <?php
                                
                                /*$con = mysqli_connect("localhost","root","root123","atrtcs092"); 
                                // Check connection 
                                if (!$con) 
                                { 
                                echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
                                } 
                                $sub = $_POST["subject"];
                                $bookname = "select name from books where subject = '$sub';";
                                $bnameresult = $con->query($bookname);
                                
                                if ($bnameresult->num_rows > 0) 
                                {
                                    echo "<label>Book Name</label>";
                                    echo '<select name="bnselect">';
                                    while($row=mysql_fetch_array($bnameresult))
                                    {
                                        echo '<option value="' .$row['name'] . '">' .$row['name'] . '</option>';
                                    }
                                    echo '</select>';
                                }
                                    
                                $con->close(); */
                            ?>
                                
                            <label for="boname">Book Owner's Name</label>
                            <input type="text" id="boname" name="boname" placeholder="Name of the Book Owner" required>
                                
                            <label for="duedate">Date of Return</label>
                            <input type="date" id="ddate" name="due_date" required>
                                
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                                
                            <b><input type="submit" value="SUBMIT"></b><br>
            
                            </form>
                            </div>
                            <div class="col-md-3"></div>
                        </div>

                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </body>
        </html>
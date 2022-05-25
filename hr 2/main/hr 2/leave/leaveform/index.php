<!DOCTYPE html>
<!--=== Coding by CodingLab | www.codinglabweb.com === -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Leave </title>
</head>

<body>

    <div class="container">
        <header>Leave form</header>

        <form method="post">
            <?php include('leave.php'); ?>
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" placeholder="Enter your name" name="fullname" value="<?php echo $fullname; ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Date of Leave</label>
                            <input type="date" placeholder="Enter birth Leave" name="dateofleave" required>
                        </div>


                        <div class="input-field">
                            <label> Supervisor Email</label>
                            <input type="text" placeholder="Enter Supervisor email" name="supervisroemail" required>
                        </div>

                        <div class="input-field">
                            <label> Supervisor Mobile Number</label>
                            <input type="number" placeholder="Enter  Supervisor mobile number" name="supervisormobilenumber" required>
                        </div>

                        <div class="input-field">
                            <label>Time-Off</label>
                            <select name="timeoff" required>
                                <option disabled selected>Type of time-off requested</option>
                                <option value="1">Vacation</option>
                                <option value="2"> Sick Leave</option>
                                <option value="2">Maternity/Paternity</option>
                                <option value="3"> Sick</option>
                                <option value="4"> Half day</option>
                                <option value="5">Time off without pay</option>
                                <option value="6">Other</option>
                            </select>
                        </div>


                        <div class="input-field">
                            <label>Occupation</label>
                            <select name="occuption" required>
                                <option disabled selected> Occupation</option>
                                <option value="1">Human resorces</option>
                                <option value="2">Texchnical engineering</option>
                                <option value="3">Operational engineering</option>
                                <option value="4">Customer Fullfilment</option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="details ID">
                    <span class="title">Identity Details</span>

                    <div class="fields">
                        <div class="input-field">

                            <label>ID Type</label>
                            <select name="idtype" required>
                                <option disabled selected>ID Type</option>
                                <option value="1"> Passport</option>
                                <option value="2"> Identity Card</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>ID Number</label>
                            <input type="number" placeholder="Enter ID number" name="idnumber" required>
                        </div>
                        <div class="input-field">
                            <label> Email</label>
                            <input type="text" placeholder="Enter your email" name="youremail" required>
                        </div>


                        <div class="input-field">
                            <label>Issued Authority</label>
                            <input type="text" placeholder="Enter issued authority" name="issuedauthority" required>
                        </div>



                        <div class="input-field">
                            <label>Issued Date</label>
                            <input type="date" placeholder="Enter your issued date" name="issueddate" required>
                        </div>

                        <div class="input-field">
                            <label>Expiry Date</label>
                            <input type="date" placeholder="Enter expiry date" name="expirydate" required>
                        </div>
                    </div>

                    <button class="sumbit" type="submit" name="signup-btn">
                        <span class="btnText">Submit</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                </div>
            </div>

            <script>
                var form = document.getElementById('form')

                form.addEventListener('submit', function(event) {
                    event.preventDefault()

                    var username = document.getElementById('username').value

                    console.log(username)

                    var date = document.getElementById('date').value

                    console.log(date)

                    filedestination = ('')
                })
            </script>



    </div>
    </div>
    </div>
    </form>
    </div>

    <!--<script src="script.js"></script>-->
</body>

</html>
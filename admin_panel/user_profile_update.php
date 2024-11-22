<?php
include('header.php');
include('../connect.php');
if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $phone_no = $_POST['phone_no'];
    $reff_id = $_POST['reff_id'];
    $reff_name = $_POST['reff_name'];
    $addres = $_POST['addres'];
    $district = $_POST['district'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];
    $acc_holder_name = $_POST['acc_holder_name'];
    $acc_no = $_POST['acc_no'];
    $bank_name = $_POST['bank_name'];
    $ifsccode = $_POST['ifsccode'];
    $password = $_POST['password'];
    $tpassword = $_POST['tpassword'];

    

    $sql = "UPDATE users SET 
                username = '$username', 
                phonenumber = '$phone_no', 
                password = '$password', 
                referalid = '$reff_id', 
                referalname = '$reff_name', 
                tpassword = '$tpassword', 
                addres = '$addres', 
                district = '$district', 
                state = '$state', 
                pincode = '$pincode', 
                holder_name = '$acc_holder_name', 
                account_number = '$acc_no', 
                bankname = '$bank_name', 
                ifsc_code = '$ifsccode'
            WHERE userid = '$user_id'";

    if ($con->query($sql) === TRUE) {
        echo '<script>alert("Data updated and saved successfully!");window.location.href = "user_profile_update.php";</script>';
    } else {
        echo '<script>alert("Error updating data!");</script>';
    }
}


?>

    <section>

        <div class="page-container">

             <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  class="check-details" method="post">
                <center>
                    <h1 style="font-size: 150%;">User Profile Update</h1>
                </center>
                <div class="check-items">
                    <label for="name" class="active-id">User ID</label><BR>
                    <input type="text" class="txt-user-id" id="userid" name="userids" onblur="fetchUserDetails(this.value)" placeholder="Enter User ID">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">User Name</label><BR>
                    <input type="text" class="txt-user-id" id="username" name="username" placeholder="Enter User Name">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">User Phone Number</label><BR>
                    <input type="text" class="txt-user-id" id="phone_no" name="phone_no" placeholder="Enter User Phone Number">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Reference ID</label><BR>
                    <input type="text" class="txt-user-id" id="reff_id" name="reff_id" placeholder="Enter User Reference ID">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Reference Name</label><BR>
                    <input type="text" class="txt-user-id" id="reff_name" name="reff_name" placeholder="Enter User Reference ID">
                </div>

                <div class="check-items">
                    <label for="name" class="active-id">Addres</label><BR>
                    <input type="text" class="txt-user-id" id="addres" name="addres"  placeholder="Enter Addres">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">District</label><BR>
                    <input type="text" class="txt-user-id" id="district" name="district"  placeholder="Enter District">
                </div>
                <div class="check-items">
                    <label for="name" class="active-id">State</label><BR>
                    <input type="text" class="txt-user-id" id="state" name="state"  placeholder="Enter State">
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Nation</h2>

                    <select name="country" class="user-id">
                        <option value="Select country">Select Country</option>
                        <option value="country-1">
                            India</option>
                        <option value="country-2">
                            Australia</option>
                        <option value="country-3">
                            Canada</option>
                        <option value="country-4">
                            Malaysia</option>
                        <option value="country-5">
                            Nepal</option>
                        <option value="country-6">
                            New Zealand</option>

                    </select>

                </div>
                <div class="check-items">
                    <label for="name" class="active-id">Pin Code</label><BR>
                    <input type="text" class="txt-user-id" id="pincode" name="pincode" maxlength="6" placeholder="Enter PinCode">
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Account Holder Name</h2>
                    <div>
                        <input type="text" class="txt-user-id" id="acc_holder_name" name="acc_holder_name" placeholder="Enter Account Holder Name ">
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Account Number</h2>
                    <div>
                        <input type="text" class="txt-user-id" id="acc_no" name="acc_no" placeholder="Enter Account Number ">
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Confirm Account Number</h2>
                    <div>
                        <input type="text" class="txt-user-id" id="acc_no" placeholder="Enter Confirm Account Number ">
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">Bank Name</h2>
                    <div>
                        <input type="text" class="txt-user-id" id="bank_name" name="bank_name" placeholder="Enter Bank Name ">
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">IFSC Code</h2>
                    <div>
                        <input type="text" class="txt-user-id" id="ifsccode" name="ifsccode" placeholder="Enter IFSC Code ">
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">User Profile Password</h2>
                    <div>
                        <input type="text" class="txt-user-id" id="password" name="password" placeholder="Enter New Password">
                    </div>
                </div>
                <div class="check-items">
                    <h2 class="head-lines">User Transaction Password</h2>
                    <div>
                        <input type="text" class="txt-user-id" id="tpassword" name="tpassword" placeholder="Enter New Password">
                    </div>
                </div>

                <div class="button-check-div">
                    <a href="./managers.php"><button type="button" class="button-check red">BACK</button></a>
                    <input type="submit" class="button-check green" name="submit" value="submit">
                    


                </div><br><br><br>
             </form>
        </div><br><br><br><br><br>

    </section>
    <script>
       function fetchUserDetails(userid) {
  fetch(`user_details_fetch.php?id=${userid}`)
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        console.error(data.error);
      } else {
        const elements = {
          username: document.getElementById('username'),
          phonenumber: document.getElementById('phone_no'),
          password: document.getElementById('password'),
          tpassword: document.getElementById('tpassword'),
          referalid: document.getElementById('reff_id'),
          referalname: document.getElementById('reff_name'),
          bankname: document.getElementById('bank_name'),
          account_number: document.getElementById('acc_no'),
          ifsc_code: document.getElementById('ifsccode'),
          holder_name: document.getElementById('acc_holder_name'),
          addres: document.getElementById('addres'),
          district: document.getElementById('district'),
          state: document.getElementById('state'),
          pincode: document.getElementById('pincode')
        };

        Object.keys(elements).forEach(key => {
          elements[key].value = data[key];
        });
      }
    })
    .catch(error => console.error('Error:', error));
}
    </script>
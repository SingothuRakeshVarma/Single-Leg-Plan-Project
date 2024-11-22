<?php

if (isset($_GET['id'])) {
  $user_id = $_GET['id'];
  $user_name = $_GET['name'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Startup Company Registration</title>
  <link rel="stylesheet" href="./user.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      background-image: url(https://storage.googleapis.com/a1aa/image/Qf6VWeNOCPr6aE3hPwb9jnKt5La84lZsV3X9TdRFhFfeLxsNB.jpg);
      background-repeat: no-repeat;
      background-size: cover;
    }
    @media only screen and (max-width: 768px) {
    .container {
      width: 300px;
      margin: 110px auto;
      
    }
    .sub_btn{
      width: 100%;
    }
  }
  @media only screen and (min-width: 1025px) {
    .container {
      width: 500px;
      margin: 110px auto;
    }
    .sub_btn{
      width: 100%;
    }
  }
  </style>
</head>

<body>
  <section>
    <div class="container">
      <h2 class="headline">Register for our Company</h2>
      <form class="Register-details" action="index.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="fullName">Full Name:</label>
          <input type="text"  class="text_in" name="username" required>
        </div>

        <div class="form-group">
          <label for="number">Mobile Number:</label>
          <input type="mobile" name="phonenumber" class="text_in" id="phonenumber" maxlength="10" minlength="required(10)" required />
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" class="text_in" name="password" required>
        </div>
        <div class="form-group">
          <label for="password">Confirm Password:</label>
          <input type="password" id="confirm-password" class="text_in" name="password" required>
        </div>
        <div class="form-group">
          <label for="number">Reffral ID:</label>
          <input type="mobile" name="reffid" value="<?php echo $user_id; ?>" class="text_in" readonly/>
        </div>
        <div class="form-group">
          <label for="fullName">Reffral Name:</label>
          <input type="text"  class="text_in" value="<?php echo $user_name; ?>" name="referral_name" readonly>
        </div>
        <div class="submit-login">
          <input type="checkbox" class="check" class="text_in" required><span class="span_check">Your Agree On Our</span><a href="#"> Privacy Policy for REALVISIONE</a>
        </div>
        <div>
          <button type="submit" class="sub_btn" value="submit">Register</button>

        </div>
      </form>
    </div>

  </section>
  <!-- JavaScript Code -->
  <script>
    const form = document.getElementById('register-form');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');

    form.addEventListener('submit', (e) => {
      e.preventDefault();

      const password = passwordInput.value;
      const confirmPassword = confirmPasswordInput.value;

      if (password !== confirmPassword) {
        alert('Passwords do not match');
        return;
      }

      // If passwords match, submit the form
      form.requestSubmit();
    });
  </script>

</body>

</html>
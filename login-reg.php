<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/login-reg.css">
</head>

<body>
  <div class="form-container" id="signup" style="display: none;">
    <h1 class="form-title">Register</h1>
    <form method="post" action="register.php">
      <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" name="fName" id="fName" placeholder="First Name" required>
           <label for="fname">Name</label>
      </div>
      <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="number" name="Pnumber" id=Pnumber required min="0" max="9999999999" maxlength="10" placeholder="enter your number">
        <label for="lname">Number</label>
      </div>
      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" id="regEmail" placeholder="Email" required>
        <label for="regEmail">Email</label>
      </div>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="regPassword" placeholder="Password" required>
        <label for="regPassword">Password</label>
      </div>
      <input type="submit" class="btn" value="Sign Up" name="signUp">
    </form>
    <p class="or">------------------ Or -----------------</p>
    <div class="icons">
      <i class="fab fa-google"></i>
      <i class="fab fa-facebook"></i>
    </div>
    <div class="links">
      <p>Already Have Account?</p>
      <button id="signInButton">Sign In</button>
    </div>
  </div>

  <div class="form-container" id="signIn">
    <h1 class="form-title">Login</h1>
    <form method="post" action="register.php">
      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" id="loginEmail" placeholder="Email" required>
        <label for="loginEmail">Email</label>
      </div>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="loginPassword" placeholder="Password" required>
        <label for="loginPassword">Password</label>
      </div>
      <p class="recover">
        <a href="#">Recover Password</a>
      </p>
      <input type="submit" class="btn" value="Login" name="signIn">
    </form>
    <p class="or">------------------ Or -----------------</p>
    <div class="icons">
      <i class="fab fa-google"></i>
      <i class="fab fa-facebook"></i>
    </div>
    <div class="links">
      <p>Don't have an account?</p>
      <button id="signUpButton">Sign Up</button>
    </div>
  </div>
</body>

<script>
const signUpButton = document.getElementById('signUpButton');
const signInButton = document.getElementById('signInButton');
const signUpForm = document.getElementById('signup');
const signInForm = document.getElementById('signIn');

signUpButton.addEventListener('click', function () {
  signInForm.style.display = "none";
  signUpForm.style.display = "block";
});

signInButton.addEventListener('click', function () {
  signInForm.style.display = "block";
  signUpForm.style.display = "none";
});

</script>
<script src="https://kit.fontawesome.com/09c7b536da.js" crossorigin="anonymous"></script>
</html>
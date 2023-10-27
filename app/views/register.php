<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Register Form</div>
                    <div class="card-body">
                        <form name="registration" method="post" action="index.php" onsubmit="return validateRegistration();">

                            <input type="hidden" name="action" value="register">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input name="username" type="text" class="form-control" />
                                <span id="fisrtNameFeedback" class="invalid-feedback"></span>
                            </div>

                            <div class="mb-3">
                              <label class="form-label">Email address</label>
                              <input type="email" name="email" class="form-control"/>
                              <span id="emailFeedback" class="invalid-feedback"></span>
                          </div>


                          <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control"/>
                            <span id="addressFeedback" class="invalid-feedback"></span>
                        </div>

                        <div class="mb-3">
                          <label class="form-label">Password</label>
                          <input type="password" name="password" class="form-control" />
                      </div>

                      <div class="mb-3">
                          <label class="form-label">Confirm Password</label>
                          <input type="password" name="confirmPassword" class="form-control" />
                          <span id="pwdFeedback" class="invalid-feedback"></span>
                      </div>


                          <div class="mb-3">
                          <label class="form-label">Balance</label>
                          <input type="number" name="balance" class="form-control" />
                          <span id="balanceFeedback" class="invalid-feedback"></span>
                      </div>


                      <button type="submit" class="btn btn-md btn-primary">
                          Submit
                      </button>

                      <p class="mt-3">Already have an account? <a href="index.php?page=login">Login</a></p>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>
<script type="text/javascript">

    function validateRegistration() {
        var regForm=document.registration;
        var username=regForm.username.value;

        var text=document.getElementById("fisrtNameFeedback");


        if (username=="") {
            text.innerHTML="Username is Required";
            text.classList.add("d-block");
            return false;
        }else{
            text.innerHTML="";
            document.getElementById("fisrtNameFeedback").classList.remove("d-block");
        }




        if (!/^[a-zA-Z]+$/.test(username)) { 
            text.innerHTML="Only characters allowed";
            document.getElementById("fisrtNameFeedback").classList.add("d-block");
            return false;
        }else{
            text.innerHTML="";
            document.getElementById("fisrtNameFeedback").classList.remove("d-block");
        }


        var email=regForm.email.value;

        if (email=="") {
            var text=document.getElementById("emailFeedback");
            text.innerHTML="Email is Required";
            text.classList.add("d-block");
            return false;

        }else{
            var text=document.getElementById("emailFeedback");
            text.innerHTML="";
            document.getElementById("emailFeedback").classList.remove("d-block");

        }


        var address=regForm.address.value;
        if (address=="") {
            var text=document.getElementById("addressFeedback");
            text.innerHTML="Address is Required";
            text.classList.add("d-block");
            return false;
        }else{
            var text=document.getElementById("addressFeedback");
            text.innerHTML="";
            document.getElementById("addressFeedback").classList.remove("d-block");
        }


        var password=regForm.password.value;
        var confirmPassword=regForm.confirmPassword.value;

        if (password=="") {
            var text=document.getElementById("pwdFeedback");
            text.innerHTML="Password cannot be empty";
            text.classList.add("d-block");
            return false;
        }

        if (password!=confirmPassword) {
            var text=document.getElementById("pwdFeedback");
            text.innerHTML="Password doesnt match";
            text.classList.add("d-block");
            return false;
        }

        return true;
    }


</script>
<!-- Add Bootstrap JS and jQuery scripts here -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>



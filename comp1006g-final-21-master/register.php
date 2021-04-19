<?php
$pageTitle = 'Register';
include 'header.php';
?>

<main class="container">
    <h1>User Registration</h1>
    <form method="post" action="save-registration.php">
        <fieldset class="form-group">
            <label for="username" class="col-2">Username:</label>
            <input name="username" id="username" required type="email" placeholder="email@email.com" />
        </fieldset>
        <fieldset class="form-group">
            <label for="password" class="col-2">Password:</label>
            <input type="password" name="password" id="password" required
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" />
        </fieldset>
        <fieldset class="form-group">
            <label for="confirm" class="col-2">Confirm Password:</label>
            <input type="password" name="confirm" id="confirm" required
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                onkeyup="return comparePasswords();"/>
            <span id="pwMsg"></span>
        </fieldset>
        <div class="offset-3">
            <button class="btn btn-primary">Register</button>
        </div>
        <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
    </form>
</main>
<!-- recaptcha -->
<script src="https://www.google.com/recaptcha/api.js?render=6LfWjqgaAAAAAFyCmnWXjJn9Dk-LtqaZX1fAI-DN"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6LfWjqgaAAAAAFyCmnWXjJn9Dk-LtqaZX1fAI-DN', {action: 'register'}).then(function(token) {
            // add the recaptcha response to the new hidden field on the form so it gets submitted to the server
            var recaptchaResponse = document.getElementById('recaptchaResponse');
            recaptchaResponse.value = token;
        });
    });
</script>
<?php include 'footer.php'; ?>



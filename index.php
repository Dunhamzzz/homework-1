<?php 
/** 
 * Stand alone contact form
 * 
 * @author Matthew Dunham <me@dunhamzzz.com>
 */

// If form is posted with data
if(isset($_POST) && !empty($_POST)) {
    
    $errors = array();
    
    // Validate Name
    if(
        !array_key_exists('name', $_POST)
        || empty($_POST['name']) 
        || strlen($_POST['name']) < 3
    ) {
        $errors[] = 'name';
    }
    
    // Validate Email
    if(
        !array_key_exists('email', $_POST)
        || empty($_POST['email'])
        || false == filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
    ) {
        $errors[] = 'email';
    }  
    
    // And Phone...
    if(
        !array_key_exists('phone', $_POST)
        || empty($_POST['phone'])
        || false == preg_match('/^[0-9-]+$/', $_POST['phone'])
    ) {
        $errors[] = 'phone';
    }  
    
    // If ajax request, respond with JSON
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        
        header('Content-Type: application/json');
        
        if(!empty($errors)) {
            $json = json_encode(array('success' => 0, 'errors' => $errors));
        } else {
            $json = json_encode(array('success' => 1));
        }
        
        echo $json;
        exit();
    }
    
}

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Homework #1</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="assets/style.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>
        $(function(){
            
            $('#contact-form').submit(function(e) {
                //e.preventDefault();
                
                $.ajax({
                    url: 'index.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        
                    }
                });
            });
            
        });
        
        </script>
    </head>
    <body>
        <div class="container">
        <h1>Contact Form</h1>
        <div id="notification-area"></div>
        <form action="index.php" method="post" id="contact-form">
            <fieldset>
                <legend>Enter your details below</legend>
                
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter your full name" value="<?php echo $_POST['name'] ?: ''; ?>">
                <span id="name-feedback"class="help-block"></span>
                
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter email address" value="<?php echo $_POST['email'] ?: ''; ?>">
                <span id="email-feedback" class="help-block"></span>
                
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" placeholder="Enter phone number" value="<?php echo $_POST['phone'] ?: ''; ?>">
                <span id="phone-feedback" class="help-block"></span>
                
            </fieldset>
            <input type="submit"id="submit-button" value="Submit">
        </form>
        </div>
    </body>
</html>
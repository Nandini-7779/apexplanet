<!DOCTYPE html>
<html>
<head>
    <title>PHP Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include("header.php"); ?>

<section>
    <h2>PHP Contact Form</h2>

    <!-- HTML Form -->
    <form method="POST" action="form.php">

        <label>Name:</label><br>
        <input type="text" name="name" 
        placeholder="Enter name">
        <br><br>

        <label>Email:</label><br>
        <input type="email" name="email" 
        placeholder="Enter email">
        <br><br>

        <label>Message:</label><br>
        <textarea name="message" rows="4" 
        placeholder="Your message..."></textarea>
        <br><br>

        <button type="submit" name="submit">
            Send Message
        </button>
    </form>

    <?php
    // Check if form was submitted
    if(isset($_POST['submit'])) {

        // Get form values
        $name    = $_POST['name'];
        $email   = $_POST['email'];
        $message = $_POST['message'];

        // Basic validation
        if(empty($name) || empty($email) || empty($message)) {
            echo "<p style='color:red'>
            ❌ All fields are required!</p>";
        } else {
            echo "<h3 style='color:green'>
            ✅ Form Submitted!</h3>";
            echo "<p><b>Name:</b> $name</p>";
            echo "<p><b>Email:</b> $email</p>";
            echo "<p><b>Message:</b> $message</p>";
        }
    }
    ?>

</section>



    <?php include("footer.php"); ?>

</body>
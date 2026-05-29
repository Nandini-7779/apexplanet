<?php
// Variables
$name = "John";
$age = 20;
$city = "Hyderabad";
$isStudent = true;

// Print variables
echo "<h1>Hello, My name is $name</h1>";
echo "<p>Age: $age</p>";
echo "<p>City: $city</p>";

// Arrays
$skills = ["HTML", "CSS", "JavaScript", "PHP"];

echo "<h2>My Skills:</h2>";
echo "<ul>";
foreach($skills as $skill) {
    echo "<li>$skill</li>";
}
echo "</ul>";
?>
<?php
$marks = 75;

// If / Else
echo "<h2>Grade Calculator:</h2>";

if($marks >= 90) {
    echo "<p>Grade: A+ ⭐</p>";
} elseif($marks >= 80) {
    echo "<p>Grade: A 😊</p>";
} elseif($marks >= 70) {
    echo "<p>Grade: B 👍</p>";
} elseif($marks >= 60) {
    echo "<p>Grade: C 😐</p>";
} else {
    echo "<p>Grade: F ❌</p>";
}

// Switch
$day = "Monday";
echo "<h2>Today is:</h2>";

switch($day) {
    case "Monday":
        echo "<p>Start of work week! 💼</p>";
        break;
    case "Friday":
        echo "<p>Weekend is coming! 🎉</p>";
        break;
    case "Sunday":
        echo "<p>Rest day! 😴</p>";
        break;
    default:
        echo "<p>Regular day! 📅</p>";
}

// Loop
echo "<h2>Counting:</h2>";
for($i = 1; $i <= 5; $i++) {
    echo "<p>Number: $i</p>";
}
?>
<?php
// Simple Function
function greet($name) {
    return "Hello, " . $name . "! Welcome! 👋";
}

echo "<h2>Functions:</h2>";
echo "<p>" . greet("John") . "</p>";
echo "<p>" . greet("Sarah") . "</p>";

// Function with calculation
function calculateAge($birthYear) {
    $currentYear = 2026;
    $age = $currentYear - $birthYear;
    return $age;
}

echo "<p>Age: " . calculateAge(2000) . " years old</p>";

// Function with array
function getFullName($firstName, $lastName) {
    return $firstName . " " . $lastName;
}

echo "<p>Full Name: " . getFullName("John", "Doe") . "</p>";
?>
<!-- header.php -->
<header style="background:#2c3e50; 
color:white; padding:20px; text-align:center;">
    <h1>My PHP Website</h1>
    <nav>
        <a href="index.html" 
        style="color:white; margin:10px;">Home</a>
        <a href="form.php" 
        style="color:white; margin:10px;">Contact</a>
        <a href="basics.php" 
        style="color:white; margin:10px;">PHP Basics</a>
    </nav>
</header>

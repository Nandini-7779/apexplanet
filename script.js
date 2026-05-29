// Variables
let name = "John";
let age = 20;
const city = "Hyderabad";

console.log("Name:", name);
console.log("Age:", age);
console.log("City:", city);

// Array
let skills = ["HTML", "CSS", "JavaScript", "PHP"];

// Loop through array
skills.forEach(function(skill) {
    console.log("Skill:", skill);
});
// Change text using getElementById
function changeText() {
    document.getElementById("demo").innerHTML = 
    "Text changed by JavaScript! 🎉";
}

// Change color using querySelector
function changeColor() {
    document.querySelector("#demo").style.color = "red";
    document.querySelector("#demo").style.fontSize = "24px";
}
// Form Validation
function validateForm() {

    // Get values
    let name = document.getElementById("valName").value;
    let email = document.getElementById("valEmail").value;
    let password = document.getElementById("valPassword").value;

    // Check empty name
    if (name === "") {
        alert("❌ Name cannot be empty!");
        return false;
    }

    // Check name length
    if (name.length < 3) {
        alert("❌ Name must be at least 3 characters!");
        return false;
    }

    // Check valid email
    if (!email.includes("@") || !email.includes(".")) {
        alert("❌ Please enter a valid email!");
        return false;
    }

    // Check password length
    if (password.length < 6) {
        alert("❌ Password must be at least 6 characters!");
        return false;
    }

    // All good!
    alert("✅ Form submitted successfully!");
    return true;
}
// Todo List
function addTodo() {
    let input = document.getElementById("todoInput").value;

    if (input === "") {
        alert("Please enter a task!");
        return;
    }

    // Create new list item
    let li = document.createElement("li");
    li.innerHTML = input + 
    ' <button onclick="this.parentElement.remove()">❌</button>';

    // Add to list
    document.getElementById("todoList").appendChild(li);

    // Clear input
    document.getElementById("todoInput").value = "";
}

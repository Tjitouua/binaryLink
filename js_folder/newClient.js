
function clients() {
    window.location.href = "clients.php";
}
function contacts() {
    window.location.href = "contacts.php";
}


function validateInputs() {
const nameInput = document.getElementById('nameInput');
const descInput = document.getElementById('descInput');
const typeInput = document.getElementById('typeInput');

let valid = true;

if (!nameInput.value.trim()) {
nameInput.style.backgroundColor = 'pink';
nameInput.style.borderColor = 'red';
nameInput.style.borderStyle = 'dotted';
nameInput.style.borderWidth = '3px';
valid = false;
} else {
nameInput.style.backgroundColor = 'transparent';
nameInput.style.borderColor = 'transparent';
nameInput.style.borderBottomColor = 'grey';
nameInput.style.borderStyle = 'solid';
nameInput.style.borderWidth = '2px';
}

if (!descInput.value.trim()) {
descInput.style.backgroundColor = 'pink';
descInput.style.borderColor = 'red';
descInput.style.borderStyle = 'dotted';
descInput.style.borderWidth = '3px';
valid = false;
} else {
descInput.style.backgroundColor = 'transparent';
descInput.style.borderColor = 'transparent';
descInput.style.borderBottomColor = 'grey';
descInput.style.borderStyle = 'solid';
descInput.style.borderWidth = '2px';
}

if (!typeInput.value.trim()) {
typeInput.style.backgroundColor = 'pink';
typeInput.style.borderColor = 'red';
typeInput.style.borderStyle = 'dotted';
typeInput.style.borderWidth = '3px';
valid = false;
} else {
typeInput.style.backgroundColor = 'transparent';
typeInput.style.borderColor = 'transparent';
typeInput.style.borderBottomColor = 'grey';
typeInput.style.borderStyle = 'solid';
typeInput.style.borderWidth = '2px';
}

return valid;
}

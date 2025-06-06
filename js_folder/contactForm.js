function clients() {
    window.location.href = "clients.php";
}
function contacts() {
    window.location.href = "contacts.php";
}

function contacts() {
    var inputDiv = document.getElementById('inputDiv');
    var contactsDiv = document.getElementById('contactsDiv');
    var unlinkedContactsDiv = document.getElementById('contactsDiv2');

    inputDiv.style.display = 'none';
    contactsDiv.style.display = 'flex';
    unlinkedContactsDiv.style.display = 'none';
}

function general() {
    var inputDiv = document.getElementById('inputDiv');
    var contactsDiv = document.getElementById('contactsDiv');
    var unlinkedContactsDiv = document.getElementById('contactsDiv2');

    inputDiv.style.display = 'flex';
    contactsDiv.style.display = 'none';
    unlinkedContactsDiv.style.display = 'none';
}

function showLinkedContacts() {
    var linkedContactsDiv = document.getElementById('contactsDiv');
    var unlinkedContactsDiv = document.getElementById('contactsDiv2');
    var inputDiv = document.getElementById('inputDiv');

    linkedContactsDiv.style.display = 'flex';
    unlinkedContactsDiv.style.display = 'none';
    input.style.display = 'none';
}

function showUnlinkedContacts() {
    var linkedContactsDiv = document.getElementById('contactsDiv');
    var unlinkedContactsDiv = document.getElementById('contactsDiv2');
    var inputDiv = document.getElementById('inputDiv');

    linkedContactsDiv.style.display = 'none';
    unlinkedContactsDiv.style.display = 'flex';
    input.style.display = 'none';
}






function validateInputs() {
const inputName = document.getElementById('inputName');
const inputSurname = document.getElementById('inputSurname');
const inputEmail = document.getElementById('inputEmail');
const inputType = document.getElementById('inputType');
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

let valid = true;

if (!inputName.value.trim()) {
inputName.style.backgroundColor = 'pink';
inputName.style.borderColor = 'red';
inputName.style.borderStyle = 'dotted';
inputName.style.borderWidth = '3px';
valid = false;
} else {
inputName.style.backgroundColor = 'transparent';
inputName.style.borderColor = 'transparent';
inputName.style.borderBottomColor = 'grey';
inputName.style.borderStyle = 'solid';
inputName.style.borderWidth = '2px';
}

if (!inputSurname.value.trim()) {
inputSurname.style.backgroundColor = 'pink';
inputSurname.style.borderColor = 'red';
inputSurname.style.borderStyle = 'dotted';
inputSurname.style.borderWidth = '3px';
valid = false;
} else {
inputSurname.style.backgroundColor = 'transparent';
inputSurname.style.borderColor = 'transparent';
inputSurname.style.borderBottomColor = 'grey';
inputSurname.style.borderStyle = 'solid';
inputSurname.style.borderWidth = '2px';
}

if (!emailRegex.test(inputEmail.value.trim())) {
inputEmail.style.backgroundColor = 'pink';
inputEmail.style.borderColor = 'red';
inputEmail.style.borderStyle = 'dotted';
inputEmail.style.borderWidth = '3px';
valid = false;
} else {
inputEmail.style.backgroundColor = 'transparent';
inputEmail.style.borderColor = 'transparent';
inputEmail.style.borderBottomColor = 'grey';
inputEmail.style.borderStyle = 'solid';
inputEmail.style.borderWidth = '2px';
}

if (!inputType.value.trim()) {
inputType.style.backgroundColor = 'pink';
inputType.style.borderColor = 'red';
inputType.style.borderStyle = 'dotted';
inputType.style.borderWidth = '3px';
valid = false;
} else {
inputType.style.backgroundColor = 'transparent';
inputType.style.borderColor = 'transparent';
inputType.style.borderBottomColor = 'grey';
inputType.style.borderStyle = 'solid';
inputType.style.borderWidth = '2px';
}

return valid;
}


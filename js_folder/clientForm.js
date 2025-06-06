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





/*
window.onload = function () {
const urlParams = new URLSearchParams(window.location.search);
const view = urlParams.get('view');
if (view === 'contacts') {
// Hide inputDiv and show contactsDiv
document.getElementById('inputDiv').style.display = 'none';
document.getElementById('contactsDiv').style.display = 'flex';
}
};
*/









/*

document.addEventListener('DOMContentLoaded', () => {
document.querySelectorAll('.linkContactBtn').forEach(button => {
button.addEventListener('click', function (e) {
    e.preventDefault();

    const row = this.closest('form');
    const formData = new FormData(row);

    // Add additional client data from PHP
    formData.append("clientId", "<?php echo $_GET['data']; ?>");
    formData.append("clientName", "<?php echo $_GET['data2']; ?>");
    formData.append("clientCode", "<?php echo $_GET['data4']; ?>");
    formData.append("clientType", "<?php echo $_GET['data5']; ?>");

    fetch('link_contact.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") {
            location.reload(); 
        }
    })
    .catch(err => {
        console.error(err);
        alert("Something went wrong");
    });
});
});
});
*/

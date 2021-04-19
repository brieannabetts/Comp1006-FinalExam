// delete confirmation to be used w/any delete link/button
function confirmDelete() {
    return confirm('Are you sure you want to delete this?');
}

// front-end password comparison for registration
function comparePasswords() {
    // get the 2 passwords entered
    var pw1 = document.getElementById('password').value;
    var pw2 = document.getElementById('confirm').value;
    var pwMsg = document.getElementById('pwMsg');

    // compare
    if (pw1 != pw2) {
        pwMsg.innerText = 'Passwords do not match';
        pwMsg.className = 'text-danger';
        return false;
    }
    else {
        pwMsg.innerText = '';
        pwMsg.className = '';
        return true;
    }
}
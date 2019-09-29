function validateForm() {
    var emailid = document.forms["RegisterForm"]["email"].value;
    var pass = document.forms["RegisterForm"]["pass"].value;
    var cpass = document.forms["RegisterForm"]["cpass"].value;
    var fname = document.forms["RegisterForm"]["firstname"].value;
    var lname = document.forms["RegisterForm"]["lastname"].value;
    var letter = /^[a-zA-Z]+$/;
    var letterNumber = /^[0-9a-zA-Z]+$/;

    function checkDotIndexes(arr, val) {
        var dotindexes = [], i;
        for (i = 0; i < arr.length; i++)
            if (arr[i] === val)
                dotindexes.push(i);

        for (var j = 0; j < dotindexes.length - 1; j++) {
            if (dotindexes[j + 1] - dotindexes[j] === 1) {
                return false;
            }
        }
    }

    function count(arr, val) {
        var count = 0;
        for (var i = 0; i < arr.length; i++) {
            if (arr[i] === val)
                count = count + 1;
        }
        return count;
    }

        var atpos = emailid.indexOf('@');
        var len = emailid.length;

        if (atpos === -1 || atpos === (emailid.length - 1) || atpos === 0) {
            alert("Enter a valid email address!");
            return false;
        }

        var emailist = emailid.split("@");
        var username = emailist[0];
        var domain = emailist[1];

        if (!username.match(/^[0-9a-z._]+$/)) {
            alert("Only lowercase letters and (_ .) are allowed in username of email");
            return false;
        }
        if (!domain.match(/^[a-z.]+$/)) {
            alert("Only ( @ .) are allowed in domain name of email");
            return false;
        }
        if (username[0] === "." || username[username.length - 1] === "." || domain[0] === "." || domain[domain.length - 1] === ".") {
            alert("Enter a valid email address!");
            return false;
        }
        if (count(domain, ".") > 2) {
            alert("Enter a valid email address!");
            return false;
        }
        var ar = username.split("");
        if ((checkDotIndexes(ar, ".")) === false) {
            alert("Enter a valid domain name in email");
            return false;
        }
        ar = domain.split("");
        if ((checkDotIndexes(ar, ".")) === false) {
            alert("Enter a valid username in email");
            return false;

        }
        if (username.search(/[a-z]/) === -1) {
            alert("Have at least one letter in your username");
            return false;
        }
        if (domain.search(/[a-z]/) === -1) {
            alert("Invalid domain name in email");
            return false;
        }
        if (domain.search(/[.]/) === -1) {
            alert("Invalid domain name in email");
            return false;
        }

        if (pass.search(/\d/) === -1) {
            alert("Have at least one number in your password");
            return false;
        }
        if (pass.search(/[a-zA-Z]/) === -1) {
            alert("Have at least one letter in your password");
            return false;
        }

        if (pass !== cpass) {
            alert("Password and Confirm Password do not match");
            return false;
        }

        if (fname.match(letter) && lname.match(letter)) {
        } else {
            alert("Your name can only have letters");
            return false;
        }

        return true;
}
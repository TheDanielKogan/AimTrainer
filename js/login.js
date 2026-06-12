/*
Daniel Kogan
March 24th, 2026
JS File for the login page
*/

window.addEventListener("load", function () {

    const submitbtn = this.document.getElementById("submitbtn");
    const emailElem = this.document.getElementById("email");
    const errorElem = this.document.getElementById("errormessage");
    submitbtn.addEventListener("click", function (e) {
        if (!isValidEmail(emailElem.value)) {
            console.log("rahh")
            errorElem.innerHTML = "Invalid Email";
            errorElem.style.visibility = "visible"
            e.preventDefault();
            setTimeout(() => {
                errorElem.style.visibility = "hidden";
            }, 5000);
        }
    })
})

/**
 * Checks if a string is a valid email.
 * 
 * @param {String} email 
 * @returns boolean
 */
function isValidEmail(email) {
    if (email.length <= 0) return false;
    if (!email.includes(".")) return false;
    if ((email.split("@").length - 1) != 1) return false;
    if (!email.split("@")[1].includes(".")) return false;
    if (email.endsWith(".")) return false;

    return true;
}
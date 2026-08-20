alert("LOGIN JS FUNCIONANDO");

const form = document.querySelector(".form.login form");

console.error("FORM ENCONTRADO:", form);
console.error("TAG:", form?.tagName);

const continueBtn = form.querySelector(".button input");
const errorText = form.querySelector(".error.text");

console.log(form);
console.log(form instanceof HTMLFormElement);
console.log('oiiii');

form.onsubmit = (e) => {
    e.preventDefault();

    let xhr = new XMLHttpRequest();

    xhr.open("POST", "php/login.php", true);

    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {

                let data = xhr.response;

                if (data === "success") {
                    location.href = "users.php";
                } else {
                    errorText.style.display = "block";
                    errorText.textContent = data;
                }
            }
        }
    };

    let formData = new FormData(form);

    xhr.send(formData);
};
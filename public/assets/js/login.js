const form = document.querySelector(".form.login form");

const continueBtn = form.querySelector(".button input");
const errorText = form.querySelector(".error.text");


form.onsubmit = (e) => {
    e.preventDefault();

    let xhr = new XMLHttpRequest();

    xhr.open("POST", "php/login.php", true);

    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {

                let data = xhr.response;
                console.log(data);

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
const form = document.querySelector(".signup form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e) => {
    e.preventDefault();

    continueBtn.disabled = true;
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/signup.php", true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response.trim();
                    if(data === "success"){
                        location.href = "users.php";
                    }else{
                        errorText.style.display = "block";
                        errorText.textContent = data;
                    }
            }else{
                errorText.style.display = "block";
                errorText.textContent = xhr.responseText || "Could not complete signup.";
            }
            continueBtn.disabled = false;
        }
    }

    let formData = new FormData(form);
    xhr.send(formData);
}

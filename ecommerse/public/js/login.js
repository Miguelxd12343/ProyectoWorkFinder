document.getElementById("loginForm");
addEventListener("submit", function (e) {
    const email = this.email.value;
    const password = this.password.value;

    if(!email.includes("@")){
        this.alert("Correo Electronico no Válido.");
        e.preventDefault();
    }

    if(password.trim().length < 6){
        this.alert("La contraseña debe tener almenos 6 caracteres.");
        e.preventDefault();
    }
});
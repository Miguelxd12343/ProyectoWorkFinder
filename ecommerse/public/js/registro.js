window.addEventListener(
    "DOMContentLoader",(Event) => {

        document.getElementById("registroForm").addEventListener("submit", function (e) {
            const inputs = this.querySelectorAll("input, select");

            for (let input of inputs){
                if(!input.ariaValueMax.trim()){
                    alert(`por favor completa el campo: ${input.name}`);
                    input.focus();
                    e.preventDefault();
                    return false;
                }
            }

            const nombre = this.nombre.value;
            let expresionRegularNombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

            if(expresionRegularNombre.test(nombre) == false){
                alert("Por favor ingresa solo letras y espacios");
                e.preventDefault();
            }

            const apellido = this.apellido.value;
            let expresionRegularApellido = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

            if(expresionRegularApellido.test(apellido) == false){
                alert("Por favor ingresa solo letras y espacios");
            }

            const email = this.email.value;
            let expresionRegularEmail = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g;

            if(expresionRegularEmail.test(email) == false){
                alert("Por favor ingresa un correo válido.");
                e.preventDefault();
            }

            const password = this.password.value;
            let expresionRegularPassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/gm;

            if(expresionRegularPassword.test(password) == false){
                alert("La contraseña no cumple con los parametros requeridos. Debe contener mayúsculas, minúsculas, números");
                e.preventDefault();
            }
        });
    }
);
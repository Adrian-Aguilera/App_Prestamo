document.addEventListener('DOMContentLoaded', function () {
    const nextButton = document.getElementById('nextButton');
    const duiInput = document.getElementById('dui');
    const telefonoInput = document.getElementById('telefono'); // Asegúrate de que este ID sea correcto

    function validarCampos() {
        const regexDUI = /^\d{9}$/;
        const regexTelefono = /^\d{9}$/; 

        let valid = true;

        if (!regexDUI.test(duiInput.value)) {
            console.log("DUI no válido");
            duiInput.classList.add('is-invalid');
            valid = false;
        } else {
            duiInput.classList.remove('is-invalid');
        }

        if (!regexTelefono.test(telefonoInput.value)) {
            console.log("Teléfono no válido");
            telefonoInput.classList.add('is-invalid');
            valid = false;
        } else {
            telefonoInput.classList.remove('is-invalid');
        }

        return valid;
    }

    nextButton.addEventListener('click', function(event) {
        if (!validarCampos()) {
            event.preventDefault(); // Detiene la navegación al siguiente paso
        }
    });
});

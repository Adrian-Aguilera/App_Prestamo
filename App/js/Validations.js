function validarDUI(dui) {
    const duiInput = document.getElementById('dui');
    const regex = /^\d{9}$/;

    if (regex.test(dui)) {
        console.log("Válido");
        duiInput.classList.remove('is-invalid');  // Suponiendo que 'is-invalid' es una clase para mostrar error
        return true;
    } else {
        duiInput.classList.add('is-invalid');  // Agrega una clase para cambiar el estilo en caso de error
        return false;
    }
}


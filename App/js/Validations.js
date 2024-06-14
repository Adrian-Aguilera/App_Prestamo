function validarDUI(dui) {
    const regex = /^\d{9}$/;
    
    if (regex.test(dui)) {
        console.log("valido");
        return true;
    } else {
        alert("El formato del DUI no es válido. Asegúrese de que tenga el formato 00000000-0.");
        return false;
    }
}
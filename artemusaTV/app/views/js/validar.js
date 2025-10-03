function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}

function checkStrength(password) {
    const bar = document.getElementById("strength-fill");
    const text = document.getElementById("strength-text");
    let strength = 0;

    if (password.length >= 6) strength++;            // longitud mínima
    if (/[A-Z]/.test(password)) strength++;          // al menos una mayúscula
    if (/[0-9]/.test(password)) strength++;          // al menos un número
    if (/[^A-Za-z0-9]/.test(password)) strength++;   // al menos un símbolo

    switch (strength) {
        case 0:
            bar.style.width = "0%";
            text.innerText = "";
            break;
        case 1:
            bar.style.width = "25%";
            bar.style.background = "red";
            text.innerText = "Contraseña muy débil";
            text.style.color = "red";
            break;
        case 2:
            bar.style.width = "50%";
            bar.style.background = "orange";
            text.innerText = "Contraseña débil";
            text.style.color = "orange";
            break;
        case 3:
            bar.style.width = "75%";
            bar.style.background = "blue";
            text.innerText = "Contraseña buena";
            text.style.color = "blue";
            break;
        case 4:
            bar.style.width = "100%";
            bar.style.background = "green";
            text.innerText = "Contraseña fuerte";
            text.style.color = "green";
            break;
    }
}
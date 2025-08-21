// script.js
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const nomeInput = document.getElementById("nome");
    const emailInput = document.getElementById("email");

    form.addEventListener("submit", function(event) {
        let errors = [];

        // Validação do nome (não aceita números)
        if (/\d/.test(nomeInput.value)) {
            errors.push("O nome não pode conter números!");
        }

        // Validação do email (aceita apenas e-mails válidos)
        // Regex simples e eficaz
        const emailRegex = /^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/;

        if (!emailRegex.test(emailInput.value)) {
            errors.push("Digite um email válido!");
        }

        // Se houver erros, impede o envio e mostra alert
        if (errors.length > 0) {
            event.preventDefault();
            alert(errors.join("\n"));
        }
    });
});
$(document).ready(function() {
    
    // Adicionando método regex
    jQuery.validator.addMethod("regex", function(value, element, regexp) {
        if (regexp.constructor !== RegExp) {
            regexp = new RegExp(regexp);
        } else if (regexp.global) regexp.lastIndex = 0;
        return this.optional(element) || regexp.test(value);
    }, "Formato inválido.");

    $("#meuFormulario").validate({
        rules: {
            nome: {
                required: true,
                minlength: 3
            },
            telefone: {
                required: true,
                regex: /^(55)?(?:[1-9]{2})?\d{8,9}$/ 
            },
            email: {
                required: true,
                regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
            },
            mensagem: {
                required: true,
                minlength: 10
            }
        },
        messages: {
            nome: "Por favor, insira seu nome completo",
            telefone: "Insira um telefone válido (com DDD)",
            email: "Digite um e-mail válido",
            mensagem: "Digite ao menos 10 caracteres"
        }
    });
});

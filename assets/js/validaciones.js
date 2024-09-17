$(document).ready(function() {
    $('form').on('submit', function(event) {
        var isValid = true;
        var camposVacios = [];

        $(this).find('input[type="text"], textarea').each(function() {
            var valor = $(this).val().trim();
            if (valor === "") {
                isValid = false;
                camposVacios.push("\n" + $(this).attr('id'));
            }
        });

        if (!isValid) {
            event.preventDefault();
            alert("Los siguientes campos están vacíos: " + camposVacios.join() + "\n\nGonzalo Monteodorisio");
        }
    });
});
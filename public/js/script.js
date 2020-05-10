$(document).ready(function() {
    handle_postcode();
    get_project_info();

    $("#postcode").mask("99999-999");
});

$.fn.animShow = function() {
    this.css({
        opacity: 1,
        visibility: "visible",
        maxHeight: "1000px"
    });
};

$.fn.animHide = function() {
    this.css({
        opacity: 0,
        visibility: "hidden",
        maxHeight: "0"
    });
};


function handle_postcode() {
    $("#main_form").on("submit", function(e) {
        e.preventDefault();

        var postcode = $(this).find("#postcode").val();

        get_postcode_info(postcode, function(data) {
            var wrapper = $(".preview__postcode__data .wrapper");

            var html = "<div class='info'>";
                html += "<li id='servico'><strong>Serviço:</strong> " + data.servico + "</li>";
                html += "<li id='endereco'><strong>Endereço:</strong> " + data.logradouro + "</li>";
                html += "<li id='bairro'><strong>Bairro:</strong> " + data.bairro + "</li>";
                html += "<li id='cidade'><strong>Cidade:</strong> " + (data.servico == "ViaCep"? data.localidade: data.cidade) + "</li>";
                html += "<li id='estado'><strong>Estado:</strong> " + data.uf + "</li>";
            html += "</div>";

            $(wrapper).html(html);


            setTimeout(function() {
                $(wrapper).animShow();
            }, 300);
        });
    });
}


function get_postcode_info(postcode, callback) {
    $.ajax({
        url: "api/get_postcode_info.php",
        type: "POST",
        dataType: "json",
        data: ({
            postcode: postcode 
        }),
        beforeSend: function() {
            $(".preview__loading").animShow();
            $(".preview__postcode__data .wrapper").animHide();
        },
        success: function(data) {
            $(".preview__loading").animHide();

            if(data.success == true) {
                callback(data);
            } else {
                Swal.fire(
                    'Erro',
                    'Ocorreu um erro inesperado!',
                    'error'
                )
            }
        }
    });
}


function get_project_info() {
    $(".homosexuals-info").on("click", function() {
        Swal.fire({
            icon: 'info',
            title: 'Componentes',
            html: '<div>Gustavo Marmentini</div><div>Paulo Chies</div><div>Vinícius Dufloth</div><div>Vitor Carminatti</div>'
        });
    });
}
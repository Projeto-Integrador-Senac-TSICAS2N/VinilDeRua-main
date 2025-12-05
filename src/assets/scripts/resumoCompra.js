// resumoCompra.js

document.addEventListener("DOMContentLoaded", function () {

    const radios = document.querySelectorAll(".payOption");
    const inputMethod = document.getElementById("inputPayMethod");
    const form = document.getElementById("formPagamento");

    const areaPix = document.getElementById("areaPix");
    const areaCartao = document.getElementById("areaCartao");
    const areaBoleto = document.getElementById("areaBoleto");

    // Esconder tudo no início
    areaPix.style.display = "none";
    areaCartao.style.display = "none";
    areaBoleto.style.display = "none";

    radios.forEach(radio => {
        radio.addEventListener("change", () => {

            // Desmarca outros
            radios.forEach(r => {
                if (r !== radio) r.checked = false;
            });

            // Define método selecionado
            const metodo = radio.dataset.method;
            inputMethod.value = metodo;

            // Controla exibição das áreas
            areaPix.style.display = (metodo === "PIX") ? "block" : "none";
            areaCartao.style.display = (metodo === "Cartão") ? "block" : "none";
            areaBoleto.style.display = (metodo === "Boleto") ? "block" : "none";
        });
    });
});

// Enviar pagamento
function realizarPagamento() {

    const inputMethod = document.getElementById("inputPayMethod");
    const form = document.getElementById("formPagamento");

    if (!inputMethod.value) {
        alert("Escolha uma forma de pagamento.");
        return;
    }

    form.submit();
}

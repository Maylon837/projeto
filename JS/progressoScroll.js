window.onscroll = function() {
    calcularProgressoDeLeitura(); // carrega a função toda vez que o usuário rolar a pg.
    };

    function calcularProgressoDeLeitura() {
                
        const alturaTotalConteudo = document.body.scrollHeight - window.innerHeight;

        const posicaoAtual = document.documentElement.scrollTop || document.body.scrollTop;

        const porcentagemLida = (posicaoAtual / alturaTotalConteudo) * 100;

        const barraDeProgresso = document.getElementById("progressoBarra");

        if (barraDeProgresso) {
                 barraDeProgresso.style.width = porcentagemLida.toFixed(2) + "%";
            }
        }

function toggleMenu() {
    var menuOpcoes = document.getElementById("menu-opcoes");
    
    menuOpcoes.classList.toggle('active'); 
}
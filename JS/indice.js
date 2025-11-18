function alternarVisivel() {
    const indiceLateral = document.getElementById('indice-lateral');

    const botaoAlternar = document.getElementById('btn-alternar');

    indiceLateral.classList.toggle('indice-fechado');

    if (indiceLateral.classList.contains('indice-fechado')) {
        botaoAlternar.innerHTML = '&raquo;'; // se estiver fechado mostra a seta para abrir.
    } else {
        botaoAlternar.innerHTML = '&laquo;'; // se estiver aberto, mostra seta para fechar.
    }
}
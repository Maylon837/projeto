document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('avaliacaoForm');
    const mensagemSucesso = document.getElementById('mensagemSucesso');
    const jotformURL = form.getAttribute('action'); // Pega a URL de submissão do Jotform

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Impede o envio padrão (para evitar o redirecionamento)

        const formData = new FormData(form);

        // O Jotform espera o envio padrão do formulário, então usamos a formData diretamente.
        // O Jotform lida com CORS e a resposta de forma mais amigável que o Google Forms.
        
        // Esconde a mensagem anterior
        mensagemSucesso.style.display = 'none';

        fetch(jotformURL, {
            method: 'POST',
            body: formData // Envia como FormData, mais robusto para formulários de terceiros
        })
        .then(response => {
            // Jotform geralmente retorna um redirecionamento ou uma resposta simples
            // Não podemos ler a resposta real, mas o POST geralmente é suficiente
            
            // Supondo sucesso (se o fetch não falhou):
            form.reset(); // Limpa o formulário
            mensagemSucesso.style.display = 'block'; // Mostra o sucesso

            setTimeout(() => {
                mensagemSucesso.style.display = 'none';
            }, 5000); // Esconde a mensagem após 5 segundos
        })
        .catch(error => {
            console.error('Erro ao enviar para Jotform:', error);
            alert('Houve um erro no envio. Verifique sua conexão e tente novamente.');
        });
    });
});
document.addEventListener('DOMContentLoaded', () => {
  const form       = document.getElementById('meu-formulario');
  const inputNome  = document.getElementById('inputNome');
  const inputEmail = document.getElementById('inputEmail');
  const inputMensagem = document.getElementById('inputMensagem');

  form.addEventListener('submit', async event => {
    event.preventDefault();

    const payload = {
      nome:  inputNome.value,
      email: inputEmail.value,
      mensagem: inputMensagem.value
    };

    try {
      const response = await fetch('http://localhost/API-de-SMTP/API/API_SMTP.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json'},
        body: JSON.stringify(payload)
      });

      const resultado = await response.json();

      if (response.ok) {
        alert(resultado.mensagem || 'Enviado o email com Sucesso!');
       console.group('Dados do formulário');
        console.log('Nome:', resultado.data.nome);
        console.log('Email:', resultado.data.email);
        console.log('Mensagem:', resultado.data.mensagem);
        console.groupEnd();
      } else {
        alert(resultado.erro || 'Ocorreu um erro ao envair ao server SMTP.');
      }

    } catch (err) {
      console.error(err);
      alert('Não foi enviado o e-mail.');
    }
  });
});

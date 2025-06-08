document.addEventListener('DOMContentLoaded', () => {
  const form       = document.getElementById('meu-formulario');
  const inputNome  = document.getElementById('inputNome');
  const inputEmail = document.getElementById('inputEmail');

  form.addEventListener('submit', async event => {
    event.preventDefault();

    const payload = {
      nome:  inputNome.value,
      email: inputEmail.value
    };

    try {
      const response = await fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json'},
        body: JSON.stringify(payload)
      });

      const resultado = await response.json();

      if (response.ok) {
        alert(resultado.mensagem || 'Dados salvos com sucesso!');
      } else {
        alert(resultado.erro || 'Ocorreu um erro no servidor.');
      }

    } catch (err) {
      console.error(err);
      alert('Não foi possível conectar ao servidor.');
    }
  });
});

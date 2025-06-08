document.addEventListener('DOMContentLoaded', () => {
  // ————— Elementos —————
  const inputNome     = document.getElementById('inputNome');
  const inputEmail    = document.getElementById('inputEmail');
  const overlay       = document.getElementById('overlay');
  const popup         = document.getElementById('popup');
  const mensagemPopup = document.getElementById('mensagemPopup');
  const btnFechar     = document.getElementById('btnFechar');
  const form          = document.getElementById('meu-formulario');

  // ————— Estado interno —————
  let nomeJaVisto  = false;
  let emailJaVisto = false;

  // ————— Funções de popup —————
  function abrirPopup(mensagem) {
    mensagemPopup.innerText = mensagem;
    popup.style.display      = 'block';
    overlay.style.display    = 'block';
  }

  function fecharPopup() {
    popup.style.display   = 'none';
    overlay.style.display = 'none';
  }

  // ————— Listeners —————
  inputNome.addEventListener('click', () => {
    if (!nomeJaVisto) {
      abrirPopup('Digite seu nome completo');
      nomeJaVisto = true;
    }
  });

  inputEmail.addEventListener('click', () => {
    if (!emailJaVisto) {
      abrirPopup('Digite um e-mail válido');
      emailJaVisto = true;
    }
  });

  overlay.addEventListener('click', fecharPopup);
  btnFechar.addEventListener('click', fecharPopup);

  form.addEventListener('submit', event => {
    event.preventDefault();
    const nome  = inputNome.value;
    const email = inputEmail.value;
    alert(`Nome: ${nome}\nEmail: ${email}`);
    fecharPopup();
  });
});

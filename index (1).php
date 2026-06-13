<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Página com Botões</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <div class="pagina">
    <div class="imagem-fundo">
      <div class="botoes">
        <button class="btn sim" onclick="window.location.href='resultado.php'">Qualquer um menos o Angelo</button>
        <button class="btn nao" id="btnNao" disabled>Angelo</button>
      </div>
    </div>
  </div>

  <audio id="musicaFundo" src="fundobom.mp3" loop autoplay></audio>

  <script>
    // ── Música de fundo ──
    const musicaFundo = document.getElementById('musicaFundo');
    musicaFundo.play().catch(() => {
      document.addEventListener('click', () => musicaFundo.play(), { once: true });
    });

    const btnNao = document.getElementById('btnNao');
    const nomes = ['Andreu', 'Isadora', 'Gabriela', 'Zoé'];

    // ── Botão foge ──
    btnNao.addEventListener('mouseenter', () => {
      const margem = 60;
      const maxX = window.innerWidth  - btnNao.offsetWidth  - margem;
      const maxY = window.innerHeight - btnNao.offsetHeight - margem;

      const x = Math.random() * (maxX - margem) + margem;
      const y = Math.random() * (maxY - margem) + margem;

      btnNao.style.position = 'fixed';
      btnNao.style.left = x + 'px';
      btnNao.style.top  = y + 'px';

      // ── Palavra que sobe do fundo da tela ──
      const nome = nomes[Math.floor(Math.random() * nomes.length)];

      const palavra = document.createElement('div');
      palavra.className = 'palavra-fundo';
      palavra.textContent = nome;

      palavra.style.left = (20 + Math.random() * 60) + '%';
      document.body.appendChild(palavra);

      palavra.getBoundingClientRect();
      palavra.classList.add('subindo');

      setTimeout(() => palavra.remove(), 900);
    });
  </script>
</body>
</html>
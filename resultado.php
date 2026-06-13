
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Resultado</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    html, body {
      width: 100%; height: 100%;
      overflow: hidden;
    }

    .bg {
      position: fixed;
      inset: 0;
      background-image: url('fotos/fundo2.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      z-index: 0;
    }

    /* Overlay vermelho sangue */
    #sangue {
      position: fixed;
      inset: 0;
      background: #8b0000;
      opacity: 0;
      z-index: 500;
      pointer-events: none;
    }

    /* Contador */
    #contador {
      position: fixed;
      top: 22px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 999;
      font-family: 'Courier New', Courier, monospace;
      font-size: 3rem;
      font-weight: 900;
      color: #ff2020;
      letter-spacing: 0.18em;
      pointer-events: none;
      text-shadow:
        0 0 10px #ff0000,
        0 0 30px #cc0000,
        0 0 60px #880000,
        2px 2px 4px #000;
      animation: pisca 1s ease-in-out infinite;
    }

    @keyframes pisca {
      0%, 100% { opacity: 1; text-shadow: 0 0 10px #ff0000, 0 0 30px #cc0000, 0 0 60px #880000, 2px 2px 4px #000; }
      50%       { opacity: 0.75; text-shadow: 0 0 4px #ff0000, 0 0 12px #880000, 2px 2px 4px #000; }
    }

    /* Pop-up */
    .popup {
      position: fixed;
      z-index: 10;
      background: #f5e6cf;
      border: 6px solid #c9a97a;
      border-radius: 18px;
      padding: 28px 44px;
      text-align: center;
      box-shadow: 0 8px 32px rgba(0,0,0,0.22);
      min-width: 220px;
      animation: popIn 0.25s cubic-bezier(.36,1.56,.64,1) forwards;
    }

    .popup .titulo {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-size: 1.6rem;
      font-weight: 900;
      color: #3b2409;
      margin-bottom: 20px;
      letter-spacing: 0.02em;
    }

    .popup .ok-btn {
      display: inline-block;
      background: #1a0a00;
      border: 3px solid #5c1a1a;
      border-radius: 6px;
      padding: 10px 32px;
      font-size: 1.15rem;
      font-weight: 900;
      font-family: 'Courier New', Courier, monospace;
      color: #c9a97a;
      letter-spacing: 0.18em;
      cursor: pointer;
      text-transform: uppercase;
      box-shadow:
        0 0 8px rgba(180, 30, 30, 0.6),
        inset 0 0 12px rgba(180, 30, 30, 0.15);
      text-shadow: 0 0 6px rgba(200, 80, 80, 0.7);
      transition: background 0.15s, box-shadow 0.15s, color 0.15s;
    }

    .popup .ok-btn:hover {
      background: #2e0a0a;
      color: #fff0d0;
      box-shadow:
        0 0 18px rgba(200, 40, 40, 0.9),
        inset 0 0 16px rgba(200, 40, 40, 0.2);
    }

    .popup .ok-btn:active { transform: scale(0.96); }

    .popup.fechando {
      animation: popOut 0.2s ease forwards;
    }

    /* Tela de susto */
    #susto {
      position: fixed;
      inset: 0;
      z-index: 9999;
      background: #000;
      display: none;
      align-items: center;
      justify-content: center;
    }

    #susto img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    @keyframes popIn {
      from { opacity: 0; transform: scale(0.5); }
      to   { opacity: 1; transform: scale(1); }
    }

    @keyframes popOut {
      from { opacity: 1; transform: scale(1); }
      to   { opacity: 0; transform: scale(0.6); }
    }
  </style>
</head>
<body>

  <div class="bg"></div>
  <div id="sangue"></div>
  <div id="contador">1:30</div>

  <!-- Tela de susto -->
  <div id="susto">
    <img src="fotos/susto.png" alt="susto" />
  </div>

  <audio id="musica"     src="musica.mp3"  loop autoplay></audio>
  <audio id="audioSusto" src="susto.mp3"></audio>

  <script>
    // ── Abre Maps ──
    window.open('https://www.google.com.br/maps/place/R.+Gen.+Hip%C3%B3lito,+4016+-+Centro,+Uruguaiana+-+RS,+97502-560/@-29.7638266,-57.0729879,3a,75y,179.56h,89.92t/data=!3m7!1e1!3m5!1sama593fZTaf1fpa4le0Rmg!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D0.07653938323409193%26panoid%3Dama593fZTaf1fpa4le0Rmg%26yaw%3D179.55825666895618!7i16384!8i8192!4m6!3m5!1s0x94535b137f88f42d:0xe6841d59109b056f!8m2!3d-29.7639576!4d-57.0730035!16s%2Fg%2F11n129y_lj?entry=ttu&g_ep=EgoyMDI2MDYxMC4wIKXMDSoASAFQAw%3D%3D', '_blank');

    // ── Música de fundo ──
    const audio = document.getElementById('musica');
    audio.play().catch(() => {
      document.addEventListener('click', () => audio.play(), { once: true });
    });

    // ── Contagem regressiva + vermelho ──
    const totalSegundos = 30; // 0:30
    let segundosRestantes = totalSegundos;
    const sangue   = document.getElementById('sangue');
    const contador = document.getElementById('contador');

    function atualizarCor() {
      const progresso = 1 - (segundosRestantes / totalSegundos);
      sangue.style.opacity = progresso.toFixed(4);
    }

    function formatarTempo(s) {
      const m = Math.floor(s / 60);
      const seg = s % 60;
      return m + ':' + String(seg).padStart(2, '0');
    }

    const timer = setInterval(() => {
      segundosRestantes--;
      contador.textContent = formatarTempo(segundosRestantes);
      atualizarCor();

      if (segundosRestantes <= 0) {
        clearInterval(timer);
        dispararSusto();
      }
    }, 1000);

    // ── Susto ──
    function dispararSusto() {
      const susto = document.getElementById('susto');
      const audioSusto = document.getElementById('audioSusto');

      // para música de fundo
      audio.pause();

      // mostra imagem e toca susto.mp3
      susto.style.display = 'flex';
      audioSusto.play().catch(() => {});

      // após 2 segundos redireciona
      setTimeout(() => {
        window.location.href = 'index.php';
      }, 2000);
    }

    // ── Popups ──
    let zCounter = 20;

    function criarPopup() {
      const popup = document.createElement('div');
      popup.className = 'popup';
      popup.innerHTML = `
        <div class="titulo">apenas angelo.</div>
        <div class="ok-btn">OK</div>
      `;

      const maxX = window.innerWidth  - 300;
      const maxY = window.innerHeight - 180;
      popup.style.left = (10 + Math.random() * Math.max(maxX - 10, 10)) + 'px';
      popup.style.top  = (10 + Math.random() * Math.max(maxY - 10, 10)) + 'px';
      popup.style.zIndex = zCounter++;

      popup.querySelector('.ok-btn').addEventListener('click', () => {
        popup.classList.add('fechando');
        setTimeout(() => popup.remove(), 200);
      });

      document.body.appendChild(popup);
    }

    criarPopup();
    let intervalo = 1800;

    function loop() {
      criarPopup();
      intervalo = Math.max(350, intervalo - 120);
      setTimeout(loop, intervalo);
    }

    setTimeout(loop, intervalo);
  </script>
</body>
</html>
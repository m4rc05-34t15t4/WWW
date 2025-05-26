<div id="content-projetos" class="d-flex flex-column flex-wrap">

  <h1>📁 Marcos Batista - Projetos</h1>

  <div class="grid" id="folderGrid">
    <!-- Cards serão inseridos via JS -->
  </div>

  <script>
    const pastas = [
      { nome: "Carteira Crypto", link: "crypto/" },
      { nome: "Compras Nota", link: "compras_nota/" },
      { nome: "TradeGun", link: "tradegun/" },
      { nome: "Dental System", link: "dentalsystem/" },
      { nome: "Dominó Placar", link: "domino_placar/" },
      { nome: "Canil", link: "canil/" }
      
    ];

    const svgIcon = `
      <svg viewBox="0 0 24 24">
        <path d="M10 4H4C2.9 4 2 4.9 2 6V18C2 
                 19.1 2.9 20 4 20H20C21.1 20 22 
                 19.1 22 18V8C22 6.9 21.1 6 20 
                 6H12L10 4Z" />
      </svg>`;

    const grid = document.getElementById("folderGrid");

    pastas.forEach(pasta => {
      const card = document.createElement("a");
      card.className = "card";
      card.href = pasta.link;
      card.target = "_blank";
      card.innerHTML = `${svgIcon}<span>${pasta.nome}</span>`;
      grid.appendChild(card);
    });
  </script>

  </div>

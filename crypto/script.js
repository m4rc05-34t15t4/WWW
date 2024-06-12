document.addEventListener('DOMContentLoaded', function() {
    const cryptoContainer = document.getElementById('crypto-container');

    // Função para recarregar a página a cada 30 segundos (30000 milissegundos)
    function autoReload() {
        setTimeout(function(){
            location.reload();
        }, 60000); // 30 segundos
    }

    // Função para obter parâmetros da URL
    function getUrlParams() {
        const params = new URLSearchParams(window.location.search);
        const cryptos = params.get('cryptos') ? params.get('cryptos').split(',') : [];
        const purchasePrices = params.get('prices') ? params.get('prices').split(',').map(Number) : [];
        const montantes = params.get('montantes') ? params.get('montantes').split(',').map(Number) : [];
        const currency = params.get('currency') && params.get('currency').length > 2 ? String(params.get('currency')) : 'usd';
        return { cryptos, purchasePrices, montantes, currency };
    }

    // Função para calcular a variação percentual do lucro
    function calculateProfitPercentage(currentPrice, purchasePrice) {
        return ((currentPrice - purchasePrice) / purchasePrice * 100).toFixed(2);
    }

    // Função para definir o fundo com base na variação percentual
    function getBackgroundColor(profitPercentage) {
        let color;
        if (profitPercentage > 0) color = 'linear-gradient(135deg, #33ff33, #336633)';
        else color = 'linear-gradient(135deg, #ff9966, #cc1133)';
        return color;
    }

    const fetchCryptoData = async () => {
        const { cryptos, purchasePrices, montantes, currency } = getUrlParams();

        if (cryptos.length === 0 || purchasePrices.length === 0 || montantes.length === 0 || cryptos.length !== purchasePrices.length || cryptos.length !== montantes.length || !currency) {
            cryptoContainer.innerHTML = '<p>Por favor, forneça parâmetros válidos na URL.<br>(cryptos, currency, prices, montantes)</p>';
            return;
        }

        try {
            // Fetch basic price data
            const response = await fetch(`https://api.coingecko.com/api/v3/simple/price?ids=${cryptos.join(',')}&vs_currencies=${currency}`);
            const data = await response.json();
            console.log(data);

            // Fetch metadata for icons
            const metadataResponse = await fetch(`https://api.coingecko.com/api/v3/coins/markets?vs_currency=${currency}&ids=${cryptos.join(',')}`);
            const metadata = await metadataResponse.json();
            const icons = metadata.reduce((acc, coin) => {
                acc[coin.id] = coin.image;
                return acc;
            }, {});

            cryptos.forEach((crypto, index) => {
                const currentPrice = data[crypto][currency];
                const purchasePrice = purchasePrices[index];
                const montante = montantes[index];
                const profitPercentage = calculateProfitPercentage(currentPrice, purchasePrice);
                //const profitValue = ((currentPrice - purchasePrice) * montante).toFixed(2);

                const cryptoElement = document.createElement('div');
                cryptoElement.className = 'crypto';
                cryptoElement.style.background = getBackgroundColor(profitPercentage);
                cryptoElement.innerHTML = `
                    <h3>${crypto.charAt(0).toUpperCase() + crypto.slice(1)}</h3>
                    <img src="${icons[crypto]}" alt="${crypto} icon">
                    <h5>${currentPrice} ${currency.toUpperCase()}</h5>
                    <p>Preço Médio: ${purchasePrice} ${currency.toUpperCase()}</p>
                    <p>Montante: ${montante}</p>
                    <p>Lucro: <b style="font-size: 14px">${profitPercentage}%</b></p>
                `;
                cryptoElement.addEventListener('click', () => {
                    window.open(`https://www.coingecko.com/en/coins/${crypto}#panel`, '_blank');
                });
                cryptoContainer.appendChild(cryptoElement);
            });
        } catch (error) {
            console.error('Erro ao buscar dados da API do CoinGecko', error);
            cryptoContainer.innerHTML = '<p>Erro ao carregar dados, muitas requesições, espere e tente novamente</p>';
        }
    };

    fetchCryptoData();

    window.onload = autoReload;
});

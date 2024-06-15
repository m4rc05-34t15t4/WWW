document.addEventListener('DOMContentLoaded', function() {

    $PERMISSAO_RELOAD = true;

    const cryptoContainer = document.getElementById('crypto-container');

    // Função para recarregar a página a cada 30 segundos (30000 milissegundos)
    function autoReload() {
        setTimeout(function(){
            if($PERMISSAO_RELOAD) location.reload();
        }, 60000); // 60 segundos
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

        if (cryptos.length === 0 || (purchasePrices.length > 0 && cryptos.length !== purchasePrices.length) || (montantes.length > 0 && cryptos.length !== montantes.length) || !currency) {
            cryptoContainer.innerHTML = '<p class="my-5">Por favor, forneça parâmetros válidos na URL.<br>(cryptos, currency, prices, montantes)</p>';
            const newUrl = `${window.location.origin}${window.location.pathname}?cryptos=bitcoin,ethereum&prices=&montantes=&currency=usd`;
            window.location.href = newUrl;
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

            $('#titulo-container').html(`Cotações de Criptomoedas (${currency.toUpperCase()})`);

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
                    <h5>${currentPrice}</h5>
                    ${purchasePrice > 0 || montante > 0 || profitPercentage > 0 ? '<hr>' : ''}
                    ${purchasePrice > 0 ? '<p>Preço Médio: '+purchasePrice+'</p>' : ''}
                    ${montante > 0 ? '<p>Montante: '+montante+'</p>' : ''}
                    ${profitPercentage > 0 ? '<p>Lucro: <b style="font-size: 14px">'+profitPercentage+'%</b></p>' : ''}
                `;

                cryptoElement.addEventListener('click', () => {
                    window.open(`https://www.coingecko.com/en/coins/${crypto}#panel`, '_blank');
                });
                cryptoContainer.appendChild(cryptoElement);
            });
        } catch (error) {
            console.error('Erro ao buscar dados da API do CoinGecko', error);
            cryptoContainer.innerHTML = '<p>Erro ao carregar dados,talvez muitas requesições ou parâmetros errados, espere e tente novamente</p>';
        }
    };

    function criar_row_form(cryptoTableBody, i="", c="", p="", m=""){
        const row = document.createElement('tr');
        row.setAttribute('nr_index', i);
        row.setAttribute('draggable', true);
        row.innerHTML = `
            <td><input type="text" class="form-control" name="cryptos[]" value="${c}"></td>
            <td><input type="text" class="form-control" name="prices[]" value="${p}"></td>
            <td><input type="text" class="form-control" name="montantes[]" value="${m}"></td>
            <td><button id="bt-del-row-form-${i}" nr_index="${i}" type="button" class="bt-del-row-form btn-close"></button></td>
        `;
        cryptoTableBody.appendChild(row);

        $(`#bt-del-row-form-${i}`).click(function(){
            console.log('d', $(this).attr("nr_index"));
            $(`tr[nr_index=${i}]`).remove();

        });
    }

    function open_form_new_crypto(){

        const { cryptos, purchasePrices, montantes, currency } = getUrlParams();
        const cryptoTableBody = document.getElementById('cryptoTableBody');
        cryptoTableBody.innerHTML='';
        cryptos.forEach((crypto, index) => {
            criar_row_form(cryptoTableBody, index, crypto, purchasePrices[index], montantes[index]);
        });
        $("#addRow").attr("nr_index", cryptos.length);
        $("#form-crypto-select").val(currency.toLowerCase());

        const table = document.getElementById('draggableTable');
        let draggedRow = null;

        table.addEventListener('dragstart', (event) => {
            draggedRow = event.target;
            event.target.classList.add('dragging');
        });

        table.addEventListener('dragend', (event) => {
            event.target.classList.remove('dragging');
            draggedRow = null;
        });

        table.addEventListener('dragover', (event) => {
        event.preventDefault();
        const target = event.target.closest('tr');
        if (target && target !== draggedRow) {
            const rect = target.getBoundingClientRect();
            const next = (event.clientY - rect.top) / (rect.bottom - rect.top) > 0.5;
            table.querySelector('tbody').insertBefore(draggedRow, next && target.nextSibling || target);
        }
        });
    }

    //EVENTOS

    $('#addRow').click(function () {
        $nr_index = parseInt($("#addRow").attr("nr_index")) + 1;
        const cryptoTableBody = document.getElementById('cryptoTableBody');
        criar_row_form(cryptoTableBody, $nr_index);
        $("#addRow").attr("nr_index", $nr_index);
    });

    $("#bt-form-salvar-cryptos").click(function () {
    
        const cryptos = Array.from(document.querySelectorAll('input[name="cryptos[]"]')).map(input => input.value);
        const prices = Array.from(document.querySelectorAll('input[name="prices[]"]')).map(input => input.value);
        const montantes = Array.from(document.querySelectorAll('input[name="montantes[]"]')).map(input => input.value);
        const currency = $("#form-crypto-select").val();

        const newUrl = `${window.location.origin}${window.location.pathname}?cryptos=${cryptos.join(',')}&prices=${prices.join(',')}&montantes=${montantes.join(',')}&currency=${currency}`;
        //console.log('h', cryptos, prices, montantes, currency, newUrl);
        window.location.href = newUrl;
    });

    $("#botao_form_crypto").click(function(){
        open_form_new_crypto();
        $PERMISSAO_RELOAD = false;
    });

    $("#botao_refresh").click(function(){
        window.location.reload();
    });

    $(".btn-close").click(function(){
        $PERMISSAO_RELOAD = true;
    });


    fetchCryptoData();
    
    window.onload = autoReload;
});

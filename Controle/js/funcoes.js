//Pegar variaveis get na url -> retorna um MAP -> se sem variaveis retorna -1
function Get_url_variaveis(){
    if(String(location).indexOf("?") > 0){
        $url = location.search.slice(1);
        $url_map = new Map();
        if($url.indexOf("&") > 0){
            $get_urls = $url.split('&');
            $get_urls.forEach(function(valor, $key){
                $array = valor.split('=');
                $url_map.set($array[0], $array[1]);
            })
        }
        else{
            $array = $url.split('=');
            $url_map.set($array[0], $array[1]);
        }
        return $url_map;
    }
    return -1;
}

//Converte px -> pt
function Converte_px_pt(valor){
    $tipo = (typeof valor);
    if($tipo == "string"){
        if(valor.indexOf("px")){
            valor = valor.replace('px', '');
        }
        valor = parseInt(valor);
    }
    valor = valor * 0.752929;
    return valor;
}

//recarrega_pagina
function recarregarPagina(){
    // Sem redimencionamento à 100ms!
    location.reload();
}

//recarrega a pagina 
function Recarregar_pagina_resize(){
    var time;
    window.onresize = function(){
    clearTimeout(time);
    time = setTimeout(recarregarPagina, 10);
    };
}

//Verifica se arquivo existe passando a url com nome e extenção
function Existe(url) {
    $http = new XMLHttpRequest();
    $http.open('HEAD', url, false);
    $http.send();
    return $http.status != 404;
 }
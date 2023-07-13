//VALIDA CARACTERE
function checkChar(e, pattern, max = 0, val = 0) {
    max--;
    if (String.fromCharCode(e.keyCode).match(pattern) && (max < 0 || max >= val.length)) {
        return true;
    }
}
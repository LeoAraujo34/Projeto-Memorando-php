function apenasNumeros(campo) {
    campo.value = campo.value.replace(/\D/g, '');
}

function formata(campo, mascara) {
    let valor = campo.value.replace(/\D/g, '');
    let resultado = '';
    let indiceValor = 0;

    for (let i = 0; i < mascara.length && indiceValor < valor.length; i++) {
        if (mascara[i] === '#') {
            resultado += valor[indiceValor];
            indiceValor++;
        } else {
            resultado += mascara[i];
        }
    }

    campo.value = resultado;
}

function artGanancia()
{
    var costo = parseFloat(document.getElementById("artprcosto").value);
    var venta = parseFloat(document.getElementById("artprventa").value);
    var ganancia = parseFloat(document.getElementById("artganancia").value);
    venta = (costo * ganancia / 100) + costo;
    document.getElementById("artprventa").value = venta.toFixed(2);	
}


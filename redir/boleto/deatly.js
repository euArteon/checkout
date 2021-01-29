let ajaxOrder = new XMLHttpRequest;
ajaxOrder.open('GET','https://deatly.com/checkout/lib/php/get_order.php');
ajaxOrder.onload = function(){
    if(ajaxOrder.status === 200 && ajaxOrder.readyState === 4){
        jsonOrder = JSON.parse(ajaxOrder.response);
        console.log(jsonOrder);
        document.querySelector('#order').innerHTML = jsonOrder[0].order;
    }else{
        console.log('Não foi possível realizar a requisição. Status => ' + ajaxOrder.status + ' readyState => ' + ajaxOrder.readyState)
    }
} 
ajaxOrder.send();

let barcode = document.querySelector('.barcode');
let copyBarCode = document.querySelector('.copybarcode');

copyBarCode.onclick = () => {
    barcode.style.display = "block";
    barcode.select();
    document.execCommand('copy');
    barcode.style.display = "none";
    alert('Código de barras copiado com sucesso.')
}

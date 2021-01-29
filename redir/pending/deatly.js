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

let payInf = document.querySelector('.payment-infos');
let copyPayInf = document.querySelector('.copy-payment-infos');

copyPayInf.onclick = () => {
    payInf.style.display = "block";
    payInf.select();
    document.execCommand('copy');
    payInf.style.display = "none";
    alert('Infomações copiadas com sucesso. Lembre-se que você também receberá um email com todas essas informações.')
}


(function(win,doc){
    //Public Key
    "use strict";
    window.Mercadopago.setPublishableKey("APP_USR-3e4df7af-4181-4f12-8a1d-a36b83dc9fa3");
    
    //Get Document Types
    window.Mercadopago.getIdentificationTypes();

    //Card bin
        // Verifica se o id do input existe. Se existe, atributui a ele um addEventListener de key up, que dispara uma função que verifica a quantidade de números informados no input. Essa função vai disparar 
    function cardBin(event){
        let textLength = event.target.value.length;
        if(textLength >= 6){
            let bin = event.target.value.substring(0,6);
            window.Mercadopago.getPaymentMethod({"bin": bin
        }, setPaymentMethod);        
        //Get Installments
        window.Mercadopago.getInstallments({
            "bin": bin,
            "amout": parseFloat(document.querySelector('#transactionAmount').value),
            },setInstallments);            
        }
    }

    if(document.querySelector('#cardNumber')){
        let cardNumber = document.querySelector('#cardNumber');
        cardNumber.addEventListener('keyup',cardBin,false);
    }
 
       
    //Set Payment 
        //Faz requisição http apra pegar a bandeira e em seguida já define o valor do id da bandeira no respectivo input.
    function setPaymentMethod(status, response) {
        if (status == 200) {
            const paymentMethodElement = document.querySelector('input[name=paymentMethodId]');
            paymentMethodElement.value=response[0].id;
            let brandings = document.querySelectorAll('[data-branding');
            let getMet = document.querySelector('#paymentMethodId');
            for (let i = 0; i < brandings.length; i++){
                brandings[i].style.opacity = "0.3";
                if (brandings[i].dataset.branding == getMet.value){
                    brandings[i].style.transition = ".6s";
                    brandings[i].style.opacity = "1";
                }
            }
        }else {
            alert('payment methodo info error: ${response}');
        }
    };
    
    //Set Installments
    function setInstallments(status, response){
        document.querySelector('#instgrid').style.display = 'inline-block';
        console.log(response);
        let label = response[0].payer_costs;
        document.getElementById('installments').options.length = 0;
        let installmentsSel = document.querySelector('#installments');
        label.map(function(elem,ind,obj){
            let getPrice = cart_total.innerHTML.replace(',','.');
            let getJuros = elem.installment_rate;
            let dif = ((getPrice * getJuros) / 100).toFixed(2);
            let totalvalue = (parseFloat(getPrice) + parseFloat(dif)).toFixed(2);
            let installvalue = (parseFloat(totalvalue) / elem.installments).toFixed(2);
            let txtOpt = elem.installments+'x de R$ '+installvalue.replace('.',',')+' (R$ '+totalvalue.replace('.',',')+')';
            let valOpt = elem.installments;
            installmentsSel.options[installmentsSel.options.length] = new Option (txtOpt,valOpt);
        })
     }
     
     //Create Token
     
     function sendPayment(event){
         insertValues();
         event.preventDefault();
         let mtd = document.querySelector('#mtd');
         if(mtd.value == 'cartao'){
            window.Mercadopago.createToken(event.target, setCardTokenAndPay,false);
         }else if(mtd.value == 'boleto'){
            let form = document.getElementById('paymentForm');
            form.submit();
         }
     }
     
     function setCardTokenAndPay(status, response){
        if (status == 200 || status == 201) {
            let form = document.getElementById('paymentForm');
            let card = document.createElement('input');
            card.setAttribute('name', 'token');
            card.setAttribute('type', 'text');
            card.setAttribute('value', response.id);
            form.appendChild(card);     
            form.submit();
        } else {
            document.querySelector('#processando').style.display = 'none';
            alert("Verify filled data!\n"+JSON.stringify(response, null, 4));
        }
     };

     if(document.querySelector('#paymentForm')){
         let formPay = document.querySelector('#paymentForm');
         formPay.addEventListener('submit',sendPayment,false)
     }

     function insertValues(){
        document.querySelector('#process-msg').innerHTML = '<p>Estamos processando seu pagamento.<br/>Não feche esta tela.</p>';
        document.querySelector('#processando').style.display = 'block';
        document.querySelector('#transactionAmount').value = document.querySelector('#cart-total').innerHTML.replace(',','.');
        fbq('trackCustom','Finished', {content_type: 'product', content_ids: content_id})
        document.querySelector('#v1v').value = document.querySelector('#solo-black').value;
        document.querySelector('#v2v').value = document.querySelector('#solo-wine').value;
        document.querySelector('#v3v').value = document.querySelector('#solo-pink').value;
        document.querySelector('#v4v').value = document.querySelector('#solo-blue').value;
        document.querySelector('#v5v').value = document.querySelector('#solo-flower').value;
        document.querySelector('#v1n').value = document.querySelector('#var1-name').innerHTML;
        document.querySelector('#v2n').value = document.querySelector('#var2-name').innerHTML;
        document.querySelector('#v3n').value = document.querySelector('#var3-name').innerHTML;
        document.querySelector('#v4n').value = document.querySelector('#var4-name').innerHTML;
        document.querySelector('#v5n').value = document.querySelector('#var5-name').innerHTML;
     }

})(window,document)
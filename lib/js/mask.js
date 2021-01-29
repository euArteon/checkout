//Name Input
let nameInput = document.querySelector('[data-form="name"]')
nameInput.addEventListener('keyup', () => {
    if(nameInput.value.length == 1){
        fbq('trackCustom','InitName', {content_type: 'product', content_ids: content_id})
    }
})

nameInput.addEventListener('focusout',()=> {
    if(nameInput.value != ''){
        fbq('trackCustom','FinishName', {content_type: 'product', content_ids: content_id})
    }
})

//Email Input
let emailInput = document.querySelector('[data-form="email"]')

emailInput.addEventListener('keyup', () => {
    if(emailInput.value.length == 1){
        fbq('trackCustom','InitEmail', {content_type: 'product', content_ids: content_id})
    }
})

emailInput.addEventListener('focusout', () => {
    if(emailInput.value != ''){
        fbq('trackCustom','FinishEmail', {content_type: 'product', content_ids: content_id})
    }
})

//Phone Input
let phone = document.querySelector('[data-form="phone"]');
phone.addEventListener('keyup',formatPhone);
function formatPhone(){
    phone.value = phone.value.replace(/\D/g,'');
    phone.value = phone.value.replace(/(\d{2})/,'($1) ');
    phone.value = phone.value.replace(/(\d{5})(\d)/,'$1-$2');
    cpf.value = cpf.value.replace(/(-\d{4})\d+?$/,'$1');

    if(phone.value.length == 1){
        fbq('trackCustom','InitPhone', {content_type: 'product', content_ids: content_id})
    }

    if(phone.value.length == 15){
            fbq('trackCustom','FinishPhone', {content_type: 'product', content_ids: content_id})
            broken_area = phone.value.split(' ');
            clear_area_first = broken_area[0].replace(/\(/g,'');
            area = clear_area_first.replace(/\)/g,'');
            clear_number = broken_area[1].replace(/\-/g,'');
            document.querySelector('#area').value = area;
            document.querySelector('#clear_number').value = clear_number;
        }
    }

//Cpf Input
let cpf = document.querySelector('#document');
cpf.addEventListener('keyup', formatCPF);
function formatCPF(){
    cpf.value = cpf.value.replace(/\D/g,'');
    cpf.value = cpf.value.replace(/(\d{3})(\d)/,'$1.$2');
    cpf.value = cpf.value.replace(/(\d{3})(\d)/,'$1.$2');
    cpf.value = cpf.value.replace(/(\d{3})(\d{1,2})/,'$1-$2');
    cpf.value = cpf.value.replace(/(-\d{2})\d+?$/,'$1');
    if(cpf.value.length == 1){
        fbq('trackCustom','InitCPF', {content_type: 'product', content_ids: content_id})
    }
    if(cpf.value.length == 14){
        fbq('trackCustom','FinishCPF', {content_type: 'product', content_ids: content_id})
        getCPF =  cpf.value;
        dots = getCPF.replace(/\./g,'');
        dash = dots.replace(/\-/g,'');
        document.querySelector('#docNumber').value = dash;
    }
}

//Zip Input
let cep = document.querySelector('#cep');
cep.addEventListener('keyup', formatCEP);
let infoCEP;
function formatCEP(){
    if (cep.value.length == 1){
        fbq('trackCustom','InitCEP', {content_type: 'product', content_ids: content_id})
    }

    if (cep.value.length == 5){
        cep.value += '-';
    }
    if (cep.value.length == 9){
        document.querySelector('#process-msg').innerHTML = 'Buscando endereço'
        document.querySelector('#processando').style.display = 'block';        
        fbq('trackCustom','FinishCEP', {content_type: 'product', content_ids: content_id})
        getCEP = cep.value;
        dash = getCEP.replace(/\-/g,'');
        document.querySelector('#zip').value = dash;
        zip = document.querySelector('#zip'); 
        ajaxCEP = new XMLHttpRequest;
        ajaxCEP.open('GET', 'https://viacep.com.br/ws/'+zip.value+'/json/unicode/');
        ajaxCEP.onloadend = function (){
            if(ajaxCEP.status === 200 && ajaxCEP.readyState === 4){
                document.querySelector('#processando').style.display = 'none'; 
                jsonResponse = JSON.parse(ajaxCEP.responseText);
                infoCEP = jsonResponse;
                let street = document.querySelector('#street');
                let complement = document.querySelector('#complement');
                let neighborhood = document.querySelector('#neighborhood');
                let city = document.querySelector('#city');
                let state = document.querySelector('#state');
                let number = document.querySelector('#number');
                street.value = infoCEP.logradouro;
                complement.value = infoCEP.complemento;
                neighborhood.value = infoCEP.bairro;
                city.value = infoCEP.localidade;
                state.value = infoCEP.uf;
                let afterCEP = document.querySelectorAll('.afterCEP');
                for(i=0; i < afterCEP.length; i++){
                   afterCEP[i].style.display = "inline-block";
                   afterCEP[i].style.opacity = "1";
                }
                number.focus();
             } else{
                 console.log('Houve um problema na requisição de CEP');
                 console.log(ajaxCEP.status);
                 console.log(ajaxCEP.readyState);
             }
         }
         ajaxCEP.send();
    }    
}


//Card Number Input
let cardNumber = document.querySelector('[data-checkout="cardNumber"]');
cardNumber.addEventListener('keyup', formatCardNumber);
function formatCardNumber(){
    formated = cardNumber.value.replace(" ","");
    cardNumber.value = formated;
    if (cardNumber.value.length == 1){
        fbq('track','AddPaymentInfo', {content_type: 'product', content_ids: content_id});
    }
}

//Moth and Year Validation Input
let cardExp = document.querySelector('#cardExpiration');
cardExp.addEventListener('keyup',formatCardExp);
function formatCardExp(){
    if (cardExp.value.length == 2){
        cardExp.value += '/';
    }
    if (cardExp.value.length == 5){
        tobreak = cardExp.value.split('/');
        document.querySelector('#cardExpirationMonth').value = tobreak[0];
        document.querySelector('#cardExpirationYear').value = tobreak[1];
    }
}
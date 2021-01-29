
/* Search */
let ajax = new XMLHttpRequest;
ajax.open('GET','https://deatly.com/checkout/lib/php/get_cart.php');
ajax.onload = function(){
   if(ajax.status === 200 && ajax.readyState === 4){
      jsonResponse = JSON.parse(ajax.responseText);
      for (let i=0; i<jsonResponse.length; i++){
         if (jsonResponse[i].id == product_id){
            let product = jsonResponse[i];
            console.log(product);
            ajaxResponse = product;
            document.querySelector('#var1-name').innerHTML = product.var1_name;
            if (product.var2_name == 'esgotado'){
              document.querySelector('#sel-var2').style.display = 'none'
            }else{ 
              document.querySelector('#var2-name').innerHTML = product.var2_name
            }            
            if (product.var3_name == 'esgotado'){
              document.querySelector('#sel-var3').style.display = 'none'
            }else{ 
              document.querySelector('#var3-name').innerHTML = product.var3_name
            }
            if (product.var4_name == 'esgotado'){
              document.querySelector('#sel-var4').style.display = 'none'
            }else{ 
              document.querySelector('#var4-name').innerHTML = product.var4_name
            }
            if (product.var5_name == 'esgotado'){
              document.querySelector('#sel-var5').style.display = 'none'
            }else{ 
              document.querySelector('#var5-name').innerHTML = product.var5_name
            } 
            document.querySelector('#cart-unitprice').innerHTML = product.price.replace('.',',');
            document.querySelector('#product-name').innerHTML = product.product_name;
            document.querySelector('#description').value = product.product_description;
         }else{
           console.log('Não foi possível localizar o id do produto');
         }
      }
   }else{
      console.log('Não foi possível realizar a requisição. Status => ' + ajax.status + ' readyState => ' + ajax.readyState)
   }
}
ajax.send()
let ajaxResponse;
/* document.querySelector('.details-three-content-img').innerHTML = '<img src='+ajaxResponse.var1_img+'alt="" srcset="">'; */

/* Search /*/

/* Obter parâmetros get ID e QUANTITY do url; */
let query = location.search.slice(1);
let partes = query.split('&');
var data = {};
partes.forEach(function (parte) {
    let chaveValor = parte.split('=');
    let chave = chaveValor[0];
    let valor = chaveValor[1];
    data[chave] = valor;
});

quantity = document.querySelector('#qtd');
let var1 = document.querySelector('#solo-black');
let var2 = document.querySelector('#solo-wine');
let var3 = document.querySelector('#solo-pink');
let var4 = document.querySelector('#solo-blue');
let var5 = document.querySelector('#solo-flower');
quantity.innerHTML = soma();
document.querySelector('#pdt_id').value = data.id;
document.querySelector('#send-order').style.background = '#'+data.color;
document.querySelector('#sec-bar').style.background = '#'+data.color;
document.querySelector('[data-btnsec]').style.background = '#'+data.color;
let product_id = data.id;
let content_id = data.id;
if (data.v1){
  var1.value = data.v1;
}
if (data.v2){
  var2.value = data.v2;
}
if (data.v3){
  var3.value = data.v3;
}
if (data.v4){
  var4.value = data.v4;
}
if (data.v5){
  var5.value = data.v5;
}


function singleShow(){
  setTimeout(() => document.querySelector('[data-total]').innerHTML = soma(), 1);
  setTimeout(() => document.querySelector('[data-totaldetails').innerHTML = soma(), 1);
}

setTimeout(() => {
  if (ajaxResponse.var1_name == data.solo){    
    var1.value = data.solov;
    singleShow();
    document.querySelector('.details-three-content-img').innerHTML = '<img src='+ajaxResponse.var1_img+'>';
  }
}, 1000);

setTimeout(() => {
if (ajaxResponse.var2_name == data.solo){
  var2.value = data.solov;
  singleShow();
  document.querySelector('.details-three-content-img').innerHTML = '<img src='+ajaxResponse.var2_img+'>';
  }
}, 1000);

setTimeout(() => {
if (ajaxResponse.var3_name == data.solo){
  var3.value = data.solov;
  singleShow();
  document.querySelector('.details-three-content-img').innerHTML = '<img src='+ajaxResponse.var3_img+'>';
  }
}, 1000);

setTimeout(() => {
if (ajaxResponse.var4_name == data.solo){
  var4.value = data.solov;
  singleShow();
  document.querySelector('.details-three-content-img').innerHTML = '<img src='+ajaxResponse.var4_img+'>';
  }
}, 1000);

setTimeout(() => {
if (ajaxResponse.var5_name == data.solo){
  var5.value = data.solov;
  singleShow();
  document.querySelector('.details-three-content-img').innerHTML = '<img src='+ajaxResponse.var5_img+'>';
  } 
}, 1000);

setTimeout(() => {
  if (document.querySelector('.details-three-content-img').innerHTML == ""){
    document.querySelector('.details-three-content-img').innerHTML = '<img src='+ajaxResponse.var1_img+'>';
  }
}, 1000);

/* Obter parâmetros get ID e QUANTITY do url; /*/

/* Cart Details Show&Hidden */
let cartIcon = document.querySelector('.cart-icon');
let cartDetails = document.querySelector('.cart-details');


if (window.innerWidth <= 1060){
  cartDetails.style.display = "none";
}

cartIcon.onclick = function(e){
    e.preventDefault();
    cartDetails.style.opacity = "1"
    if (cartDetails.style.display == "none"){
      cartDetails.style.display = "block";
    }else{
      cartDetails.style.display = "none";
    }
}

function soma(result){
  result = parseInt(var1.value) + parseInt(var2.value) + parseInt(var3.value) + parseInt(var4.value) + parseInt(var5.value);
  return result;
}

let total = document.querySelector('[data-total]');
total.innerHTML = soma();
let totaldetails = document.querySelector('[data-totaldetails');
totaldetails.innerHTML = quantity.innerHTML;
let cartunitprice = document.querySelector('#cart-unitprice');
let cart_total = document.querySelector('#cart-total');
show();

function show(){
  setTimeout(() => cart_total.innerHTML = calcTotal(), 1);
  setTimeout(() => cart_total.innerHTML = calcTotal(), 3000);
  setTimeout(() => cart_total.innerHTML = calcTotal(), 5000);
  setTimeout(() => cart_total.innerHTML = calcTotal(), 10000);
}

function calcTotal(result){
  result = (parseInt(var1.value) + parseInt(var2.value) + parseInt(var3.value) + parseInt(var4.value) + parseInt(var5.value)) * cartunitprice.innerHTML.replace(',','.');
  return result.toFixed(2).toString().replace('.',',');
}
/* Cart Details Show&Hidden /*/


/* Cart Increment & Decrement */
function increment1(id) {  
  max = parseInt(localStorage.diminuido);
  value = document.getElementById(id).value;
  value = isNaN(value) ? 0 : value;
  if (value >= max) {
    value = value;
    document.getElementById('msg2').style.display = 'block';
    setTimeout(function () {
      document.getElementById('msg2').style.display = 'none'
    }, 6000)
  } else {
    value++;
  }
  document.getElementById(id).value = value;
  total.innerHTML = soma();
  totaldetails.innerHTML = soma();
  cart_total.innerHTML = calcTotal();
}

function decrement1(id) {  
  min = 0;
  value = document.getElementById(id).value;
  value = isNaN(value) ? 0 : value;
  if (value <= min) {
    value = min;
  } else {
    value--;
  }
  document.getElementById(id).value = value;
  total.innerHTML = soma();
  totaldetails.innerHTML = soma();
  cart_total.innerHTML = calcTotal();
}


/* Show & Hide Security */

let secClick = document.querySelector('.security-click');
let secHeader = document.querySelector('.security-header');
let doneBtn = document.querySelector('[data-btnsec]');
secHeader.style.display = "none";
doneBtn.style.display = "none";
secClick.onclick = function(){
  if (secHeader.style.display == "none"){
    secHeader.style.display = "block"
    doneBtn.style.display = "inline-block"
  }else{
    secHeader.style.display = "none";
    doneBtn.style.display = "none";
  }
}
doneBtn.onclick = () => secHeader.style.display = "none";



/* Method Button */

let cardButton = document.querySelector('#credit-card');
let boletoButton = document.querySelector('#boleto');

cardButton.onclick = function(){
  boletoButton.classList.remove('mtd-btn-active');
  cardButton.classList.add('mtd-btn-active');
  document.querySelector('.credit-card-form').style.display = "block";
  document.querySelector('.boleto-form').style.display = "none";
  document.querySelector('[action]').setAttribute('action','./controllers/PaymentController.php');
  document.querySelector('#mtd').value = 'cartao';
  document.querySelector('#cardNumber').setAttribute('required','');
  document.querySelector('#cardholderName').setAttribute('required','');
  document.querySelector('#cardExpiration').setAttribute('required','');
  document.querySelector('#securityCode').setAttribute('required','');
}

boletoButton.onclick = function(){
  fbq('trackCustom','SelectedBoleto', {content_type: 'product', content_ids: content_id})
  cardButton.classList.remove('mtd-btn-active');
  boletoButton.classList.add('mtd-btn-active');
  document.querySelector('.credit-card-form').style.display = "none";
  document.querySelector('.boleto-form').style.display = "block";
  document.querySelector('[action]').setAttribute('action','./controllers/PaymentController_boleto.php');
  document.querySelector('#mtd').value = "boleto";
  document.querySelector('#cardNumber').removeAttribute('required');
  document.querySelector('#cardholderName').removeAttribute('required');
  document.querySelector('#cardExpiration').removeAttribute('required');
  document.querySelector('#securityCode').removeAttribute('required');
}
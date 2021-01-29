<?php

namespace Classes;

class ClassException{

    #Set and Getters
    private $payment; //Crio uma variável.

    public function setPayment($payment){ //Defino o valor dela daquela variável.
        $this->payment = $payment;
    }

    public function getPayment(){  //Crio um método que retorna o valor daquela variável.
        return $this->payment;
    }

    #Verify Transaction
    public function verifyTransaction(){
        if($this->getPayment()->error !== ""){
            if($this->getPayment()->status_detail == 'accredited' || 'pending_contingency' || 'pending_review_manual'){
                $html = [
                    'class'=>'success',
                    'message'=>$this->getStatus()
                ];
            }else{
                $html = [
                    'class'=>'alert',
                    'message'=>$this->getErrors()
                ];
            }
        }else{
            $html = [
                'class'=>'error',
                'message'=>$this->getErrors()
            ];
        }
        unset($_SESSION);
        return $html;
    }

    #Get Status
    public function getStatus(){
        $status = [
            'accredited'=>'Seu pagamento foi aprovado! No resumo, você verá a cobrança do valor como '.$this->getPayment()->statement_descriptor.'.',
            'pending_contingency'=>'Não se preocupe, em menos de 2 dias úteis informaremos por e-mail se foi creditado ou se necessitamos de mais informação.',
            'pending_review_manual'=>'Não se preocupe, em menos de 2 dias úteis informaremos por e-mail se foi creditado ou se necessitamos de mais informação.',
            'cc_rejected_bad_filled_card_number'=>'O número de cartão informado não é válido. Tente novamente.',
            'cc_rejected_bad_filled_date'=>'A data de vencimento informada não é válida. Tente novamente.',
            'cc_rejected_bad_filled_other'=>'Há algo de errado com os dados do cartão fornecido. Tente novamente.',
            'cc_rejected_bad_filled_security_code'=>'O código de segurança do cartão não é válido. Tente novamante.',
            'cc_rejected_blacklist'=>'O Mercado Pago não pode processar seu pagamento. Sugerimos que tenter realizar o pagamento por boleto.',
            'cc_rejected_call_for_authorize'=>'Você deve autorizar a bandeira '.$this->getPayment()->payment_method_id.' o pagamento do valor ao Mercado Pago.',
            'cc_rejected_card_disabled'=>'Ligue para a bandeira '.$this->getPayment()->payment_method_id.' para ativar seu cartão. O telefone está no verso do seu cartão.            ',
            'cc_rejected_card_error'=>'Não foi possível realizar essa transação porque há um problema não identificado com o seu cartão. Tente novamente. Se o problema persistir, sugerimos que realize o pagamento por boleto.',
            'cc_rejected_duplicated_payment'=>'Você já efetuou um pagamento com esse valor. Caso precise pagar novamente, utilize outro cartão ou outra forma de pagamento.',
            'cc_rejected_high_risk'=>'Essa compra não faz parte do padrão de consumo desse cartão, razão pela qual não podemos realizar essa transação. Sugerimos que você realize o pagamento através de boleto bancário.',
            'cc_rejected_insufficient_amount'=>'O cartão '.$this->getPayment()->payment_method_id.' não possui saldo suficiente.',
            'cc_rejected_invalid_installments'=>'O cartão '.$this->getPayment()->payment_method_id.' não processa pagamentos em '.$this->getPayment()->installments.' parcelas.',
            'cc_rejected_max_attempts'=>'Você atingiu o limite de tentativas permitido. Escolha outro cartão ou outra forma de pagamento.',
            'cc_rejected_other_reason'=>'A bandeira '.$this->getPayment()->payment_method_id.' não pode processar seu pagamento.'
        ];
        if (array_key_exists($this->getPayment()->status_detail,$status)){ //Isso aqui é quase um for it. Faz iteração no array.
            return $status[$this->getPayment()->status_detail];//Por fazer iteração, se eu colocar dentro de chaves, vai selecionar o array que está atualmente sendo iterado, igualzinho o for it.
        }else{
            return "Houve um problema não identificado na sua requisição. Tente novamente. Se o problema persistir, sugerimos que realize o pagamento via boleto bancário.";
        }
    }

    #Get Errors
    public function getErrors(){
        $error = [
            '205'=>'Digite o número do seu cartão.',
            '208'=>'Escolha um mês.',
            '209'=>'Escolha um ano.',
            '212'=>'Informe seu documento.',
            '213'=>'Informe seu documento.',
            '214'=>'Informe seu documento.',
            '220'=>'Informe seu banco emissor.',
            '221'=>'Digite o nome e sobrenome.',
            '224'=>'Digite o código de segurança.',
            'E301'=>'Há algo de errado com esse número. Digite novamente.',
            'E302'=>'Confira o código de segurança.',
            '316'=>'Por favor, digite um nome válido.',
            '322'=>'Confira seu documento.',
            '323'=>'Confira seu documento.',
            '324'=>'Confira seu documento.',
            '325'=>'Confira a data.',
            '326'=>'Confira a data.',
            'default'=>'Confira os dados.',
            '106'=>'Não pode efetuar pagamentos a usuários de outros países.',
            '109'=>'O '.$this->getPayment()->payment_method_id.' não processa pagamentos parcelados. Escolha outro cartão ou outra forma de pagamento.',
            '126'=>'Não conseguimos processar seu pagamento.',
            '129'=>'O '.$this->getPayment()->payment_method_id.' não processa pagamentos para o valor selecionado. Escolha outro cartão ou outra forma de pagamento.',
            '145'=>'Uma das partes com a qual está tentando realizar o pagamento é um usuário de teste e a outra é um usuário real.',
            '150'=>'Você não pode efetuar pagamentos.',
            '151'=>'Você não pode efetuar pagamentos.',
            '160'=>'Não conseguimos processar seu pagamento.',
            '204'=>'O '.$this->getPayment()->payment_method_id.' não está disponível nesse momento. Escolha outro cartão ou outra forma de pagamento.',
            '801'=>'Você realizou um pagamento similar há poucos instantes. Tente novamente em alguns minutos.',
            '1'=>'Os paramâtros de envio dos dados não está conforme o padrão exigido.',
            '2'=>'O Token deve ser para teste.',
            '4'=>'Forneça seu acess_token para continuar.',
            '23'=>'Formate a data de expiração no padrão (yyyy-MM-dd\'T\'HH:mm:ssz). Entre em contato com nossa equipe.',
            '1000'=>'O número de linhas excedeu o limite. Entre em contato com nossa equipe.',
            '1001'=>'Formate a data no padrão (yyyy-MM-dd\'T\'HH:mm:SSSZ). Entre em contato com nossa equipe.',
            '2001'=>'O mesmo pedido já foi postado no último minuto.',
            '2004'=>'Falha no POST para API de transações do gateway. Entre em contato com nossa equipe.',
            '2002'=>'Não foi possível localizar o id do cliente. Entre em contato com nossa equipe.',
            '2006'=>'Não foi possível localizar o Card Token. Entre em contato com nossa equipe.',
            '2007'=>'Falha na conexão com o Token API. Entre em contato com nossa equipe.',
            '2009'=>'O Card Token não pode ser nulo. Entre em contato com nossa equipe.',
            '2060'=>'The customer can\'t be equal to the collector. Entre em contato com nossa equipe.',
            '2067'=>'CPF inválido.',
            '3000'=>'Você precisa fornecer o nome impresso no cartão para efetuar essa transação.',
            '3001'=>'You must provide your cardissuer_id with your card data. Entre em contato com nossa equipe.',
            '3003'=>'Card Token inválido. Entre em contato com nossa equipe.',
            '3004'=>'Não foi possível identificar a causa do erro. Por gentileza, entre em contato com nossa equipe. ',
            '3005'=>'Ação inválida, o recurso está em um estado que não permite esta operação. Para obter mais informações, consulte o estado que possui o recurso.',
            '3006'=>'Houve um problema na criação do Token. Por gentiliza, tente novamente.',
            '3007'=>'The parameter client_id can not be null or empty.',
            '3008'=>'Not found Cardtoken.',
            '3009'=>'unauthorized client_id.',
            '3010'=>'Not found card on whitelist.',
            '3011'=>'Not found payment_method.',
            '3012'=>'Invalid parameter security_code_length.',
            '3013'=>'Código de segurança do cartão invalido.',
            '3014'=>'Invalid parameter payment_method.',
            '3015'=>'Número de cartão invalido.',
            '3016'=>'Número de cartão invalido.',
            '3017'=>'Informe o número do cartão.',
            '3018'=>'Informe o mês de vencimento do cartão.',
            '3019'=>'Informe o ano de vencimento do cartão.',
            '3020'=>'Informe o nome escrito no cartão.',
            '3021'=>'The parameter cardholder.document.number can not be null or empty.',
            '3022'=>'The parameter cardholder.document.type can not be null or empty.',
            '3023'=>'The parameter cardholder.document.subtype can not be null or empty.',
            '3024'=>'Not valid action - partial refund unsupported for this transaction.',
            '3025'=>'Invalid Auth Code.',
            '3026'=>'Invalid card_id for this payment_method_id.',
            '3027'=>'Invalid payment_type_id.',
            '3028'=>'Invalid payment_method_id.',
            '3029'=>'Invalid card expiration month.',
            '3030'=>'Invalid card expiration year.',
            '4000'=>'card atributte can\'t be null.',
            '4001'=>'payment_method_id atributte can\'t be null.',
            '4002'=>'Não foi identificada a quantidade de produtos que você deseja adquirir. Por gentileza, tente novamente.',
            '4003'=>'transaction_amount atributte must be numeric.',
            '4004'=>'Não foi identificada a quantidade de parcelas que você deseja realizar. Por gentileza, tente novamente..',
            '4005'=>'installments atributte must be numeric.',
            '4006'=>'payer atributte is malformed.',
            '4007'=>'site_id atributte can\'t be null.',
            '4012'=>'payer.id atributte can\'t be null.',
            '4013'=>'payer.type atributte can\'t be null.',
            '4015'=>'payment_method_reference_id atributte can\'t be null.',
            '4016'=>'payment_method_reference_id atributte must be numeric.',
            '4017'=>'status atributte can\'t be null.',
            '4018'=>'payment_id atributte can\'t be null.',
            '4019'=>'payment_id atributte must be numeric.',
            '4020'=>'notificaction_url atributte must be url valid.',
            '4021'=>'notificaction_url atributte must be shorter than 500 character.',
            '4022'=>'metadata atributte must be a valid JSON.',
            '4023'=>'Não foi possível identificar a quantidade de produtos que você deseja adquirir. Por gentileza, tente novamente.',
            '4024'=>'transaction_amount atributte must be numeric.',
            '4025'=>'refund_id can\'t be null.',
            '4026'=>'Invalid coupon_amount.',
            '4027'=>'campaign_id atributte must be numeric.',
            '4028'=>'coupon_amount atributte must be numeric.',
            '4029'=>'Invalid payer type.',
            '4037'=>'Invalid transaction_amount.',
            '4038'=>'application_fee cannot be bigger than transaction_amount.',
            '4050'=>'O email do pagador precisa ser válido',
            '4051'=>'O email deve ser menor que 254 caracteres.',
            '7523'=>'Data de expiração do cartão invalida.'
        ];
        if (array_key_exists($this->getPayment()->error->causes[0]->code,$error)){
            return $error[$this->getPayment()->error->causes[0]->code];//Por fazer iteração, se eu colocar dentro de chaves, vai selecionar o array que está atualmente sendo iterado, igualzinho o for it.
        }else{
            return "Houve um problema não identificado na sua requisição. Tente novamente. Se o problema persistir, sugerimos que realize o pagamento via boleto bancário.";
        }
    }
}
?>
const cardForm = mp.cardForm({
    amount: amount,
    iframe:false,
    form: {
      id: "formPayment",
        cardNumber:{
            id:'cardNumber'
        },

        expirationDate: {
            id: "expirationDate",
        },
        securityCode: {
            id: "securityCode",
        },
        cardholderName: {
            id: "cardholderName",
        },
        issuer: {
            id: "issuer",
        },
        installments: {
            id: "installments",
        },
       
    },
    callbacks: {
      onFormMounted: error => {
        if (error) return console.warn("Form Mounted handling error: ", error);
        console.log("Form mounted");
      },
      onSubmit: event => {
        event.preventDefault();
  
        const {
          paymentMethodId: payment_method_id,
          issuerId: issuer_id,
          amount,
          token,
          installments,
        } = cardForm.getCardFormData();
  
        fetch("/process_payment", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          },
          body: JSON.stringify({
            token,
            issuer_id,
            payment_method_id,
            transaction_amount: Number(amount),
            installments: Number(installments),
            description: "Descripción del producto",
            address_id: document.querySelector('#address_id').value

          }),
        }).then(response => response.json())
        .then(data => {
            if(data.error){
              $.notify('Ha ocurrido un error','error')
            }else{
              window.location.href = '/pedido/felicidades/'+data.order
            }
        })
      },
      onFetching: (resource) => {
        console.log("Fetching resource: ", resource);
  
        // Animate progress bar
        const progressBar = document.querySelector(".progress-bar");
        progressBar.removeAttribute("value");
  
        return () => {
          progressBar.setAttribute("value", "0");
        };
      },
    },
  });
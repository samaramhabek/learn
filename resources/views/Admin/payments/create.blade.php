@extends('layout.master')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<link href="{{asset('checkout.css')}}" style="sheet">
    <div class="container">
        <div class="row">
            <div class="col-lg-6  offset-lg-3 col-md-10 offest-md-1 col-12">
               
                <div id="payment-message"  class="alert alert-info" style="display: none;"></div>
                
                <form action="" method="post"  id="payment-form">
                  <div id="link-authentication-element">
                    <!--Stripe.js injects the Link Authentication Element-->
                  
                  </div>
                  <div id="payment-element"></div>

                  <button  type="submit" id="submit" class="btn">
                    <span id="button-text">pay</span>
                    <span id="spinner" >proccessing...</span></button>
                </form>
             
                
            </div>
        </div>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
   
    <script>
           // This is your test publishable API key.
           const stripe = Stripe("pk_test_51NZULnGUj5L3qAnS5kdVYEkIO3D8o5FoZ2RpPzUT1jnhdHe4dQEFH5tcch7UuGKIJogKEyHOqeGAjwefeQ6nZhXv000FExDEEZ");
           console.log(stripe);


// The items the customer wants to buy
// const items = [{ id: "xl-tshirt" }];
// const elements = stripe.elements();
//     const cardElement = elements.create('card');
 
//     cardElement.mount('#payment-element');
let elements;

initialize();
// checkStatus();

document
  .querySelector("#payment-form")
  .addEventListener("submit", handleSubmit);

let emailAddress = '';
// Fetches a payment intent and captures the client secret
async function initialize() {
            const {
                clientSecret
            } = await fetch("{{ route('stripe.paymentIntent.create', $order->id) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    "_token": "{{ csrf_token() }}"
                }),
            }).then((r) => r.json());
                    console.log(r.json());
            elements = stripe.elements({
                clientSecret
            });

            const paymentElement = elements.create("payment");
            paymentElement.mount("#payment-element");
        }


async function handleSubmit(e) {
  e.preventDefault();
  setLoading(true);

  const { error } = await stripe.confirmPayment({
    elements,
    confirmParams: {
      // Make sure to change this to your payment completion page
      return_url: "{{route('stripe.return',$order->id)}}",
      receipt_email: emailAddress,
    },
  });

  // This point will only be reached if there is an immediate error when
  // confirming the payment. Otherwise, your customer will be redirected to
  // your `return_url`. For some payment methods like iDEAL, your customer will
  // be redirected to an intermediate site first to authorize the payment, then
  // redirected to the `return_url`.
  if (error.type === "card_error" || error.type === "validation_error") {
    showMessage(error.message);
  } else {
    showMessage("An unexpected error occurred.");
  }

  setLoading(false);
}

// Fetches the payment intent status after payment submission
async function checkStatus() {
  const clientSecret = new URLSearchParams(window.location.search).get(
    "payment_intent_client_secret"
  );

  if (!clientSecret) {
    return;
  }

  const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

  switch (paymentIntent.status) {
    case "succeeded":
      showMessage("Payment succeeded!");
      break;
    case "processing":
      showMessage("Your payment is processing.");
      break;
    case "requires_payment_method":
      showMessage("Your payment was not successful, please try again.");
      break;
    default:
      showMessage("Something went wrong.");
      break;
  }
}

// ------- UI helpers -------

function showMessage(messageText) {
  const messageContainer = document.querySelector("#payment-message");

  messageContainer.style.display="block";
  messageContainer.textContent = messageText;

  setTimeout(function () {
    messageContainer.classList.add("hidden");
    messageContainer.textContent = "";
  }, 4000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("#submit").disably= true;
    document.querySelector("#spinner").style.display="inline";
    document.querySelector("#button-text").style.display="none";
  } else {
    document.querySelector("#submit").disabled = false;
    document.querySelector("#spinner").style.display="none";
    document.querySelector("#button-text").style.display="inline";
  }
}
    </script>


@endsection

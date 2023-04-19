@include('header');
<div class="container">
    <h2>Stripe Payment</h2>
    <form action="{{ route('payment.store', $order) }}" method="post" id="payment-form">
        @csrf
        <div class="form-row">
            <!-- <label for="card-element">
                Credit or debit card
            </label> -->
            <div id="card-element" class="d-block w-50">
                <!-- A Stripe Element will be inserted here. -->
            </div>

            <!-- Used to display form errors. -->
            <div id="card-errors" role="alert"></div>
        </div>

        <button class="btn btn-primary mt-3">Submit Payment</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log("Payment form script")
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        // const cardElement = elements.create('card');
        const cardElement = elements.create('card', {
            style: {
                base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
                },
                invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
                }
            }
        });

        cardElement.mount('#card-element');

        // Handle real-time validation errors from the card Element.
		cardElement.on('change', function (event) {
			const displayError = document.getElementById('card-errors');
			if (event.error) {
				displayError.textContent = event.error.message;
			} else {
				displayError.textContent = '';
			}
		});

		// Handle form submission
		const form = document.getElementById('payment-form');
		form.addEventListener('submit', async function (event) {
			event.preventDefault();

			const { token, error } = await stripe.createToken(cardElement);

			if (error) {
				const errorElement = document.getElementById('card-errors');
				errorElement.textContent = error.message;
			} else {
				stripeTokenHandler(token);
			}
		});

		function stripeTokenHandler(token) {
			const form = document.getElementById('payment-form');
			const hiddenInput = document.createElement('input');
			hiddenInput.setAttribute('type', 'hidden');
			hiddenInput.setAttribute('name', 'stripeToken');
			hiddenInput.setAttribute('value', token.id);
			form.appendChild(hiddenInput);

			form.submit();
		}
    });
</script>

@include('footer');

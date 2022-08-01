
    <!-- link to the SqPaymentForm library -->
 
     <script type="text/javascript" src="<?php echo SQUAREUP_FORM_JS ?>">  </script>


    <!-- link to the local SqPaymentForm initialization -->
    <!-- <script type="text/javascript" src="sqpaymentform.js">
    </script> -->

    <!-- link to the custom styles for SqPaymentForm -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>webroot/css/sqpaymentform-basic.css">
  <script>
   document.addEventListener("DOMContentLoaded", function(event) {
    if (SqPaymentForm.isSupportedBrowser()) {
      setTimeout(function () {
      paymentForm.build();
     paymentForm.recalculateSize();
    }, 2500);
    }
  });
  </script>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Square Payment Gateway</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>cart">Cart </a></li>
            <li class="active">Square Payment Gateway</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
            <div id="msg_div">
 
<?php echo $this->session->flashdata('message');?>
 

</div>

            </div>

            <div id="form-container">
              <div id="sq-ccbox">
                <!--
                  Be sure to replace the action attribute of the form with the path of
                  the Transaction API charge endpoint URL you want to POST the nonce to
                  (for example, "/process-card")
                -->
                <form id="nonce-form" novalidate action="<?php echo base_url().MODULE_NAME; ?>order/squarePayment" method="post">
				<p>&nbsp;</p>
					
                  <fieldset>
                    <span class="label">Card Number</span>
                    <div id="sq-card-number"></div>

                    <div class="third">
                      <span class="label">Expiration</span>
                      <div id="sq-expiration-date"></div>
                    </div>

                    <div class="third">
                      <span class="label">CVV</span>
                      <div id="sq-cvv"></div>
                    </div>

                    <div class="third">
                      <span class="label">Postal</span>
                      <div id="sq-postal-code"></div>
                    </div>
                  </fieldset>
                  <button id="sq-creditcard" class="button-credit-card" onclick="requestCardNonce(event)">Pay $<?php echo $order_amount; ?></button>

                  <div id="error"></div>

                  <!--
                    After a nonce is generated it will be assigned to this hidden input field.
                  -->
                <input type="hidden" id="btn_type" name="btn_type" value="<?php echo $btn_type; ?>">
                <input type="hidden" id="label_type" name="label_type" value="<?php echo $label_type; ?>">
                <input type="hidden" id="special_delivery_charge" name="special_delivery_charge" value="<?php echo $special_delivery_charge; ?>">
                <input type="hidden" id="checkout_amount" name="checkout_amount" value="<?php echo $checkout_amount; ?>">
                <input type="hidden" id="apply_coupon_code" name="apply_coupon_code" value="<?php echo $apply_coupon_code; ?>">
                <input type="hidden" id="actual_amount" name="actual_amount" value="<?php echo $actual_amount; ?>">
                <input type="hidden" id="user_address" name="user_address" value="<?php echo $user_address; ?>">
                <input type="hidden" id="address_id" name="address_id" value="<?php echo $address_id; ?>">
                <input type="hidden" id="amount" name="amount" value="<?php echo $order_amount; ?>">
                <input type="hidden" id="minimum_surcharge" name="minimum_surcharge" value="<?php echo $minimum_surcharge; ?>">
                  <input type="hidden" id="card-nonce" name="nonce">
                </form>
              </div> <!-- end #sq-ccbox -->

            </div> 
        </div>

        <!-- /.box -->
    </section>
    <!-- /.content -->
</aside>
<script src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
<script type="text/javascript">
  // Set the application ID
 
var applicationId = "<?php echo SQUAREUP_APPLICATION_ID ;?>";
 
var locationId = "<?php echo SQUAREUP_LOCATION_ID ;?>";


function buildForm(form) {
  if (SqPaymentForm.isSupportedBrowser()) {
    form.build();
    form.recalculateSize();
  }
}
function buildForm1() {
    if (SqPaymentForm.isSupportedBrowser()) {
      var paymentDiv = document.getElementById("form-container");
      if (paymentDiv.style.display === "none") {
          paymentDiv.style.display = "block";
      }
      paymentform.build();
      paymentform.recalculateSize();
    } else {
      // Show a "Browser is not supported" message to your buyer
    }
  }

  
/*
 * function: requestCardNonce
 *
 * requestCardNonce is triggered when the "Pay with credit card" button is
 * clicked
 *
 * Modifying this function is not required, but can be customized if you
 * wish to take additional action when the form button is clicked.
 */
function requestCardNonce(event) {

  // Don't submit the form until SqPaymentForm returns with a nonce
  event.preventDefault();
  // Request a nonce from the SqPaymentForm object
  paymentForm.requestCardNonce();
}

// Create and initialize a payment form object
var paymentForm = new SqPaymentForm({

  // Initialize the payment form elements
  applicationId: applicationId,
  locationId: locationId,
  inputClass: 'sq-input',
  autoBuild: false,

  // Customize the CSS for SqPaymentForm iframe elements
  inputStyles: [{
    fontSize: '16px',
    fontFamily: 'Helvetica Neue',
    padding: '16px',
    color: '#373F4A',
    backgroundColor: 'transparent',
    lineHeight: '24px',
    placeholderColor: '#CCC',
    _webkitFontSmoothing: 'antialiased',
    _mozOsxFontSmoothing: 'grayscale'
  }],

  // Initialize Apple Pay placeholder ID
  applePay: false,

  // Initialize Masterpass placeholder ID
  masterpass: false,

  // Initialize the credit card placeholders
  cardNumber: {
    elementId: 'sq-card-number',
    placeholder: 'XXXX XXXX XXXX XXXX'
  },
  cvv: {
    elementId: 'sq-cvv',
    placeholder: 'CVV'
  },
  expirationDate: {
    elementId: 'sq-expiration-date',
    placeholder: 'MM/YY'
  },
  postalCode: {
    elementId: 'sq-postal-code',
    placeholder: '12345'
  },

  // SqPaymentForm callback functions
  callbacks: {
	  
	const payments = Square.payments(applicationId, locationId);
	
	const card = await payments.card();
	
	await card.attach('#form-container');
	
	const tokenResult = await card.tokenize();
	if (tokenResult.status === 'OK') {
	  const token = tokenResult.token;
	} else {
	  console.error(tokenResult.errors);
	}
    /*
     * callback function: createPaymentRequest
     * Triggered when: a digital wallet payment button is clicked.
     * Replace the JSON object declaration with a function that creates
     * a JSON object with Digital Wallet payment details
     */
    createPaymentRequest: function () {
      var payment_amount = document.getElementById("form-container");
      return {
        requestShippingAddress: false,
        requestBillingInfo: true,
        currencyCode: "USD",
        countryCode: "US",
        total: {
          label: "MERCHANT NAME",
          amount: payment_amount,
          pending: false
        },
        lineItems: [
          {
            label: "Subtotal",
            amount: payment_amount,
            pending: false
          }
        ]
      }
    },

    /*
     * callback function: cardNonceResponseReceived
     * Triggered when: SqPaymentForm completes a card nonce request
     */
    cardNonceResponseReceived: function (errors, nonce, cardData) {
      if (errors) {
        // Log errors from nonce generation to the Javascript console
        console.log("Encountered errors:");
        errors.forEach(function (error) {
          console.log(' er= ' + error.message);
          alert(error.message);
        });

        return;
      }
      // Assign the nonce value to the hidden form field
      document.getElementById('card-nonce').value = nonce;

      // POST the nonce form to the payment processing page
      document.getElementById('nonce-form').submit();

    },

    /*
     * callback function: unsupportedBrowserDetected
     * Triggered when: the page loads and an unsupported browser is detected
     */
    unsupportedBrowserDetected: function () {
      /* PROVIDE FEEDBACK TO SITE VISITORS */
    },

    /*
     * callback function: inputEventReceived
     * Triggered when: visitors interact with SqPaymentForm iframe elements.
     */
    inputEventReceived: function (inputEvent) {
      switch (inputEvent.eventType) {
        case 'focusClassAdded':
          /* HANDLE AS DESIRED */
          break;
        case 'focusClassRemoved':
          /* HANDLE AS DESIRED */
          break;
        case 'errorClassAdded':
          document.getElementById("error").innerHTML = "Please fix card information errors before continuing.";
          break;
        case 'errorClassRemoved':
          /* HANDLE AS DESIRED */
          document.getElementById("error").style.display = "none";
          break;
        case 'cardBrandChanged':
          /* HANDLE AS DESIRED */
          break;
        case 'postalCodeChanged':
          /* HANDLE AS DESIRED */
          break;
      }
    },

    /*
     * callback function: paymentFormLoaded
     * Triggered when: SqPaymentForm is fully loaded
     */
    paymentFormLoaded: function () {
      /* HANDLE AS DESIRED */
      console.log("The form loaded!");
    }
  }
});
</script>
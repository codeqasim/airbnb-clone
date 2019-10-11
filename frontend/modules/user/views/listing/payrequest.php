<?php 
$baseUrl = Yii::$app->request->baseUrl;
  //echo "adminprice ".$adminprice;
   //echo "<br> paycurrency ".$paycurrency->currencycode;
   //echo "<br> paycurrencysym ".$paycurrency->currencysymbol;
    //echo "<br> sitesetting ".$sitesetting->stripe_publishkey;

?>

<script type="text/javascript">
    'use strict';

      var stripe = Stripe('<?php echo $sitesetting->stripe_publishkey; ?>'); 
      var count = 0;

    function registerElements(elements, exampleName) {
        var formClass = '.' + exampleName;
        var example = document.querySelector(formClass);

        var form = example.querySelector('form');
        var resetButton = example.querySelector('a.reset');
        var error = form.querySelector('.error');
        var errorMessage = error.querySelector('.message');

        function enableInputs() {
        Array.prototype.forEach.call(
          form.querySelectorAll(
            "input[type='text'], input[type='email'], input[type='tel']"
          ),
          function(input) {
            input.removeAttribute('disabled');
          }
        );
        }

        function disableInputs() {
        Array.prototype.forEach.call(
          form.querySelectorAll(
            "input[type='text'], input[type='email'], input[type='tel']"
          ),
          function(input) {
            input.setAttribute('disabled', 'true');
          }
        );
        }

        function triggerBrowserValidation() {
        var submit = document.createElement('input');
        submit.type = 'submit';
        submit.style.display = 'none';
        form.appendChild(submit);
        submit.click();
        submit.remove();
        }

        var savedErrors = {};
        elements.forEach(function(element, idx) {
        element.on('change', function(event) {
          if (event.error) {
            error.classList.add('visible');
            savedErrors[idx] = event.error.message;
            errorMessage.innerText = event.error.message;
          } else {
            savedErrors[idx] = null;
            var nextError = Object.keys(savedErrors)
              .sort()
              .reduce(function(maybeFoundError, key) {
                return maybeFoundError || savedErrors[key];
              }, null);

            if (nextError) {
              errorMessage.innerText = nextError;
            } else {
              error.classList.remove('visible');
            }
          }
        });
        });

        // Listen on the form's 'submit' handler...
        form.addEventListener('submit', function(e) {
        e.preventDefault();

        var plainInputsValid = true;
        Array.prototype.forEach.call(form.querySelectorAll('input'), function(
          input
        ) {
          if (input.checkValidity && !input.checkValidity()) {
            plainInputsValid = false;
            return;
          }
        });
        if (!plainInputsValid) {
          triggerBrowserValidation();
          return;
        }

        disableInputs();

        if(count == 0) {          
          stripe.createToken(elements[0]).then(function(result) {            
            if (result.token) { 
              //alert(result.token.card.last4);
              //alert(result.token.id);
              document. getElementById("payButton").style.display = "none"; 
              example.querySelector('.paytoken').value = result.token.id;
              document.getElementById("paymentFrm").submit();  
            } else {
              enableInputs(); 
            }
           
          });
          count = count + 1;
        }
    });
}
</script>

<main>
  
    <section class="container-lg">

      <!--Example 2-->
      <div class="cell example example2">
        <!-- <input type="hidden" name="days" class="days" value="<?php // echo $days; ?>"> -->
        <!-- <input type="hidden" name="booking" class="booking" value="<?php // echo $booking; ?>"> -->

        <form action="<?php echo $baseUrl.'/user/listing/payprocess'; ?>" method="POST" id="paymentFrm">  
          <input type="hidden" name="paytoken" class="paytoken" value="">
          <input type="hidden" name="paycurrency" class="currency" value="<?php echo $paycurrency->currencycode; ?>">
          <?php if($callType == "inquiry") { ?>
            <input type="hidden" name="listid" class="listid" value="<?php echo $listid; ?>">
            <input type="hidden" name="inquiryid" class="inquiryid" value="<?php echo $inquiryId; ?>">
            <input type="hidden" name="calltype" class="calltype" value="<?php echo $callType; ?>">
          <?php } elseif ($callType == "reserve") { ?>
            <input type="hidden" name="listid" class="listid" value="<?php echo $listid; ?>">
            <input type="hidden" name="calltype" class="calltype" value="<?php echo $callType; ?>">
            <input type="hidden" name="guests" class="guests" value="<?php echo $guests; ?>">
            <input type="hidden" name="sdate" class="sdate" value="<?php echo $sdate; ?>">
            <input type="hidden" name="edate" class="edate" value="<?php echo $edate; ?>">
            <input type="hidden" name="booking_timing" class="booking_timing" value="<?php echo $booking_timing; ?>">
          <?php } ?> 

          <div class="row">
            <div class="field" style="text-align: center !important; margin-bottom: 50px;">
                <img src="<?php echo $baseUrl.'/images/logo-stripe180.png';?>">
            </div>
          </div>
          <div class="row">
            <div class="field">
              <div id="example2-card-number" class="input empty"></div>
              <label for="example2-card-number" data-tid="elements_examples.form.card_number_label">Card number</label>
              <div class="baseline"></div>
            </div>
          </div>
          <div class="row">
            <div class="field half-width">
              <div id="example2-card-expiry" class="input empty"></div>
              <label for="example2-card-expiry" data-tid="elements_examples.form.card_expiry_label">Expiration</label>
              <div class="baseline"></div>
            </div>
            <div class="field half-width">
              <div id="example2-card-cvc" class="input empty"></div>
              <label for="example2-card-cvc" data-tid="elements_examples.form.card_cvc_label">CVC</label>
              <div class="baseline"></div>
            </div>
          </div>

           <?php if($callType == "inquiry" || $callType == "reserve" ) { ?>
            <button id="payButton" data-tid="elements_examples.form.pay_button">Pay - <?php echo $paycurrency->currencycode." ".$adminprice;  ?></button> 
           <?php } ?>


          <div class="error" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
              <path class="base" fill="#000" d="M8.5,17 C3.80557963,17 0,13.1944204 0,8.5 C0,3.80557963 3.80557963,0 8.5,0 C13.1944204,0 17,3.80557963 17,8.5 C17,13.1944204 13.1944204,17 8.5,17 Z"></path>
              <path class="glyph" fill="#FFF" d="M8.5,7.29791847 L6.12604076,4.92395924 C5.79409512,4.59201359 5.25590488,4.59201359 4.92395924,4.92395924 C4.59201359,5.25590488 4.59201359,5.79409512 4.92395924,6.12604076 L7.29791847,8.5 L4.92395924,10.8739592 C4.59201359,11.2059049 4.59201359,11.7440951 4.92395924,12.0760408 C5.25590488,12.4079864 5.79409512,12.4079864 6.12604076,12.0760408 L8.5,9.70208153 L10.8739592,12.0760408 C11.2059049,12.4079864 11.7440951,12.4079864 12.0760408,12.0760408 C12.4079864,11.7440951 12.4079864,11.2059049 12.0760408,10.8739592 L9.70208153,8.5 L12.0760408,6.12604076 C12.4079864,5.79409512 12.4079864,5.25590488 12.0760408,4.92395924 C11.7440951,4.59201359 11.2059049,4.59201359 10.8739592,4.92395924 L8.5,7.29791847 L8.5,7.29791847 Z"></path>
            </svg>
            <span class="message"></span></div>
        </form>
        
      </div>
    </section>

   
    </main>

    <script type="text/javascript">
        (function() {
            'use strict';

            var elements = stripe.elements({
            fonts: [
              {
                cssSrc: 'https://fonts.googleapis.com/css?family=Source+Code+Pro',
              },
            ],
            // Stripe's examples are localized to specific languages, but if
            // you wish to have Elements automatically detect your user's locale,
            // use `locale: 'auto'` instead.
            locale: window.__exampleLocale
            });

            // Floating labels
            var inputs = document.querySelectorAll('.cell.example.example2 .input');
            Array.prototype.forEach.call(inputs, function(input) {
            input.addEventListener('focus', function() {
              input.classList.add('focused');
            });
            input.addEventListener('blur', function() {
              input.classList.remove('focused');
            });
            input.addEventListener('keyup', function() {
              if (input.value.length === 0) {
                input.classList.add('empty');
              } else {
                input.classList.remove('empty');
              }
            });
            });

            var elementStyles = {
            base: {
              color: '#32325D',
              fontWeight: 500,
              fontFamily: 'Source Code Pro, Consolas, Menlo, monospace',
              fontSize: '16px',
              fontSmoothing: 'antialiased',

              '::placeholder': {
                color: '#CFD7DF',
              },
              ':-webkit-autofill': {
                color: '#e39f48',
              },
            },
            invalid: {
              color: '#E25950',

              '::placeholder': {
                color: '#FFCCA5',
              },
            },
            };

            var elementClasses = {
            focus: 'focused',
            empty: 'empty',
            invalid: 'invalid',
            };

            var cardNumber = elements.create('cardNumber', {
            style: elementStyles,
            classes: elementClasses,
            });
            cardNumber.mount('#example2-card-number');

            var cardExpiry = elements.create('cardExpiry', {
            style: elementStyles,
            classes: elementClasses,
            });
            cardExpiry.mount('#example2-card-expiry');

            var cardCvc = elements.create('cardCvc', {
            style: elementStyles,
            classes: elementClasses,
            });
            cardCvc.mount('#example2-card-cvc');

            registerElements([cardNumber, cardExpiry, cardCvc], 'example2');
            })();

    </script> 
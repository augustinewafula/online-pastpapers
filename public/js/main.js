$('document').ready(function () {

        const encryptionURL = "{{route('encryption_url')}}";
        const merchantProperties = {
            merchantTransactionID: "{{uniqid("Trans:")}}",
            customerFirstName: 'john',
            customerLastName: "njoro",
            MSISDN: "254711110128",
            customerEmail: "johnnjoroge40@gmail.com",
            amount: "1000",
            currencyCode: "KES",
            accountNumber: "123456",
            serviceCode: "APISBX3857",
            dueDate: "2018-08-24 11:09:59",
            serviceDescription: "Getting service/good x",
            accessKey: "$2a$08$Ga/jSxv1qturlAr8SkHhzOaprXnfOJUTqB6fLRrc/0nSYpRlAd96e",
            countryCode: "KE",
            languageCode: "en",
            successRedirectUrl: "{{route('success_url')}}",
            failRedirectUrl: "{{route('failure_url')}}",
            paymentWebhookUrl: "{{route('process_payment')}}"
        };

        // Provide the class name of where you would like to append the 'pay with mula' button. This example uses a div
        MulaCheckout.addPayWithMulaButton({className: 'checkout-button', checkoutType: 'express'});

        // On click of the button provide the encrypted merchant properties as well as the checkoutType.
        document.querySelector('.mula-checkout-button').addEventListener('click', () => {
            console.log("button clicked");
            encrypt().then(merchantProperties => {
                console.log("merchantproperties: "+merchantProperties);
                MulaCheckout.renderMulaCheckout({merchantProperties: merchantProperties, checkoutType: 'express'})
            })

        });

        function encrypt() {
            return fetch(encryptionURL, {
                method: 'POST',
                body: JSON.stringify(merchantProperties),
                mode: 'cors'
            }).then(response => response.json())
        }
    });

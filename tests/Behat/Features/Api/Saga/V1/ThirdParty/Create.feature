Feature:
  Behat Create Pin Code

Background:
  Given I load fixtures "Base"

  Scenario: Behat Third Party Request - success
    Given I mock "emailing_client" HTTP client next response status code should be 204
#    Given I mock "payment_http_client" HTTP client next response status code should be 200 with body:
#        """
#        {
#            "isInProgress": false,
#            "currency": "USD",
#            "externalOrderId": "123123-321321"
#        }
#        """
    Then the request contains params:
        """
        {
            "event": "test_event",
            "email": "hisemjo@gmail.com",
            "language": "en"
        }
        """
    And I send "POST" request to "api_saga_v1_third_party_create" route
    Then response status code should be 204
    And response should be empty

  Scenario: Behat Third Party Request - fail validation
    Given the request contains params:
        """
        {

        }
        """
    And I send "POST" request to "api_saga_v1_third_party_create" route
    Then response status code should be 400
    #! failInvalidId
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "thirdPartyCreateForm.event.notBlank",
                    "path": "event"
                },
                {
                    "code": "thirdPartyCreateForm.email.notBlank",
                    "path": "email"
                }
            ],
            "params": null
        }
        """

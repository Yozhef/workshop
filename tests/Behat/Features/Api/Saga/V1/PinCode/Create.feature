Feature:
  Behat Create Pin Code

Background:
  Given I load fixtures "Base"
  Given I load redis fixtures "Base"

  Scenario: Behat Show Pin Code in Redis - success
    Given I see in redis any value by key "pin-code.8fcf5165-8a10-44ce-be25-21867da3b44b"
    Then  I see in redis value "123" by key "pin-code.8fcf5165-8a10-44ce-be25-21867da3b44b"

  Scenario: Behat Create PinCode in Redis - success
    Then I don't see in redis value by key "b5329bf8-7a3a-40b2-84f0-937bbf5f4d26"
    Then the request contains params:
        """
        {
            "token": "b5329bf8-7a3a-40b2-84f0-937bbf5f4d26"
        }
        """
    And I send "POST" request to "api_saga_v1_pin_code_create" route
    Then response status code should be 204
    And response should be empty
    Given I see in redis any value by key "pin-code.b5329bf8-7a3a-40b2-84f0-937bbf5f4d26"

  Scenario: Behat Create PinCode in Redis - fail invalid id
    Given the request contains params:
        """
        {
          "token": "11111111-1111-1111-1111-111111111111"
        }
        """
    And I send "POST" request to "api_saga_v1_pin_code_create" route
    Then response status code should be 400
    #! failInvalidId
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "pinCodeCreateForm.token.invalid",
                    "path": "token"
                }
            ],
            "params": null
        }
        """

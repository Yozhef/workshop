Feature:
  Behat Create Async Message

Background:
  Given I load fixtures "Base"

  Scenario: Behat Create Async Message - success
    Then all transport "async" messages should be JSON:
      """
        [

        ]
      """
    Then the request contains params:
        """
        {
            "id": "b5329bf8-7a3a-40b2-84f0-937bbf5f4d26",
            "name": "test"
        }
        """
    And I send "POST" request to "api_saga_v1_async_message_create" route
    Then response status code should be 204
    And response should be empty
    Then all transport "async" messages should be JSON:
      """
        [
           {
                "id": "b5329bf8-7a3a-40b2-84f0-937bbf5f4d26",
                "name": "test"
            }
        ]
      """

  Scenario: Behat Create Async Message - fail invalid id
    Given the request contains params:
        """
        {
          "token": "11111111-1111-1111-1111-111111111111",
          "name": "test"
        }
        """
    And I send "POST" request to "api_saga_v1_async_message_create" route
    Then response status code should be 400
    #! failInvalidId
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "defaultEntityCreateForm.id.notBlank",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

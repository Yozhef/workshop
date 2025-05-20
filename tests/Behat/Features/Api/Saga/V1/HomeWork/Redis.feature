Feature:
  Behat Create Home Work

Background:
  Given I load redis fixtures "HomeWork"

  Scenario: Behat Show HomeWork in Redis - success
    Given I see in redis any value by key "homework.8fcf5125-8a10-44ce-bc25-21867da3b44e"
    Then I see in redis value "8fcf5125-8a10-44ce-bc25-21867da3b44e" by key "homework.8fcf5125-8a10-44ce-bc25-21867da3b44e"

  Scenario: Behat Create HomeWork in Redis - success
    Then I don't see in redis value by key "b5329bf8-7a3a-40b2-84f0-937bbf5f4d26"
    Then the request contains params:
        """
        {
            "id": "b5329bf8-7a3a-40b2-84f0-937bbf5f4d26",
            "title": "Test Homework",
            "dueDate": "2023-10-01 00:00:00"
        }
        """
    And I send "POST" request to "api_saga_v1_homework_create" route
    Then response status code should be 204
    And response should be empty
    Given I see in redis any value by key "homework.b5329bf8-7a3a-40b2-84f0-937bbf5f4d26"

  Scenario: Behat Create HomeWork in Redis - fail invalid id
    Given the request contains params:
        """
        {
            "id": "11111111-1111-1111-1111-111111111111",
            "title": "Test Homework",
            "dueDate": "2023-10-01 00:00:00"
        }
        """
    And I send "POST" request to "api_saga_v1_homework_create" route
    Then response status code should be 400
    #! failInvalidId
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeWorkCreateForm.id.invalid",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

    
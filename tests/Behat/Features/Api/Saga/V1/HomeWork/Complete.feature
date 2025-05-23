Feature:
  Behat Create Home Work

Background:
  Given I load fixtures "Base"

  Scenario: Behat Complete Home Work - success
    Then the request contains params:
        """
        {
            "id": "b92c6f54-e07d-4791-bc6a-a038893fc2a2"
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_complete" route
    Then response status code should be 204
    And response should be empty
    And I see entity "App\Domain\Entity\HomeWork" with id "b92c6f54-e07d-4791-bc6a-a038893fc2a2"
    And I see entity "App\Domain\Entity\HomeWork" with properties:
        """
        {
            "id": "b92c6f54-e07d-4791-bc6a-a038893fc2a2",
            "title": "Test 2",
            "dueDate": "2026-06-01",
            "isCompleted": true
        }
        """

  Scenario: Behat Complete Home Work - fail invalid id
    Given the request contains params:
        """
        {
          "id": "11111111-1111-1111-1111-111111111111"
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_complete" route
    Then response status code should be 400
    #! failInvalidId
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeWorkCompleteByIdForm.id.invalid",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Complete Home Work - fail homework deadline has passed
    Given the request contains params:
        """
        {
          "id": "6d095b85-e98f-49f1-b378-99097910367e"
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_complete" route
    Then response status code should be 422
    #! failDeadlinePassed
    And response should be JSON:
        """
        {
            "code": "422",
            "message": "Http Exception",
            "errors": [
                {
                    "code": "The homework deadline has passed"
                }
            ],
            "params": null
        }
        """

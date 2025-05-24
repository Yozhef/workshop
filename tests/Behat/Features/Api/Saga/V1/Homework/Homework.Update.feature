Feature:
  Behat Update Homework

  Background:
    Given I load fixtures "HomeWork"

  Scenario: Behat Update Homework - success
    Given I see entity "App\Domain\Entity\HomeWork" with properties:
        """
        {
            "id": "8fcf5165-8a10-44ce-be25-21867da3b41b",
            "isCompleted": false
        }
        """
    And the request contains params:
        """
        {
            "id": "8fcf5165-8a10-44ce-be25-21867da3b41b"
        }
        """
    And I send "PATCH" request to "api_saga_v1_home_work_update" route
    Then response status code should be 204
    And response should be empty
    Then I see entity "App\Domain\Entity\HomeWork" with properties:
        """
        {
            "id": "8fcf5165-8a10-44ce-be25-21867da3b41b",
            "isCompleted": true
        }
        """

  Scenario: Behat Update Homework - fail blank params
    Given the request contains params:
        """
        {
            "id": ""
        }
        """
    And I send "PATCH" request to "api_saga_v1_home_work_update" route
    Then response status code should be 400
    #! failBlankParams
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeWorkUpdateForm.id.notBlank",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Update Homework - fail invalid id
    Given the request contains params:
        """
        {
          "id": "11111111-1111-1111-1111-111111111111"
        }
        """
    And I send "PATCH" request to "api_saga_v1_home_work_update" route
    Then response status code should be 400
    #! failInvalidId
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeWorkUpdateForm.id.invalid",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Update Homework - fail invalid id
    Given the request contains params:
        """
        {
          "id": "8fcf5165-8a10-44ce-be25-21867da3b49b"
        }
        """
    And I send "PATCH" request to "api_saga_v1_home_work_update" route
    Then response status code should be 400
    #! failNotFound
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeWorkUpdateForm.id.notFound",
                    "path": "id"
                }
            ],
            "params": null
        }
        """
  Scenario: Behat Update Homework - due date fail
    Given the request contains params:
        """
        {
          "id": "9fcf5165-8a10-44ce-be25-21867da3b41c"
        }
        """
    And I send "PATCH" request to "api_saga_v1_home_work_update" route
    Then response status code should be 422

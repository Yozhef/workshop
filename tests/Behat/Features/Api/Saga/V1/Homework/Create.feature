Feature:
  Behat Create Homework

  Background:
    Given I load fixtures "Base"
    Given I load redis fixtures "Base"

  Scenario: Behat Create Homework - success
    Then the request contains params:
        """
        {
            "id": "d6d08aaf-5dcf-440f-9038-d399b8f81016",
            "name": "test name",
            "description": "test desc"
        }
        """
    And I send "POST" request to "api_saga_v1_homework_create" route
    Then response status code should be 204
    And response should be empty
    And I see entity "App\Domain\Entity\Homework" with id "d6d08aaf-5dcf-440f-9038-d399b8f81016"
    And I see in redis value "test name" by key "d6d08aaf-5dcf-440f-9038-d399b8f81016"

  Scenario: Behat Create Homework - fail blank params
    Given the request contains params:
        """
        {
            "id": "1c9dff2f-81df-4454-96e5-8fa415cf3cc8",
            "name": ""
        }
        """
    And I send "POST" request to "api_saga_v1_homework_create" route
    Then response status code should be 400
    #! failBlankParams
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeworkCreateForm.name.notBlank",
                    "path": "name"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Create Homework - fail invalid id
    Given the request contains params:
        """
        {
          "id": "11111111-1111-1111-1111-111111111111",
          "name": "sadfasfd"
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
                    "code": "homeworkCreateForm.id.invalid",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Create Homework - fail entity already exist
    Given the request contains params:
        """
        {
          "id": "f22ea070-491a-4022-a986-84b6e0431ca9",
          "name": "Test homework 1",
            "description": "Test description 1"
        }
        """
    And I send "POST" request to "api_saga_v1_homework_create" route
    Then response status code should be 400
    #! failEntityAlreadyExist
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeworkCreateForm.id.notUnique",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

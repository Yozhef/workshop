Feature:
  Behat Create Home Work

Background:
  Given I load fixtures "HomeWork"

  Scenario: Behat Create Home Work - success
    Then the request contains params:
        """
        {
            "id": "14aef54b-9227-4984-b038-13634559e1a4",
            "title": "Do homework",
            "dueDate": "2023-10-01 00:00:00"
        }
        """
    And I send "POST" request to "api_saga_v1_homework_create" route
    Then response status code should be 204
    And response should be empty
    And I see entity "App\Domain\Entity\HomeWork" with id "14aef54b-9227-4984-b038-13634559e1a4"

  Scenario: Behat Create Home Work - fail blank params
    Given the request contains params:
        """
        {
            "id": "71828fa1-dec2-42e8-8361-c245344a1113",
            "title": "",
            "dueDate": ""
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
                    "code": "homeWorkCreateForm.title.notBlank",
                    "path": "title"
                },
                {
                    "code": "homeWorkCreateForm.dueDate.notBlank",
                    "path": "dueDate"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Create Home Work - fail invalid id
    Given the request contains params:
        """
        {
          "id": "11111111-1111-1111-1111-111111111111",
          "title": "sadfasfd",
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

  Scenario: Behat Create Home Work - fail entity already exist
    Given the request contains params:
        """
        {
          "id": "8fcf5165-8a10-44ce-be25-21867da3b41d",
          "title": "sadfasfd",
          "dueDate": "2023-10-01 00:00:00"
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
                    "code": "homeWorkCreateForm.id.notUnique",
                    "path": "id"
                }
            ],
            "params": null
        }
        """
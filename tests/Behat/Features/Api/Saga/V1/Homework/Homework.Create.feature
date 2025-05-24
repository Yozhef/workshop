Feature:
  Behat Create Homework

  Background:
    Given I load fixtures "HomeWork"

  Scenario: Behat Create Homework - success
    Then the request contains params:
        """
        {
            "id": "ca2b6efc-efcd-46b9-998f-64c1a15758f5",
            "title": "New home work",
            "dueDate": "2025-05-20"
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_create" route
    Then response status code should be 204
    And response should be empty
    And I see entity "App\Domain\Entity\HomeWork" with id "ca2b6efc-efcd-46b9-998f-64c1a15758f5"

  Scenario: Behat Create Homework - fail blank params
    Given the request contains params:
        """
        {
            "id": "71828fa1-dec2-42e8-8361-c245344a1113"
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_create" route
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

  Scenario: Behat Create Homework - fail invalid id
    Given the request contains params:
        """
        {
          "id": "11111111-1111-1111-1111-111111111111",
           "title": "New home work",
           "dueDate": "2025-05-20"
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_create" route
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

  Scenario: Behat Create Homework - fail entity already exist
    Given the request contains params:
        """
        {
          "id": "8fcf5165-8a10-44ce-be25-21867da3b41b",
           "title": "New home work",
           "dueDate": "2025-05-20"
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_create" route
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

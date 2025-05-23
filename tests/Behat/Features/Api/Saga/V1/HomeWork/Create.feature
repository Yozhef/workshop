Feature:
  Behat Create HomeWork

Background:
  Given I load fixtures "HomeWork"
  #Given I load redis fixtures "Base"

  Scenario: Behat Create HomeWork - success
    Then I don't see in redis value by key "homework.ca2b6efc-efcd-46b9-998f-64c1a15758f5"
    Then all transport "async" messages should be JSON:
      """
        [

        ]
      """
    Then the request contains params:
        """
        {
            "id": "ca2b6efc-efcd-46b9-998f-64c1a15758f5",
            "title": "test",
            "dueDate": "2023-10-01T00:00:00+00:00"
        }
        """
    And I send "POST" request to "api_saga_v1_homework_create" route
    Then response status code should be 204
    And response should be empty
    And I see entity "App\Domain\Entity\HomeWork" with id "ca2b6efc-efcd-46b9-998f-64c1a15758f5"
    And I see in redis any value by key "homework.ca2b6efc-efcd-46b9-998f-64c1a15758f5"
    Then all transport "async" messages should be JSON:
      """
        [
           {
              "id": "ca2b6efc-efcd-46b9-998f-64c1a15758f5",
              "title": "test",
              "dueDate": 1696118400
           }
        ]
      """

  Scenario: Behat Create HomeWork - fail blank params
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

  Scenario: Behat Create Home Work Date invalid date format
    Given the request contains params:
        """
        {
            "id": "71828fa1-dec2-42e8-8361-c245344a1113",
            "title": "test",
            "dueDate": "2023-10-01"
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
                    "code": "homeWorkCreateForm.dueDate.This value is not a valid datetime.",
                    "path": "dueDate"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Create HomeWork - fail invalid id format
    Given the request contains params:
        """
        {
          "id": "11111111-1111-1111-1111-111111111111",
          "title": "test",
          "dueDate": "2023-10-01T00:00:00+00:00"
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

  Scenario: Behat Create HomeWork - fail homework already exist by id
    Given the request contains params:
        """
        {
          "id": "99aa9f8c-6dc7-4ec6-bbd8-fbb381170f8d",
          "title": "testtesttest",
          "dueDate": "2023-10-01T00:00:00+00:00"
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

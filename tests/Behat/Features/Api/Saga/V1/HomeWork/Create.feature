Feature:
  Behat Create Homework

Background:
  Given I load fixtures "Homework"

  Scenario: Behat Create Homework - success
    Then the request contains params:
        """
        {
            "id": "e44a1720-5b10-4e53-a32a-9901db76c4f1",
            "title": "test homework",
            "dueDate": "2025-06-01T00:00:00+00:00"
        }
        """
    And I send "POST" request to "api_saga_v1_homework_create" route
    Then response status code should be 204
    And response should be empty
    And I see entity "App\Domain\Entity\HomeWork" with id "e44a1720-5b10-4e53-a32a-9901db76c4f1"
    Given I see in redis any value by key "homework.e44a1720-5b10-4e53-a32a-9901db76c4f1"
    Then  I see in redis value "test homework" by key "homework.e44a1720-5b10-4e53-a32a-9901db76c4f1"

  Scenario: Behat Create Homework - fail blank params
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

  Scenario: Behat Create Homework - fail invalid id
    Given the request contains params:
        """
        {
          "id": "11111111-1111-1111-1111-111111111111",
          "title": "test homework",
          "dueDate": "2025-06-01T00:00:00+00:00"
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

  Scenario: Behat Create Homework - fail dueDate in the past
    Given the request contains params:
        """
        {
          "id": "d2ab4fff-a504-4dfd-af3a-537947f69b0d",
          "title": "test homework",
          "dueDate": "2024-05-01T00:00:00+00:00"
        }
        """
    And I send "POST" request to "api_saga_v1_homework_create" route
    Then response status code should be 400
    #! failDueDateInThePast
    And response should be JSON:
        """
         {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeWorkCreateForm.dueDate.Due date cannot be in the past.",
                    "path": "dueDate"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Create Homework - fail invalid dueDate
    Given the request contains params:
        """
        {
          "id": "d2ab4fff-a504-4dfd-af3a-537947f69b0d",
          "title": "test homework",
          "dueDate": "01-01-2025 13:12"
        }
        """
    And I send "POST" request to "api_saga_v1_homework_create" route
    Then response status code should be 400
    #! failInvalidDueDate
    And response should be JSON:
        """
         {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeWorkCreateForm.dueDate.Please enter a valid date and time.",
                    "path": "dueDate"
                }
            ],
            "params": null
        }
        """

Feature:
  Behat Create Default Entity

Background:
  Given I load fixtures "Base"

  Scenario: Behat Create Default Entity - success
    Then the request contains params:
        """
        {
            "id": "c1fd9904-72a4-45fb-9df1-1c86a9f6c1cb",
            "title": "Test name 3",
            "dueDate": "2025-06-01T00:00:00.000Z"
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_create" route
    Then response status code should be 204
    And response should be empty
    And I see entity "App\Domain\Entity\HomeWork" with id "c1fd9904-72a4-45fb-9df1-1c86a9f6c1cb"
    Given I see in redis any value by key "home-work.c1fd9904-72a4-45fb-9df1-1c86a9f6c1cb"
    And all transport "async" messages should be JSON:
      """
        [
            {
                "id": "c1fd9904-72a4-45fb-9df1-1c86a9f6c1cb",
                "title": "Test name 3",
                "dueDate": 1748736000
            }
        ]
      """

  Scenario: Behat Create Home Work - fail blank params
    Given the request contains params:
        """
        {
            "id": "d490d916-f010-47ce-aa2c-3dc0150fd61b",
            "title": "",
            "dueDate": "2025-06-01T00:00:00.000Z"
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
          "title": "Some title",
          "dueDate": "2025-06-01T00:00:00.000Z"
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

  Scenario: Behat Create Home Work - fail invalid dueDate
    Given the request contains params:
        """
        {
          "id": "d490d916-f010-47ce-aa2c-3dc0150fd61b",
          "title": "Some title",
          "dueDate": "2025-06-01"
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_create" route
    Then response status code should be 400
    #! failInvalidDueDate
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeWorkCreateForm.dueDate.invalid",
                    "path": "dueDate"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Create Home Work - fail entity already exist
    Given the request contains params:
        """
        {
          "id": "6d095b85-e98f-49f1-b378-99097910367e",
          "title": "Test name 3",
          "dueDate": "2025-06-01T00:00:00.000Z"
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

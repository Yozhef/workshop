Feature:
  Behat Create Home Work

Background:
  Given I load fixtures "Base"

  Scenario: Behat Create Home Work - success
    Then the request contains params:
        """
        {
            "id": "ee2b6efc-efcd-46b9-998f-64c1a15758f5",
            "title": "test title",
            "dueDate": 1748017288
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_create" route
    Then response status code should be 204
    And response should be empty
    Then all transport "async" messages should be JSON:
      """
        [
           {
                "id": "ee2b6efc-efcd-46b9-998f-64c1a15758f5",
                "name": "home-work"
            }
        ]
      """
    And I see in redis any value by key "home-work.ee2b6efc-efcd-46b9-998f-64c1a15758f5"
    And I see entity "App\Domain\Entity\HomeWork" with id "ee2b6efc-efcd-46b9-998f-64c1a15758f5"

  Scenario: Behat Create Home Work - fail blank params
    Given the request contains params:
        """
        {
            "id": "71828fa1-dec2-42e8-8361-c245344a1113",
            "title": "",
            "dueDate": ""
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

  Scenario: Behat Create Home Work - fail invalid id
    Given the request contains params:
        """
        {
          "id": "11111111-1111-1111-1111-111111111111",
          "title": "sadfasfd",
          "dueDate": 1748017288
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

  Scenario: Behat Create Home Work - fail entity already exist
    Given the request contains params:
        """
        {
          "id": "e12b6efc-efcd-46b9-998f-64c1a15758f5",
          "title": "sadfasfd",
          "dueDate": 1748017288
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

@HomeWork

Feature:
  Behat Create Home Work

Background:
  Given I load fixtures "Base"

  Scenario: Behat Create Home work - success
    Then the request contains params:
        """
        {
            "id": "1cfd3f63-f8e9-4210-8948-91b05e62d54f",
            "title": "Title name",
            "dueDate": "2026-06-01"
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_create" route
    Then response status code should be 204
    And response should be empty
    And I see entity "App\Domain\Entity\HomeWork" with id "1cfd3f63-f8e9-4210-8948-91b05e62d54f"
    Given I see in redis any value by key "home-work.1cfd3f63-f8e9-4210-8948-91b05e62d54f"

  Scenario: Behat Create HomeWork - fail blank params
    Given the request contains params:
        """
        {
            "id": "1cfd3f63-f8e9-4210-8948-91b05e62d54f",
            "title": "",
            "dueDate": "",
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
                    "code": "homeWorkCreateForm.name.notBlank",
                    "path": "title"
                },
                {
                    "code": "homeWorkCreateForm.name.notBlank",
                    "path": "dueDate"
                }
            ],
            "params": null
        }
        """

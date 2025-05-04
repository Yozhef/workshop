Feature:
  Behat Update Default Entity

Background:
  Given I load fixtures "Base"

  Scenario: Behat Update Default Entity - success
    Given I see entity "App\Domain\Entity\DefaultEntity" with properties:
        """
        {
            "id": "8fcf5165-8a10-44ce-be25-21867da3b41c",
            "name": "Test name 2"
        }
        """
    And the request contains params:
        """
        {
            "id": "8fcf5165-8a10-44ce-be25-21867da3b41c",
            "name": "new test"
        }
        """
    And I send "PATCH" request to "api_saga_v1_default_entity_update" route
    Then response status code should be 204
    And response should be empty
    Then I see entity "App\Domain\Entity\DefaultEntity" with properties:
        """
        {
            "id": "8fcf5165-8a10-44ce-be25-21867da3b41c",
            "name": "new test"
        }
        """

  Scenario: Behat Update Default Entity - fail blank params
    Given the request contains params:
        """
        {
            "id": "",
            "name": ""
        }
        """
    And I send "PATCH" request to "api_saga_v1_default_entity_update" route
    Then response status code should be 400
    #! failBlankParams
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "defaultEntityUpdateForm.id.notBlank",
                    "path": "id"
                },
                {
                    "code": "defaultEntityUpdateForm.name.notBlank",
                    "path": "name"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Update Default Entity - fail invalid id
    Given the request contains params:
        """
        {
          "id": "11111111-1111-1111-1111-111111111111",
          "name": "sadfasfd"
        }
        """
    And I send "PATCH" request to "api_saga_v1_default_entity_update" route
    Then response status code should be 400
    #! failInvalidId
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "defaultEntityUpdateForm.id.invalid",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Update Default Entity - fail invalid id
    Given the request contains params:
        """
        {
          "id": "8fcf5165-8a10-44ce-be25-21867da3b49b",
          "name": "sadfasfd"
        }
        """
    And I send "PATCH" request to "api_saga_v1_default_entity_update" route
    Then response status code should be 400
    #! failNotFound
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "defaultEntityUpdateForm.id.notFound",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

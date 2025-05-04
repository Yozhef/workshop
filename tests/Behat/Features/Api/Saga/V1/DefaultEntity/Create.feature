Feature:
  Behat Create Default Entity

Background:
  Given I load fixtures "Base"

  Scenario: Behat Create Default Entity - success
    Then the request contains params:
        """
        {
            "id": "ca2b6efc-efcd-46b9-998f-64c1a15758f5",
            "name": "test"
        }
        """
    And I send "POST" request to "api_saga_v1_default_entity_create" route
    Then response status code should be 204
    And response should be empty
    And I see entity "App\Domain\Entity\DefaultEntity" with id "ca2b6efc-efcd-46b9-998f-64c1a15758f5"

  Scenario: Behat Create Default Entity - fail blank params
    Given the request contains params:
        """
        {
            "id": "71828fa1-dec2-42e8-8361-c245344a1113",
            "name": ""
        }
        """
    And I send "POST" request to "api_saga_v1_default_entity_create" route
    Then response status code should be 400
    #! failBlankParams
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "defaultEntityCreateForm.name.notBlank",
                    "path": "name"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Create Default Entity - fail invalid id
    Given the request contains params:
        """
        {
          "id": "11111111-1111-1111-1111-111111111111",
          "name": "sadfasfd"
        }
        """
    And I send "POST" request to "api_saga_v1_default_entity_create" route
    Then response status code should be 400
    #! failInvalidId
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "defaultEntityCreateForm.id.invalid",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Create Default Entity - fail entity already exist
    Given the request contains params:
        """
        {
          "id": "8fcf5165-8a10-44ce-be25-21867da3b41c",
          "name": "sadfasfd"
        }
        """
    And I send "POST" request to "api_saga_v1_default_entity_create" route
    Then response status code should be 400
    #! failEntityAlreadyExist
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "defaultEntityCreateForm.id.notUnique",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

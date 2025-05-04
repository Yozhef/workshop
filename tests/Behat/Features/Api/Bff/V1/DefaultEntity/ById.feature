Feature:
  Behat Get Default Entity By Id

Background:
  Given I load fixtures "Base"

  Scenario: Get Default Entity By Id - success
    Given the request contains params:
        """
        {
            "id": "8fcf5165-8a10-44ce-be25-21867da3b41b"
        }
        """
    And I send "GET" request to "api_bff_v1_default_entity_by_id" route
    Then response status code should be 200
    #! success
    And response should be JSON:
        """
        {
            "data": {
                "id": "8fcf5165-8a10-44ce-be25-21867da3b41b",
                "name": "Test name"
            }
        }
        """

  Scenario: Get Default Entity By Id - fail invalid id
    Given the request contains params:
        """
        {
          "id": "8fcf5165-1111-1111-1111-21867da3b41b"
        }
        """
    And I send "GET" request to "api_bff_v1_default_entity_by_id" route
    Then response status code should be 400
    #! failInvalidId
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "defaultEntityByIdForm.id.invalid",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

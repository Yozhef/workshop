Feature:
  Behat Get HomeWork By Id

Background:
  Given I load fixtures "Base"

  Scenario: Get HomeWork By Id - success
    Given the request contains params:
        """
        {
            "id": "dbf6d1a6-76d2-4120-a0e3-5288ea8afc5c"
        }
        """
    And I send "GET" request to "api_bff_v1_home_work_by_id" route
    Then response status code should be 200
    #! success
    And response should be JSON:
        """
        {
            "data": {
                "id": "dbf6d1a6-76d2-4120-a0e3-5288ea8afc5c",
                "title": "Test title"
            }
        }
        """

  Scenario: Get HomeWork By Id - fail invalid id
    Given the request contains params:
        """
        {
          "id": "3f9699fc-ece9-400d-9780-2081874fee9c"
        }
        """
    And I send "GET" request to "api_bff_v1_home_work_by_id" route
    Then response status code should be 400
    #! failInvalidId
    And response should be JSON:
        """
        {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeWorkByIdForm.id.notFound",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

Feature:
  Behat Get Home Work By Id

Background:
  Given I load fixtures "HomeWork"

  Scenario: Behat Get Home Work By Id - success
    Given the request contains params:
        """
        {
            "id": "8fcf5165-8a10-44ce-be25-21867da3b41d"
        }
        """
    And I send "GET" request to "api_bff_v1_home_work_by_id" route
    Then response status code should be 200
    #! success
    And response should be JSON:
        """
        {
            "data": {
                "id": "8fcf5165-8a10-44ce-be25-21867da3b41d",
                "title": "Test homework name",
                "dueDate": 1748736000,
                "isCompleted": false
            }
        }
        """

  Scenario: Behat Get Home Work By Id - fail invalid id format
    Given the request contains params:
        """
        {
            "id": "8fcf5165-1111-1111-1111-21867da3b41b"
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
                    "code": "homeWorkByIdForm.id.invalid",
                    "path": "id"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Get Home Work By Id - fail not found
    Given the request contains params:
        """
        {
            "id": "ea55d642-73e4-4383-b88b-f80ee7b3b551"
        }
        """
    And I send "GET" request to "api_bff_v1_home_work_by_id" route
    Then response status code should be 400
    #! failNotFound
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
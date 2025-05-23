Feature:
  Behat Get Home Work By Id

Background:
  Given I load fixtures "Base"

  Scenario: Get Home Work By Id - success
    Given the request contains params:
        """
        {
            "id": "6d095b85-e98f-49f1-b378-99097910367e"
        }
        """
    And I send "GET" request to "api_bff_v1_home_work_by_id" route
    Then response status code should be 200
    #! success
    And response should be JSON:
        """
        {
            "data": {
                "id": "6d095b85-e98f-49f1-b378-99097910367e",
                "title": "Test 1",
                "dueDate": 1746057600,
                "isCompleted": false
            }
        }
        """

  Scenario: Get Home Work By Id - fail invalid id
    Given the request contains params:
        """
        {
          "id": "6d095b85-1111-1111-1111-99097910367e"
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

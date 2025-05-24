Feature:
  Behat Get Home Work By Id

Background:
  Given I load fixtures "Base"

  Scenario: Get Home Work By Id - success
    Given the request contains params:
        """
        {
            "id": "e12b6efc-efcd-46b9-998f-64c1a15758f5"
        }
        """
    And I send "GET" request to "api_bff_v1_home_work_by_id" route
    Then response status code should be 200
    #! success
    And response should be JSON:
        """
        {
            "data": {
                 "id": "e12b6efc-efcd-46b9-998f-64c1a15758f5",
                "title": "Test title 1",
                "dueDate": 1772323200,
                "isCompleted": false
            }
        }
        """

  Scenario: Get Home Work By Id - fail invalid id
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

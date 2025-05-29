Feature:
  Behat Get Homework By Id

Background:
  Given I load fixtures "Homework"

  Scenario: Get Homework By Id - success
    Given the request contains params:
        """
        {
            "id": "1618c4cd-86ed-4d29-ac75-6f406cc95e72"
        }
        """
    And I send "GET" request to "api_bff_v1_home_work_by_id" route
    Then response status code should be 200
    #! success
    And response should be JSON:
        """
        {
            "data": {
                "id": "1618c4cd-86ed-4d29-ac75-6f406cc95e72",
                "title": "Science project",
                "dueDate": 1751241600,
                "isCompleted": false
            }
        }
        """

  Scenario: Get Homework By Id - fail invalid id
    Given the request contains params:
        """
        {
          "id": "a1b2c3d4-5678-90ab-cdef-1234567890a1"
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

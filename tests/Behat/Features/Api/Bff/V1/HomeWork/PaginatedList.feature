Feature:
  Behat Home Work list

  Background:
    Given I load fixtures "Base"

  Scenario: Behat Home Work list - success
    Given the request contains params:
        """
        {
            "limit": 1,
            "offset": 0
        }
        """
    And I send "GET" request to "api_bff_v1_home_work_paginated_list" route
    Then response status code should be 200
    #! success
    And response should be JSON:
        """
        {
            "data": [
                {
                    "id": "e12b6efc-efcd-46b9-998f-64c1a15758f5",
                    "title": "Test title 1",
                    "dueDate": 1772323200,
                    "isCompleted": false
                }
            ],
            "pagination": {
                "perPage": 1,
                "pagesCount": 2,
                "currentPage": 1,
                "elementsCount": 2
            }
        }
        """

  Scenario: Behat Home Work list - fail params is not int
    Given the request contains params:
        """
        {
            "limit": "string",
            "offset": "string"
        }
        """
    And I send "GET" request to "api_bff_v1_home_work_paginated_list" route
    Then response status code should be 400
    #! failInvalidParamsNotInteger
    And response should be JSON:
        """
         {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeWorkPaginatedListForm.limit.invalid",
                    "path": "limit"
                },
                {
                    "code": "homeWorkPaginatedListForm.offset.invalid",
                    "path": "offset"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Home Work list - fail invalid params is not positive
    Given the request contains params:
        """
        {
            "limit": -1,
            "offset": -1
        }
        """
    And I send "GET" request to "api_bff_v1_home_work_paginated_list" route
    Then response status code should be 400
    #! failInvalidParamsNotPositive
    And response should be JSON:
        """
         {
            "code": "400",
            "message": "Validation Failed",
            "errors": [
                {
                    "code": "homeWorkPaginatedListForm.limit.greaterThan",
                    "path": "limit"
                },
                {
                    "code": "homeWorkPaginatedListForm.offset.greaterThanEqual",
                    "path": "offset"
                }
            ],
            "params": null
        }
        """

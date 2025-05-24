Feature:
  Homework list

  Background:
    Given I load fixtures "HomeWork"

  Scenario: Homework list - success
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
                    "id": "8fcf5165-8a10-44ce-be25-21867da3b41b",
                    "title": "Test Homework 1",
                    "dueDate": 1748563200,
                    "isCompleted": false
                }
            ],
            "pagination": {
                "perPage": 1,
                "pagesCount": 3,
                "currentPage": 1,
                "elementsCount": 3
            }
        }
        """

  Scenario: Homework list - fail params is not int
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

  Scenario: Homework list - fail invalid params is not positive
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

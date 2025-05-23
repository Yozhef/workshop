Feature:
  Behat homework list

  Background:
    Given I load fixtures "Base"

  Scenario: Behat Dummy list - success
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
                    "name": "Test name"
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

  Scenario: Behat Dummy list - fail params is not int
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
                    "code": "defaultEntityPaginatedListForm.limit.invalid",
                    "path": "limit"
                },
                {
                    "code": "defaultEntityPaginatedListForm.offset.invalid",
                    "path": "offset"
                }
            ],
            "params": null
        }
        """

  Scenario: Behat Dummy list - fail invalid params is not positive
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
                    "code": "defaultEntityPaginatedListForm.limit.greaterThan",
                    "path": "limit"
                },
                {
                    "code": "defaultEntityPaginatedListForm.offset.greaterThanEqual",
                    "path": "offset"
                }
            ],
            "params": null
        }
        """

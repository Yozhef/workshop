Feature:
  Behat homework list

  Background:
    Given I load fixtures "Homework"

  Scenario: Behat list - success
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
                    "id": "a1b2c3d4-5678-90ab-cdef-1234567890ab",
                    "title": "Math assignment",
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

  Scenario: Behat list - page 2
    Given the request contains params:
        """
        {
            "limit": 1,
            "offset": 1
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
                    "id": "1618c4cd-86ed-4d29-ac75-6f406cc95e72",
                    "title": "Science project",
                    "dueDate": 1751241600,
                    "isCompleted": false
                }
            ],
            "pagination": {
                "perPage": 1,
                "pagesCount": 3,
                "currentPage": 2,
                "elementsCount": 3
            }
        }
        """

  Scenario: Behat list - limit 3
    Given the request contains params:
        """
        {
            "limit": 3,
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
                    "id": "a1b2c3d4-5678-90ab-cdef-1234567890ab",
                    "title": "Math assignment",
                    "dueDate": 1748563200,
                    "isCompleted": false
                },
                {
                    "id": "1618c4cd-86ed-4d29-ac75-6f406cc95e72",
                    "title": "Science project",
                    "dueDate": 1751241600,
                    "isCompleted": false
                },
                {
                    "id": "c3d4e5f6-7890-12cd-ef01-3456789012cd",
                    "title": "History essay",
                    "dueDate": 1752537600,
                    "isCompleted": false
                }
            ],
            "pagination": {
                "perPage": 3,
                "pagesCount": 1,
                "currentPage": 1,
                "elementsCount": 3
            }
        }
        """

  Scenario: Behat list - fail params is not int
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


  Scenario: Behat Dummy list - blank body
    Given the request contains params:
        """
        {}
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
                    "code": "homeWorkPaginatedListForm.limit.notBlank",
                    "path": "limit"
                },
                {
                    "code": "homeWorkPaginatedListForm.offset.notBlank",
                    "path": "offset"
                }
            ],
            "params": null
        }
        """


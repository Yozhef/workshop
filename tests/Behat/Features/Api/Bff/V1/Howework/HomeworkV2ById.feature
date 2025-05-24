Feature: Get entity by provided id
  Background:
    Given I load fixtures "Base"


  Scenario: I get entity by id
    Given the request contains params:
        """
        {
            "id": "039349de-35cc-46fb-951f-58e5f310f8a6"
        }
        """
    And I send "GET" request to "find_home_work_by_id" route
    Then response status code should be 200
    And response should be JSON:
        """
        {
            "id": "039349de-35cc-46fb-951f-58e5f310f8a6",
            "name": "Test homework 2",
            "description": "Test description 2"
        }
        """


    Scenario: I get entity by id with not found
      Given I send "GET" request to "list_all_home_works" route
      Then response status code should be 200
      And response should be JSON:
      """
        [
        {
            "id": "f22ea070-491a-4022-a986-84b6e0431ca9",
            "name": "Test homework 1",
            "description": "Test description 1"
        },
        {
            "id": "039349de-35cc-46fb-951f-58e5f310f8a6",
            "name": "Test homework 2",
            "description": "Test description 2"
        },

        {
            "id": "cbcbe2f6-679e-4b26-b368-82ea659923dc",
            "name": "Test homework 3",
            "description": "Test description 3"
        }]
        """
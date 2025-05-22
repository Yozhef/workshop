Feature:
  list all homeworks from database

  Background:
    Given I load fixtures "Base"

  Scenario: I get all homeworks
    Given I send "GET" request to "homeworks_list" route
    Then response status code should be 200
    #! success
    And response should be JSON:
        """
        {
          "list": [
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
            }
          ]
        }
        """
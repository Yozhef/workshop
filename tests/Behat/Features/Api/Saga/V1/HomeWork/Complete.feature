Feature:
  Behat Complete Home Work

  Background:
    Given I load fixtures "Base"

  Scenario: Behat Complete Home Work - success
    Given the request contains params:
        """
        {
            "id": "e12b6efc-efcd-46b9-998f-64c1a15758f5"
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_complete" route
    Then response status code should be 204
    And response should be empty
    And I see entity "App\Domain\Entity\HomeWork" with properties:
        """
        {
            "id": "e12b6efc-efcd-46b9-998f-64c1a15758f5",
            "isCompleted": true
        }
        """

  Scenario: Behat Complete Home Work - is not success
    Given the request contains params:
        """
        {
            "id": "e22b6efc-efcd-46b9-998f-64c1a15758f5"
        }
        """
    And I send "POST" request to "api_saga_v1_home_work_complete" route
    Then response status code should be 400
    And response should be JSON:
        """
        {"code":"400","message":"Http Exception","errors":[{"code":"Cannot complete outdated homework"}],"params":null}
        """


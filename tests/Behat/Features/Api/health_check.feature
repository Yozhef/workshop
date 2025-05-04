Feature:
  As a customer
  I should be able to get health check status.

  Scenario: Health check - success
    When I send "GET" request to "health" route
    Then response status code should be 200
    And response should be JSON:
        """
        [
            {
                "name": "status",
                "result": true,
                "message": "up",
                "params": []
            }
        ]
        """

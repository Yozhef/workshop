Feature:
  As a customer
  I should be able to get ping check status.

  Scenario: Ping check - success
    When I send "GET" request to "ping" route
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

Feature:
    Behat CRUD Homework

    Background:
        Given I load fixtures "Base"
        Given I load redis fixtures "Base"

    Scenario: Behat CRUD Homework - success
        Then the request contains params:
            """
            {
                "id": "d6d08aaf-5dcf-440f-9038-d399b8f81016",
                "name": "test name",
                "description": "test desc"
            }
            """
        And I send "PUT" request to "homework_add" route
        Then response status code should be 204
        And response should be empty
        And I see entity "App\Domain\Entity\Homework" with id "d6d08aaf-5dcf-440f-9038-d399b8f81016"
        And I see in redis value "test name" by key "d6d08aaf-5dcf-440f-9038-d399b8f81016"


    Scenario: Some error while adding homework
        Given the request contains params:
            """
            {
                "id": "111",
                "name": "test name",
                "description": "test desc"
            }
            """
        And I send "PUT" request to "homework_add" route
        Then response status code should be 400

    Scenario: Invalid body without valid id
        Given the request contains params:
            """
            {
                "name": "invalid test name",
                "description": "invalid test desc"
            }
            """
        And I send "PUT" request to "homework_add" route
        Then response status code should be 400
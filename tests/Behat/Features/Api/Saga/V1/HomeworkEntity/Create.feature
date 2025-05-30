Feature:
  Behat Create Homework Entity

  Background:
    Given I load fixtures "Base"

  Scenario: Behat Create Homework Entity - success
    Then the request contains params:
        """
        {
            "id": "ca2b6efc-efcd-46b9-998f-64c1a15758f4",
            "title": "Crash Course: Behat & BDD Homework",
            "description": "creating a controller that: - Creates a new homework entity and saves it to the database, - Stores the homework ID in Redis, - Dispatches the homework to an asynchronous queue (e.g., using Symfony Messenger), Cover with Behat tests implemented endpoints: - Retrieve all homework entries (GET /homeworks), - Retrieve a specific homework entry by ID (GET /homeworks/{id})"
        }
        """
    And I send "POST" request to "api_saga_v1_homework_entity_create" route
    Then response status code should be 204
    And response should be empty
    And I see entity "App\Domain\Entity\HomeworkEntity" with id "ca2b6efc-efcd-46b9-998f-64c1a15758f4"
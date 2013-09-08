Feature: User sessions
  In order to access their account
  As a user
  I need to be able to log into the website

  Scenario: Login
    Given I am on "/"
    And I follow "connexion"
    And I am on "/login"
    And there are users:
      | username     | password | email          |
      | johnkrovitch | krovitch | johnkrovitch@gmail.com |
    When I fill in "username" with "johnkrovitch"
    And I fill in "password" with "krovitch"
    And I press "se connecter"
    Then I should be on "/"

  Scenario: Logout
    Given I am on "/login"
    And I fill in "username" with "johnkrovitch"
    And I fill in "password" with "krovitch"
    And I press "se connecter"
    And I should see "déconnexion"
    When I follow "déconnexion"
    Then I should be on "/"
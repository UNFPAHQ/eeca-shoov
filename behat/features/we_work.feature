Feature:
  In order to be able to view the we work page
  As an anonymous user
  We need to be able to have access to the we work page

  @api
  Scenario Outline: Check the links.
    Given I am an anonymous user
    When  I visit the "where-we-work" page
    And   I click "<country>"
    Then  I should see "<title>"

    Examples:
      | country      | title               |
      | Albania      | UNFPA Albania       |

  @api
  Scenario: Downloading files in all languages
    Given I am an anonymous user
    When  I visit the "where-we-work" page
    Then  I download the country factsheet file:
      | Belarus |
      | Turkey  |

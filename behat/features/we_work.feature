Feature:
  In order to be able to view the we work page
  As an anonymous user
  We need to be able to have access to the we work page

  @api
  Scenario: Check that we get a default text appear on the page.
    Given I am an anonymous user
    When  I visit the "where-we-work" page
    Then  I should see text:
      | Where We Work             |
      | Republic of Moldova       |
      | TFY Republic of Macedonia |

  @api
  Scenario Outline: Check the links.
    Given I am an anonymous user
    When  I visit the "where-we-work" page
    And   I click "<country>"
    Then  I should see "<title>"

    Examples:
      | country      | title               |
      | Albania      | UNFPA Albania       |
      | Kazakhstan   | UNFPA IN KAZAKHSTAN |

  @api
  Scenario: Downloading files in all languages
    Given I am an anonymous user
    When  I visit the "where-we-work" page
    Then  I download the country factsheet file:
      | Belarus |
      | Turkey  |

Feature:
  In order to be able to view the publications page
  As an anonymous user
  We need to be able to have access to the publications page

  @api
  Scenario: Check that we get a default set of articles that appear on the page.
    Given I am an anonymous user
    When  I visit the "publications" page
    Then  I should see text:
      | State of World Population 2015                                                 |
      | Ukraine Humanitarian Newsletter, Issue 2                                       |

  @api
  Scenario: Check the articles filters.
    Given I am an anonymous user
    When  I visit the "publications" page
    And   I set the filters:
      | title | #edit-title                                   | The Role of Parliamentarians in Cervical Cancer Prevention |
      | year  | #edit-field-publication-date-value-value-year | 2015                                                       |
    And   I press "Go"
    Then  I should see "The Role of Parliamentarians in Cervical Cancer Prevention"

  @api
  Scenario Outline: Downloading files in all languages
    Given I am an anonymous user
    When  I visit the "publications" page
    And   I click "<publication title>"
    Then  I download the article files in all languages

    Examples:
      | publication title                        |
      | State of World Population 2015           |
      | Ukraine Humanitarian Newsletter, Issue 2 |

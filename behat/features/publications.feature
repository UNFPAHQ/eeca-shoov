Feature:
  In order to be able to view the publications page
  As an anonymous user
  We need to be able to have access to the publications page

  @api
  Scenario Outline: Downloading files in all languages
    Given I am an anonymous user
    When  I visit the "publications" page
    And   I click "<publication title>"
    Then  I download the article files in all languages

    Examples:
      | publication title                        |
      | State of World Population 2015           |

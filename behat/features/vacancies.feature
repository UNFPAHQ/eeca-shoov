Feature:
  In order to be able to download the Vacancies PDFs
  As an anonymous user
  We need to be able to have access to the Vacancies page

  @api
  Scenario: Check that we get a default set of articles that appear on
  the page when we have no filters.
    Given I am an anonymous user
    When  I visit the "vacancies" page
    Then  I should see text:
      | Administrative Assistant |
      | Programme Assistant      |
      | Local consultant         |

  @api
  Scenario Outline: Check the articles filters.
    Given I am an anonymous user
    When  I visit the "vacancies" page
    And   I click "<titles>"
    Then  I download the PDF file

    Examples:
      | titles                   |
      | Administrative Assistant |
      | Programme Assistant      |
      | Local consultant         |

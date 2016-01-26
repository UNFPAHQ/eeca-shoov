Feature:
  In order to be able to view the topics articles
  As an anonymous user
  We need to be able to have access to the topics page

  @api
  Scenario: Check that we get a default set of articles that appear on the page.
    Given I am an anonymous user
    When  I visit the "topics/sexual-and-reproductive-health" page
    Then  I should see text:
      | Sexual and Reproductive Health         |
      | Sofia Declaration of Commitment        |
      | Sexual and Reproductive Health in EECA |

  @api
  Scenario Outline: Check the articles pager redirects us to a new page that displays a new set of articles
    Given I am an anonymous user
    When  I visit the "topics/sexual-and-reproductive-health" page
    And   I click on "Go to page 3" link in "<section>"
    Then  I should see "<article text>"

    Examples:
      | section                    | article text                                                        |
      | Related News pager         | Coordinating efforts to reduce maternal, infant and child mortality |

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

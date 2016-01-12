Feature:
  In order to be able to view the news page
  As an anonymous user
  We need to be able to have access to the news page

  @api
  Scenario: Check that we get a default set of articles that appear on the page.
    Given I am an anonymous user
    When  I visit the "news" page
    Then  I should see text:
      | Youth advocates take on child marriage, gender inequality in Albania |
      | UNFPA Executive Director visits Turkmenistan                         |
      | Y-Peer Moldova brings sexual health education to vulnerable youth    |

  @api
  Scenario: Check the articles filters.
    Given I am an anonymous user
    When  I visit the "news" page
    And   I set the filters:
      | text          | #edit-title                            | UNFPA welcomes adoption of youth policy in Georgia |
      | date          | #edit-field-news-date-value-value-year | 2014                                       |
      | thematic area | #edit-field-thematic-area-tid          | Young people                               |
      | type          | #edit-field-news-type-value            | Dispatch                                   |
    And   I press "Go"
    Then  I should see "UNFPA welcomes adoption of youth policy in Georgia"

Feature: Homepage
  In order to be able to view the homepage
  As an anonymous user
  We need to be able to have access to the homepage

  @api
  Scenario: Visit the homepage
    Given I am an anonymous user
    When  I visit the homepage
    Then  I should have access to the page


  @api
  Scenario Outline: Visit the site main links.
    Given I am an anonymous user
    When  I visit the homepage
    Then  I should see the "<section>" with the "<link>" and have access to the link destination

    Examples:
      | section             | link                                                                |
      | main menu           | Home                                                                |
      | main menu           | What We Do                                                          |
      | main menu           | Where We Work                                                       |
      | main menu           | Topics                                                              |
      | main menu           | News                                                                |
      | main menu           | Publications                                                        |
      | sub menu            | About UNFPA (Global site)                                           |
      | sub menu            | Belarus                                                             |
      | sub menu            | Kyrgyz Republic                                                     |
      | sub menu            | Maternal Health                                                     |
      | sub menu            | Gender-biased Sex Selection                                         |
      | news                | More News                                                           |
      | publications        | Addressing the Needs of Women and Girls in Humanitarian Emergencies |
      | publications        | State of World Population 2015                                      |
      | publications        | More Publications                                                   |
      | videos              | Sustainable Development Goals explained: Good health and well-being |
      | videos              | More Videos                                                         |
      | stay connected      | Facebook                                                            |
      | stay connected      | Twitter                                                             |
      | stay connected      | Youtube                                                             |
      | footer              | Contact                                                             |
      | footer              | Terms of Use                                                        |
      | footer              | Transparency                                                        |
      | footer              | Sitemap                                                             |
      | footer              | Vacancies                                                           |
      | footer social links | Twitter                                                             |
      | footer social links | Facebook                                                            |
      | footer social links | Youtube                                                             |

<?php

use Drupal\DrupalExtension\Context\DrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use GuzzleHttp\Client;

class FeatureContext extends DrupalContext implements SnippetAcceptingContext {


  /**
   * @When /^I visit the homepage$/
   */
  public function iVisitTheHomepage() {
    $this->getSession()->visit($this->locatePath('/'));
  }

  /**
   * @When I visit the :arg1 page
   */
  public function iVisitThePage($page) {
    $this->getSession()
      ->visit($this->locatePath('/' . $page));
  }

  /**
   * @Then I should have access to the page
   */
  public function iShouldHaveAccessToThePage() {
    $this->assertSession()->statusCodeEquals('200');
  }

  /**
   * @Then I should not have access to the page
   */
  public function iShouldNotHaveAccessToThePage() {
    $this->assertSession()->statusCodeEquals('403');
  }

  /**
   * Get the anchor element by it's text and it's relative parent element.
   *
   * @param $section
   *  The anchor element relative parent element.
   * @param $link_text
   *  The anchor element text.
   * @return mixed|null
   * @throws Exception
   */
  private function getLinkElement($section, $link_text) {
    $page = $this->getSession()->getPage();

    switch ($section) {
      case 'main menu':
        $link = $page->find('xpath', '//section[@id="block-system-main-menu"]//ul[@class="menu"]//li[contains(@class, "level-1")]/a[contains(., "' . $link_text .'")]');
        break;

      case 'sub menu':
        $link = $page->find('xpath', '//section[@id="block-system-main-menu"]//ul[@class="menu"]//li[contains(@class, "level-2")]/a[contains(., "' . $link_text .'")]');
        break;

      case 'events':
        $link = $page->find('xpath', '//div[contains(@class, "view-vw-events")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'carousel':
        $link = $page->find('xpath', '//div[contains(@class, "carousel")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'news':
        $link = $page->find('xpath', '//div[contains(@class, "pane-vw-news")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'videos':
        $link = $page->find('xpath', '//div[contains(@class, "pane-vw-video")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'publications':
        $link = $page->find('xpath', '//div[contains(@class, "pane-vw-publications")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'stay connected':
        $link = $page->find('xpath', '//div[contains(@class, "stay_connected")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'footer':
        $link = $page->find('xpath', '//div[@id="footer_links"]//ul[@class="menu"]//li[contains(@class, "level-1")]/a[contains(., "' . $link_text .'")]');
        break;

      case 'footer social links':
        $link = $page->find('xpath', '//div[@id="footer_social"]//a[contains(., "' . $link_text .'")]');
        break;

      case 'fistula Q&A':
        $link = $page->find('xpath', '//div[contains(@class, "views-field views-field-field-answer")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'Related News pager':
        $link = $page->find('xpath', '//div[contains(@class, "pane-custom-custom-topic-related-news")]//ul[@class="pager"]//a[contains(@title, "' . $link_text .'")]');
        break;

      case 'Related Publications pager':
        $link = $page->find('xpath', '//div[contains(@class, "pane-custom-custom-topic-related-pubs")]//ul[@class="pager"]//a[contains(@title, "' . $link_text .'")]');
        break;

      default:
        $link = FALSE;
    }

    // In case we have no links.
    if (!$link) {
      $variables = array('@section' => $section, '@link' => $link_text);
      throw new \Exception(format_string("The link: '@link' was not found on section: '@section'", $variables));
    }
    return $link;
  }

  /**
  * @When I click on :arg1 link in :arg2
  */
  public function iClickOnLinkIn($link, $section) {
    $link = $this->getLinkElement($section, $link);
    $link->click();
  }

  /**
   * @Then I should see the :arg1 with the :arg2 and have access to the link destination
   */
  public function iShouldSeeTheWithTheAndHaveAccessToTheLinkDestination($section, $link_text) {

    $link = $this->getLinkElement($section, $link_text);

    // Check if we have access to the page (link url).
    $link->click();
    $url = $this->getSession()->getCurrentUrl();
    $code = $this->getSession()->getStatusCode();
    // In case the link url doesn't return a status code of '200'.
    if ($code != '200')  {
      $variables = array(
        '@code' => $code,
        '@url' => $url,
        '@section' => $section,
      );
      $message = "The page code is '@code' it expects it to be '200' (from url: @url at section: @section)";
      throw new \Exception(format_string($message, $variables));
    }
  }

  /**
   * @Given /^I set the filters:$/
   */
  public function iSetTheFilters(TableNode $table) {
    $page = $this->getSession()->getPage();

    // Iterate over each filter and set it's field value accordingly.
    foreach ($table->getRows() as $filters => $filter_data) {

      // Get the filter data: (name, element selector ,value).
      list($filter_name, $filter, $filter_value) = $filter_data;

      // In case the target element is not found.
      $element = $page->find('css', $filter);
      if (!$element) {
        $variables = array(
          '@name' => $filter_name,
          '@id' => $filter,
        );
        throw new \Exception(format_string("The '@name' filter field with id: '@id' was not found", $variables));
      }
      $this->setElementValue($element, $filter_value);
    }
  }

  /**
   * @Then /^I should see text:$/
   */
  public function iShouldSeeText(TableNode $table) {
    // Iterate over each title and check if it's in the page.
    foreach ($table->getRows() as $titles) {
      foreach ($titles as $title) {
        if (strpos($this->getSession()->getPage()->getText(), $title) === FALSE) {
          throw new \Exception(format_string("Can't find the text '@title' on the page: @url", array('@title' => $title, '@url' => $this->getSession()->getCurrentUrl())));
        }
      }
    }
  }

  /**
   * Set an element value according to its type e.g. input || select etc.
   *
   * @param $element
   *  The target  html element to set it's value.
   * @param $value
   *  The value to be assigned to the element.
   * @throws Exception
   * @return bool
   *  In case of a success returns TRUE else throws an Exception.
   */
  private function setElementValue($element, $value) {
    // Get the element tag name.
    $tag_name = $element->getTagName();
    // Flag to identify if an element was set with a value.
    switch ($tag_name) {
      case 'input':
        $element->setValue($value);
        $element_is_set = TRUE;
        break;
      case 'select':
        $element->selectOption($value);
        $element_is_set = TRUE;
        break;
      default:
        $element_is_set = FALSE;
    }
    if (!$element_is_set) {
      $variables = array(
        '@xpath' => $element->getXpath(),
        '@value' =>$value,
      );
      throw new \Exception(format_string("The element: '@xpath' was not set with the value: '@value'", $variables));
    }
    return $element_is_set;
  }

  /**
   * Validate if we have access to the file.
   *
   * @param $download_link
   *  The download link to the file
   * @throws Exception
   */
  protected function ValidateDownloadLink($download_link) {
    $file_path = $download_link->getAttribute('href');
    $client = new Client(array('base_uri' => $this->getSession()->getCurrentUrl()));
    try {
      $client->get($file_path);
    }
    catch (GuzzleHttp\Exception\ClientException $e) {
      $status_code = $e->getResponse()->getStatusCode();
      if ($status_code != 200) {
        $variables = array (
          '@status_code' => $status_code,
          '@file_path' => $file_path,
        );
        throw new \Exception(format_string("Expected status code of '200' but returned status code of: '@status_code' for file: '@file_path' ", $variables));
      }
    }
  }

  /**
   * @Then I download the PDF file
   */
  public function iDownloadThePdfFile() {
    $page = $this->getSession()->getPage();

    // In case we can't find a download link.
    if (!$download_link = $page->find('xpath', '//span[@class="file"]//a')) {
      throw new \Exception(format_string("Download link for PDF file were not found on this page: @url", array('@url' => $this->getSession()->getCurrentUrl())));
    }

    $this->ValidateDownloadLink($download_link);
  }

  /**
   * @Then /^I download the country factsheet file:$/
   */
  public function iDownloadTheCountryFactsheetFile(TableNode $table) {
    $page = $this->getSession()->getPage();

    foreach($table->getRows() as $country) {
      // In case we can't find a download link.

      if (!$download_link = $page->find('xpath', '//div[@class="maincontent"]//a[contains(@href, ' . array_shift($country) . ')]')) {
        throw new \Exception(format_string("Download link for '@country' were not found on this page: @url", array('@country' => $country[0], '@url' => $this->getSession()->getCurrentUrl())));
      }

      $this->ValidateDownloadLink($download_link);
    }
  }

  /**
   * Check if a given language exists on the language list.
   *
   * @param $language
   *  The target language.
   * @return bool
   *  If a language exist's then it returns TRUE else returns FALSE.
   * @throws Exception
   */
  public function inLanguageList($language) {
    // The link text can only contain any language name
    //(e.g. English | Arabic etc...).
    if (!in_array($language, locale_language_list('name', TRUE))) {
      throw new \Exception(format_string("The language '@language' was not found in the language list", array('@language' => $language)));

    }
    return TRUE;
  }

  /**
   * @Then I download the article files in all languages
   */
  public function iDownloadTheArticleFilesInAllLanguages() {
    $page = $this->getSession()->getPage();

    // In case we can't find a download link.
    if (!$download_links = $page->findAll('css', '.downButtons a')) {
      throw new \Exception(format_string("Download links were not found on this page: @url", array('@url' => $this->getSession()->getCurrentUrl())));
    }

    // Download the files each link.
    foreach($download_links as $link) {

      // The link text can be an existing language name or just contain
      // 'Download' text.
      $link_text = $link->getText();
      if ($link_text != 'Download') {
        $this->inLanguageList($link_text);
      }

      $this->ValidateDownloadLink($link);
    }
  }
}

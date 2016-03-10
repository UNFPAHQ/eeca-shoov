'use strict';

var shoovWebdrivercss = require('shoov-webdrivercss');
var projectName = 'unfpa-eeca';

// This can be executed by passing the environment argument like this:
// PROVIDER_PREFIX=browserstack SELECTED_CAPS=chrome mocha
// PROVIDER_PREFIX=browserstack SELECTED_CAPS=ie11 mocha
// PROVIDER_PREFIX=browserstack SELECTED_CAPS=iphone5 mocha

var capsConfig = {
  'chrome': {
    project: projectName,
    'browser' : 'Chrome',
    'browser_version' : '42.0',
    'os' : 'OS X',
    'os_version' : 'Yosemite',
    'resolution' : '1024x768'
  },
  'ie11': {
    project: projectName,
    'browser' : 'IE',
    'browser_version' : '11.0',
    'os' : 'Windows',
    'os_version' : '7',
    'resolution' : '1024x768'
  },
  'iphone5': {
    project: projectName,
    'browser' : 'Chrome',
    'browser_version' : '42.0',
    'os' : 'OS X',
    'os_version' : 'Yosemite',
    'chromeOptions': {
      'mobileEmulation': {
        'deviceName': 'Apple iPhone 5'
      }
    }
  }
};

var selectedCaps = process.env.SELECTED_CAPS || undefined;
var caps = selectedCaps ? capsConfig[selectedCaps] : undefined;

var providerPrefix = process.env.PROVIDER_PREFIX ? process.env.PROVIDER_PREFIX + '-' : '';
var testName = selectedCaps ? providerPrefix + selectedCaps : providerPrefix + 'default';

var baseUrl = process.env.BASE_URL ? process.env.BASE_URL : 'http://eeca.unfpa.org';

var resultsCallback = process.env.DEBUG ? console.log : shoovWebdrivercss.processResults;

describe('Visual monitor testing', function() {

  this.timeout(99999999);
  var client = {};

  before(function(done){
    client = shoovWebdrivercss.before(done, caps);
  });

  after(function(done) {
    shoovWebdrivercss.after(done);
  });

  it('should show the home page',function(done) {
    client
      .url(baseUrl)
      .pause(2000)
      .webdrivercss(testName + '.homepage', {
        name: '1',
        exclude:
          [
            // Carousel.
            '.carousel',
            '.slider-for',
            '.slick-list',
            // Articles.
            '.pane-views img',
            // Videos.
            '.views-field-field-video',
            '.view-vw-video .views-row',
            // Publication.
            '.pub-image'
          ],
        remove:
          [
            // Newa
            '#block-views-vw-news-block-home-news',
            // Articles.
            '.pane-views .title',
            '.news-body p',
            '.summary p',
            // Videos title.
            '.views-field-title a',
            '.views-field-title span',
            // Publication
            '.region-center-right #block-views-7b86692f8627a684fe415812a0bdf8b4 .title',
            '.region-center-right #block-views-7b86692f8627a684fe415812a0bdf8b4 .summary',
          ],
        hide:
          [
            // Events
            '.view-vw-events .view-empty p',
            '.pane-vw-events .pane-content',
            '.view-empty'
          ],
        screenWidth: selectedCaps == 'chrome' ? [640, 960, 1200] : undefined,
      }, resultsCallback)
      .call(done);
  });

  it('should show the topics page',function(done) {
    client
      .url(baseUrl + '/topics/maternal-health')
      .webdrivercss(testName + '.topics', {
        name: '1',
        exclude:
          [
            // Related article.
            '.view-vw-related-topics-terms img'
          ],
        remove:
          [
            // Related article.
            '.view-vw-related-topics-terms .description'
          ],
        hide: [],
        screenWidth: selectedCaps == 'chrome' ? [640, 960, 1200] : undefined,
      }, resultsCallback)
      .call(done);
  });

  it('should show the news page',function(done) {
    client
      .url(baseUrl + '/news')
      .webdrivercss(testName + '.news', {
        name: '1',
        exclude:
          [
            // News image.
            '.view-content img'
          ],
        remove:
          [
            // News date.
            '.view-content .left',
            // News title and summery.
            '.view-content .right'
          ],
        hide: [],
        screenWidth: selectedCaps == 'chrome' ? [640, 960, 1200] : undefined,
      }, resultsCallback)
      .call(done);
  });

  it('should show the news article page',function(done) {
    client
      .url(baseUrl + '/news/y-peer-moldova-brings-sexual-health-education-vulnerable-youth')
      .webdrivercss(testName + '.news-article', {
        name: '1',
        exclude:
          [
            // Related article.
            '.view-vw-custom-related-views img',
          ],
        remove:
          [
            // Related article.
            '.view-vw-custom-related-views .description',
            // Social icons counters.
            '.stBubble',
          ],
        hide: [],
        screenWidth: selectedCaps == 'chrome' ? [640, 960, 1200] : undefined,
      }, resultsCallback)
      .call(done);
  });
});

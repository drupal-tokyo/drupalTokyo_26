Feature: Top page view

  Scenario: As an anomymous user, I want to view "Super easy vegetarian pasta bake" on the top page.
    Given I am an anonymous user
    When I am on the homepage
    Then I should see "Super easy vegetarian pasta bake" in the ".region-banner-top .field--name-field-title" element

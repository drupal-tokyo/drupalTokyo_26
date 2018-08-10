Feature: Admin Interface
  
  @api
  Scenario: As an admin user, I want to create a basic page.
    Given I am logged in as an "administrator"
    When I am on the homepage
    Then I should see "Content" in the "#toolbar-link-system-admin_content" element

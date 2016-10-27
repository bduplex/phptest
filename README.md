TimesOfMalta phpTest
====================

## FAQ

- Q: What kind of project is this?
  A: Get job offers from supported RSS feeds

- Q: What feed channels are supported?
  A: For this test project we do support these feeds form these channels:
  
    [jobsinmalta](https://jobsinmalta.com/jobs.rss?exclude_recruitment_agencies=1&limit=5) 
    [Konnect](https://www.konnekt.com/opportunities/fee)
    [Casttile](https://www.castilleresources.com/en/rss)
   
- Q: How to get a job feed from wanted channel?   
  A: `[http://your_development_domain.dev]/list/[channel_name]` e.g. Konnect
  
- Q: How to get all feeds by category?   
  A: `[http://your_development_domain.dev]/get/[category_name]` e.g. Management
  
- Q: Can I add more feeds?   
  A: Sure. In app/app.php file look for `$app['feed_sources']` 

## Installation

- Checkout this repository
- From console run `$ composer install`
